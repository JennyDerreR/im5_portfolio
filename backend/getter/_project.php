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
    $gallery       = array_map(fn($gallery_id) => get_media_by_id((int) $gallery_id), carbon_get_post_meta($id, 'gallery') ?: []);
    $video         = carbon_get_post_meta($id, 'video');
    $audio_id      = carbon_get_post_meta($id, 'audio');
    $audio         = $audio_id ? wp_get_attachment_url($audio_id) : null;
    $sm_post       = carbon_get_post_meta($id, 'sm_post');

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
        'gallery'            => $gallery,
        'video'              => $video,
        'audio'              => $audio,
        'sm_post'            => $sm_post,
        'project_categories' => $project_categories,
        'link'               => $external_link ?: get_permalink($id),
        'is_external'        => !empty($external_link),
    ];
}