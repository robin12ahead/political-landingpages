<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Political_Landingpages
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php get_template_part('template-parts/hero-home'); ?>

		<?php
		// Add Container to non-elementor pages
		$page_id =  get_the_ID();
		if ( !metadata_exists('post', $page_id, '_elementor_edit_mode') ) : ?>
			<div class="container">
		<?php endif; ?>

			<?php
			if ( have_posts() ) :

				if ( is_home() && ! is_front_page() ) :
					?>
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
					<?php
				endif;

				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					*/
					get_template_part( 'template-parts/content', get_post_type() );

				endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>
				
		<?php 
		if ( !metadata_exists('post', $page_id, '_elementor_edit_mode') ) : ?>
			</div><!-- .container -->
		<?php endif; ?>

	</main><!-- #main -->

<?php

// Load CTA Section
if ( !get_field( 'cta_section_visibility' ) == false && get_post_type() == 'page' ) {
	get_template_part('template-parts/section_cta'); 
} 

// Load Contact Form Section
if ( !get_field( 'contact-form_visibility' ) == false && get_post_type() == 'page' ) {
	get_template_part('template-parts/section_contact-form'); 
}

get_footer();
