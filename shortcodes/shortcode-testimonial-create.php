<?php
/**
 * Testimonial creation shortcode, banner generator & notification emails.
 *
 * Provides:
 *  1. [testimonial-create] shortcode rendering a frontend ACF form
 *  2. Automatic banner image generation when a testimonial is saved
 *  3. Post title/slug normalization + admin notification after submission
 *  4. User notification email once their testimonial is published
 *
 * Sections 1 and 2 are each gated behind their own addon toggle
 * (configured on the ACF "Addons" options page).
 */

$optionsAddons = get_field( 'addons', 'option' );

/* =============================================================================
 * 1. SHORTCODE: [testimonial-create]
 * ===========================================================================*/
if ( $optionsAddons['testimonials_generieren'] == true ) {

	add_shortcode( 'testimonial-create', 'shortcode_testimonial_create' );

	/**
	 * Renders the frontend "create testimonial" form.
	 *
	 * Two variants are rendered depending on whether the banner generator
	 * addon is active:
	 *  - Banner generator ON  -> full field group (incl. banner-related fields)
	 *  - Banner generator OFF -> reduced set of individual fields
	 *
	 * @param array $atts Shortcode attributes ('submit_text', 'updated_message').
	 * @return string Rendered form HTML.
	 */
	function shortcode_testimonial_create( $atts ) {

		// Reserved for future use: auto-assign a "Needs Approval" taxonomy
		// term to new testimonials on creation (currently disabled).
		//
		// $taxonomy  = 'testimonial_category';
		// $term_slug = 'needs-approval';
		// $term_name = 'Needs Approval';
		// $term = get_term_by( 'slug', $term_slug, $taxonomy );
		// if ( ! $term ) {
		//     $new_term = wp_insert_term( $term_name, $taxonomy, array( 'slug' => $term_slug ) );
		//     if ( is_wp_error( $new_term ) ) {
		//         error_log( 'Error creating term: ' . $new_term->get_error_message() );
		//         return;
		//     }
		//     $term_id = $new_term['term_id'];
		// } else {
		//     $term_id = $term->term_id;
		// }

		$atts = shortcode_atts( array(
			'submit_text'     => 'Testimonial erstellen',
			'updated_message' => 'Danke für Ihre Unterstützung!  Ich werde Ihr Testimonial überprüfen und im Anschluss aufschalten.',
		), $atts, 'testimonial-create' );

		$optionsAddons = get_field( 'addons', 'option' );

		// Config shared by both form variants below.
		$form_args = array(
			'post_id'               => 'new_post',
			'new_post'              => array(
				'post_type'   => 'testimonial',
				'post_status' => 'pending',
				// 'tax_input' => array( $taxonomy => array( $term_id ) ),
			),
			'post_title'            => false,
			'post_content'          => false,
			'updated_message'       => $atts['updated_message'],
			'return'                => '?updated=true#create',
			'honeypot'              => true,
			'form'                  => true,
			'uploader'              => 'basic',
			'label_placement'       => 'top',
			'instruction_placement' => 'field',
			'html_before_fields'    => '<div class="shortcode_testimonial-create row">',
			'html_after_fields'     => '</div>',
		);

		ob_start();

		if ( $optionsAddons['banner_generator_status'] == true ) {

			// Full field group, used when the banner generator is active.
			acf_form( array_merge( $form_args, array(
				'id'           => 'acf-form-testimonial',
				'field_groups' => array( 'group_6698e5e74ec9d' ),
				'submit_value' => 'Banner erstellen',
			) ) );

		} else {

			// Reduced set of individual fields, no banner generation.
			acf_form( array_merge( $form_args, array(
				'fields' => array(
					'field_66cc8b3cb4928',
					'field_66a1223baaf73',
					'field_66a1226aaaf74',
					'field_6698e631e9799',
					'field_6698e61ce9797',
					'field_66c7426818da5',
					'field_6698e625e9798',
					'field_66b37f7e6e5c1',
				),
				'submit_value' => $atts['submit_text'],
			) ) );
		}

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}

/* =============================================================================
 * 2. BANNER IMAGE GENERATION
 * ===========================================================================*/
if ( $optionsAddons['banner_generator_status'] == true ) {

	/**
	 * Creates a white circle on a transparent background. Used as an
	 * alpha mask to crop another image into a circle.
	 *
	 * @param int $width
	 * @param int $height
	 * @return resource|GdImage
	 */
	function create_circle_mask( $width, $height ) {
		$mask = imagecreatetruecolor( $width, $height );

		// Transparent background.
		imagesavealpha( $mask, true );
		$transparency = imagecolorallocatealpha( $mask, 0, 0, 0, 127 );
		imagefill( $mask, 0, 0, $transparency );

		// Draw the white circle used as the visible/opaque area.
		$white = imagecolorallocate( $mask, 255, 255, 255 );
		imagefilledellipse( $mask, $width / 2, $height / 2, $width, $height, $white );

		return $mask;
	}

	/**
	 * Applies a circular mask to an image, cropping it into a circle
	 * with a transparent background.
	 *
	 * @param resource|GdImage $image
	 * @return resource|GdImage
	 */
	function apply_circle_mask( $image ) {
		$width  = imagesx( $image );
		$height = imagesy( $image );

		$mask = create_circle_mask( $width, $height );

		$final_image = imagecreatetruecolor( $width, $height );
		imagesavealpha( $final_image, true );
		$transparency = imagecolorallocatealpha( $final_image, 0, 0, 0, 127 );
		imagefill( $final_image, 0, 0, $transparency );

		// Copy only the pixels that fall inside the (opaque) mask circle.
		for ( $x = 0; $x < $width; $x++ ) {
			for ( $y = 0; $y < $height; $y++ ) {
				$alpha = imagecolorat( $mask, $x, $y ) >> 24;
				if ( $alpha == 0 ) { // Fully opaque in mask.
					$color = imagecolorat( $image, $x, $y );
					imagesetpixel( $final_image, $x, $y, $color );
				}
			}
		}

		imagedestroy( $mask );

		return $final_image;
	}

	add_action( 'acf/save_post', 'create_custom_testimonial_banner' );

	/**
	 * Generates a custom banner image (quote, sender, profile picture,
	 * head visual) for a testimonial post and stores its URL in the
	 * "custom_banner_image" post meta.
	 *
	 * @param int $post_id
	 */
	function create_custom_testimonial_banner( $post_id ) {

		// Only run for the "testimonial" post type.
		if ( get_post_type( $post_id ) != 'testimonial' ) {
			return;
		}

		/* -----------------------------------------------------------------
		 * Banner settings (from the ACF options page)
		 * ---------------------------------------------------------------*/
		$banner_options = get_field( 'options_testimonials', 'option' );

		$upload_dir     = wp_upload_dir();
		$template_dir   = get_template_directory();
		$banner_dir     = '/banners/testimonials/';
		$banner_prefix  = $banner_options['banner_prefix'];
		$banner_format  = $banner_options['banner_file_type'];
		$font_heading   = $template_dir . '/assets/fonts/' . $banner_options['banner_heading_font'];
		$font_body      = $template_dir . '/assets/fonts/' . $banner_options['banner_body_font'];
		$banner_width   = $banner_options['banner_width'];
		$banner_height  = $banner_options['banner_height'];
		$banner_padding = $banner_options['banner_padding'];
		$bg_color       = $banner_options['banner_background_color'];
		$text_color     = $banner_options['banner_text_color'];
		$accent_color   = $banner_options['banner_accent_color'];

		/* -----------------------------------------------------------------
		 * Text content
		 * ---------------------------------------------------------------*/
		$text_firstName = get_field( 'vorname', $post_id );
		$text_lastName  = get_field( 'nachname', $post_id );
		// $text_author = get_field( 'autor', $post_id );

		$text_quote = strip_tags( get_field( 'zitat', $post_id ), '<br>' );
		$text_quote = '«' . $text_quote . '»';

		$text_function = get_field( 'funktion', $post_id );
		$text_party    = get_field( 'partei', $post_id ) ? ', ' . get_field( 'partei', $post_id ) : '';
		$text_sender   = $text_firstName . ' ' . $text_lastName . ', ' . $text_function . $text_party;

		/* -----------------------------------------------------------------
		 * Base image (background)
		 * ---------------------------------------------------------------*/
		$image = imagecreatetruecolor( $banner_width, $banner_height );

		$background_color = imagecolorallocate( $image, $bg_color['red'], $bg_color['green'], $bg_color['blue'] );
		imagefilledrectangle( $image, 0, 0, $banner_width, $banner_height, $background_color );

		/* -----------------------------------------------------------------
		 * Profile picture (imported + circular mask)
		 * ---------------------------------------------------------------*/
		$profilePicture      = get_field( 'profilbild', $post_id );
		$profilePictureImage = null;

		if ( ! empty( $profilePicture ) ) {
			$profilePictureURL  = wp_get_attachment_image_url( $profilePicture['id'], 'testimonial' );
			$profilePicturePath = get_image_file_path_from_url( $profilePictureURL );

			if ( $profilePicture['subtype'] == 'jpeg' || $profilePicture['subtype'] == 'jpg' ) {
				$profilePictureImage = imagecreatefromjpeg( $profilePicturePath );
			} elseif ( $profilePicture['subtype'] == 'png' ) {
				$profilePictureImage = imagecreatefrompng( $profilePicturePath );
			}
		}

		if ( ! empty( $profilePictureImage ) ) {

			$profilePictureImageCircular = apply_circle_mask( $profilePictureImage );

			$profilePictureWidth  = imagesx( $profilePictureImageCircular );
			$profilePictureHeight = imagesy( $profilePictureImageCircular );

			$newProfileWidth  = '500';
			$newProfileHeight = '500';

			imagecopyresampled( 
                $image, 
                $profilePictureImageCircular, 
                $banner_padding, 
                $banner_padding, 
                0, 
                0, 
                $newProfileWidth, 
                $newProfileHeight, 
                $profilePictureWidth, 
                $profilePictureHeight,
            );

			// Head visual shifts right to make room for the profile picture.
			$headVisualPosX = '900';

		} else {

			$headVisualPosX = $banner_padding;
		}

		/* -----------------------------------------------------------------
		 * Head visual (imported)
		 * ---------------------------------------------------------------*/
		// $headVisualURL = get_theme_mod( 'headvisual-image' );
		$headVisualURL = $banner_options['banner_visual'];

		if ( ! empty( $headVisualURL ) ) {
			$headVisualPath  = get_image_file_path_from_url( $headVisualURL );
			$headVisualImage = imagecreatefrompng( $headVisualPath );

			if ( ! empty( $headVisualImage ) ) {

				$headvisualWidth  = imagesx( $headVisualImage );
				$headvisualHeight = imagesy( $headVisualImage );

				$newHeadvisualWidth  = '290';
				$newHeadvisualHeight = '215';
				$headVisualPosY      = $banner_padding;

				imagecopyresampled( 
                    $image, 
                    $headVisualImage, 
                    $headVisualPosX, 
                    $headVisualPosY, 
                    0, 
                    0, 
                    $newHeadvisualWidth, 
                    $newHeadvisualHeight, 
                    $headvisualWidth, 
                    $headvisualHeight,
                );
			}
		}

		/* -----------------------------------------------------------------
		 * Text overlays
		 * ---------------------------------------------------------------*/

		// Quote text.
		if ( ! empty( $text_quote ) ) {

			$text_quote_color = imagecolorallocate( $image, $text_color['red'], $text_color['green'], $text_color['blue'] );
			$text_quote_size  = '52';
			$text_quote_PosY  = '720';

			$text_quote = wordwrap( $text_quote, 34, "\n", true );
			imagettftext( $image, $text_quote_size, 0, $banner_padding, $text_quote_PosY, $text_quote_color, $font_heading, $text_quote );
		}

		// Sender text (name, function, party).
		if ( ! empty( $text_sender ) ) {

			$text_author_color = imagecolorallocate( $image, $text_color['red'], $text_color['green'], $text_color['blue'] );
			$text_author_size  = '40';
			$text_author_PosY  = '1400';

			imagettftext( $image, $text_author_size, 0, $banner_padding, $text_author_PosY, $text_author_color, $font_body, $text_sender );
		}

		// Decorative quotation mark (only when a profile picture is present).
		if ( ! empty( $profilePictureImage ) ) {

			$quotation_color = imagecolorallocate( $image, $accent_color['red'], $accent_color['green'], $accent_color['blue'] );
			$quotation_size  = '256';
			$quotation_PosY  = '256';

			imagettftext( 
                $image, 
                $quotation_size, 
                0, 
                $banner_padding, 
                $quotation_PosY, 
                $quotation_color, 
                $font_heading, 
                '«',
            );
		}

		/* -----------------------------------------------------------------
		 * Save the banner & store its URL
		 * ---------------------------------------------------------------*/
		$image_path = $upload_dir['basedir'] . $banner_dir . $banner_prefix . '_' . $post_id . $banner_format;
		$image_url  = $upload_dir['baseurl'] . $banner_dir . $banner_prefix . '_' . $post_id . $banner_format;

		if ( $banner_format == '.png' ) {
			header( 'Content-Type: image/png' );
			imagepng( $image, $image_path, $banner_options['banner_qualitiy'] );
		}

		/* -----------------------------------------------------------------
		 * Cleanup
		 * ---------------------------------------------------------------*/
		imagedestroy( $image );
		// imagedestroy( $headVisualImage );
		// imagedestroy( $profilePictureImage );
		// imagedestroy( $profilePictureImageCircular );

		update_post_meta( $post_id, 'custom_banner_image', $image_url, $post_id );
	}
}

/* =============================================================================
 * 3. POST-SAVE HOUSEKEEPING (title/slug) + ADMIN NOTIFICATION EMAIL
 * ===========================================================================*/
add_action( 'acf/save_post', 'testimonial_after_save', 20 );

/**
 * Runs once, right after a testimonial is first saved:
 *  - Sets the post title/slug from the submitted first/last name
 *  - Sends an admin notification email (if enabled in the options)
 *
 * @param int $post_id
 */
function testimonial_after_save( $post_id ) {

	// Only run for the "testimonial" post type.
	if ( get_post_type( $post_id ) != 'testimonial' ) {
		return;
	}

	// Only run once per post.
	$flag = get_post_meta( $post_id, 'new_post_flag', true );
	if ( $flag == 'true' ) {
		return;
	}
	update_post_meta( $post_id, 'new_post_flag', 'true' );

	/* -----------------------------------------------------------------
	 * Update post title / slug
	 * ---------------------------------------------------------------*/
	$new_title = get_field( 'vorname', $post_id ) . ' ' . get_field( 'nachname', $post_id );

	$new_post = array(
		'ID'         => $post_id,
		'post_title' => $new_title,
		'post_name'  => (string) $post_id,
	);

	// Temporarily remove the banner hook to avoid an infinite loop, since
	// wp_update_post() below triggers acf/save_post again.
	// Must be removed/re-added with the same priority (20) it was added with.
	remove_action( 'acf/save_post', 'create_custom_testimonial_banner', 20 );

	wp_update_post( $new_post );
	// wp_set_post_terms( $post_id, array( '7', '19' ), 'testimonial_category' );

	add_action( 'acf/save_post', 'create_custom_testimonial_banner', 20 );

	/* -----------------------------------------------------------------
	 * Admin notification email
	 * ---------------------------------------------------------------*/
	$optionsEmails = get_field( 'options_emails', 'option' );

	if ( $optionsEmails['send_email_new_testimonial'] == true ) {

        // get post edit link
		$post_edit_link = get_site_url() . '/wp-admin/post.php?post=' . $post_id . '&action=edit';

        // get email information
		$email_firstName = get_field( 'vorname', $post_id );
		$email_lastName  = get_field( 'nachname', $post_id );
		$email_quote     = get_field( 'zitat', $post_id );
		$email_function  = get_field( 'funktion', $post_id );

        // get email headers
		$to   = $optionsEmails['receiver_new_testimonial'] ? $optionsEmails['receiver_new_testimonial'] : get_option( 'admin_email' );
		$from = $optionsEmails['sender_email'] ? $optionsEmails['sender_email'] : get_option( 'admin_email' );

		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
			'From: ' . get_bloginfo( 'name' ) . '<' . $from . '>',
		);

		$subject = __( 'Neues Testimonial' );

        // the email body
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
				";

        // Send the email
		wp_mail( 
            $to, 
            $subject, 
            $body, 
            $headers,
        );
	}
}

