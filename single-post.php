<?php
/**
 * The template for displaying all single news posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Political_Landingpages
 */

get_header();

$overviewPageUrl = get_permalink( get_page_by_path( 'news' ) );
?>

	<main id="primary" class="site-main">

        <section class="hero-section hero-news background-color-tertiary">
            <div class="section-padding-large">
                <div class="container">

                    <div class="hero_inner hero-news_inner ">
                        <div class="hero-news_header row justify-content-between row-cols-auto align-items-end">
                            <div class="back-wrapper">
                                <a class="text-link back-link" href="<?php echo $overviewPageUrl; ?>"><div class="icon-wrapper"><img src="<?php echo get_template_directory_uri() . '/assets/icons/arrow_left.svg'; ?>" class="arrow inline-svg" alt="Arrow Icon"/></div><?php _e( 'Zurück zu allen News', 'political-landingpages' ); ?></a>
                            </div>
                        </div>
                        <div class="divider divider-secondary"></div>
                        <div class="hero-news_content row align-items-center">
                            <div class="col-md-8 offset-md-2 text-align-center">
                                <h3 class="text-style-overline text-color-accent"><?php echo get_the_terms( get_the_ID(), 'category' )[0]->name; ?></h3>
                                <?php the_title( '<h1 class="event-title">', '</h1>' ); ?>
                                <div class="spacer-small"></div>
                                <div class="post-excerpt text-size-large"><?php the_excerpt(); ?></div>
                            </div>
                        </div>
                        <div class="divider divider-secondary"></div>
                        <div class="hero-news_footer row justify-content-between row-cols-auto align-items-center">
                            <div class="location-wrapper">
                                <b class="text-size-regular post-meta-category"><?php echo get_the_category( get_the_ID() )[0]->name; ?></b>
                                <p class="text-size-regular post-meta-date"><?php echo get_the_date("d. F Y"); ?></p>
                            </div>
                            <div class="share-wrapper">
                                <a class="text-link share-link" href="#" data-copy-clipboard="click" data-copy-clickboard-text="Kopiert!"><span data-copy-clipboard="notice"><?php _e( 'Teilen', 'political-landingpages' ); ?></span><div class="icon-wrapper"><img src="<?php echo get_template_directory_uri() . '/assets/icons/icon_share.svg'; ?>" class="arrow inline-svg" alt="Share Icon"/></div></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

		<div class="container">
			<div class="section-padding-large">
                
				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', get_post_type() ); 
					
					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Vorheriger Arikel:', 'political-landingpages' ) . '</span> <span class="nav-title">%title</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Nächster Arikel:', 'political-landingpages' ) . '</span> <span class="nav-title">%title</span>',
						)
					);

				endwhile; // End of the loop.
				?>

			</div>
		</div><!-- .container -->
	</main><!-- #main -->

	<section class="section_more-posts background-color-secondary">
		<div class="section-padding-large">
			<div class="container">
				<h2 class=""><?php _e( 'Weitere News', 'political-landingpages' ); ?></h2>
				<div class="spacer-medium"></div>
				<?php echo do_shortcode('[news]'); ?>
				<div class="spacer-medium"></div>
				<a href="<?php echo $overviewPageUrl; ?>" class="button button-secondary"><?php _e( 'Alle News', 'political-landingpages' ); ?></a>
			</div>
		</div>
	</section>

<?php

// Load CTA Section
get_template_part('template-parts/section_cta'); 

// Load Contact Form Section
get_template_part('template-parts/section_contact-form'); 

get_footer();

