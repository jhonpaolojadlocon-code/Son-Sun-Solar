<?= view('layout/header') ?>
<main class="employee-page">
    <section class="employee-heading">
        <div><p class="eyebrow">Customer portal</p><h1>Welcome, <?= esc($customer['first_name'] ?: $customer['email']) ?>.</h1><p>Manage service visits, your profile, and support in one place.</p></div>
        <a class="button button-primary" href="#request-service">Request a service</a>
    </section>
    <?php if (session()->getFlashdata('error')): ?><div class="auth-message error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?><div class="auth-message success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
    <section class="employee-card employee-create-account" id="request-service"><h2>Schedule a service</h2><p class="employee-empty">Requests are pending until the team confirms a time.</p>
        <form class="staff-account-form" method="post" action="<?= base_url('customer/bookings') ?>">
            <label>Service<select name="service_type" required><option value="">Choose a service</option><?php foreach ($services as $service): ?><option value="<?= esc($service['service_name']) ?>"><?= esc($service['service_name']) ?><?= $service['price'] !== null ? ' · ₱' . number_format((float) $service['price'], 2) : '' ?></option><?php endforeach; ?></select></label>
            <label>Date and time<input type="datetime-local" name="scheduled_for" required></label>
            <label class="staff-form-wide">Service address<input name="address" value="<?= esc($customer['address'] ?? '') ?>" required></label>
            <label class="staff-form-wide">Notes<textarea name="notes" rows="3"></textarea></label>
            <div><button class="button button-primary" type="submit">Send request</button></div>
        </form>
    </section>
    <section class="employee-card employee-history"><div class="employee-section-heading"><div><p class="eyebrow">Schedule and history</p><h2>Your service requests</h2></div></div>
        <?php if ($bookings): ?><div class="employee-table-wrap"><table class="employee-table"><thead><tr><th>Service</th><th>Date</th><th>Address</th><th>Status</th></tr></thead><tbody><?php foreach ($bookings as $booking): ?><tr><td><?= esc($booking['service_type']) ?></td><td><?= esc(date('M j, Y g:i A', strtotime($booking['scheduled_for']))) ?></td><td><?= esc($booking['address']) ?></td><td><span class="employee-record-status is-open"><?= esc($booking['status']) ?></span></td></tr><?php endforeach; ?></tbody></table></div><?php else: ?><p class="employee-empty">Your requests and completed services will appear here.</p><?php endif; ?>
    </section>
    <div class="employee-today">
        <section class="employee-card employee-history"><p class="eyebrow">Updates</p><h2>Notifications</h2><?php if ($announcements): ?><?php foreach ($announcements as $item): ?><article class="announcement-item"><strong><?= esc($item['title']) ?></strong><p><?= nl2br(esc($item['message'])) ?></p><small><?= esc(date('M j, Y', strtotime($item['created_at']))) ?></small></article><?php endforeach; ?><?php else: ?><p class="employee-empty">Company updates will appear here.</p><?php endif; ?></section>
        <section class="employee-card employee-create-account"><h2>Contact support</h2><form method="post" action="<?= base_url('customer/support') ?>"><label class="auth-label">Subject</label><input name="subject" maxlength="160" required><label class="auth-label">Message</label><textarea name="message" rows="4" required></textarea><button class="button button-primary" type="submit">Send support request</button></form><?php foreach ($tickets as $ticket): ?><article class="announcement-item"><strong><?= esc($ticket['subject']) ?></strong><p><?= esc($ticket['message']) ?></p><small><?= esc($ticket['status']) ?></small></article><?php endforeach; ?></section>
    </div>
    <section class="employee-card employee-create-account"><details><summary><span><span class="eyebrow">Account settings</span><strong>Update profile</strong></span></summary>
        <form class="staff-account-form" method="post" action="<?= base_url('customer/profile') ?>">
            <label>First name<input name="first_name" value="<?= esc($customer['first_name'] ?? '') ?>" required></label><label>Last name<input name="last_name" value="<?= esc($customer['last_name'] ?? '') ?>" required></label><label>Middle name<input name="middle_name" value="<?= esc($customer['middle_name'] ?? '') ?>"></label><label>Email<input value="<?= esc($customer['email']) ?>" disabled></label>
            <label>Birthday<input type="date" name="birthday" value="<?= esc($customer['birthday'] ?? '') ?>" required></label><label>Gender<select name="gender" required><option value="Male" <?= ($customer['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option><option value="Female" <?= ($customer['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option></select></label><label>Phone<input name="phone_number" value="<?= esc($customer['phone_number'] ?? '') ?>" required></label><label class="staff-form-wide">Address<textarea name="address" rows="2" required><?= esc($customer['address'] ?? '') ?></textarea></label><label>Current password (for password change)<input type="password" name="current_password" autocomplete="current-password"></label><label>New password<input type="password" name="new_password" autocomplete="new-password" minlength="6"></label><label>Confirm new password<input type="password" name="confirm_password" autocomplete="new-password" minlength="6"></label><div><button class="button button-primary" type="submit">Save profile</button></div>
        </form>
    </details></section>
</main>
<?= view('layout/footer') ?>
