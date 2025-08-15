<?php
/**
 * The template for displaying all single testimonials
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Political_Landingpages
 */

get_header();
?>

	<main id="primary" class="site-main testimonial-main">

		<div class="container">
			<div class="section-padding-large">
				<h2 class="text-style-overline text-color-accent">Ihr Banner</h2>

				<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', get_post_type() ); ?>
						
						<div class="spacer-small"></div>
						
						<div class="max-width-medium">
							<a class="banner-wrapper banner-link" href="<?php echo get_post_meta( get_the_ID(), 'custom_banner_image', true); ?>" target="_blank">
								<img src="<?php echo get_post_meta( get_the_ID(), 'custom_banner_image', true); ?>" alt="banner">
							</a>
						</div>

						<div class="spacer-medium"></div>
						<div class="">
							<h3>Banner herunterladen</h3>
							<div class="spacer-xsmall"></div>
							<a class="button banner-download" href="<?php echo get_post_meta( get_the_ID(), 'custom_banner_image', true); ?>" download="">Download Banner</a>
						</div>

						<?php

					endwhile; // End of the loop.
				?>
			</div>

		</div><!-- .container -->
	</main><!-- #main -->
	
<?php

// Load CTA Section
get_template_part('template-parts/section_cta'); 

// Load Contact Form Section
get_template_part('template-parts/section_contact-form'); 

get_footer();
