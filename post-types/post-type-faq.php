<?php
// proceed if status is set to "active"
$optionsAddons = get_field('addons', 'option');
if ($optionsAddons["faq_status"] == true) {

// Add Custom Post Type
function create_post_type_faq() {
    $supports = array(
        'title', // post title
        'editor', // post content
        'author', // post author
        // 'thumbnail', // featured images
        // 'excerpt', // post excerpt
        'custom-fields', // custom fields
        // 'comments', // post comments
        'revisions', // post revisions
        // 'post-formats', // post formats
    );

    $labels = array(
        'name' => _x('FAQ', 'plural'),
        'singular_name' => _x('FAQ', 'singular'),
        'menu_name' => _x('FAQ', 'admin menu'),
        'name_admin_bar' => _x('FAQ', 'admin bar'),
        'add_new' => _x('Neues FAQ', 'add new'),
        'add_new_item' => __('Neues FAQ'),
        'new_item' => __('Neues FAQ'),
        'edit_item' => __('FAQ bearbeiten'),
        'view_item' => __('FAQ ansehen'),
        'all_items' => __('Alle FAQ'),
        'search_items' => __('FAQ suchen'),
        'not_found' => __('keine FAQ gefunden'),
    );

    $args = array(
        'menu_icon' => 'dashicons-excerpt-view',
        'supports' => $supports,
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'publicity_querable' => true,
        'query_var' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'show_in_nav_menus' => false,
        // 'rewrite' => array('slug' => 'faq'),
        'rewrite' => false,
        'hierarchical' => false,
    );

    register_post_type('faq', $args);
}
add_action('init', 'create_post_type_faq', 9);


// Add Custom Tag Taxonomy
function register_faq_category() {

    $labels = array(
        'name'                       => __( 'Kategorien', 'political-landingpages' ),
        'singular_name'              => __( 'Kategorie', 'political-landingpages' ),
        'menu_name'                  => __( 'Kategorien', 'political-landingpages' ),
        'edit_item'                  => __( 'Kategorie Bearbeiten', 'political-landingpages' ),
        'update_item'                => __( 'Kategorie aktualisieren', 'political-landingpages' ),
        'add_new_item'               => __( 'Neue Kategorie', 'political-landingpages' ),
        'new_item_name'              => __( 'Neue Kategorie', 'political-landingpages' ),
        'parent_item'                => __( 'Übergeordnete Kategorie', 'political-landingpages' ),
        'parent_item_colon'          => __( 'Übergeordnete Kategorie:', 'political-landingpages' ),
        'all_items'                  => __( 'Alle Kategorien', 'political-landingpages' ),
        'search_items'               => __( 'Kategorien suchen', 'political-landingpages' ),
        'popular_items'              => __( 'Populäre Kategorien', 'political-landingpages' ),
        'separate_items_with_commas' => __( 'Separate categories with commas', 'political-landingpages' ),
        'add_or_remove_items'        => __( 'Add or remove tags', 'political-landingpages' ),
        'choose_from_most_used'      => __( 'Choose from the most used tags', 'political-landingpages' ),
        'not_found'                  => __( 'No tags found.', 'political-landingpages' ),
    );

    $args = array(
        'labels'            => $labels,
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'show_tagcloud'     => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'query_var'         => true,

    );

    register_taxonomy( 'faq_category', array( 'faq' ), $args );

}

add_action( 'init', 'register_faq_category', 0 );
}