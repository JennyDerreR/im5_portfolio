<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// -> Konfiguration der verschiedenen Module
Container::make('post_meta', 'Module')
    ->where('post_type', '=', 'page')
    ->add_fields([
        Field::make('complex', 'modules', 'Module')
            // -> example
            ->add_fields('example', 'Beispiel', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('image', 'image', 'Bild')->set_required(),
            ])

            // -> hero_front
            ->add_fields('hero_front', 'Hero Startseite', [
                Field::make('text', 'heading', 'Spitzmarke')
                    ->set_required()
                    ->set_help_text('Tags über dem Namen, z. B. Fotografie · Film · Journalismus · Social Media'),
                Field::make('text', 'title', 'Name')
                    ->set_required(),
                Field::make('textarea', 'subline', 'Rolle')
                    ->set_rows(2)
                    ->set_help_text('Optional, z. B. Studentin Multimedia Production'),
                Field::make('image', 'image', 'Bild')
                    ->set_help_text('Foto von dir. Ohne Bild bleibt eine graue Fläche stehen.'),
            ])

            // -> statement
            ->add_fields('statement', 'Statement', [
                Field::make('textarea', 'headline', 'Haupttext')
                    ->set_required()
                    ->set_rows(2)
                    ->set_help_text('Wörter in *Sternchen* werden grün, z. B. Capturing *stories*, one *frame* at a time.'),
                Field::make('textarea', 'subline', 'Zweiter Text')
                    ->set_rows(2)
                    ->set_help_text('Optional. Erscheint kleiner und grau in der rechten Hälfte.'),
            ])

            // -> overview_projects
            ->add_fields('overview_projects', 'Übersicht Projekte', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('association', 'selection', 'Auswahl Projekte')
                    ->set_max(3)
                    ->set_types([
                        [
                            'type'      => 'post',
                            'post_type' => 'project',
                        ]
                    ])
            ])

            // -> contact
            ->add_fields('contact', 'Kontakt', [
                Field::make('text', 'title', 'Titel')
                    ->set_required()
                    ->set_default_value('Let\'s Connect'),
                Field::make('text', 'email', 'E-Mail')
                    ->set_required()
                    ->set_attribute('type', 'email'),
                Field::make('text', 'instagram', 'Instagram')
                    ->set_attribute('type', 'url')
                    ->set_help_text('Optional, ganzer Link mit https://'),
                Field::make('text', 'linkedin', 'LinkedIn')
                    ->set_attribute('type', 'url')
                    ->set_help_text('Optional, ganzer Link mit https://'),
            ])

            // -> hero_about
            ->add_fields('hero_about', 'Hero Über mich', [
                Field::make('text', 'heading', 'Spitzmarke')
                    ->set_help_text('Optional, kleine grüne Zeile über dem Titel, z. B. Über mich'),
                Field::make('textarea', 'title', 'Titel')
                    ->set_required()
                    ->set_rows(2)
                    ->set_help_text('Wörter in *Sternchen* werden grün, z. B. Hi, ich bin *Jennifer*.'),
                Field::make('textarea', 'text', 'Text')
                    ->set_required()
                    ->set_rows(6)
                    ->set_help_text('Leerzeile = neuer Absatz.'),
                Field::make('image', 'image', 'Polaroid')
                    ->set_help_text('Quadratisch, 1200 × 1200. Ohne Bild bleibt eine graue Fläche stehen.'),
                Field::make('text', 'caption', 'Beschriftung Polaroid')
                    ->set_help_text('Optional, steht unten auf dem Polaroid.'),
            ])

            // -> software
            ->add_fields('software', 'Software', [
                Field::make('text', 'title', 'Titel')
                    ->set_required()
                    ->set_default_value('Damit arbeite ich'),
                Field::make('complex', 'items', 'Programme')
                    ->set_layout('tabbed-horizontal')
                    ->add_fields([
                        Field::make('text', 'name', 'Name')->set_required(),
                        Field::make('checkbox', 'basics', 'Grundkenntnisse')
                            ->set_option_value('yes')
                            ->set_help_text('Anhaken, wenn du erst die Grundlagen kannst. Sonst wird kein Level angezeigt.'),
                        Field::make('image', 'icon', 'Logo')
                            ->set_help_text('Optional, quadratisch, PNG mit transparentem Hintergrund.'),
                    ])
                    ->set_header_template('<%- name %>'),
            ])

            // -> education
            ->add_fields('education', 'Bildungsweg', [
                Field::make('text', 'title', 'Titel')
                    ->set_required()
                    ->set_default_value('Bildungsweg'),
                Field::make('complex', 'items', 'Stationen')
                    ->set_layout('tabbed-horizontal')
                    ->set_help_text('Reihenfolge per Drag-and-drop, die oberste steht zuerst.')
                    ->add_fields([
                        Field::make('text', 'years', 'Jahre')
                            ->set_required()
                            ->set_help_text('z. B. 2017 – 2020 oder seit 2023'),
                        Field::make('text', 'title', 'Titel')
                            ->set_required()
                            ->set_help_text('z. B. Lehre Fachfrau Gesundheit'),
                        Field::make('text', 'place', 'Ort / Schule')
                            ->set_help_text('Optional'),
                        Field::make('textarea', 'text', 'Beschreibung')
                            ->set_rows(2)
                            ->set_help_text('Optional, ein bis zwei Sätze.'),
                    ])
                    ->set_header_template('<%- years %> <%- title %>'),
            ])

            // -> hobbies
            ->add_fields('hobbies', 'Hobbies', [
                Field::make('text', 'title', 'Titel')
                    ->set_required()
                    ->set_default_value('Hobbies'),
                Field::make('complex', 'items', 'Polaroids')
                    ->set_max(8)
                    ->set_layout('tabbed-horizontal')
                    ->set_help_text('Höchstens 8. Bilder quadratisch, 1200 × 1200.')
                    ->add_fields([
                        Field::make('image', 'image', 'Bild')->set_required(),
                        Field::make('text', 'label', 'Beschriftung vorne')
                            ->set_required()
                            ->set_help_text('Kurz, z. B. Feuerwehr'),
                        Field::make('textarea', 'note', 'Text Rückseite')
                            ->set_rows(2)
                            ->set_help_text('Erscheint, wenn man das Polaroid umdreht.'),
                    ])
                    ->set_header_template('<%- label %>'),
            ])

            // -> all_projects
            ->add_fields('all_projects', 'Alle Projekte (nach Kategorie)', [
                Field::make('text', 'title', 'Titel')
                    ->set_required()
                    ->set_default_value('Arbeiten'),
                Field::make('textarea', 'intro', 'Einleitung')
                    ->set_rows(2)
                    ->set_help_text('Optional, ein bis zwei Sätze unter dem Titel.'),
            ])

            // -> text_page
            ->add_fields('text_page', 'Textseite', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('rich_text', 'text', 'Text')
                    ->set_required()
                    ->set_help_text('Für Impressum, Datenschutz usw. Zwischentitel als „Überschrift 2“ formatieren.'),
            ])

            // todo: add new modules here
            // -> SETTINGS
            ->set_layout('tabbed-vertical')
    ]);

