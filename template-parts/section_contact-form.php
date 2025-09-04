<?php
/**
 * Template part for displaying Contact Form Section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Political_Landingpages
 */

?>

<section class="section_contact-form background-color-tertiary">
    <div class="section-padding-large">
        <div class="spacer-edge"></div>
        <div class="container">
            <h2 class="heading-has-unterline"><?php _e( 'Kontaktieren Sie uns', 'political-landingpages' ); ?></h2>
            <div class="spacer-medium"></div>
        
            <?php if ( is_active_sidebar( 'contact-form' ) ) {
                dynamic_sidebar( 'contact-form' );
            } ?>
        </div>
    </div>
</section>