<?php
/**
* Global Styling Variables
*/

add_action( 'wp_head', 'root_global_variables');
function root_global_variables()
{
    $colors = get_field('colors', 'option');
    $base_colors = $colors['base_colors'];
    if( $colors ):
    ?>
    <style type="text/css" id="root-variables">
    :root {
        /* Test – ACF Options-page */
        --white: <?php echo esc_attr( $base_colors['white'] ); ?>;
        --black: <?php echo esc_attr( $base_colors['black'] ); ?>;    
    }

    </style>
    <?php
    endif;
}