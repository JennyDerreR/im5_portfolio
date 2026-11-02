<?php
$data = $args['data'];
js_log($data);
?>


<section data-module="hero_front">
    <p class="heading"><?= $data['heading'] ?></p>
    <h1 class="title"><?= $data['title'] ?></h1>
    <p class="subline"><?= $data['subline'] ?></p>
    <img src="<?= $data['image']['src'] ?>" alt="<?= $data['image']['alt'] ?>">
</section>