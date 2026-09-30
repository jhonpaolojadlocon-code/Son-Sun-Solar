<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Sun Son Solar | Clean energy for your home</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>

<body>
<header class="site-header">
    <div class="header-inner">
        <a href="<?= base_url('/') ?>" class="brand" aria-label="Sun Son Solar home">
            <span class="brand-mark" aria-hidden="true">☀</span>
            <span>Sun Son Solar</span>
        </a>

        <nav class="main-nav" aria-label="Main navigation">
            <a href="<?= base_url('/') ?>">Home</a>
            <a href="<?= base_url('/') ?>#benefits">Benefits</a>
            <a href="<?= base_url('/') ?>#how-it-works">How it works</a>
            <a href="<?= base_url('/') ?>#get-started">Contact</a>
        </nav>

        <div class="header-actions">
            <?php if (session()->get('username')): ?>
                <span class="user-badge">Hi, <?= esc((string) session()->get('username')) ?></span>
                <a class="nav-login" href="<?= base_url('logout') ?>">Log out</a>
            <?php else: ?>
                <a class="nav-login" href="<?= base_url('login') ?>">Log in</a>
                <a class="button button-primary header-cta" href="<?= base_url('register') ?>">Get started</a>
            <?php endif; ?>
        </div>
    </div>
</header>
