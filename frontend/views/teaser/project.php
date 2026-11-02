<?php
$id = $args['id'];
$project = get_project_by_id($id);
?>
<a href="<?= $project['link'] ?>" target="_self">
    <img src="<?= $project['image']['src'] ?>" alt="<?= $project['image']['alt'] ?>">
    <p><?= $project['title'] ?></p>
    <p><?= $project['lead'] ?></p>
</a>