<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Political_Landingpages
 */

?>


	<footer id="site-footer" class="footer">
		<div class="container">
			<div class="footer-wrapper">
				<div class="row justify-content-between row-cols-auto">
					<div class="footer-col">
						<div class="site-branding">

						<?php
						if ( has_custom_logo() ) : ?>
							<?php the_custom_logo(); ?>
						<?php 
						$genericLogo = get_template_directory_uri() . '/assets/img/site-logo.svg';
						elseif ( file_exists( $genericLogo ) ) : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home" aria-current="page"><img width="299" height="97" src="<?php echo $genericLogo; ?>" class="custom-logo" alt="<?php bloginfo( 'name' ); ?>-logo" decoding="async"></a>
						<?php else: ?>
							<div class="site-title"><a class="site-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
						<?php endif; ?>

						</div><!-- .site-branding -->
					</div>
					<div class="footer-col footer-icons">
						<?php if ( is_active_sidebar( 'footer-1' ) ) {
							dynamic_sidebar( 'footer-1' );
						} ?>
					</div>
				</div>
				
				<div class="divider"></div>
				
				<div class="row justify-content-between row-cols-auto">
					<div class="footer-col col-md-6">
						<?php
						$political_landingpages_description = get_bloginfo( 'description', 'display' );
						if ( $political_landingpages_description || is_customize_preview() ) :
							?>
							<p class="site-description">© <?php echo date('Y'); ?> - <?php echo $political_landingpages_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<?php endif; ?>
					</div>
					<div class="footer-col">
						<nav id="footer-nav" class="navigation">
							<?php
							wp_nav_menu(
								array(
									'theme_location' 	=> 'footer-menu',
									'menu_id'        	=> 'footer-menu',
									'link_class'   	 => 'nav-link',
									'menu_class'     => 'menu nav',
									'container' => false,
									)
								);
								?>
						</nav><!-- #footer-navigation -->
					</div>
				</div>
			</div>
		</div>
	</footer><!-- #site-footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
