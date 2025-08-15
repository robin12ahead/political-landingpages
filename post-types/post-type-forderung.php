<?php
// Add Custom Post Type
function create_post_type_forderung() {
    $supports = array(
        'title', // post title
        'editor', // post content
        'author', // post author
        // 'thumbnail', // featured images
        'excerpt', // post excerpt
        'custom-fields', // custom fields
        // 'comments', // post comments
        'revisions', // post revisions
        // 'post-formats', // post formats
    );

    $labels = array(
        'name' => _x('Forderungen', 'plural'),
        'singular_name' => _x('Forderung', 'singular'),
        'menu_name' => _x('Forderungen', 'admin menu'),
        'name_admin_bar' => _x('Forderungen', 'admin bar'),
        'add_new' => _x('Neue Forderung', 'add new'),
        'add_new_item' => __('Neue Forderung'),
        'new_item' => __('Neue Forderung'),
        'edit_item' => __('Forderung bearbeiten'),
        'view_item' => __('Forderung ansehen'),
        'all_items' => __('Alle Forderungen'),
        'search_items' => __('Forderungen suchen'),
        'not_found' => __('keine Forderungen gefunden'),
    );

    $args = array(
        'menu_icon' => 'dashicons-heading',
        'supports' => $supports,
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'publicity_querable' => true,
        'query_var' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'show_in_nav_menus' => false,
        // 'rewrite' => array('slug' => 'forderung'),
        'rewrite' => false,
        'hierarchical' => false,
    );

    register_post_type('forderung', $args);
}
add_action('init', 'create_post_type_forderung', 4);
