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

    <?php if ($project['medium']): ?>
        <p>Medium: <?= $project['medium'] ?></p>
    <?php endif; ?>

    <?php if ($project['video']): ?>
        <div class="project-media project-media--video"><?= wp_oembed_get($project['video']) ?></div>
    <?php elseif ($project['image']): ?>
        <div class="project-media project-media--image">
            <img src="<?= $project['image']['src'] ?>" alt="<?= $project['image']['alt'] ?>">
        </div>
    <?php endif; ?>

    <?php if ($project['audio']): ?>
        <audio class="project-audio" controls src="<?= $project['audio'] ?>"></audio>
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
                <button type="button" class="gallery-item" data-index="<?= $i ?>" aria-label="Foto <?= $i + 1 ?> vergrössern">
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
        // Plattformname aus dem Link lesen (Rückfall: die Adresse selbst)
        $sm_host = preg_replace('/^www\./', '', parse_url($project['sm_post'], PHP_URL_HOST) ?: '');
        $sm_name = $sm_host;
        foreach (['instagram' => 'Instagram', 'tiktok' => 'TikTok', 'youtube' => 'YouTube', 'youtu.be' => 'YouTube', 'linkedin' => 'LinkedIn', 'facebook' => 'Facebook'] as $needle => $name) {
            if (str_contains($sm_host, $needle)) { $sm_name = $name; break; }
        }
        $sm_embed = wp_oembed_get($project['sm_post']);
        ?>

        <?php if ($sm_embed): ?>
            <div class="project-embed"><?= $sm_embed ?></div>
        <?php endif; ?>

        <a class="project-sm-card" href="<?= $project['sm_post'] ?>" target="_blank" rel="noopener" aria-label="<?= $sm_name ?>: Post ansehen (öffnet in neuem Tab)">
        <span class="sm-card-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M10 14l11 -11"/><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"/></svg>
        </span>
            <span class="sm-card-text">
            <span class="sm-card-label"><?= $sm_name ?></span>
            <span class="sm-card-title">Post ansehen</span>
        </span>
        </a>
    <?php endif; ?>
</main>