<?php
$data = $args['data'];
?>

<section data-module="education">
    <h2 class="module-title"><?= esc_html($data['title']) ?></h2>

    <?php if (!empty($data['items'])): ?>
        <div class="sketch-path">
            <svg class="sketch-svg" aria-hidden="true" focusable="false"></svg>

            <ol class="sketch-list">
                <?php foreach ($data['items'] as $item): ?>
                    <li class="sketch-item">
                        <span class="sketch-years"><?= esc_html($item['years']) ?></span>
                        <h3 class="sketch-title"><?= esc_html($item['title']) ?></h3>

                        <?php if (!empty($item['place'])): ?>
                            <p class="sketch-place"><?= esc_html($item['place']) ?></p>
                        <?php endif; ?>

                        <?php if (!empty($item['text'])): ?>
                            <p class="sketch-text"><?= esc_html($item['text']) ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    <?php endif; ?>
</section>