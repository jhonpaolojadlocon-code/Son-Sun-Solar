<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#102b4b">
    <title>Field technician portal | Sun Son Solar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="field-portal-page">
<main class="field-app-shell">
    <header class="field-header">
        <a class="field-brand" href="<?= base_url('field') ?>">
            <span class="field-sun" aria-hidden="true">☀</span>
            <span><strong>Sun Son Solar</strong><small>FIELD TECHNICIAN</small></span>
        </a>
        <span class="field-avatar" aria-label="Technician profile">MD</span>
    </header>

    <div class="field-content">
        <section class="field-greeting">
            <h1>Good morning, <?= esc((string) (session()->get('username') ?: 'Marco')) ?></h1>
            <p>You have 3 jobs assigned today.</p>
        </section>

        <section class="field-assignment" aria-label="Next assignment">
            <div><span class="field-kicker">NEXT ASSIGNMENT</span><strong>Panel maintenance</strong></div>
            <time>9:30 AM</time>
        </section>

        <section class="field-checkin" aria-labelledby="checkin-title">
            <h2 id="checkin-title">Ready at the job site?</h2>
            <button type="button" class="field-checkin-button"><span aria-hidden="true">◎</span> CHECK IN NOW</button>
            <p>Logs your name, timestamp and GPS location.</p>
        </section>

        <section class="field-jobs" id="job-list" aria-labelledby="jobs-title">
            <h2 id="jobs-title">TODAY’S ASSIGNED JOBS</h2>
            <article class="field-job-card">
                <div class="field-job-top"><time>09:30 AM</time><span class="job-state in-progress">In progress</span></div>
                <h3>Panel maintenance</h3>
                <p>Maria Santos · Pasig City</p>
            </article>
            <article class="field-job-card">
                <div class="field-job-top"><time>12:00 PM</time><span class="job-state upcoming">Upcoming</span></div>
                <h3>Inverter inspection</h3>
                <p>Daniel Reyes · Mandaluyong</p>
            </article>
            <article class="field-job-card">
                <div class="field-job-top"><time>03:00 PM</time><span class="job-state upcoming">Upcoming</span></div>
                <h3>Site assessment</h3>
                <p>Ella Cruz · Quezon City</p>
            </article>
        </section>
    </div>

    <nav class="field-bottom-nav" aria-label="Technician navigation">
        <a class="selected" href="<?= base_url('field') ?>" aria-current="page"><span aria-hidden="true">▦</span><small>Today</small></a>
        <a href="#job-list"><span aria-hidden="true">＋</span><small>Jobs</small></a>
        <a href="#checkin-title"><span aria-hidden="true">◉</span><small>Check in</small></a>
        <a href="<?= base_url('login') ?>"><span aria-hidden="true">●</span><small>Profile</small></a>
    </nav>
</main>
</body>
</html>
