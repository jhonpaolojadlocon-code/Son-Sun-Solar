<?= view('layout/header') ?>

<section class="auth-page">
    <div class="auth-shell">
        <div class="auth-hero">
            <p class="eyebrow">Customer portal</p>
            <h1>Your energy, all in one place.</h1>
            <p>
                Sign in to view your solar account and stay connected with your Sun Son Solar team.
            </p>

            <div class="auth-highlights">
                <div class="auth-chip">Account access</div>
                <div class="auth-chip">Project updates</div>
                <div class="auth-chip">Solar support</div>
            </div>
        </div>

        <div class="auth-box auth-card">
            <p class="eyebrow">Login</p>
            <h2>Welcome Back</h2>
            <p class="auth-intro">Use your username or email and password to sign in.</p>

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
