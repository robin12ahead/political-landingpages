<?php
add_shortcode( 'news', 'news_shortcode' );
function news_shortcode( $atts ) {
    
    // set unique identifier for each query (for indivisual paginations)
    static $instance_count = 0;
    $instance_count++;
    $instance_id = 'news_' . $instance_count;
	
	$post_id = get_the_ID();
	
	$parameters = shortcode_atts( array(
		'status' => 'publish',
		'posts_per_page' => '-1',
		'orderby' => 'date',
		'order' => 'DESC',
        'categories' => '',
        'meta_key'  => '',
		'paged' => 'false',
		'thumbnail' => 'true',

	), $atts, 'news' );

    // define $paged var
    if ( $parameters['paged'] == "true" ) {
        // $paged = (get_query_var($instance_id . '_paged')) ? get_query_var($instance_id . '_paged') : 1;
        $paged = isset( $_GET[$instance_id . '_paged'] ) ? (int) $_GET[$instance_id . '_paged'] : 1;
    } else {
        $paged = false;
    }

    $args = array (
        'post_type'           => 'post',
        'status'              => "{$parameters['status']}",
        'posts_per_page'      => "{$parameters['posts_per_page']}",
        'post__not_in'        => array($post_id),
        'ignore_sticky_posts' => 1,
        'meta_key'            => "{$parameters['meta_key']}",
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
                'relation' => 'OR',
                array(
                    'taxonomy' => 'category',   // taxonomy name
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

        $output .= '<div class="news-shortcode row">';
        
        while ($custom_query->have_posts()) : $custom_query->the_post();

            $output .= '<div class="news-item news-id-' . get_the_ID() . ' col-lg-4 col-md-6">';

                $output .= '<a class="news-inner box" href="' . get_the_permalink() . '">';
                
                    $output .= '<div class="thumbnail-wrapper">';
                    if( has_post_thumbnail() && $parameters['thumbnail'] == "true" ) { 
                        $output .= get_the_post_thumbnail( get_the_ID(), 'thumbnail' );
                    } 
                    $output .= '</div>';

                    $output .= '<div class="text-wrapper">';
                        $output .= '<h3 class="post-title text-style-h4">' . get_the_title() . '</h3>';

                        $output .= '<div class="post-excerpt text-size-medium"><p>' . get_excerpt(180) . '<span class="read-more-text">' . __("weiterlesen", "political-landingpages") . '</span></p></div>';
                        
                        $output .= '<div class="post-meta">';
                            $output .= '<p class="text-size-regular post-meta-category">' . get_the_category( get_the_ID() )[0]->name . '</p>';
                            $output .= '<p class="text-size-regular post-meta-date">' . get_the_date("d. F Y") . '</p>';
                            // $output .= '<small class="author">' . __('Beitrag von ', "political-landingpages")  . get_the_author() . '</small>';
                        $output .= '</div>';
                    $output .= '</div>'; // close .texts
                
                $output .= '</a>';

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
        $output .= '<p class="test">' . __( 'Keine News gefunden', 'political-landingpages' ) . '</p>';
    }

    // Return your shortcode output
    return $output;
}