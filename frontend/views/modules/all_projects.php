<?php
$data   = $args['data'];
$groups = $data['groups'] ?? [];
?>

<section data-module="all_projects">
    <h1 class="module-title"><?= esc_html($data['title']) ?></h1>

    <?php if (!empty($data['intro'])): ?>
        <p class="all-intro"><?= esc_html($data['intro']) ?></p>
    <?php endif; ?>

    <?php if ($groups): ?>
        <div class="filter" role="group" aria-label="Projekte filtern">
            <button class="filter-pill" type="button" data-filter="alle" aria-pressed="true">Alle</button>
            <?php foreach ($groups as $group): ?>
                <button class="filter-pill" type="button" data-filter="<?= esc_attr($group['slug']) ?>" aria-pressed="false">
                    <?= esc_html($group['title']) ?>
                </button>
            <?php endforeach; ?>
        </div>

        <?php foreach ($groups as $group): ?>
            <section class="category" id="<?= esc_attr($group['slug']) ?>" data-category="<?= esc_attr($group['slug']) ?>">
                <h2 class="category-title">
                    <span class="category-icon" aria-hidden="true">
                        <?php if ($group['icon']): ?>
                            <img src="<?= $group['icon']['src'] ?>" alt="" loading="lazy">
                        <?php else: ?>
                            <!-- Platzhalter, bis die eigene Skizze hochgeladen ist -->
                            <svg viewBox="0 0 48 48"><path d="M10 14 C 14 6, 34 4, 39 14 C 45 26, 36 42, 22 41 C 9 40, 4 26, 11 16 C 15 11, 24 9, 30 12"/></svg>
                        <?php endif; ?>
                    </span>
                    <?= esc_html($group['title']) ?>
                    <span class="category-count">· <?= count($group['ids']) ?></span>
                </h2>

                <div class="projects">
                    <?php foreach ($group['ids'] as $project_id): ?>
                        <?php get_template_part('frontend/views/teaser/project', null, ['id' => (int) $project_id]); ?>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>
</section>