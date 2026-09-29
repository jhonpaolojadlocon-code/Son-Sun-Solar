<?= view('layout/header') ?>

<div class="main-container">
    <div class="content-box">
        <h1>YES, THE <?= esc(strtoupper($platformName)) ?> BUTTON IS WORKING.</h1>

        <p>
            This is a temporary link for the <?= esc($platformName) ?> button.
        </p>

        <p>
            The official <?= esc($platformName) ?> account does not exist yet, but the button is connected correctly.
        </p>

        <p>
            Once the real account is ready, this temporary page can be replaced with the real link.
        </p>

        <p>
            <a href="<?= base_url('/') ?>" class="project-link">Go back to the home page</a>
        </p>
    </div>
</div>

<?= view('layout/footer') ?>
