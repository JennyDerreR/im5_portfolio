<?php
$data = $args['data'];
?>

<section data-module="hero_front">
    <div class="hero-media">
        <?php if (!empty($data['image'])): ?>
            <img src="<?= $data['image']['src'] ?>" alt="<?= $data['image']['alt'] ?>">
        <?php endif; ?>
    </div>

    <div class="hero-text">
        <p class="hero-tags"><?= $data['heading'] ?></p>
        <h1 class="title"><?= $data['title'] ?></h1>

        <?php if (!empty($data['subline'])): ?>
            <p class="hero-role"><?= $data['subline'] ?></p>
        <?php endif; ?>
    </div>
</section>