<?php
/**
 * Template part for displaying CTA Section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Political_Landingpages
 */

?>

<section class="section_cta-boxes background-color-primary">
    <div class="section-padding-large">
        <div class="container">
            <h2 class=""><?php _e( 'Mitmachen & Unterstützen', 'political-landingpages' ); ?></h2>
            <div class="spacer-medium"></div>

            <div class="row justify-content-between row-cols-md-auto justify-content-md-center">

            <?php if ( is_active_sidebar( 'cta-1' ) ) : ?>
                <div class="col-lg-4 col-md-6">
                    <div class="box cta-box">
                        <?php dynamic_sidebar( 'cta-1' ); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'cta-2' ) ) : ?>
                <div class="col-lg-4 col-md-6">
                    <div class="box cta-box">
                        <?php dynamic_sidebar( 'cta-2' ); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'cta-3' ) ) : ?>
                <div class="col-lg-4 col-md-6">
                    <div class="box cta-box">
                        <?php dynamic_sidebar( 'cta-3' ); ?>
                    </div>
                </div>
            <?php endif; ?>
                
            </div>
        </div>
    </div>
</section>