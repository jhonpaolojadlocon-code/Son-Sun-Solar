<?= view('layout/header') ?>

<section class="auth-page">
    <div class="auth-shell">
        <div class="auth-hero">
            <p class="eyebrow">Administrator access</p>
            <h1>Manage your departments.</h1>
            <p>Sign in with your administrator account to view the company departments.</p>
            <div class="auth-highlights">
                <div class="auth-chip">Secure admin access</div>
                <div class="auth-chip">Department directory</div>
            </div>
        </div>

        <div class="auth-box auth-card">
            <p class="eyebrow">Admin portal</p>
            <h2>Administrator sign in</h2>
            <p class="auth-intro">Use your administrator email and password.</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="auth-message error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('admin/login') ?>">
                <label class="auth-label" for="admin-email">Admin email</label>
                <input id="admin-email" type="email" name="email" placeholder="admin@example.com" value="<?= esc(old('email')) ?>" autocomplete="username" required>

                <label class="auth-label" for="admin-department">Department</label>
                <select id="admin-department" name="department" required>
                    <option value="">Select your department</option>
                    <?php foreach (['Administration', 'IT', 'Dispatch', 'Accounting', 'HR', 'Marketing', 'Sales', 'Customer Service'] as $department): ?>
                        <option value="<?= esc($department) ?>" <?= old('department') === $department ? 'selected' : '' ?>><?= esc($department) ?></option>
                    <?php endforeach; ?>
                </select>

                <label class="auth-label" for="admin-password">Password</label>
                <input id="admin-password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>

                <button type="submit">Sign in as admin</button>
            </form>
            <p class="auth-switch"><a href="<?= base_url('/') ?>">Back to home</a></p>
        </div>
    </div>
</section>

<?= view('layout/footer') ?>
