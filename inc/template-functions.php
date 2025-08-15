<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Political_Landingpages
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function political_landingpages_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'political_landingpages_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function political_landingpages_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'political_landingpages_pingback_header' );


/*=========================================================
// function to add classes to menu items
=========================================================*/

function add_menu_link_class( $atts, $item, $args ) {
	if (property_exists($args, 'link_class')) {
	  $atts['class'] = $args->link_class;
	}
	return $atts;
  }
add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );


function add_menu_list_item_class( $classes, $item, $args ) {
	if (property_exists($args, 'list_item_class')) {
		$classes[] = $args->list_item_class;
	}
	return $classes;
	}
add_filter('nav_menu_css_class', 'add_menu_list_item_class', 1, 3);


function add_menu_list_item_parent_class( $atts, $item, $args ) {

    // add class only on parent
        if (property_exists($args, 'list_item_parent_class') && $item->menu_item_parent == 0) {
			$atts['class'] = $args->list_item_class;
		}
	return $atts;
}
add_filter('nav_menu_css_class', 'add_menu_list_item_parent_class', 1, 3);


/*=========================================================
// change length of the excerpt text by number of characters
=========================================================*/

function get_excerpt($limit, $source = null){

    $excerpt = $source == "content" ? get_the_content() : get_the_excerpt();
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    $excerpt = $excerpt . '…&ensp;';
    // $excerpt = $excerpt . '&ensp;(…)' . '<a class="readmore" href="' . get_the_permalink() . '"></a>';
    return $excerpt;
}

/*=========================================================
// Change default excerpt character length
=========================================================*/

// function new_excerpt_length($length) {

//     return 100;
    
// }
    
// add_filter('excerpt_length', 'new_excerpt_length');

/*=========================================================
// Get file path from url
=========================================================*/

function get_image_file_path_from_url($image_url) {
    // Get the upload directory paths
    $upload_dir = wp_upload_dir();

    if (strpos($image_url, $upload_dir['baseurl']) !== false) {
        // If the image URL is in the uploads directory, convert URL to path
        $file_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $image_url);
        return $file_path;
    }

    // If the image URL is not in the uploads directory, return false
    return false;
}

/*=========================================================
// Custom Post Status
=========================================================*/

// /**
//  * Add 'Needs approval' post status.
//  */
// function needs_approval_custom_post_status(){
// 	register_post_status( 'needs_approval', array(
// 		'label'                     => _x( 'Needs approval', 'post' ),
// 		'public'                    => true,
// 		'publicly_queryable'        => false,
// 		'exclude_from_search'       => true,
// 		'show_in_admin_all_list'    => true,
// 		'show_in_admin_status_list' => true,
// 	) );
// }
// add_action( 'init', 'needs_approval_custom_post_status' );

// function render_pending_testimonials($template) {
//     if (is_singular('testimonial') ) {
//         global $post;
//         if ($post->post_status === 'pending') {
//             // Load the single template for the 'testimonial' post type
//             $single_template = locate_template('single-testimonial.php');
//             if ($single_template) {
//                 // Set the post status to 'publish' temporarily
//                 $post->post_status = 'publish';
//                 // Load the template
//                 return $single_template;
//             }
//         }
//     }
//     return $template;
// }
// add_filter('template_include', 'render_pending_testimonials');

// function exclude_pending_testimonials_from_queries($query) {
//     if (!is_admin() && $query->is_main_query() && $query->get('post_type') === 'testimonial') {
//         $query->set('post_status', array('publish'));
//     }
// }
// add_action('pre_get_posts', 'exclude_pending_testimonials_from_queries');


/*=========================================================
// Output banner Image on testimonial
=========================================================*/

// Add new column to the testimonial post type list
function add_custom_banner_image_column($columns) {
    $columns['custom_banner_image'] = __('Banner Image', 'political-landingpages');
    return $columns;
}
add_filter('manage_testimonial_posts_columns', 'add_custom_banner_image_column');

