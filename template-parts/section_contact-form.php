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
            <h2 class=""><?php _e( 'Kontaktieren Sie uns', 'political-landingpages' ); ?></h2>
            <div class="spacer-medium"></div>
            <?php echo do_shortcode('[contact-form-7 id="23d0a7b" title="Generisches Kontaktformular"]'); ?>
        </div>
    </div>
</section>