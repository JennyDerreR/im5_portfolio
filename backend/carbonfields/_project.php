<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
Container::make('post_meta', 'Projekt')
        ->where('post_type', '=', 'project')
        ->add_fields([
                Field::make('image', 'image', 'Bild')->set_required()->set_help_text('Format und Grösse beachten, bei Journalismus Screenshot aus dem Artikel sofern keine eigene Datei vorhanden ist.'),
                Field::make('textarea', 'lead', 'Lead')->set_help_text('Kurzbeschrieb des Projekts, max. 3-4 Sätze'),
                Field::make('rich_text', 'text', 'Text')->set_help_text('Bilder über “Add Media” hinzufügen'),
                Field::make('complex', 'tasks', 'Meine Aufgaben')->add_fields([Field::make('text', 'task', 'Aufgabe')]),
                Field::make('text', 'medium', 'Medium'),
                Field::make('text', 'external_link', 'Link zum Original')->set_attribute('type', 'url'),
                Field::make('media_gallery', 'gallery', 'Galerie'),
                Field::make('oembed', 'video', 'Video')->set_help_text('Ersetzt das Bild, falls vorhanden.'),
                Field::make('file', 'audio', 'Audio')->set_help_text('MP3-Datei hochladen'),
                Field::make('text', 'sm_post', 'Link zum Post')->set_attribute('type', 'url')->set_help_text('Nur bei Social Media Projekten, Link zum Post auf der Plattform'),

            // Felder hier einfügen
        ]);