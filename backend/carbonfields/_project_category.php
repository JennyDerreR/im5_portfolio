<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// -> Zusatzfelder für die Projektkategorien (Projekte -> Projektkategorien -> Kategorie bearbeiten)
Container::make('term_meta', 'Darstellung')
    ->where('term_taxonomy', '=', 'project_category')
    ->add_fields([
        Field::make('image', 'icon', 'Icon / Skizze')
            ->set_help_text('PNG mit transparentem Hintergrund (weiss gezeichnet) oder SVG, quadratisch. Ohne Bild erscheint ein Platzhalter.'),
        Field::make('text', 'sort', 'Reihenfolge')
            ->set_attribute('type', 'number')
            ->set_default_value('0')
            ->set_help_text('Kleinere Zahl steht weiter oben auf der Seite Arbeiten, z. B. 1, 2, 3.'),
    ]);