<?php
// proceed if status is set to "active"
$optionsAddons = get_field('addons', 'option');
if ($optionsAddons["testimonials_generieren"] == true) {

/*---------------------------------------------------------------------------
Add Shortcode to create Testimonial with frontend form
---------------------------------------------------------------------------*/
add_shortcode( 'testimonial-create', 'shortcode_testimonial_create' );
function shortcode_testimonial_create( $atts ) { 

    ob_start();

    // Attributes
    $atts = shortcode_atts( array(
        'submit_text' => 'Banner erstellen',
        'updated_message' => 'Vielen Dank fürs Erstellen der Referenz! Ihre Angaben werden nun von uns überprüft.',
    ), $atts, 'testimonial-create' );
    
    acf_form(array(
        'post_id'       => 'new_post',
        'new_post'      => array(
            'post_type'     => 'testimonial',
            'post_status'   => 'publish',
            'tax_input'    => array(
                'testimonial_category' => array("7", "19")
            ),
        ),
        'post_title' => false,
        'post_content' => false,
        'field_groups' => array("group_6698e5e74ec9d"),
        // 'fields' => array("field_66a1223baaf73","field_66a1226aaaf74","field_6698e631e9799", "field_6698e5e7e9796", "field_6698e61ce9797", "field_6698e625e9798"),
        'updated_message' => $atts['updated_message'],
        'return' => '%post_url%',
        'submit_value'  => $atts['submit_text'],
        'honeypot' => true,
        'form' => true,
        'uploader' => 'basic',
        'label_placement' => 'top',
        'instruction_placement' => 'field',
        'html_before_fields' => '<div class="shortcode_testimonial-create row">',
        'html_after_fields' => '</div>',
    ));
    
    $html = ob_get_contents(); 
    ob_end_clean();
    return $html;
}

}

