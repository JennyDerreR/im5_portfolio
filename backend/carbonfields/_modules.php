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