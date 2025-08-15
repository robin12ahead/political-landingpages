<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Political_Landingpages
 */
 
 get_header();
 ?>

	<main id="primary" class="site-main">

		<?php 
		if (get_field("hero_visibility") == true) {

			// different template if it is home or subpage
			if ( is_front_page() ) {
				get_template_part('template-parts/hero-home'); 
			} else {
				get_template_part('template-parts/hero-subpages'); 
			}
		}
		?>

		<?php
		// Add Container to non-elementor pages
		$page_id =  get_the_ID();
		if ( !metadata_exists('post', $page_id, '_elementor_edit_mode') ) : ?>
			<div class="container">
		<?php endif; ?>

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		<?php 
		if ( !metadata_exists('post', $page_id, '_elementor_edit_mode') ) : ?>
			</div><!-- .container -->
		<?php endif; ?>

	</main><!-- #main -->

<?php	
get_sidebar();

// Load CTA Section
if ( !get_field( 'cta_section_visibility' ) == false ) {
	get_template_part('template-parts/section_cta'); 
} 

// Load Contact Form Section
if ( !get_field( 'contact-form_visibility' ) == false ) {
	get_template_part('template-parts/section_contact-form'); 
}

get_footer();