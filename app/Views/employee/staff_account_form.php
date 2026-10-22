<form class="staff-account-form" method="post" action="<?= esc($formAction) ?>">
    <?= csrf_field() ?>
    <div class="staff-form-field">
        <label class="auth-label" for="staff-first-name">First name</label>
        <input id="staff-first-name" type="text" name="first_name" value="<?= esc(old('first_name')) ?>" autocomplete="given-name" required>
    </div>
    <div class="staff-form-field">
        <label class="auth-label" for="staff-last-name">Last name</label>
        <input id="staff-last-name" type="text" name="last_name" value="<?= esc(old('last_name')) ?>" autocomplete="family-name" required>
    </div>
    <div class="staff-form-field">
        <label class="auth-label" for="staff-middle-name">Middle name</label>
        <input id="staff-middle-name" type="text" name="middle_name" value="<?= esc(old('middle_name')) ?>" autocomplete="additional-name" required>
    </div>
    <div class="staff-form-field">
        <label class="auth-label" for="staff-birthday">Birthday</label>
        <input id="staff-birthday" type="date" name="birthday" value="<?= esc(old('birthday')) ?>" required>
    </div>
    <div class="staff-form-field">
        <label class="auth-label" for="staff-gender">Gender</label>
        <select id="staff-gender" name="gender" required>
            <option value="">Select gender</option>
            <?php foreach (['Male', 'Female'] as $genderOption): ?>
                <option value="<?= esc($genderOption) ?>" <?= old('gender') === $genderOption ? 'selected' : '' ?>><?= esc($genderOption) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="staff-form-field">
        <label class="auth-label" for="staff-email">Email</label>
        <input id="staff-email" type="email" name="email" value="<?= esc(old('email')) ?>" autocomplete="email" required>
    </div>
    <div class="staff-form-field">
        <label class="auth-label" for="staff-phone">Phone number</label>
        <input id="staff-phone" type="tel" name="phone_number" value="<?= esc(old('phone_number')) ?>" autocomplete="tel" required>
    </div>
    <div class="staff-form-field">
        <label class="auth-label" for="staff-department-create">Department</label>
        <select id="staff-department-create" name="department" required>
            <option value="">Choose department</option>
            <?php foreach ($departments as $departmentOption): ?>
                <option value="<?= esc($departmentOption) ?>" <?= old('department') === $departmentOption ? 'selected' : '' ?>><?= esc($departmentOption) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="staff-form-field staff-form-wide">
        <label class="auth-label" for="staff-address">Address</label>
        <textarea id="staff-address" name="address" autocomplete="street-address" required><?= esc(old('address')) ?></textarea>
    </div>
    <div class="staff-form-field">
        <label class="auth-label" for="staff-new-password">Password</label>
        <input id="staff-new-password" type="password" name="password" minlength="6" autocomplete="new-password" required>
    </div>
    <div class="staff-form-field">
        <label class="auth-label" for="staff-confirm-password">Confirm password</label>
        <input id="staff-confirm-password" type="password" name="confirm_password" minlength="6" autocomplete="new-password" required>
    </div>
    <div class="staff-form-wide">
        <button class="button button-primary" type="submit"><?= esc($submitLabel) ?></button>
    </div>
</form>
