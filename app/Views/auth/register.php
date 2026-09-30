<?= view('layout/header') ?>

<section class="auth-page">
    <div class="auth-shell">
        <div class="auth-hero">
<<<<<<< HEAD
            <p class="eyebrow">New Operative</p>
            <h1>Create your account.</h1>
            <p>
                Pick a username and secure it with a password to get started.
            </p>

            <div class="auth-highlights">
                <div class="auth-chip">Secure sign-up</div>
                <div class="auth-chip">Simple account setup</div>
                <div class="auth-chip">Clean interface</div>
=======
            <p class="eyebrow">Get started with solar</p>
            <h1>Make room for a brighter future.</h1>
            <p>
                Create your account to begin planning a cleaner, more affordable way to power your home.
            </p>

            <div class="auth-highlights">
                <div class="auth-chip">Personalized solar plan</div>
                <div class="auth-chip">Easy account setup</div>
                <div class="auth-chip">Friendly support</div>
>>>>>>> e4eea015a47fb28b5fdecd33cbb63d32711396f5
            </div>
        </div>

        <div class="auth-box auth-card">
            <p class="eyebrow">Sign Up</p>
<<<<<<< HEAD
            <h2>Join Operation Apostle</h2>
            <p class="auth-intro">Create your account with a clean, simple sign-up flow.</p>
=======
            <h2>Create your account</h2>
            <p class="auth-intro">Tell us a little about yourself to get started.</p>
>>>>>>> e4eea015a47fb28b5fdecd33cbb63d32711396f5

            <?php if (session()->getFlashdata('error')): ?>
                <div class="auth-message error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('register') ?>">
                <label class="auth-label" for="register-username">Username</label>
                <input id="register-username" type="text" name="username" placeholder="Choose a username" value="<?= esc(old('username')) ?>" required>

                <label class="auth-label" for="register-email">Email</label>
<<<<<<< HEAD
                <input id="register-email" type="email" name="email" placeholder="you@example.com" value="<?= esc(old('email')) ?>" required>
=======
                <input id="register-email" type="email" name="email" placeholder="you@example.com" value="<?= esc(old('email', (string) service('request')->getGet('email'))) ?>" required>
>>>>>>> e4eea015a47fb28b5fdecd33cbb63d32711396f5

                <label class="auth-label" for="register-password">Password</label>
                <input id="register-password" type="password" name="password" placeholder="At least 6 characters" required>

                <label class="auth-label" for="register-confirm-password">Confirm Password</label>
                <input id="register-confirm-password" type="password" name="confirm_password" placeholder="Retype your password" required>

                <button type="submit">Create Account</button>
            </form>

            <p class="auth-switch">Already registered? <a href="<?= base_url('login') ?>">Sign in here</a></p>
        </div>
    </div>
</section>

<?= view('layout/footer') ?>
