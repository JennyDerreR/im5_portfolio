<?php
$id = $args['id'];
$project = get_project_by_id($id);

// Tag: alle Kategorien mit Komma getrennt, bei Artikeln zusätzlich das Medium
$categories = array_filter(array_column($project['project_categories'] ?? [], 'title'));
$tag = implode(', ', $categories);
if ($tag && !empty($project['medium'])) {
    $tag .= ' · ' . $project['medium'];
}
?>

<a class="teaser-project" href="<?= esc_url(get_permalink($id)) ?>">

    <div class="teaser-media">
        <?php if ($project['image']): ?>
            <img src="<?= $project['image']['src'] ?>" alt="<?= esc_attr($project['image']['alt']) ?>" loading="lazy" decoding="async">
        <?php endif; ?>
    </div>

    <div class="teaser-body">
        <?php if ($tag): ?>
            <span class="teaser-tag"><?= esc_html($tag) ?></span>
        <?php endif; ?>

        <h3 class="teaser-title"><?= esc_html($project['title']) ?></h3>

        <?php if (!empty($project['lead'])): ?>
            <p class="teaser-lead"><?= esc_html($project['lead']) ?></p>
        <?php endif; ?>

        <span class="teaser-more">Projekt ansehen →</span>
    </div>
</a>