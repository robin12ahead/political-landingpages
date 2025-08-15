<?php
// proceed if status is set to "active"
$optionsAddons = get_field('addons', 'option');
if ($optionsAddons["argumente_status"] == true) {

// Add Custom Post Type
function create_post_type_argument() {
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
        'name' => _x('Argumente', 'plural'),
        'singular_name' => _x('Argument', 'singular'),
        'menu_name' => _x('Argumente', 'admin menu'),
        'name_admin_bar' => _x('Argumente', 'admin bar'),
        'add_new' => _x('Neues Argument', 'add new'),
        'add_new_item' => __('Neues Argument'),
        'new_item' => __('Neues Argument'),
        'edit_item' => __('Argument bearbeiten'),
        'view_item' => __('Argument ansehen'),
        'all_items' => __('Alle Argumente'),
        'search_items' => __('Argumente suchen'),
        'not_found' => __('keine Argumente gefunden'),
    );

    $args = array(
        'menu_icon' => 'dashicons-lightbulb',
        'supports' => $supports,
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'publicity_querable' => true,
        'query_var' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'show_in_nav_menus' => false,
        // 'rewrite' => array('slug' => 'argument'),
        'rewrite' => false,
        'hierarchical' => false,
    );

    register_post_type('argument', $args);
}
add_action('init', 'create_post_type_argument', 3);
}