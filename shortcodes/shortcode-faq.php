<?php
add_shortcode( 'faqs', 'faq_shortcode' );
function faq_shortcode( $atts ) { 
	
	$post_id = get_the_ID();
	
	$parameters = shortcode_atts( array(
		'status' => 'publish',
		'posts_per_page' => '-1',
		'orderby' => 'menu_order',
		'order' => 'ASC',
        'categories' => '6',
		'paged' => 'false',

	), $atts, 'faqs' );

    // Define output var
    $output = '';

    $categories = explode(",", "{$parameters['categories']}");

    $args = array (
        'post_type'           => 'faq',
        'status'              => "{$parameters['status']}",
        'posts_per_page'      => "{$parameters['posts_per_page']}",
        'tax_query' => array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'faq_category',   // taxonomy name
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

        $output .= '<div class="faqs faqs-shortcode">';

        while ($custom_query->have_posts()) : $custom_query->the_post();

        $output .= '<div class="accordion-item faq-item faq-id-' . get_the_ID() . '">';

            $output .= '<div class="accordion-trigger">';
                $output .= '<div class="title-wrapper">';
                    if ( get_field("frage") ) {
                        $output .= '<h3 class="faq-title text-style-h5">' . get_field("frage") . '</h3>';
                    } else {
                        $output .= '<h3 class="faq-title text-style-h5">' . get_the_title() . '</h3>';
                    }
                $output .= '</div>';

                $output .= '<button class="accordion_trigger-icon"><div class="accordion_trigger-line"></div><div class="accordion_trigger-line trigger-line_plus"></div></button>';

            $output .= '</div>';
                
            $output .= '<div class="accordion-content">';
                $output .= '<div class="accordion-inner">';
                    $output .= '<div class="accordion-spacer"></div>';
                    $output .= '<div class="text-size-medium">' . get_field("antwort") . '</div>';
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
        $output .= '<p>' . __( 'Keine FAQs gefunden', 'political-landingpages' ) . '</p>';
    }

    // Return your shortcode output
    return $output;
}