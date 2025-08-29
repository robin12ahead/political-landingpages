<?php
add_shortcode( 'medienberichte', 'medienberichte_shortcode¨' );
function medienberichte_shortcode( $atts ) { 
	
	$post_id = get_the_ID();
	
	$parameters = shortcode_atts( array(
		'status' => 'publish',
		'posts_per_page' => '-1',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'paged' => 'false',

	), $atts, 'medienberichte' );

    // Define output var
    $output = '';

    $args = array (
        'post_type'           => 'medienbericht',
        'status'              => "{$parameters['status']}",
        'posts_per_page'      => "{$parameters['posts_per_page']}",
        'post__not_in'        => array($post_id),
        'ignore_sticky_posts' => 1,
        'orderby'             => "{$parameters['orderby']}",
        'order'               => "{$parameters['order']}",
		'supress_filters'     => true,
        'paged'               => "{$parameters['paged']}",
    );

    // Query posts
    $custom_query = new WP_Query($args);

    if ($custom_query->have_posts()) {

        $output .= '<div class="medienberichte-shortcode row">';
        
        while ($custom_query->have_posts()) : $custom_query->the_post();

            $output .= '<div class="medienberichte-item medienberichte-id-' . get_the_ID() . ' col">';
                $output .= '<div class="medienberichte-inner box">';

                    $output .= '<div class="content">';                

                        $output .= '<div class="item-meta text-size-medium">';
                            $output .= '<span class="">' . get_field('absender') . '</span>';
                            $output .= '<span class="meta-separator"> | </span>';
                            $output .= '<span class="">' . get_field('absender') . '</span>';
                        $output .= '</div>';

                        if ( get_field('title') ) {
                            $output .= '<h3 class="medienberichte-title text-style-h4">' . get_field('title') . '</h3>';
                        } else {
                            $output .= '<h3 class="medienberichte-title text-style-h4">' . get_the_title() . '</h3>';
                        }
                    
                    $output .= '</div>';
                        
                    $output .= '<a href="' . get_the_title('link_medienbericht') . '" target="_blank" class="button btn btn-has-arrow" target="">Zum Bericht</a>';

                $output .= '</div>';

            $output .= '</div>';

        endwhile; 

        // Close div wrapper around loop
        $output .= '</div>';
        

        if ($parameters['paged'] == "true") {
            $output .= '<div class="pagination-wrapper">';
                $output .= paginate_links( array(
                    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                    'total'        => $custom_query->max_num_pages,
                    'current'      => max( 1, get_query_var( 'paged' ) ),
                    'format'       => '?page=%#%',
                    'show_all'     => true,
                    'type'         => 'plain',
                    'end_size'     => 2,
                    'mid_size'     => 2,
                    'prev_next'    => true,
                    'prev_text'    => sprintf( '<i></i> %1$s', __( 'Zurück', 'political-landingpages' ) ),
                    'next_text'    => sprintf( '%1$s <i></i>', __( 'Weiter', 'political-landingpages' ) ),
                    'add_args'     => false,
                    'add_fragment' => '',
                    // 'before_page_number' => '<div class="pagination">',
                    // 'after_page_number' => '</div>',
                ));
            $output .= '</div>';
        }

    wp_reset_postdata(); 
    
    } else {
        $output .= '<p>' . __( 'Keine Medienberichte gefunden', 'political-landingpages' ) . '</p>';
    }

    // Return your shortcode output
    return $output;
}