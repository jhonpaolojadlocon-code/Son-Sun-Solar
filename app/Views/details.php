<?= view('layout/header') ?>

<div class="details-page">

    <div class="left-panel">
        <div class="left-title">OPERATION APOSTLE</div>

        <?php if (is_file(FCPATH . 'images/icon.png')): ?>
            <div class="feature-image-frame">
                <img src="<?= base_url('images/icon.png') ?>" alt="Operation Apostle icon" class="feature-image">
            </div>
        <?php else: ?>
            <div class="media-placeholder feature-image">Key art unavailable</div>
        <?php endif; ?>

        <div class="game-info">
            <div class="info-box">Status: Work in Progress</div>
            <div class="info-box">Date Created: May 3, 2025</div>
            <div class="info-box">Release: TBA</div>
        </div>
    </div>

    <div class="right-panel">
        <h1>What does this logo represent?</h1>

        <p>The logo represents the central theme of sanity and its role in the game's mechanics.
            its shows the depletion of sanity as the character's mind deteriorates, and the transformation into a monstrous form as a result of losing control over their sanity.</p>
            showing cracks of the character and its identity is slowing changing when you use your sanity to enhance your abilities, but at the cost of losing your humanity. The logo captures the essence of the game's psychological horror elements and the consequences of the player's choices regarding their sanity.</p>
            everything has a cost even your sanity, and the logo visually represents the trade-off between power and sanity in the game. 
        </p>

        <h2>Core Mechanics</h2>
        <ul>
            <li>Sanity replaces health</li>
            <li>Mutations as weapons</li>
            <li>Craft sanity pills</li>
            <li>Morality has its buffs and debuffs to yourself</li>
            <li>making right-decisions for what is the intended out come of your actios </li>
        </ul>
    </div>

</div>

<?= view('layout/footer') ?>
