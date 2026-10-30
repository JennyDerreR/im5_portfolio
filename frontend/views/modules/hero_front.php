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

/*Lea hat im Video geschaut, dass man eine Bedingung schreibt und so die Subline nur angezeigt wird, wenn es auch eine gibt (not required) würde das bei mir Sinn machen irgendwo?*/