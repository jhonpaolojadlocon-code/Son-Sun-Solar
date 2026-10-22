<?= view('layout/header') ?>

<section class="auth-page">
    <div class="auth-shell">
        <div class="auth-hero">
            <p class="eyebrow">Staff access</p>
            <h1>Your workday starts here.</h1>
            <p>Sign in to your staff account to access your dashboard and attendance records.</p>
            <div class="auth-highlights">
                <div class="auth-chip">Staff dashboard</div>
                <div class="auth-chip">Time and attendance</div>
            </div>
        </div>

        <div class="auth-box auth-card">
            <p class="eyebrow">Staff portal</p>
            <?php if ($needsInitialStaff): ?>
                <h2>Set up the first staff account</h2>
                <p class="auth-intro">There are no staff accounts yet. Create the first one to open the dashboard.</p>
            <?php else: ?>
                <h2>Staff sign in</h2>
                <p class="auth-intro">Enter the exact Username and Password stored in the admin table. Department is optional and does not affect sign-in.</p>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="auth-message error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <?php if ($needsInitialStaff): ?>
                <p class="employee-empty">The first staff account is created once. After that, staff accounts can only be added from the dashboard.</p>
                <?= view('employee/staff_account_form', [
                    'formAction' => base_url('admin/staff/create'),
                    'submitLabel' => 'Create first staff account',
                    'departments' => $departments,
                ]) ?>
            <?php else: ?>
                <form method="post" action="<?= base_url('admin/login') ?>">
                    <label class="auth-label" for="staff-username">Username</label>
                    <input id="staff-username" type="text" name="username" placeholder="Enter the Username from the admin table" value="<?= esc(old('username')) ?>" autocomplete="username" required>

                    <label class="auth-label" for="admin-password">Password</label>
                    <input id="admin-password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>

                    <button type="submit">Sign in to staff portal</button>
                </form>
            <?php endif; ?>
            <p class="auth-switch"><a href="<?= base_url('/') ?>">Back to home</a></p>
        </div>
    </div>
</section>

<?= view('layout/footer') ?>
