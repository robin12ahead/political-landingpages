<?php
/**
 * Template part for displaying the hero on subpages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Political_Landingpages
 */

?>

<section class="hero-section hero-home background-color-primary section-padding-medium d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="max-width-large">
                    <?php
                    if (get_field("overline_text")) : ?>
                    <h4 class="text-style-overline text-color-accent"><?php the_field("overline_text"); ?></h4>
                    <?php endif; ?>
                    
                    <?php
                    if ( is_singular() ) :
                        if (get_field("title_override")) {
                            echo '<h1 class="site-title ">' . wp_kses_post ( get_field("title_override") ) .'</h1>';
                        } else {
                            the_title( '<h1 class="site-title">', '</h1>' );
                        }
                    endif; ?>
                    <div class="spacer-medium"></div>
                </div>

                <?php 
                $hero_button = get_field("hero_button"); 
                if ( $hero_button ) : ?>
                <a href="<?php echo $hero_button["url"]; ?>" class="button btn btn-has-arrow" target="<?php echo $hero_button["target"]; ?>"><?php echo $hero_button["title"]; ?></a>
                <?php endif; ?>
            </div>

            <div class="col-lg-5 d-flex justify-content-md-end">
                <div class="headvisual-wrapper">
                    <?php
                    if ( get_theme_mod( 'headvisual-image' )) : ?>
                        <img src="<?php echo get_theme_mod( 'headvisual-image' ); ?>" alt="headvisual">
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri() . '/assets/img/headvisual-placeholder.jpg'; ?>" alt="headvisual">
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </div>
    <button class="btn scroll-to-main">
        <svg width="16" height="25" viewBox="0 0 16 25" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.29289 24.7071C7.68342 25.0976 8.31658 25.0976 8.70711 24.7071L15.0711 18.3431C15.4616 17.9526 15.4616 17.3195 15.0711 16.9289C14.6805 16.5384 14.0474 16.5384 13.6569 16.9289L8 22.5858L2.34315 16.9289C1.95262 16.5384 1.31946 16.5384 0.928931 16.9289C0.538407 17.3195 0.538407 17.9526 0.928931 18.3431L7.29289 24.7071ZM7 -4.37114e-08L7 24L9 24L9 4.37114e-08L7 -4.37114e-08Z"/>
        </svg>
    </button>
</section>
