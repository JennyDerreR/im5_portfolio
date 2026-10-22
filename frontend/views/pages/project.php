<?php
$project = get_project_by_id(get_the_ID());
?>

<main>
    <h1><?= $project['title'] ?></h1>

    <?php if ($project['medium']): ?>
        <p>Medium: <?= $project['medium'] ?></p>
    <?php endif; ?>

    <?php if ($project['lead']): ?>
        <p><?= $project['lead'] ?></p>
    <?php endif; ?>

    <?php if ($project['video']): ?>
        <div><?= wp_oembed_get($project['video']) ?></div>
    <?php elseif ($project['image']): ?>
        <img src="<?= $project['image']['src'] ?>" alt="<?= $project['image']['alt'] ?>">
    <?php endif; ?>

    <?php if ($project['audio']): ?>
        <audio controls src="<?= $project['audio'] ?>"></audio>
    <?php endif; ?>

    <?php if ($project['text']): ?>
        <div><?= apply_filters('the_content', $project['text']) ?></div>
    <?php endif; ?>

    <?php foreach ($project['gallery'] as $photo): ?>
        <img src="<?= $photo['src'] ?>" alt="<?= $photo['alt'] ?>">
    <?php endforeach; ?>

    <?php if ($project['tasks']): ?>
        <h3>Meine Aufgaben</h3>
        <ul>
            <?php foreach ($project['tasks'] as $task): ?>
                <li><?= $task ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($project['sm_post']): ?>
        <p><a href="<?= $project['sm_post'] ?>" target="_blank" rel="noopener">Post auf der Plattform ansehen ↗</a></p>
    <?php endif; ?>
</main>