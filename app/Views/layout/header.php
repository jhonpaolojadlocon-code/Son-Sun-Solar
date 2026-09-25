<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</header>
