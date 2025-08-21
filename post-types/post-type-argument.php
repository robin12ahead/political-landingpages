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
        'name' => _x('Themen', 'plural'),
        'singular_name' => _x('Thema', 'singular'),
        'menu_name' => _x('Themen', 'admin menu'),
        'name_admin_bar' => _x('Themen', 'admin bar'),
        'add_new' => _x('Neues Thema', 'add new'),
        'add_new_item' => __('Neues Thema'),
        'new_item' => __('Neues Thema'),
        'edit_item' => __('Thema bearbeiten'),
        'view_item' => __('Thema ansehen'),
        'all_items' => __('Alle Themen'),
        'search_items' => __('Themen suchen'),
        'not_found' => __('keine Themen gefunden'),
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