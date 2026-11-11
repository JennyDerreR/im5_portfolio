<?php
global $wp;
$menu = get_menu_by_slug('legal_menu');
$current_url = trailingslashit(home_url($wp->request));
?>

<footer data-layout="footer">
    <p>© <?= date('Y') ?> Jennifer Derrer. Alle Rechte vorbehalten.</p>

    <nav class="nav-container" aria-label="Rechtliches">
        <ul class="nav">
            <?php foreach ($menu as $item): ?>
                <?php $is_current = trailingslashit($item['url']) === $current_url; ?>
                <li class="nav-item">
                    <a href="<?= esc_url($item['url']) ?>"
                       <?php if (!empty($item['target'])): ?>target="<?= esc_attr($item['target']) ?>" rel="noopener"<?php endif; ?>
                       <?php if ($is_current): ?>aria-current="page"<?php endif; ?>>
                        <?= esc_html($item['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</footer>