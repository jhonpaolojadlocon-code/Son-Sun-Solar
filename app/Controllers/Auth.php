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
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        if ($email === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Enter both email and password.');
        }

        $user = $model->where('email', $email)->first();

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
                'display_name' => $user['first_name'] ?? $user['email']
            ]);

            return redirect()->to('/')->with('success', 'Welcome back, ' . ($user['first_name'] ?? $user['email']) . '.');
        }

        return redirect()->back()->withInput()->with('error', 'Invalid login details.');
    }

    public function registerProcess()
    {
        $model = new UserModel();
        $email = trim((string) $this->request->getPost('email'));
        $firstName = trim((string) $this->request->getPost('first_name'));
        $lastName = trim((string) $this->request->getPost('last_name'));
        $middleName = trim((string) $this->request->getPost('middle_name'));
        $birthday = trim((string) $this->request->getPost('birthday'));
        $gender = trim((string) $this->request->getPost('gender'));
        $phoneNumber = trim((string) $this->request->getPost('phone_number'));
        $address = trim((string) $this->request->getPost('address'));
        $department = trim((string) $this->request->getPost('department'));
        $password = (string) $this->request->getPost('password');
        $confirmPassword = (string) $this->request->getPost('confirm_password');

        if ($email === '' || $firstName === '' || $lastName === '' || $middleName === '' || $birthday === '' || $gender === '' || $phoneNumber === '' || $address === '' || $password === '' || $confirmPassword === '') {
            return redirect()->back()->withInput()->with('error', 'Complete all fields before signing up.');
        }

        $departments = ['Administration', 'IT Dispatch', 'Accounting', 'HR', 'Marketing', 'Sales', 'Customer service'];
        if ($department !== '' && ! in_array($department, $departments, true)) {
            return redirect()->back()->withInput()->with('error', 'Choose a valid department.');
        }

        if (! in_array($gender, ['Female', 'Male', 'Non-binary', 'Prefer not to say'], true)) {
            return redirect()->back()->withInput()->with('error', 'Choose a valid gender option.');
        }

        $birthdayDate = \DateTimeImmutable::createFromFormat('Y-m-d', $birthday);
        if (! $birthdayDate || $birthdayDate->format('Y-m-d') !== $birthday || $birthdayDate > new \DateTimeImmutable('today')) {
            return redirect()->back()->withInput()->with('error', 'Enter a valid birthday.');
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
            ->where('email', $email)
            ->first();

        if ($existingUser) {
            return redirect()->back()->withInput()->with('error', 'That email address is already registered.');
        }

        $model->save([
            'email' => $email,
            'password' => $password,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'middle_name' => $middleName,
            'birthday' => $birthday,
            'gender' => $gender,
            'phone_number' => $phoneNumber,
            'address' => $address,
            'department' => $department !== '' ? $department : null,
        ]);

        $newUser = $model->where('email', $email)->first();

        if ($newUser) {
            session()->set([
                'user_id' => $newUser['id'],
                'display_name' => $newUser['first_name']
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
