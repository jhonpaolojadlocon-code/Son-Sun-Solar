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

    public function adminLogin()
    {
        if (session()->get('is_admin')) {
            return redirect()->to(base_url('admin/dashboard'));
        }

        return view('auth/admin_login', ['departments' => self::DEPARTMENTS]);
    }

    public function adminLoginProcess()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');
        $department = trim((string) $this->request->getPost('department'));
        if ($username !== '' && $password !== '' && in_array($department, self::DEPARTMENTS, true)) {
            $staff = db_connect()->table('admin')
                ->where('Username', $username)
                ->where('Department', $department)
                ->get()->getRowArray();
            $storedPassword = (string) ($staff['Password'] ?? '');
            $validPassword = $storedPassword !== '' && password_verify($password, $storedPassword);

            // Keep existing plaintext staff passwords working while allowing hashed passwords.
            if (! $validPassword && $storedPassword !== '' && hash_equals($storedPassword, $password)) {
                $validPassword = true;
            }

            if ($staff && $validPassword) {
                session()->regenerate(true);
                session()->set([
                    'is_admin' => true,
                    'admin_email' => (string) $staff['Username'],
                    'admin_department' => (string) $staff['Department'],
                ]);
                return redirect()->to(base_url('admin/dashboard'));
            }
        }

        return redirect()->back()->withInput()->with('error', 'Invalid staff username or password.');
    }

    public function employeeDashboard()
    {
        if (! session()->get('is_admin')) {
            return redirect()->to(base_url('admin/login'))->with('error', 'Sign in to access the employee dashboard.');
        }

        $db = db_connect();
        $email = (string) session()->get('admin_email');
        $today = date('Y-m-d');
        $todayRecord = $db->table('employee_attendance')->where('employee_email', $email)->where('work_date', $today)->get()->getRowArray();
        $history = $db->table('employee_attendance')->where('employee_email', $email)->orderBy('work_date', 'DESC')->limit(7)->get()->getResultArray();

        return view('employee/dashboard', [
            'todayRecord' => $todayRecord,
            'history' => $history,
            'employeeEmail' => $email,
            'department' => (string) session()->get('admin_department'),
        ]);
    }

    public function timeIn()
    {
        if (! session()->get('is_admin')) {
            return redirect()->to(base_url('admin/login'))->with('error', 'Sign in to record attendance.');
        }

        $db = db_connect();
        $email = (string) session()->get('admin_email');
        $today = date('Y-m-d');
        $existing = $db->table('employee_attendance')->where('employee_email', $email)->where('work_date', $today)->get()->getRowArray();
        if ($existing) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'You have already timed in today.');
        }

        $db->table('employee_attendance')->insert([
            'employee_email' => $email,
            'work_date' => $today,
            'time_in' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/dashboard'))->with('success', 'Time in recorded.');
    }

    public function timeOut()
    {
        if (! session()->get('is_admin')) {
            return redirect()->to(base_url('admin/login'))->with('error', 'Sign in to record attendance.');
        }

        $db = db_connect();
        $record = $db->table('employee_attendance')
            ->where('employee_email', (string) session()->get('admin_email'))
            ->where('work_date', date('Y-m-d'))
            ->where('time_out', null)
            ->get()->getRowArray();
        if (! $record) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'You need to time in before you can time out.');
        }

        $db->table('employee_attendance')->where('id', $record['id'])->update(['time_out' => date('Y-m-d H:i:s')]);
        return redirect()->to(base_url('admin/dashboard'))->with('success', 'Time out recorded.');
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
