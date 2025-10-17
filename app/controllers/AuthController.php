<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Session;
use app\core\Request;
use app\services\MailService;
use app\models\User;
use app\services\EmailValidationService;

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
            'username' => 'required|unique:users,username|min:3|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|match:password'
        ]);

        // Validate username format (alphanumeric and underscores only)
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
            setFlash('error', 'Username can only contain letters, numbers, and underscores (no spaces or special characters).');
            redirect('/register');
            return;
        }

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
     * Enhanced email validation using AbstractAPI
     * Falls back to basic validation if API is unavailable
     */
    private function isValidRealEmail($email)
    {
        // Basic email format validation first
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Use AbstractAPI for comprehensive email verification
        $result = EmailValidationService::verifyEmail($email);
        
        // If validation failed or returned error, use basic validation
        if (isset($result['error'])) {
            error_log("Email validation failed: " . $result['error']);
            return $this->basicEmailValidation($email);
        }
        
        // Return validation result
        return $result['valid'];
    }

    /**
     * Fallback email validation when AbstractAPI is unavailable
     * Performs basic checks for disposable emails and MX records
     */
    private function basicEmailValidation($email)
    {
        // Extract domain from email
        $domain = substr(strrchr($email, "@"), 1);

        // Basic disposable email check
        $disposableEmailDomains = [
            '10minutemail.com', 'tempmail.org', 'guerrillamail.com',
            'mailinator.com', 'yopmail.com', 'temp-mail.org',
            'throwaway.email', 'getnada.com', 'maildrop.cc'
        ];

        if (in_array(strtolower($domain), $disposableEmailDomains)) {
            return false;
        }

        // Check for MX record to ensure domain can receive emails
        if (!checkdnsrr($domain, 'MX') && !checkdnsrr($domain, 'A')) {
            return false;
        }

        return true;
    }
}