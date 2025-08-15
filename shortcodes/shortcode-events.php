<?php
/*
add_shortcode( 'events', 'events_shortcode' );
function events_shortcode( $atts ) { 

    // set unique identifier for each query (for indivisual paginations)
    static $instance_count = 0;
    $instance_count++;
    $instance_id = 'events_' . $instance_count;

    $currentDateTime = new DateTime(date('d.m.Y H:i'));
	
    // get the current post / page id
	$post_id = get_the_ID();
	
	$parameters = shortcode_atts( array(
		'status' => 'publish',
		'posts_per_page' => '-1',
		'orderby' => 'date',
        'meta_key'  => '',
		'order' => 'DESC',
        'categories' => '',
		'paged' => 'false',
		'filter' => '',

	), $atts, 'events' );

    // define $paged var
    if ( $parameters['paged'] == "true" ) {
        // $paged = (get_query_var($instance_id . '_paged')) ? get_query_var($instance_id . '_paged') : 1;
        $paged = isset( $_GET[$instance_id . '_paged'] ) ? (int) $_GET[$instance_id . '_paged'] : 1;
    } else {
        $paged = false;
    }

    $args = array (
        'post_type'           => 'event',
        'status'              => "{$parameters['status']}",
        'posts_per_page'      => "{$parameters['posts_per_page']}",
        'post__not_in'        => array($post_id),
        'ignore_sticky_posts' => 1,
        'orderby'             => "{$parameters['orderby']}",
        'order'               => "{$parameters['order']}",
        'meta_key'            => "{$parameters['meta_key']}",
        'supress_filters'     => true,
        'paged'               => $paged,
    );


    // categories filter
    $categories = '';

    if ( $parameters['categories'] !== "" ) {
        $categories = explode(",", "{$parameters['categories']}");

        $tax_query = array (
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'event_category',   // taxonomy name
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

        $output .= '<div class="events-shortcode row">';
        
        while ($custom_query->have_posts()) : $custom_query->the_post();
        
            $start_date = DateTime::createFromFormat( 'd.m.Y H:i', get_field("event_start_date") );

            if ( ($parameters['filter'] == "") || ( $parameters['filter'] == "past" && $start_date <= $currentDateTime ) || ( $parameters['filter'] == "future" && $start_date >= $currentDateTime ) ) {

            $output .= '<div class="event-item event-id-' . get_the_ID() . ' col-lg-4 col-md-6">';

                $output .= '<a class="event-inner box" href="' . get_the_permalink() . '">';

                // $output .= '<h3 class="date-day">' . var_dump(get_post_meta( get_the_ID(), 'event_start_date' ))  . '</h3>';
                // $output .= '<h3 class="date-day">' . var_dump(wp_date('Y-m-d H:i:s'))  . '</h3>';
                        
                    $output .= '<div class="text-wrapper">';

                        $output .= '<div class="post-meta post-header row justify-content-between row-cols-auto align-items-end">';
                        
                            $output .= '<div class="date-wrapper">';
                                $output .= '<h3 class="date-day">' . $start_date->format( 'j.' )  . '</h3>';
                                $output .= '<span class="date-month">' . $start_date->format( 'F' )  . '</span>';
                            $output .= '</div>';

                            // if (get_the_terms( get_the_ID(), 'event_category' ) !== "" ) {
                            //     $output .= '<p class="text-size-regular post-meta-category">' . get_the_terms( get_the_ID(), 'event_category' )[0]->name . '</p>';
                            // }
                            
                        $output .= '</div>';

                        $output .= '<div class="divider divider-tertiary"></div>';
                        
                        $output .= '<h3 class="post-title text-style-h4">' . get_the_title() . '</h3>';

                        $output .= '<div class="post-excerpt text-size-medium"><p>' . get_excerpt(180) . '<span class="read-more-text">' . __("weiterlesen", "political-landingpages") . '</span></p></div>';

                        $output .= '<div class="post-meta post-footer">';
                            $output .= '<div class="location-wrapper">';

                                if (get_field("event_end_date")) {
                                    $end_date = DateTime::createFromFormat( 'd.m.Y H:i', get_field("event_end_date") );
                                    $output .= '<b class="text-size-regular post-meta-time">' . $start_date->format( 'H:i' ) . " - " . $end_date->format( 'H:i' ) . '</b>';
                                } else {
                                    $output .= '<b class="text-size-regular post-meta-time">' . $start_date->format( 'H:i' ) . '</b>';
                                }

                                if (get_field("event_location")) {
                                    $output .= '<p class="text-size-regular">' . get_field("event_location") . '</p>';
                                }

                                if (get_field("event_address")) {
                                    $output .= '<p class="text-size-regular">' . get_field("event_address") . '</p>';
                                }

                            $output .= '</div>';

                            $output .= '<button class="arrow-button"><img src="' . get_template_directory_uri() . '/assets/icons/arrow_right.svg" class="arrow inline-svg" alt="Arrow Icon"/></button>';

                        $output .= '</div>';

                    $output .= '</div>'; // close .texts
                
                $output .= '</a>';

            $output .= '</div>';
            
            }

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
        $output .= '<p>' . __( 'Keine Events gefunden', 'political-landingpages' ) . '</p>';
    }

    // Return your shortcode output
    return $output;
}
*/

