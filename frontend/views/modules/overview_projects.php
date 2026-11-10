<?php
$data = $args['data'];
?>

<section data-module="overview_projects">
    <h2 class="module-title">
        <?= $data['title'] ?>
        <svg class="squiggle" viewBox="0 0 160 14" aria-hidden="true"><path d="M3 9C25 3 50 4 70 8C90 12 120 5 157 7"/></svg>
    </h2>

    <div class="projects">
        <?php foreach ($data['selection'] as $project_id) : ?>
            <?php
            get_template_part(
                    'frontend/views/teaser/project',
                    null,
                    [
                            'id' => (int) $project_id
                    ]
            );
            ?>
        <?php endforeach; ?>
    </div>
</section>