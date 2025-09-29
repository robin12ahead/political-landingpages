<?php
/**
 * Template part for the sticky button that is displayed under the navbar
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Political_Landingpages
 */

?>

<?php
	$optionsStickyButton = get_field('sticky_button', 'option');
	
	if ( $optionsStickyButton["sticky_button_status"] == true ) : ?>
	<aside class="sidenav">
		<nav class="sidenav_menu">
			<a href="<?php echo $optionsStickyButton["link"]; ?>" class="sidenav_menu-item" target="_blank">

				<?php
				$icon = $optionsStickyButton["icon"];

				// Handle if the return type is a string.
				if ( is_string( $icon ) ) {

					// If the type selected was a Dashicon, the value of $icon will be the dashicon class string.
					// If the type selected was a Media Library image, the value of $icon will be the URL to the image.
					// If the type selected was a URL, the value of $icon will be the URL to the image.
					esc_html( $icon );

				} else {
					// Handle if the return type is an array.

					// If the type selected was a Dashicon, render a div with the dashicon class.
					if ( 'dashicons' === $icon['type'] ) {
						echo '<div class="' . $icon['value'] . ' dashicons"></div>';
					}

					// If the type selected was a Media Library image, use the attachment ID to get and render the image.
					if ( 'media_library' === $icon['type'] ) {  
						$attachment = $icon['value'];

						echo '<img src="' . $attachment['url'] .'" alt="social-icon" class="inline-svg" style="width: 100%;">';
					}

					// // If the type selected was a URL, render an image tag with the URL.
					// if ( 'url' === $icon['type'] ) {
					// 	$url = $icon['value'];
					// 	echo '<img src="' . esc_url( $url ) .'" alt="social-icon">';
					// }
				}
				?>
			</a>
		</nav>
	</aside>
	<?php endif; ?>