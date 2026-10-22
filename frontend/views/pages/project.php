<?php
$project = get_project_by_id(get_the_ID());
js_log($project);
?>


<main>
    <h2><?= $project['title']; ?></h2>
    <img src="<?= $project['image']['src']; ?>" alt="<?= $project['image']['alt']; ?>">
    <p><?= $project['image']['src'] ?></p>
    <div>
        <?= wpautop($project['text']) ?>
    </div>

</main>
