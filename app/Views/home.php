<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#102b4b">
    <title>Energy dashboard | Sun Son Solar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="dashboard-page">
<div class="dashboard-shell">
    <aside class="dashboard-sidebar" aria-label="Customer dashboard">
        <a class="dashboard-brand" href="<?= base_url('/') ?>">
            <span class="dashboard-brand-mark" aria-hidden="true">☼</span>
            <span>SUN SON SOLAR</span>
        </a>
        <p class="sidebar-label">ENERGY MANAGEMENT</p>
        <nav class="dashboard-nav" aria-label="Dashboard navigation">
            <a class="active" href="<?= base_url('/') ?>" aria-current="page"><span aria-hidden="true">•</span> Overview</a>
            <a href="<?= base_url('details') ?>"><span aria-hidden="true">•</span> Service bookings</a>
            <a href="<?= base_url('agent') ?>"><span aria-hidden="true">•</span> My solar system</a>
            <a href="<?= base_url('details') ?>"><span aria-hidden="true">•</span> Service history</a>
            <a href="<?= base_url('details') ?>"><span aria-hidden="true">•</span> Payments &amp; receipts</a>
            <a href="<?= base_url('about') ?>"><span aria-hidden="true">•</span> Support center</a>
        </nav>
        <div class="sidebar-account">
            <span><?= esc((string) (session()->get('username') ?: 'Katherine & Santino')) ?></span>
            <span>Sinagaraw founders</span>
        </div>
    </aside>

    <main class="dashboard-main">
        <header class="dashboard-topbar">
            <div>
                <h1>Good morning, <?= esc((string) (session()->get('username') ?: 'Alex')) ?> 👋</h1>
                <p>Here’s your solar service overview.</p>
            </div>
            <div class="topbar-actions">
                <span class="online-status"><span aria-hidden="true"></span> System online</span>
                <a class="help-button" href="<?= base_url('about') ?>">Help</a>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="dashboard-intro">
                <p>Your clean-energy journey, all in one place.</p>
                <a class="book-button" href="<?= base_url('details') ?>"><span aria-hidden="true">＋</span> Book a service</a>
            </div>

            <section class="metric-grid" aria-label="Account summary">
                <article class="dashboard-card metric-card">
                    <h2>Next appointment</h2><p>Installation review</p><strong>Oct 28 · 9:00 AM</strong>
                </article>
                <article class="dashboard-card metric-card">
                    <h2>System status</h2><p>4.8 kW generated today</p><strong class="status-good">Performing well</strong>
                </article>
                <article class="dashboard-card metric-card">
                    <h2>Lifetime savings</h2><p>Estimated bill savings</p><strong>₱ 48,620</strong>
                </article>
                <article class="dashboard-card metric-card">
                    <h2>Open requests</h2><p>Awaiting confirmation</p><strong>1 request</strong>
                </article>
            </section>

            <div class="dashboard-grid">
                <section class="dashboard-card upcoming-card">
                    <h2>Upcoming service</h2>
                    <div class="appointment-row">
                        <div class="appointment-date"><strong>OCT</strong><span>28</span></div>
                        <div class="appointment-info"><strong>Installation review</strong><span>9:00 AM – 11:00 AM&nbsp; · &nbsp;Pasig City</span></div>
                        <span class="confirmed-pill">Confirmed</span>
                    </div>
                    <a class="details-button" href="<?= base_url('details') ?>">View booking details</a>
                </section>

                <section class="dashboard-card notifications-card">
                    <h2>Notifications</h2>
                    <article class="notification-item"><strong>Service request received</strong><p>We’ve received your maintenance request.</p><time>2h ago</time></article>
                    <article class="notification-item"><strong>Technician assigned</strong><p>Marco D. will visit on Oct 28.</p><time>Yesterday</time></article>
                    <article class="notification-item"><strong>Energy tip</strong><p>Keep panels clear for better output.</p><time>Oct 18</time></article>
                </section>

                <section class="dashboard-card snapshot-card">
                    <h2>Solar system snapshot</h2>
                    <p>System: Residential rooftop<br>Inverter: Online<br>Battery: 92% charged<br>Last sync: 2 minutes ago</p>
                </section>
                <section class="dashboard-card support-card">
                    <h2>Need a hand?</h2>
                    <p>Chat with our support team or create a ticket.<br>Average response: under 1 business day.</p>
                    <a href="<?= base_url('about') ?>" aria-label="Contact support">Contact support</a>
                </section>
            </div>
        </div>
    </main>
</div>
</body>
</html>
