<?php
$menu = get_menu_by_slug('legal_menu');
js_log($menu);
?>

<footer data-layout="footer">
    <p>© Jennifer Derrer. Alle Rechte vorbehalten.</p>
    <nav class="nav-container">
      <ul class="nav">
        <?php foreach ($menu as $item): ?>
          <li class="nav-item">
            <a target="<?= $item['target']; ?>" href="<?= $item['url']; ?>">
                <?= $item['title']; ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
</footer>