<?= view('layout/header') ?>

<div class="container about-layout">

    <div class="team-card">
        <h2>The Developer</h2>

        <?php if (is_file(FCPATH . 'images/logo.png')): ?>
            <p class="developer-section-title">Developer Logo</p>
            <figure class="developer-logo-box">
                <img
                    src="<?= base_url('images/logo.png') ?>"
                    alt="Developer logo"
                    class="developer-logo"
                >
                <figcaption>Logo</figcaption>
            </figure>

            <div class="developer-contact-box">
                <p class="developer-section-title">Contact</p>
                <p>
                    Wanna contact me? or perhaps hire me for your projects? LET ME KNOW!
                </p>
                <p>
                    Email - jqpogie@gmail.com
                </p>
                <p>
                    Discord - tom#1214
                </p>
            </div>

            <div class="developer-creations-section">
                <h1>Developers Creations</h1>

                <div class="developer-gallery">
                    <?php
                    $developerImages = [
                        ['file' => 'bloxLord.png', 'label' => 'BloxLord'],
                        ['file' => 'bloxTron.png', 'label' => 'BloxTron'],
                        ['file' => 'new godly.png', 'label' => 'New Godly'],
                        ['file' => 'slenderman.jpg', 'label' => 'Blender Starter Model'],
                    ];
                    ?>

                    <?php foreach ($developerImages as $image): ?>
                        <?php if (is_file(FCPATH . 'images/' . $image['file'])): ?>
                            <figure class="developer-shot">
                                <button
                                    type="button"
                                    class="developer-preview"
                                    data-image-src="<?= esc(base_url('images/' . $image['file'])) ?>"
                                    data-image-alt="<?= esc($image['label']) ?> concept art"
                                    data-image-title="<?= esc($image['label']) ?>"
                                    aria-label="Open full image of <?= esc($image['label']) ?>"
                                >
                                    <img
                                        src="<?= base_url('images/' . $image['file']) ?>"
                                        alt="<?= esc($image['label']) ?> concept art"
                                        class="team-image developer-thumb"
                                    >
                                </button>
                                <figcaption><?= esc($image['label']) ?></figcaption>
                            </figure>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="media-placeholder team-image">Developer image unavailable</div>
        <?php endif; ?>

    </div>

    <div class="about-column">
        <div class="about-text-column">
            <div class="about-box">
                <h1>Developer Experiences</h1>

                <p>
                    Operation Apostle is a solo-developed horror game project. The developer, a passionate indie game creator, has been working tirelessly to bring this vision to life.
                </p>

                <p>
                    There is also experience in making concept art for the platform Roblox, including Roblox drawings of models like Ultron, Star-Lord, and Marie, all inspired by different kinds of media.
                </p>
            </div>

            <div class="about-box">
                <h1>Other Experiences</h1>

                <p>
                    Beyond concept art, the developer also has hands-on experience with character and creature design, beginner 3D modeling in Blender, and building original visual ideas from scratch. These projects helped strengthen creative direction, design planning, and the ability to turn rough ideas into polished game-ready concepts.
                </p>
            </div>

            <div class="about-box">
                <h1>Languages I Learned</h1>

                <p>
                    I have learned HTML, PHP, and JavaScript while building projects for school and personal development.
                </p>

                <p>
                    One of the previous projects my teammates and I created was a Donation Management System:
                    <a href="https://bryanrazon.github.io/BSIT2A-Donation-Management-System/" target="_blank" rel="noopener noreferrer" class="project-link">View the project here</a>.
                </p>

                <p>
                    The current language I am learning is Lua, which is used in game scripting, including Roblox. Lua can also be used in different kinds of systems beyond game development.
                </p>
            </div>
        </div>
    </div>

</div>

<div class="image-lightbox" id="developer-lightbox" hidden>
    <div class="image-lightbox-backdrop" data-close-lightbox></div>
    <div class="image-lightbox-dialog" role="dialog" aria-modal="true" aria-labelledby="lightbox-title">
        <button type="button" class="image-lightbox-close" data-close-lightbox aria-label="Close full image">×</button>
        <img src="" alt="" id="lightbox-image" class="image-lightbox-image">
        <p id="lightbox-title" class="image-lightbox-title"></p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const lightbox = document.getElementById('developer-lightbox');
    const image = document.getElementById('lightbox-image');
    const title = document.getElementById('lightbox-title');
    const previewButtons = document.querySelectorAll('.developer-preview');
    const closeButtons = document.querySelectorAll('[data-close-lightbox]');

    if (!lightbox || !image || !title || previewButtons.length === 0) {
        return;
    }

    const closeLightbox = function () {
        lightbox.hidden = true;
        document.body.classList.remove('lightbox-open');
        image.src = '';
        image.alt = '';
        title.textContent = '';
    };

    previewButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            image.src = button.dataset.imageSrc || '';
            image.alt = button.dataset.imageAlt || '';
            title.textContent = button.dataset.imageTitle || '';
            lightbox.hidden = false;
            document.body.classList.add('lightbox-open');
        });
    });

    closeButtons.forEach(function (button) {
        button.addEventListener('click', closeLightbox);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !lightbox.hidden) {
            closeLightbox();
        }
    });
});
</script>

<?= view('layout/footer') ?>
