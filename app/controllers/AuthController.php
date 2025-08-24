<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Session;
use app\core\Request;
use app\services\MailService;
use app\models\User;

class AuthController extends Controller
{
    /**
     * Set location session after approval
     */
    public function setLocationSession(Session $session) 
    {
        $session->set('location_approved', true);
    }

    /**
     * Show login page
     */
    public function login()
    {
        return $this->view('auth/login', [
            'title' => 'Login Page'
        ]);
    }

    /**
     * Handle login submission
     */
    public function loginForm(Request $request)
    {
        // Validate login fields
        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        // Try finding by email first, then by username
        if (filter_var($credentials['login'], FILTER_VALIDATE_EMAIL)) {
            $user = User::where(['email' => $credentials['login']]);
        } else {
            $user = User::where(['username' => $credentials['login']]);
        }

        // Validate user existence and password
        if (!$user || !password_verify($credentials['password'], $user->password)) {
            setFlash('error', 'Invalid username/email or password.');
            redirect('/login');
            return;
        }

        // check if user is email verified
        if (!$user->isEmailVerified()) {
            setFlash('info', 'Your email is not verified yet. Please check you inbox');
            redirect('/login');
            return;
        }

        login($user);

        // redirect based on role
        if ($user->role === 'admin') {
            redirect('/admin/dashboard');
        } else {
            redirect('/customer/home');
        }
    }

    /**
     * Shows the register form
     */
    public function register()
    {
        return $this->view('auth/register', [
            'title' => 'Register Page',
        ]);
    }

