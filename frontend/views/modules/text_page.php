<?php
$data = $args['data'];
?>

<section data-module="text_page">
    <h1 class="module-title"><?= esc_html($data['title']) ?></h1>

    <div class="text-body">
        <?= wpautop(wp_kses_post($data['text'])) ?>
    </div>
</section>