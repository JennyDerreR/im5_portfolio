<?php
$project = get_project_by_id(get_the_ID());

js_log($project);
?>

<main data-page="project">
    <p class="category">
        <?php foreach ($project['project_categories'] as $category) : ?>
            <span class="category-item"><?= $category['title'] ?></span>
        <?php endforeach; ?>
    </p>

    <h1><?= $project['title'] ?></h1>

    <?php if ($project['lead']): ?>
        <h3 class="lead"><?= $project['lead'] ?></h3> <!-- NEU: Klasse "lead" -->
    <?php endif; ?>

    <?php if ($project['medium']): ?>
        <p>Medium: <?= $project['medium'] ?></p>
    <?php endif; ?>

    <?php if ($project['video']): ?>
        <div class="project-media project-media--video"><?= wp_oembed_get($project['video']) ?></div> <!-- NEU: ein gemeinsamer Platz für Video und Bild -->
    <?php elseif ($project['image']): ?>
        <div class="project-media project-media--image"> <!-- NEU -->
            <img src="<?= $project['image']['src'] ?>" alt="<?= $project['image']['alt'] ?>">
        </div>
    <?php endif; ?>

    <?php if ($project['audio']): ?>
        <audio class="project-audio" controls src="<?= $project['audio'] ?>"></audio> <!-- NEU: Klasse "project-audio" -->
    <?php endif; ?>

    <?php if ($project['text']): ?>
        <div class="project-text"><?= apply_filters('the_content', $project['text']) ?></div> <!-- NEU: Klasse "project-text" -->
    <?php endif; ?>

    <div class="project-gallery">
        <?php foreach ($project['gallery'] as $photo): ?>
            <img src="<?= $photo['src'] ?>" alt="<?= $photo['alt'] ?>">
        <?php endforeach; ?>
    </div>

    <?php if ($project['tasks']): ?>
        <h4>Meine Aufgaben</h4>
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