/* =============================================================================
 * 4. USER NOTIFICATION EMAIL (on publish)
 * ===========================================================================*/
add_action( 'transition_post_status', 'check_pending_publish', 10, 3 );

/**
 * Sends the submitter a notification email once their testimonial moves
 * from "pending" to "publish", including a link to view it.
 *
 * @param string  $new_status
 * @param string  $old_status
 * @param WP_Post $post
 */
function check_pending_publish( $new_status, $old_status, $post ) {

	// Only act on the pending -> publish transition.
	if ( 'pending' !== $old_status || 'publish' !== $new_status ) {
		return;
	}

	// Restrict to the "testimonial" post type.
	if ( 'testimonial' !== $post->post_type ) {
		return;
	}

    // get post id
	$post_id = $post->ID;

    // get addon options 
    $optionsAddons = get_field( 'addons', 'option' );

    // get email options
	$optionsEmails = get_field( 'options_emails', 'option' );
	if ( $optionsEmails['send_email_new_testimonial'] != true ) {
		return;
	}

	// $post_banner_link = get_site_url() . '/aktuelles/testimonial/' . $post_id;
	$post_banner_link = get_permalink( $post_id );
    $testimonials_link = get_site_url() . '/unterstuetzen/testimonials/';

	$email_firstName = get_field( 'vorname', $post_id );
	$email_lastName  = get_field( 'nachname', $post_id );

    
    // get email headers
    $banner_to   = get_field( 'email', $post_id );
    $banner_from = $optionsEmails['sender_email'];

	$banner_headers = array(
        'Content-Type: text/html; charset=UTF-8',
		'From: ' . get_bloginfo( 'name' ) . '<' . $banner_from . '>',
        );
        
	$banner_subject = __( 'Neues Testimonial' );

    if ( $optionsAddons['banner_generator_status'] == true ) {

        $banner_body = "
            <h1>Dein Testimonial wurde erstellt</h1>
            <h3>Hallo {$email_firstName} {$email_lastName},</h3>
            <p>Dein Testimonial wurde von uns geprüft und ist nun freigegeben.</p>
            </br>
            <h4>Herzlichen Dank für deine Unterstützung!</h4>
            <p>Wir freuen uns, wenn du das Testimonial teilst.</p>
            </br>
            <h4>Download Banner:</h4>
            <b><a href='{$post_banner_link}'>Zum Testimonial</a></b>
            ";
    } else {

        $banner_body = "
            <h1>Dein Testimonial wurde erstellt</h1>
            <h3>Hallo {$email_firstName} {$email_lastName},</h3>
            <p>Dein Testimonial wurde von uns geprüft und ist nun freigegeben.</p>
            </br>
            <h4>Herzlichen Dank für deine Unterstützung!</h4>
            <p>Wir freuen uns, wenn du das Testimonial teilst.</p>
            </br>
            <h4>Testimonial ansehen</h4>
            <b><a href='{$testimonials_link}'>Zum Testimonial</a></b>
            ";
    }


    // Send the email
	wp_mail( 
        $banner_to, 
        $banner_subject, 
        $banner_body, 
        $banner_headers,
    );
}