    /**
     * Handle form submission for registration
     */
    public function registerForm(Request $request)
    {
        // Validate input fields
        $data = $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|match:password'
        ]);

        if (!$this->isValidRealEmail($data['email'])) {
            setFlash('error', 'Please provide a valid email address from a real email provider.');
            redirect('/register');
            return;
        }

        unset($data['confirmPassword']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Generate a 6-digit verification code with expiry time
        $data['verification_code'] = User::generateVerificationCode();
        $data['verification_code_expires_at'] = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Insert new user
        if (User::insert($data)) {
            // Send verification email
            $sent = $this->sendVerificationEmail($data['email'], $data['verification_code']);
            if ($sent) {
                setFlash('success', 'Registration successful! Please check your email to verify your account.');
                redirect('/verify-email');
            } else {
                setFlash('error', 'Account created, but failed to send verification email.');
                redirect('/register');
            }
        } else {
            setFlash('error', 'Failed to create your account. Please try again.');
            redirect('/register');
        }
    }

    /**
     * Show email verification form
     */
    public function showVerifyEmail()
    {
        return $this->view('auth/verify-email', [
            'title' => 'Verify Email'
        ]);
    }

    /**
     * Handle verification code submission
     */
    public function verifyEmail(Request $request)
    {
        // Validate the input code
        $data = $request->validate([
            'verification_code' => 'required|min:6|max:6'
        ]);

        // Find the user with the code
        $user = User::findByVerificationCode($data['verification_code']);

        if (!$user) {
            setFlash('error', 'Invalid verification code.');
            redirect('/verify-email');
            return;
        }

        // Check if code has expired
        if (strtotime($user->verification_code_expires_at) < time()) {
            setFlash('error', 'Verification code has expired. Please request a new one.');
            redirect('/verify-email');
            return;
        }

        // Mark email as verified
        $user->markEmailAsVerified();
        setFlash('success', 'Email verified successfully. You can now login.');
        redirect('/login');
    }

    /**
     * Send the verification email.
     */
    private function sendVerificationEmail($email, $code)
    {
        $subject = 'Verify your email address';
        $body = $this->view('emails/verification', [
            'code' => $code
        ]);

        // Attempt to send the verification email
        return MailService::send($email, $subject, $body);
    }

    /**
     * Enhanced email validation to check for real/valid emails
     * This checks for common disposable/temporary email providers and validates MX records
     */
    private function isValidRealEmail($email)
    {
        // Extract domain from email
        $domain = substr(strrchr($email, "@"), 1);

        // For Gmail addresses, verify they actually exist on Google's servers
        if (in_array(strtolower($domain), ['gmail.com', 'googlemail.com'])) {
            if (!$this->verifyGmailExists($email)) {
                return false;
            }
        }

        // List of known disposable/temporary email providers to block
        $disposableEmailDomains = [
            '10minutemail.com', '10minutemail.net', 'tempmail.org', 'guerrillamail.com',
            'mailinator.com', 'yopmail.com', 'temp-mail.org', 'throwaway.email',
            'getnada.com', 'maildrop.cc', 'sharklasers.com', 'guerrillamailblock.com',
            'pokemail.net', 'spam4.me', 'bccto.me', 'chacuo.net', 'dispostable.com',
            'fakeinbox.com', 'hidemail.de', 'mytrashmail.com', 'no-spam.ws',
            'nospam.ze.tc', 'nowmymail.com', 'objectmail.com', 'proxymail.eu',
            'rcpt.at', 'sogetthis.com', 'spambog.com', 'spambog.de', 'spambog.ru',
            'spamgourmet.com', 'spamhole.com', 'spamify.com', 'spamthisplease.com',
            'superrito.com', 'suremail.info', 'tempemail.com', 'tempinbox.com',
            'tempymail.com', 'thankyou2010.com', 'trash-mail.at', 'trashmail.at',
            'trashmail.me', 'trashmail.net', 'trashymail.com', 'trbvm.com',
            'wegwerfmail.de', 'wegwerfmail.net', 'wegwerfmail.org', 'wh4f.org'
        ];

        // Check if domain is in disposable email list
        if (in_array(strtolower($domain), $disposableEmailDomains)) {
            return false;
        }

        // Check for MX record to ensure domain can receive emails
        if (!checkdnsrr($domain, 'MX') && !checkdnsrr($domain, 'A')) {
            return false;
        }

        // Additional checks for suspicious patterns
        $suspiciousPatterns = [
            '/^\d+@/',  
            '/^[a-z]{1,3}@/', 
            '/\+.*\+/', 
            '/\.{2,}/', 
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, strtolower($email))) {
                return false;
            }
        }

        return true;
    }

    private function verifyGmailExists($email)
    {
        try {
            // Gmail SMTP servers
            $smtpServers = ['gmail-smtp-in.l.google.com', 'alt1.gmail-smtp-in.l.google.com'];
            
            foreach ($smtpServers as $server) {
                // Try to connect to Gmail SMTP server
                $connection = @fsockopen($server, 25, $errno, $errstr, 10);
                
                if (!$connection) {
                    continue; // Try next server
                }
                
                // Set timeout for socket operations
                stream_set_timeout($connection, 10);
                
                // Read initial response
                $response = fgets($connection, 1024);
                if (strpos($response, '220') !== 0) {
                    fclose($connection);
                    continue;
                }
                
                // Send HELO command
                fwrite($connection, "HELO " . $_SERVER['HTTP_HOST'] . "\r\n");
                $response = fgets($connection, 1024);
                if (strpos($response, '250') !== 0) {
                    fclose($connection);
                    continue;
                }
                
                // Send MAIL FROM command (use a generic sender)
                fwrite($connection, "MAIL FROM: <noreply@" . $_SERVER['HTTP_HOST'] . ">\r\n");
                $response = fgets($connection, 1024);
                if (strpos($response, '250') !== 0) {
                    fclose($connection);
                    continue;
                }
                
                // Send RCPT TO command to verify the email
                fwrite($connection, "RCPT TO: <" . $email . ">\r\n");
                $response = fgets($connection, 1024);
                
                // Send QUIT command
                fwrite($connection, "QUIT\r\n");
                fclose($connection);
                
                // Check if email exists
                if (strpos($response, '250') === 0) {
                    return true; // Email exists
                } elseif (strpos($response, '550') === 0 || strpos($response, '551') === 0) {
                    return false; // Email doesn't exist
                }
            }
            
            /**
             * If all servers failed or gave unclear responses, assume email is valid
             * to avoid blocking legitimate users due to temporary server issues
             */
            return true;

            /**
             * Strict mode: if all servers failed or responses where unclear, treat as invalid
             */
            return false;
            
        } catch (\Exception $e) {
            // On any error, assume email is valid to avoid blocking legitimate users
            return true;
        } catch (\Exception $e) {
            // Strict mode: on any error, treat as invalid
            return false;
        }
    }
}