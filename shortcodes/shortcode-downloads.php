<?php
add_shortcode( 'downloads', 'downloads_shortcode' );
function downloads_shortcode( $atts ) { 
	
	$post_id = get_the_ID();
	
	$parameters = shortcode_atts( array(
		'status' => 'publish',
		'posts_per_page' => '-1',
		'orderby' => 'menu_order',
		'order' => 'ASC',
        'categories' => '5',
		'paged' => 'false',

	), $atts, 'downloads' );

    // Define output var
    $output = '';

    $categories = explode(",", "{$parameters['categories']}");

    $args = array (
        'post_type'           => 'download',
        'status'              => "{$parameters['status']}",
        'posts_per_page'      => "{$parameters['posts_per_page']}",
        'tax_query' => array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'download_category',   // taxonomy name
				'field' => 'term_id',           // term_id, slug or name
				'terms' => $categories,       // term id, term slug or term name
				'operator' => 'IN',
			)
		),
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

        $output .= '<div class="downloads downloads-shortcode">';

        while ($custom_query->have_posts()) : $custom_query->the_post();

        $file = get_field('file');
        // var_dump($file);
        
        // Extract variables.
        $url = $file['url'];
        $title = $file['title'];
        $caption = $file['caption'];
        $icon = $file['icon'];
        $filename = $file['filename'];
        $filesize = $file['filesize'];

        // Display image thumbnail when possible.
        if( $file['type'] == 'image' ) {
            $icon =  $file['sizes']['thumbnail'];
        }

        $output .= '<div class="download-item download-item download-id-' . get_the_ID() . '">';
            $output .= '<div class="download-inner row">';

                $output .= '<div class="download-content col-lg-5">';

                    $output .= '<div class="download-thumnail">';
                        if ( get_field("thumbnail") ) {
                            $output .= '<img src="' . get_field("thumbnail") . '" />';
                        } elseif ( $icon ) {
                            $output .= '<img src="' . esc_attr($icon) . '" />';
                        }
                    $output .= '</div>';
        
                    $output .= '<div class="download-text-wrapper">';
                        $output .= '<h3 class="download-title text-style-h5">' . get_the_title() . '</h3>';
                        $output .= '<p class="download-filename">' . esc_attr($filename) . '</p>';
                    $output .= '</div>';

                $output .= '</div>';
                    
                if (get_field("file_types")) {
                    $output .= '<div class="download-filetypes col-lg-2"><p>' . get_field("file_types") . '</p></div>';
                }
                
                $output .= '<div class="download-filesize col-lg-2"><p>' . size_format(esc_attr($filesize)) . '</p></div>';

                $output .= '<div class="download-button-wrapper col-lg-auto">';
                    $output .= '<a class="download-button" download href="' . esc_attr($url) . '">' . __( 'Download', 'political-landingpages' ) .'<img class="inline-svg" src="' . get_template_directory_uri() . '/assets/icons/download-icon_red.svg" alt="download icon" /></a>';
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
        $output .= '<p>' . __( 'Keine Downloads gefunden', 'political-landingpages' ) . '</p>';
    }

    // Return your shortcode output
    return $output;
}