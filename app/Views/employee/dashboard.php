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
                    <form method="post" action="<?= base_url('admin/time-in') ?>"><button class="button button-primary" type="submit">Time in</button></form>
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
</main>

<?= view('layout/footer') ?>
