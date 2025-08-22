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
			</div>

		</div>

	</header><!-- #site-header -->