// -> Hilfsfunktion: Wörter in *Sternchen* werden grün hervorgehoben
function accent_words (string $text): string {
    return preg_replace('/\*(.+?)\*/u', '<span class="accent">$1</span>', esc_html($text));
}

// -> Funktion, um die Module und die entsprechenden Templates auf der Seite zu laden
function render_modules (): void {
    $modules = carbon_get_the_post_meta('modules');
    if (empty($modules)) {
        return;
    }
    foreach ($modules as $module) {
        // -> Modifiziere die Daten des Moduls, falls nötig, basierend auf dem Modultyp
        switch ($module['_type']) {
            case 'example':
                $module['image'] = get_media_by_id($module['image'], 'full');
                break;

            case 'hero_front':
                // Das Bild ist optional, solange das Foto noch fehlt
                $module['image'] = !empty($module['image']) ? get_media_by_id($module['image'], 'full') : null;
                break;

            case 'hero_about':
                $module['image'] = !empty($module['image']) ? get_media_by_id($module['image'], 'medium_large') : null;
                break;

            case 'software':
                $module['items'] = array_map(function($item) {
                    $item['icon'] = !empty($item['icon']) ? get_media_by_id($item['icon'], 'thumbnail') : null;
                    return $item;
                }, $module['items'] ?? []);
                break;

            case 'hobbies':
                $module['items'] = array_map(function($item) {
                    $item['image'] = get_media_by_id($item['image'], 'medium_large');
                    return $item;
                }, $module['items'] ?? []);
                break;

            case 'all_projects':
                // Kategorien mit Icon und Reihenfolge holen
                $terms = get_terms([
                    'taxonomy'   => 'project_category',
                    'hide_empty' => true,
                ]);
                $terms = is_wp_error($terms) ? [] : $terms;

                $groups = array_map(function($term) {
                    $icon = carbon_get_term_meta($term->term_id, 'icon');
                    return [
                        'slug'  => $term->slug,
                        'title' => $term->name,
                        'sort'  => (int) carbon_get_term_meta($term->term_id, 'sort'),
                        'icon'  => $icon ? get_media_by_id($icon, 'thumbnail') : null,
                        // alle Projekte dieser Kategorie, neueste zuerst
                        'ids'   => get_posts([
                            'post_type'      => 'project',
                            'posts_per_page' => -1,
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                            'fields'         => 'ids',
                            'tax_query'      => [[
                                'taxonomy' => 'project_category',
                                'field'    => 'term_id',
                                'terms'    => $term->term_id,
                            ]],
                        ]),
                    ];
                }, $terms);

                usort($groups, fn($a, $b) => [$a['sort'], $a['title']] <=> [$b['sort'], $b['title']]);
                $module['groups'] = $groups;
                break;

            // todo: add data modifications for modules here as a new case

            case 'overview_projects':
                $module['selection'] = array_map(function($item) {
                    return (int) $item['id'];
                }, $module['selection'] ?? []);
                break;
        }

        // -> Laden des Templates basierend auf dem Modultyp und weitergeben der Daten
        get_template_part(
            'frontend/views/modules/' . $module['_type'],
            null,
            [
                'data' => $module
            ]
        );
    }
}