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
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-C0P27ZCD4Q"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'G-C0P27ZCD4Q');
	</script>
	<!-- Meta Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '811300244535723');
	fbq('track', 'PageView');
	</script>
	<!-- End Meta Pixel Code -->
	<meta name="facebook-domain-verification" content="lmdrbruhlecmj7ug1f3d7l7653l4e0" />
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
					the_custom_logo();
					?>
					<div class="site-title"><a class="site-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
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
