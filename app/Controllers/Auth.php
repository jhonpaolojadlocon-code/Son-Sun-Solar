<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    private const DEPARTMENTS = ['Administration', 'IT', 'Dispatch', 'Accounting', 'HR', 'Marketing', 'Sales', 'Customer Service'];

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

            return redirect()->to(base_url())->with('success', 'Welcome back, ' . ($user['first_name'] ?? $user['email']) . '.');
        }

        return redirect()->back()->withInput()->with('error', 'Invalid login details.');
    }

    public function adminLogin()
    {
        if (session()->get('is_admin')) {
            return redirect()->to(base_url('admin/departments'));
        }

        return view('auth/admin_login');
    }

    public function adminLoginProcess()
    {
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');
        $department = trim((string) $this->request->getPost('department'));
        $adminEmail = trim((string) env('ADMIN_EMAIL', ''));
        $passwordHash = (string) env('ADMIN_PASSWORD_HASH', '');

        if (! in_array($department, self::DEPARTMENTS, true)) {
            return redirect()->back()->withInput()->with('error', 'Choose a valid department.');
        }

        if ($adminEmail === '' || $passwordHash === '') {
            return redirect()->back()->withInput()->with('error', 'Admin login is not configured. Set ADMIN_EMAIL and ADMIN_PASSWORD_HASH in the server environment.');
        }

        if ($email !== '' && $password !== '' && hash_equals($adminEmail, $email) && password_verify($password, $passwordHash)) {
            session()->regenerate(true);
            session()->set([
                'is_admin' => true,
                'admin_email' => $adminEmail,
                'admin_department' => $department,
            ]);

            return redirect()->to(base_url('admin/departments'));
        }

        return redirect()->back()->withInput()->with('error', 'Invalid admin email or password.');
    }

    public function adminDepartments()
    {
        if (! session()->get('is_admin')) {
            return redirect()->to(base_url('admin/login'))->with('error', 'Sign in as an administrator to view departments.');
        }

        return view('admin/departments', ['departments' => self::DEPARTMENTS]);
    }

    public function adminLogout()
    {
        session()->remove(['is_admin', 'admin_email', 'admin_department']);

        return redirect()->to(base_url('admin/login'));
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
        $password = (string) $this->request->getPost('password');
        $confirmPassword = (string) $this->request->getPost('confirm_password');

        if ($email === '' || $firstName === '' || $lastName === '' || $middleName === '' || $birthday === '' || $gender === '' || $phoneNumber === '' || $address === '' || $password === '' || $confirmPassword === '') {
            return redirect()->back()->withInput()->with('error', 'Complete all fields before signing up.');
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
            'department' => null,
        ]);

        $newUser = $model->where('email', $email)->first();

        if ($newUser) {
            session()->set([
                'user_id' => $newUser['id'],
                'display_name' => $newUser['first_name']
            ]);

            return redirect()->to(base_url());
        }

        return redirect()->to(base_url('login'))->with('success', 'Account created. Please sign in.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
