<?= view('layout/header') ?>

<<<<<<< HEAD
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
=======
<main>
    <section class="hero section-wrap" aria-labelledby="hero-title">
        <div class="hero-copy">
            <p class="eyebrow"><span class="sun-mark" aria-hidden="true">✦</span> Next-gen clean energy</p>
            <h1 id="hero-title">Power your home with clean solar energy</h1>
            <p class="hero-lede">Lower your electric bill and feel good about the energy you use. Get a solar plan made for your home in just a few minutes.</p>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="notice-success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>

            <div class="hero-actions">
                <a class="button button-primary" href="<?= base_url('register') ?>">Create customer account <span aria-hidden="true">→</span></a>
                <a class="button button-secondary" href="<?= base_url('login') ?>">Staff / admin portal</a>
            </div>
            <div class="hero-proof"><span class="proof-stars" aria-hidden="true">★★★★★</span> Trusted solar support from plan to installation</div>
        </div>

        <div class="hero-art" role="img" aria-label="Modern home with rooftop solar panels in a sunny neighborhood">
            <svg class="solar-scene" viewBox="0 0 900 560" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <defs>
                    <linearGradient id="sky" x1="0" y1="0" x2="0" y2="1"><stop stop-color="#83c8f7"/><stop offset="1" stop-color="#e8f7ff"/></linearGradient>
                    <linearGradient id="wall" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#f2dfc8"/><stop offset="1" stop-color="#c7a987"/></linearGradient>
                    <linearGradient id="glass" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#a8d9ee"/><stop offset="1" stop-color="#386a84"/></linearGradient>
                    <linearGradient id="lawn" x1="0" y1="0" x2="0" y2="1"><stop stop-color="#90bb71"/><stop offset="1" stop-color="#537f50"/></linearGradient>
                    <filter id="soft-shadow" x="-30%" y="-30%" width="160%" height="180%"><feDropShadow dx="0" dy="18" stdDeviation="18" flood-color="#17334c" flood-opacity=".2"/></filter>
                </defs>
                <rect width="900" height="560" fill="url(#sky)"/>
                <circle cx="722" cy="104" r="52" fill="#fff3bd" opacity=".95"/>
                <path d="M0 305 118 212l99 79 107-119 141 143 120-99 167 112 148-94v139H0Z" fill="#a4c4c1" opacity=".55"/>
                <path d="M0 342 137 245l105 83 116-85 130 99 142-111 141 110 129-71v116H0Z" fill="#70979a" opacity=".42"/>
                <path d="M0 364c136-34 218-21 340 8s225 35 560-13v201H0Z" fill="url(#lawn)"/>
                <g opacity=".95">
                    <path d="M0 330h152v86H0z" fill="#fff5e8"/><path d="m-12 330 83-61 92 61Z" fill="#687a88"/><path d="M22 353h33v44H22zM100 352h32v31h-32z" fill="url(#glass)"/>
                    <path d="M732 320h168v91H732z" fill="#f7f0e6"/><path d="m713 321 99-68 106 68Z" fill="#596e7d"/><path d="M760 345h39v39h-39zM827 345h43v39h-43z" fill="url(#glass)"/>
                </g>
                <g filter="url(#soft-shadow)">
                    <path d="M222 303 495 147l271 156v177H222Z" fill="url(#wall)"/>
                    <path d="M180 308 495 119l306 189-31 26-275-166-285 170Z" fill="#424b52"/>
                    <path d="m220 305 275-164 271 166-5 20-266-160-271 161Z" fill="#66747a"/>
                    <path d="M285 327h153v153H285z" fill="#805a42"/><path d="M301 344h121v136H301z" fill="#6c4b3a"/><path d="M312 357h98v123h-98z" fill="#a8754f"/>
                    <path d="M490 324h224v111H490z" fill="url(#glass)"/><path d="M501 335h97v88h-97zM607 335h96v88h-96z" fill="#90cce0" opacity=".72"/><path d="M603 324v111M490 429h224" stroke="#f4eee3" stroke-width="10"/>
                    <path d="M477 454h255v26H477z" fill="#5d6465"/><path d="M242 480h523v16H242z" fill="#ded0bf"/>
                    <path d="M340 204 493 113l190 116-155 19Z" fill="#143c59" stroke="#d8e4e8" stroke-width="6"/>
                    <path d="m392 173 177 7M364 190l179 8M338 207l181 9M441 143l-22 80M491 113l-25 115M541 144l-25 85M591 174l-25 58" stroke="#92b5c7" stroke-width="3" opacity=".8"/>
                    <path d="M187 480h605" stroke="#eee4d5" stroke-width="12" stroke-linecap="round"/>
                </g>
                <g fill="#315f49"><circle cx="182" cy="392" r="44"/><circle cx="213" cy="375" r="37"/><circle cx="750" cy="399" r="51"/><circle cx="788" cy="376" r="40"/><circle cx="108" cy="432" r="24"/><circle cx="835" cy="436" r="29"/></g>
                <g fill="#d8e9b7"><circle cx="165" cy="379" r="17"/><circle cx="765" cy="385" r="18"/><circle cx="203" cy="359" r="13"/><circle cx="808" cy="361" r="15"/></g>
                <path d="M127 502c173-20 472-20 666 0" fill="none" stroke="#d9e6cf" stroke-width="5" opacity=".7"/>
            </svg>
            <div class="art-caption"><span class="caption-icon" aria-hidden="true">☀</span><span><strong>Make sunshine work for you</strong><small>Smart solar, designed around your home</small></span></div>
        </div>
    </section>

    <section class="benefits-section" id="benefits" aria-labelledby="benefits-title">
        <div class="section-wrap">
            <div class="section-heading">
                <p class="eyebrow">A brighter way to power home</p>
                <h2 id="benefits-title">Why choose Sun Son Solar?</h2>
                <p>We make going solar smooth, secure, and worth it.</p>
            </div>
            <div class="benefit-grid">
                <article class="benefit-card">
                    <div class="benefit-icon" aria-hidden="true">＄</div>
                    <h3>Zero upfront cost</h3>
                    <p>Start saving from day one with flexible payment plans designed around your budget.</p>
                </article>
                <article class="benefit-card">
                    <div class="benefit-icon" aria-hidden="true">♢</div>
                    <h3>25-year warranty</h3>
                    <p>Get dependable coverage for your panels, inverters, and expert installation.</p>
                </article>
                <article class="benefit-card">
                    <div class="benefit-icon" aria-hidden="true">▣</div>
                    <h3>Real-time app tracking</h3>
                    <p>See your energy production, savings, and system health wherever you are.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="steps-section" id="how-it-works" aria-labelledby="steps-title">
        <div class="section-wrap">
            <div class="section-heading">
                <p class="eyebrow">Easy from the start</p>
                <h2 id="steps-title">How it works</h2>
                <p>From signup to sunshine in three simple steps.</p>
            </div>
            <div class="steps-grid">
                <article class="step-card"><span class="step-icon" aria-hidden="true">♙</span><span class="step-number">1</span><h3>Create your account</h3><p>Sign up in under two minutes with your basic information.</p></article>
                <article class="step-card"><span class="step-icon" aria-hidden="true">▤</span><span class="step-number">2</span><h3>Get your solar plan</h3><p>We shape a solar solution around your home and energy use.</p></article>
                <article class="step-card"><span class="step-icon" aria-hidden="true">☼</span><span class="step-number">3</span><h3>Start saving</h3><p>Our certified team installs your system so you can start saving.</p></article>
            </div>
        </div>
    </section>

    <section class="signup-cta" id="get-started" aria-labelledby="signup-title">
        <div class="section-wrap signup-inner">
            <p class="eyebrow">Your solar journey starts here</p>
            <h2 id="signup-title">Ready to start saving?</h2>
            <p>Enter your email to create an account and get started.</p>
            <form class="signup-form" action="<?= base_url('register') ?>" method="get">
                <label class="visually-hidden" for="signup-email">Your email address</label>
                <input id="signup-email" type="email" name="email" placeholder="Enter your email address" required>
                <button class="button button-primary" type="submit">Continue <span aria-hidden="true">→</span></button>
            </form>
        </div>
    </section>
</main>
>>>>>>> e4eea015a47fb28b5fdecd33cbb63d32711396f5

<?= view('layout/footer') ?>
