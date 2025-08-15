<?php
add_shortcode( 'forderungen', 'forderungen_shortcode' );
function forderungen_shortcode( $atts ) { 
	
	$post_id = get_the_ID();
	
	$parameters = shortcode_atts( array(
		'status' => 'publish',
		'posts_per_page' => '-1',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'paged' => 'false',

	), $atts, 'forderungen' );

    // Define output var
    $output = '';

    $args = array (
        'post_type'           => 'forderung',
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

        $output .= '<div class="forderungen-shortcode row">';
        
        while ($custom_query->have_posts()) : $custom_query->the_post();

            $output .= '<div class="forderungen-item forderungen-id-' . get_the_ID() . ' col-md-6">';
                $output .= '<div class="forderungen-inner box">';

        
                
                    $output .= '<div class="icon-wrapper">';

                        if ( get_field('pro_contra') == true ) {
                            $output .= '<div class="forderungen-icon is-pro">';

                        }  elseif ( get_field('pro_contra') == false ) {
                            $output .= '<div class="forderungen-icon is-contra">';
                        }

                            if ( get_field('icon')['value'] !== "" ) {

                                $icon = get_field('icon');

                                // Handle if the return type is a string.
                                if ( is_string( $icon ) ) {
            
                                    // If the type selected was a Dashicon, the value of $icon will be the dashicon class string.
                                    // If the type selected was a Media Library image, the value of $icon will be the URL to the image.
                                    // If the type selected was a URL, the value of $icon will be the URL to the image.
                                    $output .= esc_html( $icon );
            
                                } else {
                                    
                                    // Handle if the return type is an array.
            
                                    // If the type selected was a Dashicon, render a div with the dashicon class.
                                    if ( 'dashicons' === $icon['type'] ) {
                                        $output .= '<div class="' . esc_attr( $icon['value'] ) . ' dashicons"></div>';
                                    }
            
                                    // If the type selected was a Media Library image, use the attachment ID to get and render the image.
                                    if ( 'media_library' === $icon['type'] ) {
                                        $iconValue = $icon['value'];
                                        $attachment_id = $iconValue['id'];
                                        $size = 'full'; // (thumbnail, medium, large, full, or custom size)
            
                                        $image_url = wp_get_attachment_image_url( $attachment_id, $size );
                                        $output .= '<img src="' . $image_url . '" alt="icon" id="' . $attachment_id  . '" class="media-library-icon inline-svg">';
                                    }
            
                                    // If the type selected was a URL, render an image tag with the URL.
                                    if ( 'url' === $icon['type'] ) {
                                        $url = $icon['value'];
                                        $output .= '<img src="' . esc_url( $url ) . '" alt="">';
                                    }
                                }

                            } else {
                                if ( get_field('pro_contra') == true ) {
                                    $output .= '<img class="inline-svg" src="' . get_template_directory_uri() . '/assets/icons/icon_pro.svg" alt="icon">';
                                }  elseif ( get_field('pro_contra') == false ) {
                                    $output .= '<img class="inline-svg" src="' . get_template_directory_uri() . '/assets/icons/icon_contra.svg" alt="icon">';
                                }
                            }
                        $output .= '</div>';
                    $output .= '</div>';

                    $output .= '<div class="text-wrapper">';
                        $output .= '<h3 class="forderungen-title text-style-h4">' . get_the_title() . '</h3>';
                        $output .= '<div class="text-size-medium">' . get_field('content') . '</div>';
                    $output .= '</div>';
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
        $output .= '<p>' . __( 'Keine Forderungen gefunden', 'political-landingpages' ) . '</p>';
    }

    // Return your shortcode output
    return $output;
}