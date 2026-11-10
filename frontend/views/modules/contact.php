<?php
$data = $args['data'];
?>

<section data-module="contact" id="kontakt">
    <h2 class="module-title"><?= $data['title'] ?></h2>

    <a class="pill" href="mailto:<?= esc_attr($data['email']) ?>"><?= $data['email'] ?></a>

    <?php if (!empty($data['instagram']) || !empty($data['linkedin'])): ?>
        <div class="socials">
            <?php if (!empty($data['instagram'])): ?>
                <a href="<?= esc_url($data['instagram']) ?>" target="_blank" rel="noopener">Instagram</a>
            <?php endif; ?>

            <?php if (!empty($data['linkedin'])): ?>
                <a href="<?= esc_url($data['linkedin']) ?>" target="_blank" rel="noopener">LinkedIn</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>