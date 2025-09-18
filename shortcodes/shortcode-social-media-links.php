<?php
add_shortcode( 'social-media-links', 'social_media_shortcode' );
function social_media_shortcode( $atts ) { 
	
    $options = get_field('social_media', 'option');
    $soMe_items = $options['socia_media_link'];

    // define empty output var
    $output = '';

    $output .= '<div class="social-media-links-shortcode">';
        $output .= '<div class="icon-group">';

            foreach( $soMe_items as $soMe_item ) {
                $link = $soMe_item['link'];
                $icon = $soMe_item['icon'];

                $output .= '<a href="' . $link . '" class="social-media-link icon-wrapper" target="_blank">';

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
                            $attachment = $icon['value'];

                            $output .= '<img src="' . $attachment['url'] .'" alt="social-icon" class="inline-svg" style="width: 100%;">';
                        }

                        // If the type selected was a URL, render an image tag with the URL.
                        if ( 'url' === $icon['type'] ) {
                            $url = $icon['value'];
                            $output .= '<img src="' . esc_url( $url ) .'" alt="social-icon">';
                        }
                    }
                        
                $output .= '</a>';
            }

        $output .= '</div>';
    $output .= '</div>';

    // Return your shortcode output
    return $output;
}
