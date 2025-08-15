<?php
// proceed if status is set to "active"
$optionsAddons = get_field('addons', 'option');
if ($optionsAddons["testimonials_status"] == true) {

// Add Custom Post Type
function create_post_type_testimonial() {
    $supports = array(
        'title', // post title
        'editor', // post content
        'author', // post author
        'thumbnail', // featured images
        'excerpt', // post excerpt
        'custom-fields', // custom fields
        // 'comments', // post comments
        'revisions', // post revisions
        // 'post-formats', // post formats
    );

    $labels = array(
        'name' => _x('Testimonials', 'plural'),
        'singular_name' => _x('Testimonial', 'singular'),
        'menu_name' => _x('Testimonials', 'admin menu'),
        'name_admin_bar' => _x('Testimonials', 'admin bar'),
        'add_new' => _x('Neues Testimonial', 'add new'),
        'add_new_item' => __('Neues Testimonial'),
        'new_item' => __('Neues Testimonial'),
        'edit_item' => __('Testimonial bearbeiten'),
        'view_item' => __('Testimonial ansehen'),
        'all_items' => __('Alle Testimonials'),
        'search_items' => __('Testimonials suchen'),
        'not_found' => __('keine Testimonials gefunden'),
    );

    $args = array(
        'menu_icon' => 'dashicons-format-quote',
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'publicity_querable' => true,
        'query_var' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'show_in_nav_menus' => false,
        'rewrite' => array('slug' => 'testimonial'),
        'hierarchical' => false,
    );

    register_post_type('testimonial', $args);
}
add_action('init', 'create_post_type_testimonial', 7);


// Add Custom Tag Taxonomy
function register_testimonial_category() {

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

    register_taxonomy( 'testimonial_category', array( 'testimonial' ), $args );

}

add_action( 'init', 'register_testimonial_category', 0 );
}