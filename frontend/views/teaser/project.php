<?php
$id = $args['id'];
$project = get_project_by_id($id);

// Tag: Kategorie, bei Artikeln zusätzlich das Medium
$tag = $project['project_categories'][0]['title'] ?? '';
if ($tag && $project['medium']) {
    $tag .= ' · ' . $project['medium'];
}
?>

<a class="teaser-project"
   href="<?= $project['link'] ?>"
   <?php if ($project['is_external']): ?>target="_blank" rel="noopener" aria-label="<?= esc_attr($project['title']) ?> (öffnet in neuem Tab)"<?php endif; ?>>

    <div class="teaser-media">
        <?php if ($project['image']): ?>
            <img src="<?= $project['image']['src'] ?>" alt="<?= $project['image']['alt'] ?>" loading="lazy" decoding="async">
        <?php endif; ?>
    </div>

    <div class="teaser-body">
        <?php if ($tag): ?>
            <span class="teaser-tag"><?= $tag ?></span>
        <?php endif; ?>

        <h3 class="teaser-title"><?= $project['title'] ?></h3>

        <?php if (!empty($project['lead'])): ?>
            <p class="teaser-lead"><?= $project['lead'] ?></p>
        <?php endif; ?>

        <span class="teaser-more">
            <?= $project['is_external'] ? 'Artikel lesen ↗' : 'Projekt ansehen →' ?>
        </span>
    </div>
</a>