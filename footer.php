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
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
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
