<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Political_Landingpages
 */

?>
<?php acf_form_head(); ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'political-landingpages' ); ?></a>

	<header id="site-header" class="header">
		<div id="main-navbar" class="navbar">
			<div class="container">

				<div class="site-branding">

					<?php
					if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php 
					$genericLogo = get_template_directory_uri() . '/assets/img/site-logo.svg';
					elseif ( getimagesize( $genericLogo ) ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home" aria-current="page"><img src="<?php echo $genericLogo; ?>" class="custom-logo" alt="<?php bloginfo( 'name' ); ?>-logo" decoding="async"></a>
					<?php else: ?>
						<div class="site-title"><a class="site-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
					<?php endif; ?>

				</div><!-- .site-branding -->
		
				<div class="navigation-wrapper">

					<?php echo do_shortcode( '[social-media-links]' ); ?>
					
					<nav id="main-nav" class="navigation">
						<?php
						wp_nav_menu(
							array(
								'theme_location' 	=> 'primary-menu',
								'menu_id'        	=> 'primary-menu',
								'link_class'   	 => 'nav-link',
								'menu_class'     => 'menu nav',
								'container' => false,
								)
							);
							?>
					</nav><!-- #site-navigation -->

					<button class="navbar-toggle hamburger hamburger--squeeze" aria-controls="primary-menu" aria-expanded="false">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>

				</div><!-- .navigation-wrapper -->


			</div>

		</div>

	</header><!-- #site-header -->

	<aside class="sidenav">
		<nav class="sidenav_menu">
			<a href="<?php echo get_permalink( get_page_by_path( 'spenden' ) ); ?>" class="sidenav_menu-item" target="_blank">
				<svg id="Ebene_1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 34 34" fill="currentColor">
					<path d="M4.38,9.12s.02.03.04.04l5.34,5.55c1.17,1.22,3.12,1.22,4.29,0l5.34-5.55s.02-.02.03-.04c2.91-3.1.8-8.2-3.41-8.37h-.2s-.01,0-.01,0c-1.56,0-2.97.72-3.9,1.89-.93-1.17-2.34-1.89-3.9-1.89h-.01c-4.27.01-6.5,5.05-3.75,8.22l.13.15ZM8,2.9c1.56,0,2.82,1.26,2.82,2.82,0,.59.48,1.07,1.07,1.07.59,0,1.07-.48,1.07-1.07,0-1.56,1.27-2.82,2.83-2.82,2.48,0,3.74,2.99,2.03,4.77,0,0-.02.02-.02.03l-5.31,5.52c-.31.32-.81.34-1.14.06l-.06-.06-5.3-5.51s-.02-.03-.03-.04c-1.71-1.79-.43-4.77,2.04-4.77Z"/>
					<path d="M32.15,16.71h-15.48c-2.11,0-3.82,1.71-3.82,3.82,0,1.47.84,2.75,2.07,3.39l-1.59,1-6.7-4.22c-1.78-1.12-4.14-.59-5.26,1.19-1.12,1.78-.59,4.14,1.19,5.27l8.74,5.51c1.24.78,2.83.78,4.07,0l13.2-8.32h3.58c.59,0,1.07-.48,1.07-1.07v-5.49c0-.59-.48-1.07-1.07-1.07ZM14.22,30.85c-.54.34-1.24.34-1.78,0l-8.74-5.51c-1.41-.89-.78-3.08.89-3.08.3,0,.61.08.89.26l7.27,4.58c.35.22.8.22,1.14,0l4.37-2.75h1.42c.59,0,1.07-.48,1.07-1.07s-.48-1.07-1.07-1.07h-3.02c-.92,0-1.67-.75-1.67-1.67s.75-1.67,1.67-1.67h14.4v3.34h-2.82c-.2,0-.4.06-.57.17l-13.46,8.49Z"/>
				</svg>
			</a>
		</nav>
	</aside>
