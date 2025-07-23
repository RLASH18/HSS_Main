<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller
{
    public function register()
    {
        return $this->view('auth/register', [
            'title' => 'Register Page',
        ]);
    }

    public function registerForm(Request $request)
    {
        if ($request->isPost()) {

            $data = $request->validate([
                'username' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'confirmPassword' => 'required|match:password'
            ]);

            if (User::create($data)) {
                setFlash('success', 'Registration successful');
                redirect('/login');
            } else {
                setFlash('error', 'Something went wrong');
                redirect('/register');
            }
        }
    }

    public function login()
    {
        return $this->view('auth/login', [
            'title' => 'Login Page',
        ]);
    }

    public function loginForm(Request $request)
    {
        // request method
        if ($request->isPost()) {

            // validate
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // attempt
            $user = User::attempt($credentials);

            // logs in if user valid
            if ($user) {
                setFlash('success', 'Okairi');
                redirect('/home');
            } else {
                setFlash('error', 'User does not exists.');
                redirect('/login');
            }
        }
    }
}
