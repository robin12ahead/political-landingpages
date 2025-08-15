<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Political_Landingpages
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="section-404 background-color-tertiary">
			<div class="container">
				<div class="section-padding-medium">
					<h1>404</h1>
					<h3>Hier ist nichts…</h3>
					<p class="text-size-medium">Diese Seite scheint nicht zu existieren oder wurde gelöscht.</p>
					</br>
					<a href="/" class="button">Startseite</a>
				</div>
			</div>
			
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php

// Load CTA Section
get_template_part('template-parts/section_cta'); 

// Load Contact Form Section
get_template_part('template-parts/section_contact-form'); 

get_footer();
