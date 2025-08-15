<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Political_Landingpages
 */


get_header();
?>


	<main id="primary" class="site-main">

		<div class="container">
			<div class="section-padding-large">

				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', get_post_type() ); 
					
					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'political-landingpages' ) . '</span> <span class="nav-title">%title</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'political-landingpages' ) . '</span> <span class="nav-title">%title</span>',
						)
					);

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
				
			</div>
		</div><!-- .container -->
	</main><!-- #main -->
	
<?php

// Load Contact Form Section
if (  get_post_type() == 'post' ) : ?>

	<section class="section_more-posts background-color-secondary">
		<div class="section-padding-large">
			<div class="container">
				<h2 class=""><?php _e( 'Mehr News', 'political-landingpages' ); ?></h2>
				<div class="spacer-medium"></div>
				<?php echo do_shortcode('[news]'); ?>
				<div class="spacer-medium"></div>
				<a href="<?php get_permalink( get_page_by_path( 'news' ) ); ?>" class="button button-secondary"><?php _e( 'Alle News', 'political-landingpages' ); ?></a>
			</div>
		</div>
	</section>

<?php 
endif;

// Load CTA Section
get_template_part('template-parts/section_cta'); 

// Load Contact Form Section
get_template_part('template-parts/section_contact-form'); 

get_footer();
