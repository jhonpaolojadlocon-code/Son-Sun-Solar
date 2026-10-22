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

        return view('auth/admin_login', [
            'departments' => self::DEPARTMENTS,
            'needsInitialStaff' => db_connect()->table('admin')->countAllResults() === 0,
        ]);
    }

    public function adminLoginProcess()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');
        if ($username !== '' && $password !== '') {
            $staffRows = db_connect()->table('admin')->where('Username', $username)->get()->getResultArray();
            foreach ($staffRows as $staff) {
                $storedPassword = (string) ($staff['Password'] ?? '');
                $validPassword = $storedPassword !== '' && password_verify($password, $storedPassword);

                // Keep existing plaintext staff passwords working while allowing hashed passwords.
                if (! $validPassword && $storedPassword !== '' && hash_equals($storedPassword, $password)) {
                    $validPassword = true;
                }

                if (! $validPassword) {
                    continue;
                }
                if (isset($staff['IsActive']) && (int) $staff['IsActive'] !== 1) {
                    continue;
                }

                session()->regenerate(true);
                session()->set([
                    'is_admin' => true,
                    'admin_email' => (string) $staff['Username'],
                    'admin_department' => (string) $staff['Department'],
                    'admin_name' => trim((string) ($staff['FirstName'] ?? '') . ' ' . (string) ($staff['LastName'] ?? '')),
                ]);
                return redirect()->to(base_url('admin/dashboard'));
            }
        }

        return redirect()->back()->withInput()->with('error', 'Invalid staff username or password. Check the username and password saved in the admin table.');
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
        $jobs = $db->table('service_bookings')
            ->select('service_bookings.*, registration.first_name, registration.last_name')
            ->join('registration', 'registration.id = service_bookings.customer_id', 'left')
            ->where('service_bookings.assigned_employee', $email)
            ->orderBy('service_bookings.scheduled_for', 'ASC')->get()->getResultArray();
        $announcements = $db->table('announcements')->whereIn('audience', ['employees', 'all'])->orderBy('created_at', 'DESC')->limit(8)->get()->getResultArray();
        $staff = $db->table('admin')->orderBy('ID', 'DESC')->get()->getResultArray();
        $bookings = $db->table('service_bookings')
            ->select('service_bookings.*, registration.first_name, registration.last_name, registration.email AS customer_email')
            ->join('registration', 'registration.id = service_bookings.customer_id', 'left')
            ->orderBy('service_bookings.scheduled_for', 'ASC')->get()->getResultArray();
        $reports = $db->table('service_reports')->orderBy('created_at', 'DESC')->limit(20)->get()->getResultArray();
        $supportTickets = $db->table('support_tickets')
            ->select('support_tickets.*, registration.first_name, registration.last_name, registration.email')
            ->join('registration', 'registration.id = support_tickets.customer_id', 'left')
            ->orderBy('support_tickets.created_at', 'DESC')->limit(30)->get()->getResultArray();
        $serviceCatalog = $db->table('service_catalog')->orderBy('service_name')->get()->getResultArray();
        $analytics = [
            'total' => $db->table('service_bookings')->countAllResults(),
            'pending' => $db->table('service_bookings')->where('status', 'Pending')->countAllResults(),
            'completed' => $db->table('service_bookings')->where('status', 'Completed')->countAllResults(),
            'usage' => $db->table('service_bookings')->select('service_type, COUNT(*) AS booking_count')->groupBy('service_type')->orderBy('booking_count', 'DESC')->get()->getResultArray(),
        ];

        return view('employee/dashboard', [
            'todayRecord' => $todayRecord,
            'history' => $history,
            'employeeEmail' => $email,
            'department' => (string) session()->get('admin_department'),
            'departments' => self::DEPARTMENTS,
            'jobs' => $jobs,
            'announcements' => $announcements,
            'staff' => $staff,
            'bookings' => $bookings,
            'reports' => $reports,
            'supportTickets' => $supportTickets,
            'serviceCatalog' => $serviceCatalog,
            'analytics' => $analytics,
        ]);
    }

    public function createStaffAccount()
    {
        $db = db_connect();
        $isInitialSetup = $db->table('admin')->countAllResults() === 0;
        if ((! session()->get('is_admin') || ! in_array(session()->get('admin_department'), ['Administration', 'HR'], true)) && ! $isInitialSetup) {
            return redirect()->to(base_url('admin/login'))->with('error', 'Sign in to create a staff account.');
        }

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

        if ($email === '' || $firstName === '' || $lastName === '' || $middleName === '' || $birthday === '' || $gender === '' || $phoneNumber === '' || $address === '' || $password === '' || $confirmPassword === '' || $department === '') {
            return redirect()->to(base_url('admin/dashboard'))->withInput()->with('error', 'Complete every field to create the staff account.');
        }
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->to(base_url('admin/dashboard'))->withInput()->with('error', 'Enter a valid email address.');
        }
        if (! in_array($gender, ['Male', 'Female'], true)) {
            return redirect()->to(base_url('admin/dashboard'))->withInput()->with('error', 'Choose Male or Female.');
        }
        if (! in_array($department, self::DEPARTMENTS, true)) {
            return redirect()->to(base_url('admin/dashboard'))->withInput()->with('error', 'Choose a valid department.');
        }
        $birthdayDate = \DateTimeImmutable::createFromFormat('Y-m-d', $birthday);
        if (! $birthdayDate || $birthdayDate->format('Y-m-d') !== $birthday || $birthdayDate > new \DateTimeImmutable('today')) {
            return redirect()->to(base_url('admin/dashboard'))->withInput()->with('error', 'Enter a valid birthday.');
        }
        if (mb_strlen($password) < 6) {
            return redirect()->to(base_url('admin/dashboard'))->withInput()->with('error', 'Password must be at least 6 characters.');
        }
        if ($password !== $confirmPassword) {
            return redirect()->to(base_url('admin/dashboard'))->withInput()->with('error', 'Passwords do not match.');
        }

        if ($db->table('admin')->where('Username', $email)->countAllResults() > 0) {
            return redirect()->to(base_url('admin/dashboard'))->withInput()->with('error', 'A staff account already uses that email address.');
        }

        $db->table('admin')->insert([
            'Username' => $email,
            'Department' => $department,
            'Password' => password_hash($password, PASSWORD_DEFAULT),
            'FirstName' => $firstName,
            'LastName' => $lastName,
            'MiddleName' => $middleName,
            'Birthday' => $birthday,
            'Gender' => $gender,
            'PhoneNumber' => $phoneNumber,
            'Address' => $address,
        ]);

        if ($isInitialSetup) {
            session()->regenerate(true);
            session()->set([
                'is_admin' => true,
                'admin_email' => $email,
                'admin_department' => $department,
                'admin_name' => trim($firstName . ' ' . $lastName),
            ]);
        }

        return redirect()->to(base_url('admin/dashboard'))->with('success', 'Staff account created. They can sign in using their email and password.');
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
            'employee_name' => trim((string) session()->get('admin_name')) ?: $email,
            'work_date' => $today,
            'time_in' => date('Y-m-d H:i:s'),
            'latitude' => $this->request->getPost('latitude') ?: null,
            'longitude' => $this->request->getPost('longitude') ?: null,
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
        session()->remove(['is_admin', 'admin_email', 'admin_department', 'admin_name']);
        return redirect()->to(base_url('admin/login'));
    }

    public function customerDashboard()
    {
        if (! session()->get('user_id')) {
            return redirect()->to(base_url('login'))->with('error', 'Sign in to view your customer dashboard.');
        }

        $db = db_connect();
        $user = (new UserModel())->find((int) session()->get('user_id'));
        if (! $user) {
            session()->remove(['user_id', 'display_name']);
            return redirect()->to(base_url('login'))->with('error', 'Your account could not be found. Please sign in again.');
        }

        return view('customer/dashboard', [
            'customer' => $user,
            'bookings' => $db->table('service_bookings')->where('customer_id', $user['id'])->orderBy('scheduled_for', 'DESC')->get()->getResultArray(),
            'tickets' => $db->table('support_tickets')->where('customer_id', $user['id'])->orderBy('created_at', 'DESC')->limit(8)->get()->getResultArray(),
            'announcements' => $db->table('announcements')->whereIn('audience', ['customers', 'all'])->orderBy('created_at', 'DESC')->limit(8)->get()->getResultArray(),
            'services' => $db->table('service_catalog')->where('available', 1)->orderBy('service_name')->get()->getResultArray(),
        ]);
    }

    public function updateCustomerProfile()
    {
        if (! session()->get('user_id')) {
            return redirect()->to(base_url('login'));
        }
        $gender = trim((string) $this->request->getPost('gender'));
        if (! in_array($gender, ['Male', 'Female'], true)) {
            return redirect()->to(base_url('customer/dashboard'))->with('error', 'Choose Male or Female.');
        }
        $model = new UserModel();
        $user = $model->find((int) session()->get('user_id'));
        $currentPassword = (string) $this->request->getPost('current_password');
        $newPassword = (string) $this->request->getPost('new_password');
        $confirmPassword = (string) $this->request->getPost('confirm_password');
        $update = [
            'first_name' => trim((string) $this->request->getPost('first_name')),
            'last_name' => trim((string) $this->request->getPost('last_name')),
            'middle_name' => trim((string) $this->request->getPost('middle_name')),
            'birthday' => trim((string) $this->request->getPost('birthday')),
            'gender' => $gender,
            'phone_number' => trim((string) $this->request->getPost('phone_number')),
            'address' => trim((string) $this->request->getPost('address')),
        ];
        if ($newPassword !== '' || $currentPassword !== '' || $confirmPassword !== '') {
            $stored = (string) ($user['password'] ?? '');
            $currentIsValid = $stored !== '' && (password_verify($currentPassword, $stored) || hash_equals($stored, $currentPassword));
            if (! $currentIsValid || mb_strlen($newPassword) < 6 || $newPassword !== $confirmPassword) {
                return redirect()->to(base_url('customer/dashboard'))->with('error', 'To change your password, enter your current password and a matching new password of at least 6 characters.');
            }
            $update['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }
        $model->update((int) session()->get('user_id'), $update);
        return redirect()->to(base_url('customer/dashboard'))->with('success', 'Your profile has been updated.');
    }

    public function createBooking()
    {
        if (! session()->get('user_id')) {
            return redirect()->to(base_url('login'));
        }
        $type = trim((string) $this->request->getPost('service_type'));
        $schedule = trim((string) $this->request->getPost('scheduled_for'));
        $address = trim((string) $this->request->getPost('address'));
        $date = \DateTimeImmutable::createFromFormat('Y-m-d\TH:i', $schedule);
        $serviceAvailable = db_connect()->table('service_catalog')->where('service_name', $type)->where('available', 1)->countAllResults() > 0;
        if (! $serviceAvailable || ! $date || $date <= new \DateTimeImmutable() || $address === '') {
            return redirect()->to(base_url('customer/dashboard'))->with('error', 'Choose a service, a future date and time, and enter the service address.');
        }
        db_connect()->table('service_bookings')->insert([
            'customer_id' => (int) session()->get('user_id'),
            'service_type' => $type,
            'scheduled_for' => $date->format('Y-m-d H:i:s'),
            'address' => $address,
            'notes' => trim((string) $this->request->getPost('notes')) ?: null,
            'status' => 'Pending',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to(base_url('customer/dashboard'))->with('success', 'Service request sent. The team will confirm your schedule.');
    }

    public function createSupportRequest()
    {
        if (! session()->get('user_id')) {
            return redirect()->to(base_url('login'));
        }
        $subject = trim((string) $this->request->getPost('subject'));
        $message = trim((string) $this->request->getPost('message'));
        if ($subject === '' || $message === '') {
            return redirect()->to(base_url('customer/dashboard'))->with('error', 'Enter a support subject and message.');
        }
        db_connect()->table('support_tickets')->insert([
            'customer_id' => (int) session()->get('user_id'), 'subject' => $subject,
            'message' => $message, 'status' => 'Open', 'created_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to(base_url('customer/dashboard'))->with('success', 'Your support request was sent.');
    }

    public function createAnnouncement()
    {
        if (! session()->get('is_admin') || ! in_array(session()->get('admin_department'), ['Administration', 'HR'], true)) {
            return redirect()->to(base_url('admin/login'));
        }
        $title = trim((string) $this->request->getPost('title'));
        $message = trim((string) $this->request->getPost('message'));
        $audience = trim((string) $this->request->getPost('audience'));
        if ($title === '' || $message === '' || ! in_array($audience, ['employees', 'customers', 'all'], true)) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Enter an announcement and choose its audience.');
        }
        db_connect()->table('announcements')->insert([
            'title' => $title, 'message' => $message, 'audience' => $audience,
            'created_by' => (string) session()->get('admin_email'), 'created_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to(base_url('admin/dashboard'))->with('success', 'Announcement published.');
    }

    public function saveServiceSetting()
    {
        if (! session()->get('is_admin') || ! in_array(session()->get('admin_department'), ['Administration', 'HR'], true)) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Only Administration or HR can change service settings.');
        }
        $name = trim((string) $this->request->getPost('service_name'));
        $priceInput = trim((string) $this->request->getPost('price'));
        $price = $priceInput === '' ? null : $priceInput;
        $available = $this->request->getPost('available') === '1' ? 1 : 0;
        if ($name === '' || mb_strlen($name) > 80 || ($price !== null && (! is_numeric($price) || (float) $price < 0))) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Enter a service name and a valid non-negative price.');
        }
        $db = db_connect();
        $existing = $db->table('service_catalog')->where('service_name', $name)->get()->getRowArray();
        $values = ['price' => $price, 'available' => $available];
        if ($existing) {
            $db->table('service_catalog')->where('id', $existing['id'])->update($values);
        } else {
            $db->table('service_catalog')->insert(['service_name' => $name] + $values);
        }
        return redirect()->to(base_url('admin/dashboard'))->with('success', 'Service settings saved.');
    }

    public function createServiceReport()
    {
        if (! session()->get('is_admin')) {
            return redirect()->to(base_url('admin/login'));
        }
        $details = trim((string) $this->request->getPost('details'));
        $bookingId = (int) $this->request->getPost('booking_id');
        if ($details === '') {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Enter the service issue details.');
        }
        db_connect()->table('service_reports')->insert([
            'booking_id' => $bookingId ?: null, 'employee_email' => (string) session()->get('admin_email'),
            'details' => $details, 'created_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to(base_url('admin/dashboard'))->with('success', 'Service report sent to the admin dashboard.');
    }

    public function updateBooking(int $id)
    {
        if (! session()->get('is_admin') || ! in_array(session()->get('admin_department'), ['Administration', 'Dispatch'], true)) {
            return redirect()->to(base_url('admin/login'));
        }
        $status = trim((string) $this->request->getPost('status'));
        $allowed = ['Pending', 'Approved', 'Declined', 'Completed'];
        if (! in_array($status, $allowed, true)) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Choose a valid booking status.');
        }
        $assignee = trim((string) $this->request->getPost('assigned_employee'));
        db_connect()->table('service_bookings')->where('id', $id)->update([
            'status' => $status, 'assigned_employee' => $assignee !== '' ? $assignee : null,
        ]);
        return redirect()->to(base_url('admin/dashboard'))->with('success', 'Booking updated.');
    }

    public function deactivateStaff(int $id)
    {
        if (! session()->get('is_admin') || ! in_array(session()->get('admin_department'), ['Administration', 'HR'], true)) {
            return redirect()->to(base_url('admin/login'));
        }
        $account = db_connect()->table('admin')->where('ID', $id)->get()->getRowArray();
        if (! $account || (string) $account['Username'] === (string) session()->get('admin_email')) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'You cannot deactivate your own account.');
        }
        db_connect()->table('admin')->where('ID', $id)->update(['IsActive' => 0]);
        return redirect()->to(base_url('admin/dashboard'))->with('success', 'Staff account deactivated.');
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

            return redirect()->to(base_url('customer/dashboard'))->with('success', 'Welcome back, ' . ($user['first_name'] ?? $user['email']) . '.');
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

        if (! in_array($gender, ['Male', 'Female'], true)) {
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
            'password' => password_hash($password, PASSWORD_DEFAULT),
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

            return redirect()->to(base_url('customer/dashboard'));
        }

        return redirect()->to('/login')->with('success', 'Account created. Please sign in.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