// Display the custom banner image in the custom column
function display_custom_banner_image_column($column, $post_id) {
    if ($column == 'custom_banner_image') {
        $image_url = get_post_meta($post_id, 'custom_banner_image', true);
        if ($image_url) {
            echo '<img src="' . esc_url($image_url) . '" style="max-width:100px; height:auto;" />';
        } else {
            echo __('No Banner image', 'political-landingpages');
        }
    }
}
add_action('manage_testimonial_posts_custom_column', 'display_custom_banner_image_column', 10, 2);

// Register the custom meta box
function custom_banner_image_meta_box() {
    add_meta_box(
        'custom_banner_image_meta_box', // Unique ID
        __('Custom Banner Image', 'textdomain'), // Box title
        'display_custom_banner_image_meta_box', // Content callback, must be of type callable
        'testimonial', // Post type
        'side', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'custom_banner_image_meta_box');

// Display the custom banner image in the meta box
function display_custom_banner_image_meta_box($post) {
    // Retrieve the existing image URL if it exists
    $image_url = get_post_meta($post->ID, 'custom_banner_image', true);

    // Display the image
    if ($image_url) {
        echo '<img src="' . esc_url($image_url) . '" style="max-width:100%; height:auto;" />';
    } else {
        echo __('No image available', 'political-landingpages');
    }
}

/*=========================================================
// Custom Pagination
=========================================================*/

/**
 * Numeric pagination via WP core function paginate_links().
 * @link http://codex.wordpress.org/Function_Reference/paginate_links
 *
 * @param array $args
 *
 * @return string HTML for numneric pagination
 */
function my_pagination( $args = array() ) {
    global $wp_query;
    $output = '';

    if ( $wp_query->max_num_pages <= 1 ) {
        return;
    }

    $pagination_args = array(
        'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
        'total'        => $wp_query->max_num_pages,
        'current'      => max( 1, get_query_var( 'paged' ) ),
        'format'       => '?paged=%#%',
        'show_all'     => false,
        'type'         => 'plain',
        'end_size'     => 2,
        'mid_size'     => 1,
        'prev_next'    => true,
        //'prev_text'    => __( '&laquo; Prev', 'text-domain' ),
        //'next_text'    => __( 'Next &raquo;', 'text-domain' ),
        //'prev_text'    => __( '&lsaquo; Prev', 'text-domain' ),
        //'next_text'    => __( 'Next &rsaquo;', 'text-domain' ),
        'prev_text'    => sprintf( '<i></i> %1$s',
            apply_filters( 'my_pagination_page_numbers_previous_text',
            __( 'Newer Posts', 'text-domain' ) )
        ),
        'next_text'    => sprintf( '%1$s <i></i>',
            apply_filters( 'my_pagination_page_numbers_next_text',
            __( 'Older Posts', 'text-domain' ) )
        ),
        'add_args'     => false,
        'add_fragment' => '',

        // Custom arguments not part of WP core:
        'show_page_position' => false, // Optionally allows the "Page X of XX" HTML to be displayed.
    );

    $pagination_args = apply_filters( 'my_pagination_args', array_merge( $pagination_args, $args ), $pagination_args );

    $output .= paginate_links( $pagination_args );

    // Optionally, show Page X of XX.
    if ( true == $pagination_args['show_page_position'] && $wp_query->max_num_pages > 0 ) {
        $output .= '<span class="page-of-pages">' .
                                    sprintf( __( 'Page %1s of %2s', 'text-domain' ), $pagination_args['current'], $wp_query->max_num_pages ) .
                '</span>';
    }

    return $output;
}

/*=========================================================
// Hide Posts from Wordpress Dashboard
=========================================================*/

$optionsAddons = get_field('addons', 'option');

if ($optionsAddons["news_status"] == false) {

// Hide "Posts" menu in the WordPress admin
function my_remove_posts_menu() {
    remove_menu_page('edit.php'); // 'edit.php' is the slug for Posts
}
add_action('admin_menu', 'my_remove_posts_menu');

// Hide "Posts" from admin bar
function my_remove_posts_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_node('new-post');
}
add_action('wp_before_admin_bar_render', 'my_remove_posts_admin_bar');

}