// proceed if status is set to "active"
$optionsAddons = get_field('addons', 'option');
if ($optionsAddons["banner_generator_status"] == true) {

/*---------------------------------------------------------------------------
Create custom Banner Image
---------------------------------------------------------------------------*/

add_action('acf/save_post', 'create_custom_testimonial_banner');
function create_custom_testimonial_banner($post_id) {

    // only create banner for testimponail post type
    $post_type = get_post_type($post_id);
    if ($post_type != 'testimonial') {
    return;
    }

    /*--------------------------------------------
    Banner Parameters
    --------------------------------------------*/

    $BannerOptions = get_field('options_testimonials', 'option');

    $upload_dir = wp_upload_dir();
    $template_dir = get_template_directory();
    $banner_dir = "/banners/testimonials/";
    $banner_prefix = $BannerOptions["banner_prefix"];
    $banner_format = $BannerOptions["banner_file_type"];
    $font_heading = $template_dir . '/assets/fonts/' . $BannerOptions["banner_heading_font"];
    $font_body = $template_dir . '/assets/fonts/' . $BannerOptions["banner_body_font"];
    $banner_width = $BannerOptions["banner_width"];
    $banner_height = $BannerOptions["banner_height"];
    $banner_padding = $BannerOptions["banner_padding"];

    /*--------------------------------------------
    Get Texts
    --------------------------------------------*/

    $title = get_post_meta($post_id, 'banner_title', true);
    $text_firstName = get_field('vorname', $post_id);
    $text_lastName = get_field('nachname', $post_id);
    // $text_author = get_field('autor', $post_id);
    $text_quote = strip_tags( get_field('zitat', $post_id), '<br>' );
    $text_quote = "«" . $text_quote . "»";
    $text_function = get_field('funktion', $post_id);
    
    if ( get_field('partei', $post_id) ) {
        $text_party = ", " . get_field('partei', $post_id);
    } else {
        $text_party = "";
    }
    
    $text_sender = $text_firstName . " " . $text_lastName . ", " . $text_function . $text_party;

    /*--------------------------------------------
    Get Images (to import)
    --------------------------------------------*/

    // create circle mask function
    function create_circle_mask($width, $height) {
        // Create a blank true color image
        $mask = imagecreatetruecolor($width, $height);
    
        // Set the background to be transparent
        imagesavealpha($mask, true);
        $transparency = imagecolorallocatealpha($mask, 0, 0, 0, 127);
        imagefill($mask, 0, 0, $transparency);
    
        // Allocate a white color
        $white = imagecolorallocate($mask, 255, 255, 255);
    
        // Draw a white circle
        imagefilledellipse($mask, $width / 2, $height / 2, $width, $height, $white);
    
        return $mask;
    }
    
    // call circle mask function
    function apply_circle_mask($image) {
        $width = imagesx($image);
        $height = imagesy($image);
    
        // Create the circle mask
        $mask = create_circle_mask($width, $height);
    
        // Create a new image with the same dimensions and with transparency
        $final_image = imagecreatetruecolor($width, $height);
        imagesavealpha($final_image, true);
        $transparency = imagecolorallocatealpha($final_image, 0, 0, 0, 127);
        imagefill($final_image, 0, 0, $transparency);
    
        // Copy the image using the mask
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $alpha = imagecolorat($mask, $x, $y) >> 24;
                if ($alpha == 0) { // Fully opaque in mask
                    $color = imagecolorat($image, $x, $y);
                    imagesetpixel($final_image, $x, $y, $color);
                }
            }
        }
    
        imagedestroy($mask);
        return $final_image;
    }

    /*--------------------------------------------
    Create Base Image
    --------------------------------------------*/

    // Image base (BG)
    $image = imagecreatetruecolor($banner_width, $banner_height);
    $background_color = imagecolorallocate($image, 255, 229, 0); // background color in RGB
    imagefilledrectangle($image, 0, 0, $banner_width, $banner_height, $background_color);

    /*--------------------------------------------
    Import Profile image
    --------------------------------------------*/
    // get profilepicture
    $profilePicture = get_field("profilbild", $post_id);

    if ( !empty($profilePicture) ) {
        // $profilePicturePath = get_image_file_path_from_url($profilePicture["url"]);

        $profilePictureURL = wp_get_attachment_image_url($profilePicture["id"], 'testimonial');
        $profilePicturePath = get_image_file_path_from_url($profilePictureURL);

        if ($profilePicture["subtype"] == "jpeg" || $profilePicture["subtype"] == "jpg") {
            $profilePictureImage = imagecreatefromjpeg($profilePicturePath);
        } elseif ($profilePicture["subtype"] == "png") {
            $profilePictureImage = imagecreatefrompng($profilePicturePath);
        }
    }

    if ( !empty($profilePictureImage) ) {

        // Apply the circular mask
        $profilePictureImageCircular = apply_circle_mask($profilePictureImage);

        // Get dimensions of the imported image
        $profilePictureWidth = imagesx($profilePictureImageCircular);
        $profilePictureHeight = imagesy($profilePictureImageCircular);
    
        // Calculate new dimensions to fit within the base image
        $newProfileWidth = '680';
        $newProfileHeight = '680';
    
        // Copy the imported image onto the base image
        imagecopyresampled($image, $profilePictureImageCircular, $banner_padding, $banner_padding, 0, 0, $newProfileWidth, $newProfileHeight, $profilePictureWidth, $profilePictureHeight);

        // X coord for headvisual if profile picture exists
        $headVisualPosX = '570';

    } else {

         // X coord for headvisual if profile picture does not exist
        $headVisualPosX = $banner_padding;
    }

    /*--------------------------------------------
    Import Headvisual
    --------------------------------------------*/

    // $headVisualURL = get_theme_mod( 'headvisual-image' );
    $headVisualURL = $BannerOptions["banner_visual"];
    
    if ( !empty($headVisualURL) ) {
    $headVisualPath = get_image_file_path_from_url($headVisualURL);
    $headVisualImage = imagecreatefrompng($headVisualPath);

        if ( !empty($headVisualImage) ) {

            // Get dimensions of the imported image
            $headvisualWidth = imagesx($headVisualImage);
            $headvisualHeight = imagesy($headVisualImage);

            // Calculate new dimensions to fit within the base image
            $newHeadvisualWidth = '580';
            $newHeadvisualHeight = '430';

            $headVisualPosY = $banner_padding;

            // Copy the imported image onto the base image
            imagecopyresampled($image, $headVisualImage, $headVisualPosX, $headVisualPosY, 0, 0, $newHeadvisualWidth, $newHeadvisualHeight, $headvisualWidth, $headvisualHeight);

        }
    }

    /*--------------------------------------------
    Add Texts to Image
    --------------------------------------------*/

    // Quote text
    if ( !empty($text_quote) ) {

        $text_quote_color = imagecolorallocate($image, 0, 0, 0); // RGB Color
        $text_quote_size = '54';
        $text_quote_PosY = '900';

        $text_quote = wordwrap($text_quote, 34, "\n", true);
        imagettftext($image, $text_quote_size, 0, $banner_padding, $text_quote_PosY, $text_quote_color, $font_heading, $text_quote);
    }

    // Sender text
    if ( !empty($text_sender) ) {

        $text_author_color = imagecolorallocate($image, 218, 8, 18); // RGB Color
        $text_author_size = '48';
        $text_author_PosY = '1380';

        imagettftext($image, $text_author_size, 0, $banner_padding, $text_author_PosY, $text_author_color, $font_body, $text_sender);
        
    }

    if ( !empty($profilePictureImage) ) {
        // quotation mark
        $quotation_color = imagecolorallocate($image, 218, 8, 18); // RGB Color
        $quotation_size = '256';
        $quotation_PosY = '768';

        imagettftext($image, $quotation_size, 0, $banner_padding, $quotation_PosY, $quotation_color, $font_heading, "«");
    }

    /*--------------------------------------------
    Create the final Banner Image
    --------------------------------------------*/

    // put together final banner image url
    $image_path = $upload_dir['basedir'] . $banner_dir . $banner_prefix . '_' . $post_id . $banner_format;
    $image_url = $upload_dir['baseurl'] . $banner_dir . $banner_prefix . '_' . $post_id . $banner_format;
    
    // create image banner
    if ($banner_format == ".png") {
        header('Content-Type: image/png');
        imagepng($image, $image_path, $BannerOptions["banner_qualitiy"]);
    }
    
    /*--------------------------------------------
    Finalize / Cleanup
    --------------------------------------------*/
    
    // destroy php images
    imagedestroy($image);
    imagedestroy($headVisualImage);
    // imagedestroy($profilePictureImage);
    // imagedestroy($profilePictureImageCircular);

    // update and set meta field containing the banner url
    update_post_meta($post_id, 'custom_banner_image', $image_url, $post_id);

}
}

