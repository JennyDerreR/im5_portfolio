<?php
global $wp;
$menu = get_menu_by_slug('main_menu');
$logo = get_globals_logo();

// aktuelle Adresse, um den aktiven Menüpunkt zu markieren
$current_url = trailingslashit(home_url($wp->request));
?>

<header data-layout="header">
    <a class="logo-link" href="<?= esc_url(home_url('/')) ?>" aria-label="Zur Startseite">
        <img class="logo" src="<?= $logo['src'] ?>" alt="<?= esc_attr($logo['alt']) ?>">
    </a>

    <nav class="nav-container" aria-label="Hauptnavigation">
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
</header>