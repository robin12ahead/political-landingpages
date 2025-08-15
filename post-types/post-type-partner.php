<?php
<<<<<<< Updated upstream
=======
// proceed if status is set to "active"
$optionsAddons = get_field('addons', 'option');
if ($optionsAddons["partner_status"] == true) {

>>>>>>> Stashed changes
// Add Custom Post Type
function create_post_type_partner() {
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
        'name' => _x('Partner', 'plural'),
        'singular_name' => _x('Partner', 'singular'),
        'menu_name' => _x('Partner', 'admin menu'),
        'name_admin_bar' => _x('Partner', 'admin bar'),
        'add_new' => _x('Neuer Partner', 'add new'),
        'add_new_item' => __('Neuer Partner'),
        'new_item' => __('Neuer Partner'),
        'edit_item' => __('Partner bearbeiten'),
        'view_item' => __('Partner ansehen'),
        'all_items' => __('Alle Partner'),
        'search_items' => __('Partner suchen'),
        'not_found' => __('keine Partner gefunden'),
    );

    $args = array(
        'menu_icon' => 'dashicons-universal-access',
        'supports' => $supports,
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'publicity_querable' => true,
        'query_var' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'show_in_nav_menus' => false,
        // 'rewrite' => array('slug' => 'partner'),
        'rewrite' => false,
        'hierarchical' => false,
    );

    register_post_type('partner', $args);
}
add_action('init', 'create_post_type_partner', 8);
