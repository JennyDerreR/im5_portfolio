<?php
$data = $args['data'];
?>

<section data-module="hero_about">
    <div class="about-content">
        <?php if (!empty($data['heading'])): ?>
            <p class="about-tags"><?= esc_html($data['heading']) ?></p>
        <?php endif; ?>

        <h1 class="title"><?= accent_words($data['title']) ?></h1>

        <div class="about-text">
            <?= wpautop(esc_html($data['text'])) ?>
        </div>
    </div>

    <figure class="about-polaroid">
        <?php if (!empty($data['image'])): ?>
            <img src="<?= $data['image']['src'] ?>" alt="<?= esc_attr($data['image']['alt']) ?>">
        <?php else: ?>
            <span class="about-placeholder"></span>
        <?php endif; ?>

        <?php if (!empty($data['caption'])): ?>
            <figcaption><?= esc_html($data['caption']) ?></figcaption>
        <?php endif; ?>
    </figure>
</section>