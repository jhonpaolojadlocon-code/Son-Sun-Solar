<?= view('layout/header') ?>

<div class="main-container">

    <div class="home-column">
        <div class="content-box">
            <h1>OPERATION APOSTLE</h1>

            <h2>
                <?php if (session()->get('username')): ?>
                    WELCOME, <?= esc(strtoupper(session()->get('username'))) ?>.
                <?php else: ?>
                    WELCOME, DEAR USER.
                <?php endif; ?>
            </h2>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="auth-message success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>

            <p>
                Operation Apostle is a first-person melee horror experience.
                There is no health bar. Your sanity is your life.
            </p>

            <p>
                Use your sanity to enhance your abilities.
                Mutate your body into weapons to survive.
            </p>

            <p>
                Survival is not about strength. It is about control.
            </p>

            <p>
                This is a passion project developed by a solo indie developer. The game is currently in early development, and there is no release date yet. However, the developer is committed to creating a unique and immersive horror experience for players to enjoy.
            </p>

            <p>
                or perhaps recruit me for your projects? LET ME KNOW! all of my information is in the about us page.
            </p>
        </div>

        <div class="content-box">
            <h2>What Is Operation Apostle?</h2>

            <p>
                Operation Apostle is a psychological horror game where it tests your morality to the NPCs in the game world, making choices which will affect the ending of the game depending on your choices.
                Do you have what it takes to survive the horrors of Operation Apostle? Or will you succumb to the darkness that lurks within?
                or lose your mind and become a monster yourself?
            </p>
        </div>
    </div>

    <div class="side-panel">
        <a href="<?= base_url('social/patreon') ?>" class="side-button" aria-label="Patreon">
            <img src="<?= base_url('images/patreon-logo-.webp') ?>" alt="Patreon" class="side-button-icon">
        </a>
        <a href="<?= base_url('social/discord') ?>" class="side-button" aria-label="Discord">
            <img src="<?= base_url('images/Discord-Symbol.png') ?>" alt="Discord" class="side-button-icon">
        </a>
        <a href="<?= base_url('social/x') ?>" class="side-button side-button-x" aria-label="X">
            <img src="<?= base_url('images/twitterx-banner.avif') ?>" alt="X" class="side-button-icon">
        </a>

        <div class="social-box">
            <?php if (is_file(FCPATH . 'video/Trailer.mp4')): ?>
                <video controls>
                    <source src="<?= base_url('video/Trailer.mp4') ?>" type="video/mp4">
                </video>
            <?php else: ?>
                <div class="media-placeholder">Trailer coming soon</div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?= view('layout/footer') ?>
