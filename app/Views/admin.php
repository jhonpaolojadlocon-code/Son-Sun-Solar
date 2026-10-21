<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#102b4b">
    <title>Operations overview | Sun Son Solar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="admin-dashboard-page">
<div class="admin-dashboard-shell">
    <aside class="admin-sidebar" aria-label="Operations console">
        <a class="admin-brand" href="<?= base_url('admin') ?>"><span aria-hidden="true">☼</span> SUN SON SOLAR</a>
        <p class="admin-sidebar-label">OPERATIONS CONSOLE</p>
        <nav class="admin-nav" aria-label="Operations navigation">
            <a href="<?= base_url('admin') ?>"><span>•</span> Overview</a>
            <a class="active" href="<?= base_url('admin') ?>" aria-current="page"><span>•</span> Master schedule</a>
            <a href="<?= base_url('admin') ?>#staff"><span>•</span> User management</a>
            <a href="<?= base_url('admin') ?>#staff"><span>•</span> Field team</a>
            <a href="<?= base_url('admin') ?>#performance"><span>•</span> Reports &amp; analytics</a>
            <a href="<?= base_url('admin') ?>#requests"><span>•</span> Notifications</a>
            <a href="<?= base_url('admin') ?>#automation"><span>•</span> System settings</a>
        </nav>
        <div class="admin-account"><span>Admin access</span><span>Role-based permissions</span></div>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <div>
                <h1>Operations overview</h1>
                <p>Dispatch, staff access, and service performance.</p>
            </div>
            <div class="admin-topbar-actions">
                <span class="admin-online"><i aria-hidden="true"></i> System online</span>
                <a class="admin-help" href="<?= base_url('about') ?>">Help</a>
            </div>
        </header>

        <div class="admin-content">
            <div class="admin-toolbar">
                <p><?= esc(date('l, F j, Y')) ?></p>
                <div class="admin-toolbar-actions">
                    <a class="admin-primary-button" href="#staff"><span aria-hidden="true">＋</span> Add employee</a>
                    <button class="admin-secondary-button" type="button" onclick="window.print()">Export report</button>
                </div>
            </div>

            <section class="admin-metrics" aria-label="Operations summary">
                <article class="admin-card admin-metric"><h2>Requests to review</h2><p>4 urgent</p><strong>12</strong></article>
                <article class="admin-card admin-metric"><h2>Jobs today</h2><p>21 assigned</p><strong>28</strong></article>
                <article class="admin-card admin-metric"><h2>Technicians active</h2><p>2 unavailable</p><strong>16 / 18</strong></article>
                <article class="admin-card admin-metric"><h2>Revenue this month</h2><p>+12.6% vs last month</p><strong>₱ 1.84M</strong></article>
            </section>

            <div class="admin-grid">
                <section class="admin-card admin-schedule" aria-labelledby="master-schedule-title">
                    <div class="admin-card-heading">
                        <div><h2 id="master-schedule-title">Master schedule</h2><p>OCTOBER 2026&nbsp; · &nbsp;WEEK VIEW</p></div>
                    </div>
                    <div class="schedule-week" aria-label="Schedule for October 21 to 25">
                        <article class="schedule-day"><h3>MON 21</h3><div class="schedule-job consultation"><strong>09:00 ·</strong><span>Consultation</span></div><div class="schedule-job installation"><strong>11:30 ·</strong><span>Installation</span></div></article>
                        <article class="schedule-day"><h3>TUE 22</h3><div class="schedule-job consultation"><strong>09:00 ·</strong><span>Consultation</span></div><div class="schedule-job installation"><strong>11:30 ·</strong><span>Installation</span></div></article>
                        <article class="schedule-day"><h3>WED 23</h3><div class="schedule-job consultation"><strong>09:00 ·</strong><span>Consultation</span></div><div class="schedule-job installation"><strong>11:30 ·</strong><span>Installation</span></div></article>
                        <article class="schedule-day"><h3>THU 24</h3><div class="schedule-job consultation"><strong>09:00 ·</strong><span>Consultation</span></div><div class="schedule-job installation"><strong>11:30 ·</strong><span>Installation</span></div></article>
                        <article class="schedule-day"><h3>FRI 25</h3><div class="schedule-job consultation"><strong>09:00 ·</strong><span>Consultation</span></div><div class="schedule-job installation"><strong>11:30 ·</strong><span>Installation</span></div></article>
                    </div>
                </section>

                <section class="admin-card admin-requests" id="requests" aria-labelledby="pending-requests-title">
                    <h2 id="pending-requests-title">Pending requests</h2>
                    <article class="request-row"><strong>Maria Santos</strong><p>Panel maintenance&nbsp; · &nbsp;Today · 10:30 AM</p><div><button type="button" class="admin-primary-button">Approve</button><button type="button" class="admin-secondary-button">Reschedule</button></div></article>
                    <article class="request-row"><strong>Daniel Reyes</strong><p>Solar consultation&nbsp; · &nbsp;Tomorrow · 2:00 PM</p><div><button type="button" class="admin-primary-button">Approve</button><button type="button" class="admin-secondary-button">Reschedule</button></div></article>
                    <article class="request-row"><strong>Ella Cruz</strong><p>Inverter inspection&nbsp; · &nbsp;Oct 24 · 9:00 AM</p><div><button type="button" class="admin-primary-button">Approve</button><button type="button" class="admin-secondary-button">Reschedule</button></div></article>
                </section>

                <section class="admin-card admin-performance" id="performance">
                    <h2>Service performance</h2>
                    <p>Completed jobs&nbsp; 86%<br>On-time arrival&nbsp; 94%<br>Customer satisfaction&nbsp; 4.8 / 5</p>
                </section>
                <section class="admin-card admin-automation" id="automation">
                    <h2>Automation center</h2>
                    <p>SMS reminders: Enabled<br>Email confirmations: Enabled<br>Urgent incident alerts: Immediate</p>
                </section>
            </div>
        </div>
    </main>
</div>
</body>
</html>
