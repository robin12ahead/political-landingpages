<?php
add_shortcode( 'testimonials', 'testimonials_shortcode' );
function testimonials_shortcode( $atts ) { 

    static $instance_count = 0;
    $instance_count++;
    $instance_id = 'testimonial_' . $instance_count;
	
	$post_id = get_the_ID();
	
	$parameters = shortcode_atts( array(
		'status' => 'publish',
		'posts_per_page' => '-1',
		'orderby' => 'menu_order',
        'categories' => '7',
		'order' => 'ASC',
		'paged' => 'false',

	), $atts, 'testimonials' );

    // define $paged var
    if ( $parameters['paged'] == "true" ) {
        // $paged = (get_query_var($instance_id . '_paged')) ? get_query_var($instance_id . '_paged') : 1;
        $paged = isset( $_GET[$instance_id . '_paged'] ) ? (int) $_GET[$instance_id . '_paged'] : 1;
    } else {
        $paged = false;
    }

    $args = array (
        'post_type'           => 'testimonial',
        'status'              => "{$parameters['status']}",
        'posts_per_page'      => "{$parameters['posts_per_page']}",
        'post__not_in'        => array($post_id),
        'ignore_sticky_posts' => 1,
        'orderby'             => "{$parameters['orderby']}",
        'order'               => "{$parameters['order']}",
		'supress_filters'     => true,
        'paged'               => $paged,
    );

    // categories filter
    $categories = '';

    if ( $parameters['categories'] !== "" ) {
        $categories = explode(",", "{$parameters['categories']}");

        $tax_query = array (
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'testimonial_category',   // taxonomy name
                    'field' => 'term_id',           // term_id, slug or name
                    'terms' => $categories,       // term id, term slug or term name
                    'operator' => 'IN',
                ),
                array(
                    'taxonomy' => 'testimonial_category',   // taxonomy name
                    'field' => 'term_id',           // term_id, slug or name
                    'terms' => '19',       // term id, term slug or term name
                    'operator' => 'NOT IN',
                ),
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

        $output .= '<div class="testimonials-shortcode row">';
        
        while ($custom_query->have_posts()) : $custom_query->the_post();
        
            $profilePicture = get_field("profilbild");
            $text_firstName = get_field('vorname');
            $text_lastName = get_field('nachname');
            $text_function = get_field('funktion');

            if ( get_field('partei') ) {
                $text_party = ", " . get_field('partei');
            } else {
                $text_party = "";
            }

            $text_sender = $text_firstName . " " . $text_lastName . ", " . $text_function . $text_party;

            $output .= '<div class="testimonial-item testimonial-id-' . get_the_ID() . ' col-lg-4 col-md-6">';
                $output .= '<div class="testimonial-inner box" data-name="' . get_the_title() . '">';

                    if ($profilePicture) {
                        $output .= '<div class="profile-wrapper">';
                            $output .= wp_get_attachment_image( $profilePicture["id"], 'testimonial');
                            $output .= '<span class="quotation-mark">«</span>';
                        $output .= '</div>';
                    }

                    if( !empty($profilePicture) ) {
                        $output .= '<img class="testimonial-logo is-absolute" src="' . get_theme_mod( 'headvisual-image' ) .'" alt="headvisual">';
                    } else {
                        $output .= '<img class="testimonial-logo" src="' . get_theme_mod( 'headvisual-image' ) .'" alt="headvisual">';
                    }

                    $output .= '<div class="text-wrapper">';
                        $output .= '<div class="quote-text">' . "«" . get_field('zitat') . "»" . '</div>';
                        $output .= '<p class="text-size-medium text-color-accent">' . $text_sender . '</p>';
                    $output .= '</div>';
                $output .= '</div>';

                // $output .= '<img src="' . get_post_meta( get_the_ID(), 'custom_banner_image', true) . '" alt="banner">';

            $output .= '</div>';

        endwhile; 

        // Close div wrapper around loop
        $output .= '</div>';
        

        if ($parameters['paged'] == "true") {
            $output .= '<div class="pagination-wrapper">';

                $output .= paginate_links( array(
                    // 'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                    // 'base'         => esc_url( add_query_arg( $instance_id . '_paged', '%#%' ) ),
                    'total'        => $custom_query->max_num_pages,
                    'current'      => max( 1, $paged ),
                    'format'       => '?'.$instance_id.'_paged=%#%',
                    'type'         => 'plain',
                    'show_all'     => true,
                    'end_size'     => 2,
                    'mid_size'     => 1,
                    'prev_next'    => true,
                    'prev_text'    => sprintf( '<i></i> %1$s', __( 'Zurück', 'political-landingpages' ) ),
                    'next_text'    => sprintf( '%1$s <i></i>', __( 'Weiter', 'political-landingpages' ) ),
                    // 'add_args' => array( $instance_id.'_paged' => $paged )
                ));

            $output .= '</div>';
        }

    wp_reset_postdata(); 
    
    } else {
        $output .= '<p>' . __( 'Keine Testimonials gefunden', 'political-landingpages' ) . '</p>';
    }

    // Return your shortcode output
    return $output;
}