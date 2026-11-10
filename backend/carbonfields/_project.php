<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
Container::make('post_meta', 'Projekt')
    ->where('post_type', '=', 'project')
    ->add_fields([
        Field::make('image', 'image', 'Bild')
            ->set_required()
            ->set_help_text('Format und Grösse beachten, bei Journalismus Screenshot aus dem Artikel sofern keine eigene Datei vorhanden ist.'),
        Field::make('textarea', 'lead', 'Lead')
            ->set_help_text('Kurzbeschrieb des Projekts, max. 3-4 Sätze'),

        Field::make('complex', 'content', 'Inhalt')
            ->setup_labels(['plural_name' => 'Bausteine', 'singular_name' => 'Baustein'])
            ->add_fields('text', 'Text', [
                Field::make('rich_text', 'text', 'Text'),
            ])
            ->add_fields('image', 'Bild', [
                Field::make('image', 'image', 'Bild')
                    ->set_required(),
                Field::make('text', 'caption', 'Bildunterschrift'),
                Field::make('text', 'credit', 'Foto von'),
                Field::make('select', 'size', 'Grösse')
                    ->set_options([
                        'normal' => 'Textbreite',
                        'wide'   => 'Breit (wie das Video)',
                    ]),
            ]),

        Field::make('complex', 'tasks', 'Meine Aufgaben')
            ->add_fields([Field::make('text', 'task', 'Aufgabe')]),
        Field::make('text', 'medium', 'Medium')
            ->set_help_text('Nur Journalismus, ausgeschrieben, z. B. Aargauer Zeitung. Wird unter dem Titelbild angezeigt.'),
        Field::make('date', 'date', 'Datum')
            ->set_help_text('Erscheinungsdatum des Artikels. Wird unter dem Medium angezeigt.'),
        Field::make('text', 'external_link', 'Link zum Original')
            ->set_attribute('type', 'url')
            ->set_help_text('Link zum Artikel. Mit PDF führt die Karte trotzdem auf diese Seite, ohne PDF direkt zur Zeitung.'),
        Field::make('file', 'pdf', 'Artikel als PDF')
            ->set_type(['application/pdf'])
            ->set_help_text('Unverändert hochladen, so wie du es vom Medium bekommen hast.'),
        Field::make('media_gallery', 'gallery', 'Galerie'),
        Field::make('oembed', 'video', 'Video')
            ->set_help_text('Ersetzt das Bild, falls vorhanden.'),
        Field::make('file', 'audio', 'Audio')
            ->set_help_text('MP3-Datei hochladen'),
        Field::make('text', 'sm_post', 'Link zum Post')
            ->set_attribute('type', 'url')
            ->set_help_text('Nur bei Social Media Projekten, Link zum Post auf der Plattform'),

        // Felder hier einfügen
    ]);