<?php
add_shortcode( 'partners', 'partners_shortcode' );
function partners_shortcode( $atts ) { 
	
	$post_id = get_the_ID();
	
	$parameters = shortcode_atts( array(
		'status' => 'publish',
		'posts_per_page' => '-1',
		'orderby' => 'menu_order',
        'categories' => '',
		'order' => 'ASC',
		'paged' => 'false',

	), $atts, 'partners' );

    $args = array (
        'post_type'           => 'partner',
        'status'              => "{$parameters['status']}",
        'posts_per_page'      => "{$parameters['posts_per_page']}",
        'post__not_in'        => array($post_id),
        'ignore_sticky_posts' => 1,
        'orderby'             => "{$parameters['orderby']}",
        'order'               => "{$parameters['order']}",
		'supress_filters'     => true,
        'paged'               => "{$parameters['paged']}",
    );

    // categories filter
    $categories = '';

    if ( $parameters['categories'] !== "" ) {
        $categories = explode(",", "{$parameters['categories']}");

        $tax_query = array (
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'partner_category',   // taxonomy name
                    'field' => 'term_id',           // term_id, slug or name
                    'terms' => $categories,       // term id, term slug or term name
                    'operator' => 'IN',
                )
            ),
        );
    
        // merge args arrays together
        $args = array_merge($args, $tax_query);
    }

    // Define output var
    $output = '';

    // Query posts
    $custom_query = new WP_Query($args);

    if ($custom_query->have_posts()) {

        $output .= '<div class="partners-shortcode row">';
        
        while ($custom_query->have_posts()) : $custom_query->the_post();

            $logo = get_field("logo");

            $output .= '<div class="partner-item partner-id-' . get_the_ID() . ' col-lg-3 col-md-4 col-sm-6">';
                $output .= '<a class="partner-link box" href="' . get_field("website") . '" target="_blank">';

                    // $output .= wp_get_attachment_image( $logo()['id'], 'komitee' );
                    $output .= '<img class="partner-logo" src="' . esc_url($logo['url']) .'" alt="' . get_the_title() . '" />';

                $output .= '</a>';

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
        $output .= '<p>' . __( 'Keine Partner gefunden', 'political-landingpages' ) . '</p>';
    }

    // Return your shortcode output
    return $output;
}
