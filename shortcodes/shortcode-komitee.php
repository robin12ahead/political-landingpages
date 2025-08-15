<?php
add_shortcode( 'komitee', 'komitee_shortcode' );
function komitee_shortcode( $atts ) { 

    static $instance_count = 0;
    $instance_count++;
    $instance_id = 'komitee_' . $instance_count;

    $post_id = get_the_ID();

    $parameters = shortcode_atts( array(
        'status' => 'publish',
        'posts_per_page' => '-1',
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_key'  => '',
        'categories' => '',
        'show-featured' => 'true',
        'paged' => 'false',
        'style' => 'default',
    ), $atts, 'komitee' );

    if ( $parameters['paged'] == "true" ) {
        // $paged = (get_query_var($instance_id . '_paged')) ? get_query_var($instance_id . '_paged') : 1;
        $paged = isset( $_GET[$instance_id . '_paged'] ) ? (int) $_GET[$instance_id . '_paged'] : 1;
    } else {
        $paged = false;
    }

    $args = array (
        'post_type'           => 'komitee',
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

    // Define output var
    $output = '';

    // categories filter
    $categories = '';

    if ( $parameters['categories'] !== "" ) {
        $categories = explode(",", "{$parameters['categories']}");

        $tax_query = array (
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'komitee_category',   // taxonomy name
                    'field' => 'term_id',           // term_id, slug or name
                    'terms' => $categories,       // term id, term slug or term name
                    'operator' => 'IN',
                )
            ),
        );
    
        // merge args arrays together
        $args = array_merge($args, $tax_query);
    }

    // Query posts
    $custom_query = new WP_Query($args);

    if ($custom_query->have_posts()) {

        // Open div wrapper around loop
        if ($parameters['style'] == "list") {
            $output .= '<div class="komitee-shortcode komitee-list">';
            $output .= '<table class="komitee-table">';
            $output .= '<thead class="komitee-table-head"><tr>';
            $output .= '<th class="komitee-first-name"><b>Vorname</b></th>';
            $output .= '<th class="komitee-last-name"><b>Nachname</b></th>';
            $output .= '<th class="komitee-funktion">Funktion</th>';
            $output .= '<th class="komitee-partei">Partei</th>';
            $output .= '<th class="komitee-wohnort">Wohnort</th>';
            $output .= '<th class="komitee-kanton">Kanton</th>';
            $output .= '</tr></thead>';
            $output .= '<tbody class="komitee-table-body">';

            while ($custom_query->have_posts()) : $custom_query->the_post();
                // get general info
                $general = get_field('allgemeine_angaben');

                $output .= '<tr class="komitee-item komitee-id-' . get_the_ID() . '">';
                $output .= '<td class="komitee-first-name"><b>' . $general['first_name'] . '</b></td>';
                $output .= '<td class="komitee-last-name"><b>' . $general['last_name'] . '</b></td>';
                $output .= '<td class="komitee-funktion">' . $general['funktion'] . '</td>';
                $output .= '<td class="komitee-partei">' . $general['partei'] . '</td>';
                $output .= '<td class="komitee-wohnort">' . $general['wohnort'] . '</td>';
                $output .= '<td class="komitee-kanton">' . $general['kanton'] . '</td>';
                $output .= '</tr>';

            endwhile; 

            $output .= '</tbody>';
            $output .= '</table>';
            $output .= '</div>';

        } else {
            $output .= '<div class="komitee-shortcode komitee-columns row">';
            
             while ($custom_query->have_posts()) : $custom_query->the_post();
    
                $output .= '<div class="komitee-item komitee-id-' . get_the_ID() . ' col-md-4 col-sm-6">';
                    $output .= '<div class="komitee-inner">';
    
                        $general = get_field('allgemeine_angaben');
    
                        $output .= '<div class="image-wrapper">';
                        if( has_post_thumbnail() ) {
                            $output .= get_the_post_thumbnail( get_the_ID(), 'komitee' );
                            
                        } else {
                            $output .= '<img src="' . get_template_directory_uri() . '/assets/img/komitee-placeholder.jpg" alt="Komitee Platzhalterbild" />';
                        }
                        // elseif ( $general['profilbild'] ) {
                        //     $output .= wp_get_attachment_image( $general['profilbild'], 'komitee' );
                        // }
                        $output .= '</div>';
    
                        $output .= '<div class="text-wrapper">';
    
                            $output .= '<h4 class="komitee-name">' . $general['first_name'] . ' ' . $general['last_name'] . '</h4>';
                            $output .= '<b class="text-size-regular">' . $general['funktion']  . '</b>';
                            $output .= '<p class="text-size-regular">' . $general['partei'] . '</p>';

                            // if ($general['wohnort']) {
                            //     $output .= '<p class="text-size-regular">' . $general['wohnort'] . ', ' . 'Kanton ' . $general['kanton'] . '</p>';
                            // } else {
                            //     $output .= '<p class="text-size-regular">' . 'Kanton ' . $general['kanton'] . '</p>';
                            // }
    
                        $output .= '</div>';
    
                    $output .= '</div>';
    
                $output .= '</div>';
    
            endwhile; 

            // Close div wrapper around loop
            $output .= '</div>';
        }

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
        $output .= '<p>Keine Komitee-Mitglieder gefunden</p>';
    }

    // Return your shortcode output
    return $output;
}