add_shortcode( 'events', 'events_shortcode' );
function events_shortcode( $atts ) { 

    // set unique identifier for each query (for indivisual paginations)
    static $instance_count = 0;
    $instance_count++;
    $instance_id = 'events_' . $instance_count;

    // $currentDateTime = wp_date('d.m.Y H:i');
    $currentDateTime = wp_date('Y-m-d H:i:s');
    $currentDateTimeObj= new DateTime($currentDateTime);
	
    // get the current post / page id
	$post_id = get_the_ID();
	
	$parameters = shortcode_atts( array(
		'status' => 'publish',
		'posts_per_page' => '-1',
		'orderby' => 'date',
        'meta_key'  => '',
		'order' => 'DESC',
        'categories' => '',
		'paged' => 'false',
		'filter' => '',

	), $atts, 'events' );

    // define $paged var
    if ( $parameters['paged'] == "true" ) {
        // $paged = (get_query_var($instance_id . '_paged')) ? get_query_var($instance_id . '_paged') : 1;
        $paged = isset( $_GET[$instance_id . '_paged'] ) ? (int) $_GET[$instance_id . '_paged'] : 1;
    } else {
        $paged = false;
    }

    $args = array (
        'post_type'           => 'event',
        'status'              => "{$parameters['status']}",
        'posts_per_page'      => "{$parameters['posts_per_page']}",
        'post__not_in'        => array($post_id),
        'ignore_sticky_posts' => 1,
        'orderby'             => "{$parameters['orderby']}",
        'order'               => "{$parameters['order']}",
        'meta_key'            => "{$parameters['meta_key']}",
        'supress_filters'     => true,
        'paged'               => $paged,
    );


    // categories filter
    $categories = '';

    if ( $parameters['categories'] !== "" ) {
        $categories = explode(",", "{$parameters['categories']}");

        $tax_query = array (
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'event_category',   // taxonomy name
                    'field' => 'term_id',           // term_id, slug or name
                    'terms' => $categories,       // term id, term slug or term name
                    'operator' => 'IN',
                )
            ),
        );
    
        // merge args arrays together
        $args = array_merge($args, $tax_query);
    }

    if ( $parameters['filter'] == "future" ) {

        $meta_query = array (
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'event_start_date', 
                    'value' =>  $currentDateTime,
                    'compare' => '>=',
                    'type' => 'DATETIME',
                )
            ),
        );
    
        // merge args arrays together
        $args = array_merge($args, $meta_query);
        
    } elseif ($parameters['filter'] == "past") {

        $meta_query = array (
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'event_start_date', 
                    'value' =>  $currentDateTime,
                    'compare' => '<=',
                    'type' => 'DATETIME',
                )
            ),
        );
    
        // merge args arrays together
        $args = array_merge($args, $meta_query);

    }
    
    // Define output var
    $output = '';

    // Query posts
    $custom_query = new WP_Query($args);

    if ($custom_query->have_posts()) {

        $output .= '<div class="events-shortcode row">';
        
        while ($custom_query->have_posts()) : $custom_query->the_post();
        
            $start_date = DateTime::createFromFormat( 'd.m.Y H:i', get_field("event_start_date") );

            // if ( ($parameters['filter'] == "") || ( $parameters['filter'] == "past" && $start_date < $currentDateTimeObj ) || ( $parameters['filter'] == "future" && $start_date > $currentDateTimeObj ) ) {

            $output .= '<div class="event-item event-id-' . get_the_ID() . ' col-lg-4 col-md-6">';

                $output .= '<a class="event-inner box" href="' . get_the_permalink() . '">';
                        
                    $output .= '<div class="text-wrapper">';

                        $output .= '<div class="post-meta post-header row justify-content-between row-cols-auto align-items-end">';
                        
                            $output .= '<div class="date-wrapper">';
                                $output .= '<h3 class="date-day">' . $start_date->format( 'j.' )  . '</h3>';
                                $output .= '<span class="date-month">' . $start_date->format( 'F' )  . '</span>';
                            $output .= '</div>';

                            // if (get_the_terms( get_the_ID(), 'event_category' ) !== "" ) {
                            //     $output .= '<p class="text-size-regular post-meta-category">' . get_the_terms( get_the_ID(), 'event_category' )[0]->name . '</p>';
                            // }
                            
                        $output .= '</div>';

                        $output .= '<div class="divider divider-tertiary"></div>';
                        
                        $output .= '<h3 class="post-title text-style-h4">' . get_the_title() . '</h3>';

                        $output .= '<div class="post-excerpt text-size-medium"><p>' . get_excerpt(180) . '<span class="read-more-text">' . __("weiterlesen", "political-landingpages") . '</span></p></div>';

                        $output .= '<div class="post-meta post-footer">';
                            $output .= '<div class="location-wrapper">';

                                if (get_field("event_end_date")) {
                                    $end_date = DateTime::createFromFormat( 'd.m.Y H:i', get_field("event_end_date") );
                                    $output .= '<b class="text-size-regular post-meta-time">' . $start_date->format( 'H:i' ) . " - " . $end_date->format( 'H:i' ) . '</b>';
                                } else {
                                    $output .= '<b class="text-size-regular post-meta-time">' . $start_date->format( 'H:i' ) . '</b>';
                                }

                                if (get_field("event_location")) {
                                    $output .= '<p class="text-size-regular">' . get_field("event_location") . '</p>';
                                }

                                if (get_field("event_address")) {
                                    $output .= '<p class="text-size-regular">' . get_field("event_address") . '</p>';
                                }

                            $output .= '</div>';

                            $output .= '<button class="arrow-button"><img src="' . get_template_directory_uri() . '/assets/icons/arrow_right.svg" class="arrow inline-svg" alt="Arrow Icon"/></button>';

                        $output .= '</div>';

                    $output .= '</div>'; // close .texts
                
                $output .= '</a>';

            $output .= '</div>';
            
            // }

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
        $output .= '<p>' . __( 'Keine Events gefunden', 'political-landingpages' ) . '</p>';
    }

    // Return your shortcode output
    return $output;
}