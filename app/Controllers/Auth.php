<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function loginProcess()
    {
        $model = new UserModel();
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Enter both username and password.');
        }

        $user = $model
            ->groupStart()
            ->where('Username', $username)
            ->orWhere('email', $username)
            ->groupEnd()
            ->first();

        if ($user) {
            $storedPassword = (string) ($user['password'] ?? '');
            $isValid = $storedPassword !== '' && password_verify($password, $storedPassword);

            // Support existing plaintext entries without rewriting stored credentials.
            if (! $isValid && $storedPassword !== '' && hash_equals($storedPassword, $password)) {
                $isValid = true;
            }
        }

        if (! empty($isValid)) {

            session()->set([
                'user_id' => $user['id'],
                'username' => $user['Username']
            ]);

            return redirect()->to('/')->with('success', 'Welcome back, ' . $user['Username'] . '.');
        }

        return redirect()->back()->withInput()->with('error', 'Invalid login details.');
    }

    public function registerProcess()
    {
        $model = new UserModel();
        $username = trim((string) $this->request->getPost('username'));
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');
        $confirmPassword = (string) $this->request->getPost('confirm_password');

        if ($username === '' || $email === '' || $password === '' || $confirmPassword === '') {
            return redirect()->back()->withInput()->with('error', 'Complete all fields before signing up.');
        }

        if (mb_strlen($username) < 3) {
            return redirect()->back()->withInput()->with('error', 'Username must be at least 3 characters.');
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->with('error', 'Enter a valid email address.');
        }

        if (mb_strlen($password) < 6) {
            return redirect()->back()->withInput()->with('error', 'Password must be at least 6 characters.');
        }

        if ($password !== $confirmPassword) {
            return redirect()->back()->withInput()->with('error', 'Passwords do not match.');
        }

        $existingUser = $model
            ->groupStart()
            ->where('Username', $username)
            ->orWhere('email', $email)
            ->groupEnd()
            ->first();

        if ($existingUser) {
            return redirect()->back()->withInput()->with('error', 'That username or email is already taken.');
        }

        $model->save([
            'Username' => $username,
            'email' => $email,
            'password' => $password,
            'confirmpassword' => $confirmPassword,
        ]);

        $newUser = $model->where('Username', $username)->first();

        if ($newUser) {
            session()->set([
                'user_id' => $newUser['id'],
                'username' => $newUser['Username']
            ]);

            return redirect()->to('/');
        }

        return redirect()->to('/login')->with('success', 'Account created. Please sign in.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
