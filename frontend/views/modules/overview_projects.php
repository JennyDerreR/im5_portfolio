<?php
$data = $args['data'];
?>


<section data-module="overview_projects">
    <h2><?= $data['title'] ?></h2>

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

<?php  /*Lea hat im Video geschaut, dass man eine Bedingung schreibt und so die Subline nur angezeigt wird, wenn es auch eine gibt (not required) würde das bei mir Sinn machen irgendwo?*/ ?>