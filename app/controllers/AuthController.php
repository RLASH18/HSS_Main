<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\services\MailService;
use app\models\User;

class AuthController extends Controller
{
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

        unset($data['confirmPassword']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Generate a 6-digit verification code with expiry time
        $data['verification_code'] = User::generateVerificationCode();
        $data['verification_code_expires_at'] = date('Y-m-d H:i:s', strtotime('+30 minutes'));

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
}
