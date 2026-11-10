<?php
$data = $args['data'];
?>

<section data-module="statement">
    <p class="statement-headline"><?= accent_words($data['headline']) ?></p>

    <?php if (!empty($data['subline'])): ?>
        <p class="statement-subline"><?= esc_html($data['subline']) ?></p>
    <?php endif; ?>
</section>