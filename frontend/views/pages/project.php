<?php
$project = get_project_by_id(get_the_ID());

js_log($project);
?>

<main data-page="project">
    <p class="category">
        <?php foreach ($project['project_categories'] as $category) : ?>
            <span class="category-item"><?= $category['title'] ?></span>
        <?php endforeach; ?>
    </p>

    <h1><?= $project['title'] ?></h1>

    <?php if ($project['lead']): ?>
        <h3 class="lead"><?= $project['lead'] ?></h3>
    <?php endif; ?>

    <?php if ($project['video']): ?>
        <div class="project-media project-media--video"><?= wp_oembed_get($project['video']) ?></div>
    <?php elseif ($project['image']): ?>
        <div class="project-media project-media--image">
            <img src="<?= $project['image']['src'] ?>" alt="<?= $project['image']['alt'] ?>">
        </div>
    <?php endif; ?>

    <?php if ($project['medium'] || $project['date'] || $project['external_link']): ?>
        <div class="project-meta">
            <?php if ($project['medium']): ?>
                <p class="project-medium"><?= $project['medium'] ?></p>
            <?php endif; ?>

            <?php if ($project['date']): ?>
                <p class="project-date"><?= $project['date'] ?></p>
            <?php endif; ?>

            <?php if ($project['external_link']): ?>
                <a class="project-original" href="<?= $project['external_link'] ?>" target="_blank" rel="noopener">Artikel beim Medium lesen ↗</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($project['pdf']): ?>
        <a class="project-sm-card" href="<?= $project['pdf']['url'] ?>" target="_blank" rel="noopener" aria-label="Artikel als PDF lesen (öffnet in neuem Tab)">
            <span class="sm-card-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/><path d="M9 9h1"/><path d="M9 13h6"/><path d="M9 17h6"/></svg>
            </span>
            <span class="sm-card-text">
                <span class="sm-card-label">PDF<?= $project['pdf']['size'] ? ' · ' . $project['pdf']['size'] : '' ?></span>
                <span class="sm-card-title">Artikel als PDF lesen</span>
            </span>
        </a>
    <?php endif; ?>

    <?php if ($project['audio']): ?>
        <div class="audio-player" data-audio>
            <audio preload="metadata" src="<?= $project['audio'] ?>"></audio>

            <div class="audio-top">
                <span class="audio-label">Audio anhören:</span>
                <div class="audio-speed">
                    <button type="button" class="audio-speed-down" aria-label="Langsamer">&minus;</button>
                    <span class="audio-speed-value" aria-live="polite">1.0x</span>
                    <button type="button" class="audio-speed-up" aria-label="Schneller">+</button>
                </div>
            </div>

            <input class="audio-seek" type="range" min="0" max="100" step="0.1" value="0" aria-label="Position im Audio">

            <div class="audio-times">
                <span class="audio-current">00:00</span>
                <span class="audio-duration">00:00</span>
            </div>

            <div class="audio-controls">
                <button type="button" class="audio-btn audio-back" aria-label="10 Sekunden zurück">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19.95 11a8 8 0 1 0 -.5 4m.5 5v-5h-5"/><text x="12" y="15.5" text-anchor="middle" font-size="7" font-weight="600" fill="currentColor" stroke="none">10</text></svg>
                </button>

                <button type="button" class="audio-btn audio-toggle" aria-label="Abspielen">
                    <svg class="icon-play" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" aria-hidden="true"><path d="M7 4.5l12 7.5-12 7.5z"/></svg>
                    <svg class="icon-pause" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><path d="M8 5v14M16 5v14"/></svg>
                </button>

                <button type="button" class="audio-btn audio-forward" aria-label="10 Sekunden vor">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.05 11a8 8 0 1 1 .5 4m-.5 5v-5h5"/><text x="12" y="15.5" text-anchor="middle" font-size="7" font-weight="600" fill="currentColor" stroke="none">10</text></svg>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php foreach ($project['content'] as $block): ?>

        <?php if ($block['_type'] === 'text'): ?>
            <div class="project-text"><?= apply_filters('the_content', $block['text'] ?? '') ?></div>

        <?php elseif ($block['_type'] === 'image' && !empty($block['image'])): ?>
            <?php
            $size    = !empty($block['size']) ? $block['size'] : 'normal';
            $caption = $block['caption'] ?? '';
            $credit  = $block['credit'] ?? '';
            ?>
            <figure class="project-figure project-figure--<?= $size ?>">
                <img src="<?= $block['image']['src'] ?>" alt="<?= $block['image']['alt'] ?>">
                <?php if ($caption || $credit): ?>
                    <figcaption>
                        <?= $caption ?>
                        <?php if ($credit): ?><span class="credit">Foto: <?= $credit ?></span><?php endif; ?>
                    </figcaption>
                <?php endif; ?>
            </figure>

        <?php endif; ?>

    <?php endforeach; ?>

    <?php if ($project['gallery']): ?>
        <div class="project-gallery" data-gallery>
            <?php foreach ($project['gallery'] as $i => $photo): ?>
                <button type="button" class="gallery-item<?= !empty($photo['portrait']) ? ' gallery-item--portrait' : '' ?>" data-index="<?= $i ?>" aria-label="Foto <?= $i + 1 ?> vergrössern">
                    <img src="<?= $photo['src'] ?>" alt="<?= $photo['alt'] ?>" loading="lazy" decoding="async">
                </button>
            <?php endforeach; ?>
        </div>

        <dialog class="lightbox" aria-label="Fotogalerie">
            <button type="button" class="lightbox-close" aria-label="Schliessen">&times;</button>
            <button type="button" class="lightbox-prev" aria-label="Vorheriges Foto">&lsaquo;</button>
            <img class="lightbox-img" src="" alt="">
            <button type="button" class="lightbox-next" aria-label="Nächstes Foto">&rsaquo;</button>
            <p class="lightbox-count"></p>
        </dialog>
    <?php endif; ?>

    <?php if ($project['tasks']): ?>
        <section class="project-tasks">
            <h4>Meine Aufgaben</h4>
            <ul>
                <?php foreach ($project['tasks'] as $task): ?>
                    <li><?= $task ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if ($project['sm_post']): ?>
        <?php
        // Plattform aus dem Link erkennen: Name und Logo (einfarbige Linien-Icons)
        $icon_send    = '<path d="M10 14l11 -11"/><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"/>';
        $icon_youtube = '<path d="M2 8a4 4 0 0 1 4 -4h12a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-12a4 4 0 0 1 -4 -4v-8z"/><path d="M10 9l5 3l-5 3z"/>';

        $platforms = [
                'instagram' => ['Instagram', '<path d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z"/><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/><path d="M16.5 7.5v.01"/>'],
                'tiktok'    => ['TikTok', '<path d="M21 7.917v4.034a9.948 9.948 0 0 1 -5 -1.951v4.5a6.5 6.5 0 1 1 -8 -6.326v4.326a2.5 2.5 0 1 0 4 2v-11.5h4.083a6.005 6.005 0 0 0 4.917 4.917z"/>'],
                'youtube'   => ['YouTube', $icon_youtube],
                'youtu.be'  => ['YouTube', $icon_youtube],
                'linkedin'  => ['LinkedIn', '<path d="M8 11v5"/><path d="M8 8v.01"/><path d="M12 16v-5"/><path d="M16 16v-3a2 2 0 1 0 -4 0"/><path d="M3 7a4 4 0 0 1 4 -4h10a4 4 0 0 1 4 4v10a4 4 0 0 1 -4 4h-10a4 4 0 0 1 -4 -4z"/>'],
                'facebook'  => ['Facebook', '<path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3"/>'],
        ];

        $sm_host = preg_replace('/^www\./', '', parse_url($project['sm_post'], PHP_URL_HOST) ?: '');
        $sm_name = $sm_host;      // Rückfall: die Adresse
        $sm_icon = $icon_send;    // Rückfall: Papierflieger

        foreach ($platforms as $needle => [$label, $paths]) {
            if (strpos($sm_host, $needle) !== false) {
                $sm_name = $label;
                $sm_icon = $paths;
                break;
            }
        }

        $sm_embed = wp_oembed_get($project['sm_post']);
        ?>

        <?php if ($sm_embed): ?>
            <div class="project-embed"><?= $sm_embed ?></div>
        <?php endif; ?>

        <a class="project-sm-card" href="<?= $project['sm_post'] ?>" target="_blank" rel="noopener" aria-label="<?= $sm_name ?>: Post ansehen (öffnet in neuem Tab)">
            <span class="sm-card-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><?= $sm_icon ?></svg>
            </span>
            <span class="sm-card-text">
                <span class="sm-card-label"><?= $sm_name ?></span>
                <span class="sm-card-title">Post ansehen</span>
            </span>
        </a>
    <?php endif; ?>
</main>