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
            <h2>Staff sign in</h2>
            <p class="auth-intro">Use the username and password saved in your staff account.</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="auth-message error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('admin/login') ?>">
                <label class="auth-label" for="staff-username">Username</label>
                <input id="staff-username" type="text" name="username" placeholder="Enter your username" value="<?= esc(old('username')) ?>" autocomplete="username" required>

                <label class="auth-label" for="staff-department">Department</label>
                <select id="staff-department" name="department" required>
                    <option value="">Choose your department</option>
                    <?php foreach ($departments as $department): ?>
                        <option value="<?= esc($department) ?>" <?= old('department') === $department ? 'selected' : '' ?>><?= esc($department) ?></option>
                    <?php endforeach; ?>
                </select>

                <label class="auth-label" for="admin-password">Password</label>
                <input id="admin-password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>

                <button type="submit">Sign in to staff portal</button>
            </form>
            <p class="auth-switch"><a href="<?= base_url('/') ?>">Back to home</a></p>
        </div>
    </div>
</section>

<?= view('layout/footer') ?>
