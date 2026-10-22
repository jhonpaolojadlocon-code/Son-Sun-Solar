<?= view('layout/header') ?>

<main class="employee-page">
    <section class="employee-heading">
        <div>
            <p class="eyebrow">Employee workspace</p>
            <h1>Good day.</h1>
            <p><?= esc($employeeEmail) ?> <span class="employee-department"><?= esc($department) ?></span></p>
        </div>
        <div class="employee-date"><?= esc(date('l, F j, Y')) ?></div>
    </section>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="auth-message error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="auth-message success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <section class="employee-today">
        <div class="employee-card employee-clock-card">
            <p class="eyebrow">Today's attendance</p>
            <div class="employee-status">
                <span class="employee-status-dot <?= $todayRecord && $todayRecord['time_out'] ? 'is-done' : ($todayRecord ? 'is-active' : '') ?>"></span>
                <?= $todayRecord ? ($todayRecord['time_out'] ? 'Shift completed' : 'Currently clocked in') : 'Not clocked in yet' ?>
            </div>
            <div class="employee-times">
                <div><span>Time in</span><strong><?= $todayRecord ? esc(date('g:i A', strtotime($todayRecord['time_in']))) : '—' ?></strong></div>
                <div><span>Time out</span><strong><?= $todayRecord && $todayRecord['time_out'] ? esc(date('g:i A', strtotime($todayRecord['time_out']))) : '—' ?></strong></div>
            </div>
            <div class="employee-clock-actions">
                <?php if (! $todayRecord): ?>
                    <form method="post" action="<?= base_url('admin/time-in') ?>" id="time-in-form"><input type="hidden" name="employee_name" value="<?= esc($employeeEmail) ?>"><input type="hidden" name="latitude" id="attendance-latitude"><input type="hidden" name="longitude" id="attendance-longitude"><button class="button button-primary" type="submit">Time in at site</button><small id="location-status" class="employee-empty">Location is optional; allow location access to attach coordinates.</small></form>
                <?php elseif (! $todayRecord['time_out']): ?>
                    <form method="post" action="<?= base_url('admin/time-out') ?>"><button class="button button-primary" type="submit">Time out</button></form>
                <?php else: ?>
                    <p>Your attendance for today is complete.</p>
                <?php endif; ?>
            </div>
        </div>
        <aside class="employee-card employee-note">
            <span class="employee-note-icon" aria-hidden="true">✓</span>
            <h2>Keep your time up to date</h2>
            <p>Record your start and end times here. You can only submit one time in and one time out each day.</p>
        </aside>
    </section>

    <section class="employee-card employee-history">
        <div class="employee-section-heading"><div><p class="eyebrow">Field work</p><h2>Assigned customer jobs</h2></div></div>
        <?php if ($jobs): ?><div class="employee-table-wrap"><table class="employee-table"><thead><tr><th>Customer</th><th>Service</th><th>Address</th><th>Schedule</th><th>Status</th></tr></thead><tbody><?php foreach ($jobs as $job): ?><tr><td><?= esc(trim(($job['first_name'] ?? '') . ' ' . ($job['last_name'] ?? ''))) ?></td><td><?= esc($job['service_type']) ?></td><td><?= esc($job['address']) ?></td><td><?= esc(date('M j, Y g:i A', strtotime($job['scheduled_for']))) ?></td><td><?= esc($job['status']) ?></td></tr><?php endforeach; ?></tbody></table></div><?php else: ?><p class="employee-empty">No customer jobs are assigned to you yet.</p><?php endif; ?>
    </section>
    <div class="employee-today">
        <section class="employee-card employee-history"><p class="eyebrow">Team updates</p><h2>Announcements</h2><?php if ($announcements): ?><?php foreach ($announcements as $item): ?><article class="announcement-item"><strong><?= esc($item['title']) ?></strong><p><?= nl2br(esc($item['message'])) ?></p><small><?= esc(date('M j, Y', strtotime($item['created_at']))) ?></small></article><?php endforeach; ?><?php else: ?><p class="employee-empty">HR and admin announcements will appear here.</p><?php endif; ?></section>
        <section class="employee-card employee-create-account"><h2>Submit a field report</h2><form method="post" action="<?= base_url('admin/reports') ?>"><label class="auth-label">Related job</label><select name="booking_id"><option value="">No specific job</option><?php foreach ($jobs as $job): ?><option value="<?= (int) $job['id'] ?>"><?= esc($job['service_type'] . ' — ' . date('M j', strtotime($job['scheduled_for']))) ?></option><?php endforeach; ?></select><label class="auth-label">Issue or customer concern</label><textarea name="details" rows="4" required></textarea><button class="button button-primary" type="submit">Send report</button></form></section>
    </div>

    <section class="employee-card employee-history">
        <div class="employee-section-heading"><div><p class="eyebrow">Your records</p><h2>Recent attendance</h2></div></div>
        <?php if ($history): ?>
            <div class="employee-table-wrap">
                <table class="employee-table">
                    <thead><tr><th>Date</th><th>Time in</th><th>Time out</th><th>Status</th></tr></thead>
                    <tbody>
                    <?php foreach ($history as $record): ?>
                        <tr>
                            <td><?= esc(date('M j, Y', strtotime($record['work_date']))) ?></td>
                            <td><?= esc(date('g:i A', strtotime($record['time_in']))) ?></td>
                            <td><?= $record['time_out'] ? esc(date('g:i A', strtotime($record['time_out']))) : '—' ?></td>
                            <td><span class="employee-record-status <?= $record['time_out'] ? 'is-done' : 'is-open' ?>"><?= $record['time_out'] ? 'Complete' : 'In progress' ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="employee-empty">Your attendance history will show here after you clock in.</p>
        <?php endif; ?>
    </section>

    <?php if (in_array($department, ['Administration', 'HR'], true)): ?>
    <section class="employee-card employee-create-account">
        <details open>
            <summary><span><span class="eyebrow">Staff management</span><strong>Create a staff account</strong></span><span class="staff-create-caret" aria-hidden="true">⌄</span></summary>
            <p class="employee-empty">Enter the same profile details as customer signup. The email address will be the staff member's sign-in username.</p>
            <?= view('employee/staff_account_form', [
                'formAction' => base_url('admin/staff/create'),
                'submitLabel' => 'Create staff account',
                'departments' => $departments,
            ]) ?>
        </details>
    </section>
    <?php endif; ?>
    <?php if (in_array($department, ['Administration', 'HR', 'Dispatch'], true)): ?>
    <section class="employee-card employee-history"><div class="employee-section-heading"><div><p class="eyebrow">Operations</p><h2>Schedule overview</h2></div></div>
        <?php if ($bookings): ?><div class="employee-table-wrap"><table class="employee-table"><thead><tr><th>Customer</th><th>Service</th><th>Schedule</th><th>Address</th><th>Assignment and status</th></tr></thead><tbody><?php foreach ($bookings as $booking): ?><tr><td><?= esc(trim(($booking['first_name'] ?? '') . ' ' . ($booking['last_name'] ?? '')) ?: $booking['customer_email']) ?></td><td><?= esc($booking['service_type']) ?></td><td><?= esc(date('M j, Y g:i A', strtotime($booking['scheduled_for']))) ?></td><td><?= esc($booking['address']) ?></td><td><form method="post" action="<?= base_url('admin/bookings/' . $booking['id']) ?>"><select name="assigned_employee"><option value="">Unassigned</option><?php foreach ($staff as $person): if ((int) ($person['IsActive'] ?? 1) !== 1) continue; ?><option value="<?= esc($person['Username']) ?>" <?= ($booking['assigned_employee'] ?? '') === $person['Username'] ? 'selected' : '' ?>><?= esc(($person['FirstName'] ?? '') . ' ' . ($person['LastName'] ?? '') . ' · ' . $person['Username']) ?></option><?php endforeach; ?></select><select name="status"><?php foreach (['Pending','Approved','Declined','Completed'] as $status): ?><option <?= $booking['status'] === $status ? 'selected' : '' ?>><?= esc($status) ?></option><?php endforeach; ?></select><button type="submit">Save</button></form></td></tr><?php endforeach; ?></tbody></table></div><?php else: ?><p class="employee-empty">Customer service requests will appear here.</p><?php endif; ?>
    </section>
    <?php endif; ?>
    <?php if (in_array($department, ['Administration', 'HR'], true)): ?>
    <section class="employee-card employee-create-account"><h2>Publish an announcement</h2><form method="post" action="<?= base_url('admin/announcements') ?>"><label class="auth-label">Title</label><input name="title" maxlength="160" required><label class="auth-label">Message</label><textarea name="message" rows="3" required></textarea><label class="auth-label">Audience</label><select name="audience"><option value="employees">Employees</option><option value="customers">Customers</option><option value="all">Everyone</option></select><button class="button button-primary" type="submit">Publish</button></form></section>
    <section class="employee-card employee-history"><div class="employee-section-heading"><div><p class="eyebrow">Configuration</p><h2>Services, pricing, and availability</h2></div></div><div class="employee-table-wrap"><table class="employee-table"><thead><tr><th>Service</th><th>Price</th><th>Available to request</th><th></th></tr></thead><tbody><?php foreach ($serviceCatalog as $service): $serviceForm = 'service-form-' . (int) $service['id']; ?><tr><td><form id="<?= esc($serviceForm) ?>" method="post" action="<?= base_url('admin/services') ?>"></form><input form="<?= esc($serviceForm) ?>" name="service_name" maxlength="80" value="<?= esc($service['service_name']) ?>" readonly></td><td><input form="<?= esc($serviceForm) ?>" name="price" type="number" min="0" step="0.01" value="<?= esc($service['price'] ?? '') ?>" placeholder="Set price"></td><td><select form="<?= esc($serviceForm) ?>" name="available"><option value="1" <?= (int) $service['available'] === 1 ? 'selected' : '' ?>>Available</option><option value="0" <?= (int) $service['available'] !== 1 ? 'selected' : '' ?>>Unavailable</option></select></td><td><button form="<?= esc($serviceForm) ?>" type="submit">Save</button></td></tr><?php endforeach; ?><tr><td><form id="service-form-new" method="post" action="<?= base_url('admin/services') ?>"></form><input form="service-form-new" name="service_name" placeholder="New service" maxlength="80" required></td><td><input form="service-form-new" name="price" type="number" min="0" step="0.01" placeholder="Set price"></td><td><select form="service-form-new" name="available"><option value="1">Available</option><option value="0">Unavailable</option></select></td><td><button form="service-form-new" type="submit">Add service</button></td></tr></tbody></table></div></section>
    <section class="employee-card employee-history"><div class="employee-section-heading"><div><p class="eyebrow">Account access</p><h2>Staff accounts</h2></div></div><div class="employee-table-wrap"><table class="employee-table"><thead><tr><th>Employee</th><th>Department</th><th>Account</th><th></th></tr></thead><tbody><?php foreach ($staff as $person): ?><tr><td><?= esc(trim(($person['FirstName'] ?? '') . ' ' . ($person['LastName'] ?? '')) ?: $person['Username']) ?></td><td><?= esc($person['Department']) ?></td><td><?= (int) ($person['IsActive'] ?? 1) === 1 ? 'Active' : 'Deactivated' ?></td><td><?php if ((int) ($person['IsActive'] ?? 1) === 1): ?><form method="post" action="<?= base_url('admin/staff/' . $person['ID'] . '/deactivate') ?>" onsubmit="return confirm('Deactivate this staff account?')"><button type="submit">Deactivate</button></form><?php endif; ?></td></tr><?php endforeach; ?></tbody></table></div></section>
    <section class="employee-card employee-history"><p class="eyebrow">Reports and analytics</p><h2>Service activity</h2><div class="employee-times"><div><span>Total requests</span><strong><?= (int) $analytics['total'] ?></strong></div><div><span>Pending</span><strong><?= (int) $analytics['pending'] ?></strong></div><div><span>Completed</span><strong><?= (int) $analytics['completed'] ?></strong></div></div><?php if ($analytics['usage']): ?><h3>Requests by service</h3><?php foreach ($analytics['usage'] as $usage): ?><div class="announcement-item"><strong><?= esc($usage['service_type']) ?></strong><span> <?= (int) $usage['booking_count'] ?> requests</span></div><?php endforeach; ?><?php else: ?><p class="employee-empty">Service activity will appear when customers request appointments.</p><?php endif; ?><h3>Field reports</h3><?php if ($reports): ?><?php foreach ($reports as $report): ?><article class="announcement-item"><strong><?= esc($report['employee_email']) ?> · <?= esc(date('M j, Y g:i A', strtotime($report['created_at']))) ?></strong><p><?= nl2br(esc($report['details'])) ?></p></article><?php endforeach; ?><?php else: ?><p class="employee-empty">Field reports will appear here.</p><?php endif; ?><h3>Customer support requests</h3><?php if ($supportTickets): ?><?php foreach ($supportTickets as $ticket): ?><article class="announcement-item"><strong><?= esc(trim(($ticket['first_name'] ?? '') . ' ' . ($ticket['last_name'] ?? '')) ?: $ticket['email']) ?> · <?= esc($ticket['subject']) ?></strong><p><?= nl2br(esc($ticket['message'])) ?></p><small><?= esc($ticket['status']) ?> · <?= esc(date('M j, Y g:i A', strtotime($ticket['created_at']))) ?></small></article><?php endforeach; ?><?php else: ?><p class="employee-empty">Customer support requests will appear here.</p><?php endif; ?></section>
    <?php endif; ?>
</main>

<script>
document.getElementById('time-in-form')?.addEventListener('submit', function (event) {
    const status = document.getElementById('location-status');
    if (!navigator.geolocation || this.dataset.locationChecked === '1') return;
    event.preventDefault();
    const form = this;
    navigator.geolocation.getCurrentPosition(function (position) {
        document.getElementById('attendance-latitude').value = position.coords.latitude;
        document.getElementById('attendance-longitude').value = position.coords.longitude;
        status.textContent = 'Location attached to your time in.';
        form.dataset.locationChecked = '1';
        form.requestSubmit();
    }, function () { status.textContent = 'Location unavailable; your time in will still be recorded.'; form.dataset.locationChecked = '1'; form.requestSubmit(); }, { enableHighAccuracy: true, timeout: 2500, maximumAge: 0 });
});
</script>

<?= view('layout/footer') ?>
