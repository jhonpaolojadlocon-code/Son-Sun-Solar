<?= view('layout/header') ?>

<div class="container">

    <div class="agent-card agent-card-sticky">
        <div class="agent-title">AGENT PROFILE</div>

        <?php if (is_file(FCPATH . 'images/the agent herselve.png')): ?>
            <img src="<?= base_url('images/the agent herselve.png') ?>" alt="Agent portrait" class="agent-image">
        <?php else: ?>
            <div class="media-placeholder agent-image">Agent portrait unavailable</div>
        <?php endif; ?>

        <div class="info-box">Name: Classified</div>
        <div class="info-box">Race: Human?</div>
        <div class="info-box">Status: Unknown</div>
        <div class="info-box">Mutation: Apostle Hybrid</div>
    </div>

    <div class="agent-details">
        <h1>AGENT</h1>

        <p>A mysterious survivor.</p>
        <p>
            The agent is a survivor of the horrors that have befallen the world of Operation Apostle. They are a lone wanderer, trying to survive in a world filled with danger and uncertainty. The agent is a complex character, with a dark past and a troubled present. They are a survivor, but they are also a victim of the horrors that have befallen the world.
        </p>

        <div class="abilities">
            <button type="button" class="ability-header" data-ability-toggle aria-expanded="false">
                <span class="ability-arrow">+</span>
                <span>Weapon: Arm Blade</span>
            </button>

            <div class="ability-content" hidden>
                <div class="info-box">Weapon Status: Stable Mutation</div>
                <div class="info-box">Damage Type: Close-Range Slash</div>
                <div class="info-box">Threat Level: High</div>

                <p>
                    The Arm Blade is a mutation born from the agent's corrupted body and sharpened by repeated survival. What once was a human arm has been twisted into a living weapon, reflecting the price of enduring a world consumed by horror.
                </p>

                <p>
                    Every use of the blade is a reminder that power in Operation Apostle always comes with a cost. The weapon represents the agent's struggle between survival and the gradual loss of humanity.
                </p>
            </div>

            <button type="button" class="ability-header" data-ability-toggle aria-expanded="false">
                <span class="ability-arrow">+</span>
                <span>Skill 1: Sanity Consumption</span>
            </button>

            <div class="ability-content" hidden>
                <div class="info-box">Type: Self Buff</div>
                <div class="info-box">Cost: Sanity</div>
                <div class="info-box">Effect: Enhanced attacks and temporary buffs</div>

                <p>
                    Use your sanity to enhance your attacks and gain temporary buffs, but be careful because if you run out of sanity you will be vulnerable to enemy attacks and your vision will become distorted.
                </p>
            </div>

            <button type="button" class="ability-header" data-ability-toggle aria-expanded="false">
                <span class="ability-arrow">+</span>
                <span>Skill 2: Ally Summon</span>
            </button>

            <div class="ability-content" hidden>
                <div class="info-box">Type: Summon</div>
                <div class="info-box">Cost: One Dagger</div>
                <div class="info-box">Effect: Calls an ally to fight beside you</div>

                <p>
                    Use one of your daggers to spawn your own ally that will fight alongside you. This skill turns one of your weapons into a living extension of your will, giving you support when survival becomes overwhelming.
                </p>
            </div>

            <button type="button" class="ability-header" data-ability-toggle aria-expanded="false">
                <span class="ability-arrow">+</span>
                <span>Passive: You Are the Weapon</span>
            </button>

            <div class="ability-content" hidden>
                <div class="info-box">Type: Passive</div>
                <div class="info-box">Effect: Enhances weapon damage through sanity use</div>
                <div class="info-box">Risk: Loss of self with excessive use</div>

                <p>
                    You ARE the weapon. Enhance the damage of the weapon by using your sanity, but be careful because you might lose yourself with excessive use.
                </p>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('[data-ability-toggle]');

    if (toggles.length === 0) {
        return;
    }

    toggles.forEach(function (toggle) {
        const content = toggle.nextElementSibling;
        const arrow = toggle.querySelector('.ability-arrow');

        if (!content) {
            return;
        }

        toggle.addEventListener('click', function () {
            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';

            toggle.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
            content.hidden = isExpanded;

            if (arrow) {
                arrow.textContent = isExpanded ? '+' : '-';
            }
        });
    });
});
</script>

<?= view('layout/footer') ?>