/*---------------------------------------------------------------------------
update the post after saving
---------------------------------------------------------------------------*/

// update the post after saving
add_action('acf/save_post', 'testimonial_after_save', 20);
function testimonial_after_save($post_id) {

    // only create banner for testimponail post type
    $post_type = get_post_type($post_id);
    if ($post_type != 'testimonial') {
    return;
    }

    // set new post flag
    $flag = get_post_meta($post_id, 'new_post_flag', true);
    if ($flag == 'true') {
        return;
    }
    update_post_meta($post_id, 'new_post_flag', 'true');

    /*--------------------------------------------
    update the post after saving
    --------------------------------------------*/

    // Get the data from a field
    $new_title = get_field('vorname', $post_id) . ' ' . get_field('nachname', $post_id);

    // Set the post data
    $new_post = array(
        'ID'           => $post_id,
        'post_title'   => $new_title,
    );

    // Remove the hook to avoid infinite loop. Please make sure that it has
    // the same priority (20)
    remove_action('acf/save_post', 'create_custom_testimonial_banner', 20);

    // Update the post
    wp_update_post( $new_post );
    wp_set_post_terms( $post_id, array("7", "19"), 'testimonial_category' );

    // Add the hook back
    add_action('acf/save_post', 'create_custom_testimonial_banner', 20);

    /*--------------------------------------------
    Send Notification Email to admin
    --------------------------------------------*/

    $optionsEmails = get_field('options_emails', 'option');

    if ($optionsEmails['send_email_new_testimonial'] == true) {

        // Get Info
        $post_title = get_the_title( $post_id );
        $post_edit_link = get_site_url() . '/wp-admin/post.php?post=' . $post_id . '&action=edit'; // custom edit link
    
        $email_firstName = get_field('vorname', $post_id);
        $email_lastName = get_field('nachname', $post_id);
        $email_quote = get_field('zitat', $post_id);
        $email_function = get_field('funktion', $post_id);
        
        // Email Settings
        if ( $optionsEmails['receiver_new_testimonial'] ) {
            $to = $optionsEmails['receiver_new_testimonial'];
        } else {
            $to = get_option('admin_email');
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', 'From: ' . get_bloginfo( 'name' ) . ' <admin@gratis-studium-nein.ch>');//make it HTML
        $subject = __('Neues Testimonial');
    
        // Message
        $body = "<h1>Neues Testimonial wurde erstellt</h1>
                </br>
                <h3>{$email_firstName} {$email_lastName}</h3>
                <p>Funktion: </p>
                <p>{$email_function}</p>
                </br>
                <p>Zitat: </p>
                <p>{$email_quote}</p>
                </br>
                <p>Das Testimonial muss überprüft und freigegeben werden: </p>
                <b><a href='{$post_edit_link}'>Testimonial jetzt prüfen</a></b>
                " ;
    
        // Send email to admin.
        wp_mail( $to, $subject, $body, $headers );
    }
  
}