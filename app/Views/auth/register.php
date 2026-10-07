<?= view('layout/header') ?>

<section class="auth-page">
    <div class="auth-shell">
        <div class="auth-hero">
            <p class="eyebrow">Get started with solar</p>
            <h1>Make room for a brighter future.</h1>
            <p>
                Create your account to begin planning a cleaner, more affordable way to power your home.
            </p>

            <div class="auth-highlights">
                <div class="auth-chip">Personalized solar plan</div>
                <div class="auth-chip">Easy account setup</div>
                <div class="auth-chip">Friendly support</div>
            </div>
        </div>

        <div class="auth-box auth-card">
            <p class="eyebrow">Sign Up</p>
            <h2>Create your account</h2>
            <p class="auth-intro">Enter your details to create your employee account.</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="auth-message error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('register') ?>">
                <label class="auth-label" for="register-first-name">First Name</label>
                <input id="register-first-name" type="text" name="first_name" placeholder="First name" value="<?= esc(old('first_name')) ?>" autocomplete="given-name" required>

                <label class="auth-label" for="register-last-name">Last Name</label>
                <input id="register-last-name" type="text" name="last_name" placeholder="Last name" value="<?= esc(old('last_name')) ?>" autocomplete="family-name" required>

                <label class="auth-label" for="register-middle-name">Middle Name</label>
                <input id="register-middle-name" type="text" name="middle_name" placeholder="Middle name" value="<?= esc(old('middle_name')) ?>" autocomplete="additional-name" required>

                <label class="auth-label" for="register-birthday">Birthday</label>
                <input id="register-birthday" type="date" name="birthday" value="<?= esc(old('birthday')) ?>" required>

                <label class="auth-label" for="register-gender">Gender</label>
                <select id="register-gender" name="gender" required>
                    <option value="">Select gender</option>
                    <?php foreach (['Female', 'Male', 'Non-binary', 'Prefer not to say'] as $gender): ?>
                        <option value="<?= esc($gender) ?>" <?= old('gender') === $gender ? 'selected' : '' ?>><?= esc($gender) ?></option>
                    <?php endforeach; ?>
                </select>

                <label class="auth-label" for="register-email">Email</label>
                <input id="register-email" type="email" name="email" placeholder="you@example.com" value="<?= esc(old('email', (string) service('request')->getGet('email'))) ?>" autocomplete="email" required>

                <label class="auth-label" for="register-phone">Phone Number</label>
                <input id="register-phone" type="tel" name="phone_number" placeholder="Phone number" value="<?= esc(old('phone_number')) ?>" autocomplete="tel" required>

                <label class="auth-label" for="register-address">Address</label>
                <textarea id="register-address" name="address" placeholder="Street, city, and other address details" autocomplete="street-address" required><?= esc(old('address')) ?></textarea>

                <label class="auth-label" for="register-department">Department</label>
                <select id="register-department" name="department">
                    <option value="">Select a department (optional)</option>
                    <?php foreach (['Administration', 'IT Dispatch', 'Accounting', 'HR', 'Marketing', 'Sales', 'Customer service'] as $department): ?>
                        <option value="<?= esc($department) ?>" <?= old('department') === $department ? 'selected' : '' ?>><?= esc($department) ?></option>
                    <?php endforeach; ?>
                </select>

                <label class="auth-label" for="register-password">Password</label>
                <input id="register-password" type="password" name="password" placeholder="At least 6 characters" autocomplete="new-password" required>

                <label class="auth-label" for="register-confirm-password">Confirm Password</label>
                <input id="register-confirm-password" type="password" name="confirm_password" placeholder="Retype your password" autocomplete="new-password" required>

                <button type="submit">Create Account</button>
            </form>

            <p class="auth-switch">Already registered? <a href="<?= base_url('login') ?>">Sign in here</a></p>
        </div>
    </div>
</section>

<?= view('layout/footer') ?>
