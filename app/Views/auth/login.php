<?= view('layout/header') ?>

<section class="auth-page">
    <div class="auth-shell">
        <div class="auth-hero">
            <p class="eyebrow">Secure Access</p>
            <h1>Return to the mission.</h1>
            <p>
                Sign in to continue your Operation Apostle profile and keep your progress attached to your username.
            </p>

            <div class="auth-highlights">
                <div class="auth-chip">Persistent username</div>
                <div class="auth-chip">Fast sign-in flow</div>
                <div class="auth-chip">Shared site styling</div>
            </div>
        </div>

        <div class="auth-box auth-card">
            <p class="eyebrow">Login</p>
            <h2>Welcome Back</h2>
            <p class="auth-intro">Use your username and password to continue where you left off.</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="auth-message error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="auth-message success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('login') ?>">
                <label class="auth-label" for="login-username">Username or Email</label>
                <input id="login-username" type="text" name="username" placeholder="Enter your username or email" value="<?= esc(old('username')) ?>" required>

                <label class="auth-label" for="login-password">Password</label>
                <input id="login-password" type="password" name="password" placeholder="Enter your password" required>

                <button type="submit">Sign In</button>
            </form>

            <p class="auth-switch">Need an account? <a href="<?= base_url('register') ?>">Create one here</a></p>
        </div>
    </div>
</section>

<?= view('layout/footer') ?>
