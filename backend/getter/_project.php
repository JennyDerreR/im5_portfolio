<?php

function get_project_by_id(int $id): array
{
    //Daten sammeln
    $title         = get_the_title($id);
    $image_id      = carbon_get_post_meta($id, 'image');
    $image         = get_media_by_id($image_id);
    $lead          = carbon_get_post_meta($id, 'lead');
    $tasks         = array_column(carbon_get_post_meta($id, 'tasks') ?: [], 'task');
    $medium        = carbon_get_post_meta($id, 'medium');
    $external_link = carbon_get_post_meta($id, 'external_link');
    $video         = carbon_get_post_meta($id, 'video');
    $audio_id      = carbon_get_post_meta($id, 'audio');
    $audio         = $audio_id ? wp_get_attachment_url($audio_id) : null;
    $sm_post       = carbon_get_post_meta($id, 'sm_post');

    //Datum (z. B. 12. März 2025)
    $date_raw = carbon_get_post_meta($id, 'date');
    $date     = $date_raw ? date_i18n('j. F Y', strtotime($date_raw)) : null;

    //Galerie: pro Foto merken, ob es hochformatig ist
    $gallery = array_map(function ($gallery_id) {
        $photo = get_media_by_id((int) $gallery_id) ?: [];
        $size  = wp_get_attachment_image_src((int) $gallery_id, 'full');   // [URL, Breite, Höhe]
        $photo['portrait'] = ($size && $size[2] > $size[1]);
        return $photo;
    }, carbon_get_post_meta($id, 'gallery') ?: []);

    //PDF
    $pdf_id = carbon_get_post_meta($id, 'pdf');
    $pdf    = null;
    if ($pdf_id) {
        $pdf_path = get_attached_file($pdf_id);
        $pdf = [
            'url'  => wp_get_attachment_url($pdf_id),
            'size' => ($pdf_path && file_exists($pdf_path)) ? size_format(filesize($pdf_path)) : null,
        ];
    }

    //Inhalt (Bausteine)
    $content = array_map(function ($block) {
        if ($block['_type'] === 'image' && !empty($block['image'])) {
            $block['image'] = get_media_by_id((int) $block['image']);
        }
        return $block;
    }, carbon_get_post_meta($id, 'content') ?: []);

    //Kategorien laden
    $terms              = get_the_terms($id, 'project_category');
    $project_categories = array_map(
        fn($term) => ['title' => $term->name, 'slug' => $term->slug],
        is_array($terms) ? $terms : []
    );

    //Daten ausgeben
    return [
        'title'              => $title,
        'image'              => $image,
        'lead'               => $lead,
        'content'            => $content,
        'tasks'              => $tasks,
        'medium'             => $medium,
        'date'               => $date,
        'gallery'            => $gallery,
        'video'              => $video,
        'audio'              => $audio,
        'sm_post'            => $sm_post,
        'pdf'                => $pdf,
        'project_categories' => $project_categories,
        'external_link'      => $external_link,
        'link'               => ($external_link && !$pdf) ? $external_link : get_permalink($id),
        'is_external'        => ($external_link && !$pdf),
    ];
}