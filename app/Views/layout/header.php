<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Operation Apostle</title>

    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
</head>

<body>

<header class="navbar">
    <a href="<?= base_url('/') ?>" class="logo">
        OPERATION <br> APOSTLE
    </a>

    <nav>
        <a href="<?= base_url('/') ?>">Home</a>
        <a href="<?= base_url('details') ?>">Details</a>
        <a href="<?= base_url('agent') ?>">Agent</a>
        <a href="<?= base_url('about') ?>">About us</a>
        <?php if (session()->get('username')): ?>
            <span class="user-badge">Hi, <?= esc((string) session()->get('username')) ?></span>
            <a href="<?= base_url('logout') ?>">Logout</a>
        <?php else: ?>
            <a href="<?= base_url('login') ?>">Login</a>
            <a href="<?= base_url('register') ?>" class="nav-cta">Sign Up</a>
        <?php endif; ?>
    </nav>
=======
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
>>>>>>> e4eea015a47fb28b5fdecd33cbb63d32711396f5
</header>
