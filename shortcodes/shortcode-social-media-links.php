<?php
add_shortcode( 'social-media-links', 'social_media_shortcode' );
function social_media_shortcode( $atts ) { 
	
    $options = get_field('social_media', 'option');
    $soMe_items = $options['socia_media_link'];

    // define empty output var
    $output = '';

    $output .= '<div class="social-media-links-shortcode">';
        $output .= '<div class="button-group">';

            foreach( $soMe_items as $soMe_item ) {
                $link = $soMe_item['link'];
                $icon = $soMe_item['icon'];

                $output .= '<a href="' . $link . '" class="social-media-link" target="_blank">';

                    // Handle if the return type is a string.
                    if ( is_string( $icon ) ) {

                        // If the type selected was a Dashicon, the value of $icon will be the dashicon class string.
                        // If the type selected was a Media Library image, the value of $icon will be the URL to the image.
                        // If the type selected was a URL, the value of $icon will be the URL to the image.
                        echo esc_html( $icon );

                    } else {
                        // Handle if the return type is an array.

                        // If the type selected was a Dashicon, render a div with the dashicon class.
                        if ( 'dashicons' === $icon['type'] ) {
                            $output .= '<div class="' . esc_attr( $icon['value'] ) . '"></div>';
                        }

                        // If the type selected was a Media Library image, use the attachment ID to get and render the image.
                        if ( 'media_library' === $icon['type'] ) {
                            $attachment_id = $icon['value'];
                            $size = 'full'; // (thumbnail, medium, large, full, or custom size)

                            $image_html = wp_get_attachment_image( $attachment_id, $size );
                            $output .= wp_kses_post( $image_html );
                        }

                        // If the type selected was a URL, render an image tag with the URL.
                        if ( 'url' === $icon['type'] ) {
                            $url = $icon['value'];
                            $output .= '<img src="' . esc_url( $url ) .'" alt="">';
                        }
                    }
                        
                $output .= '</a>';
            }

        $output .= '</div>';
    $output .= '</div>';

    // Return your shortcode output
    return $output;
}
