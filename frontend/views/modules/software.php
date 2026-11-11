<?php
$data = $args['data'];
?>

<section data-module="software">
    <h2 class="module-title"><?= esc_html($data['title']) ?></h2>

    <?php if (!empty($data['items'])): ?>
        <ul class="software-list">
            <?php foreach ($data['items'] as $item): ?>
                <li class="software-item">
                    <?php if (!empty($item['icon'])): ?>
                        <img src="<?= $item['icon']['src'] ?>" alt="" loading="lazy" decoding="async">
                    <?php endif; ?>

                    <span class="software-name"><?= esc_html($item['name']) ?></span>

                    <?php if (!empty($item['basics'])): ?>
                        <span class="level-text">Grundkenntnisse</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>