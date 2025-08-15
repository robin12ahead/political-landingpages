<?php
/**
 * The template for displaying all single event posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Political_Landingpages
 */


get_header();

// event meta
if ( get_field("event_start_date") ) {
    $start_date = DateTime::createFromFormat( 'd.m.Y H:i', get_field("event_start_date") );
}
if ( get_field("event_end_date") ) {
    $end_date = DateTime::createFromFormat( 'd.m.Y H:i', get_field("event_end_date") );
} else {
    // $end_date = date('Y-m-d\TH:i:s', strtotime(get_field("event_start_date") . ' +2 hours'));
    // $end_date = date('Y-m-d\TH:i:s', strtotime('+2 hours', $start_date->getTimestamp()));
    $end_date = $start_date->add(new DateInterval('PT2H'));
}

$overviewPageUrl = get_permalink( get_page_by_path( 'events' ) );

?>

	<main id="primary" class="site-main">

        <section class="hero-section hero-events background-color-tertiary">
            <div class="section-padding-large">
                <div class="container">

                    <div class="hero_inner hero-events_inner">
                        <div class="hero-events_header row justify-content-between row-cols-auto align-items-end">
                            <div class="back-wrapper">
                                <a class="text-link back-link" href="<?php echo $overviewPageUrl; ?>"><div class="icon-wrapper"><img src="<?php echo get_template_directory_uri() . '/assets/icons/arrow_left.svg'; ?>" class="arrow inline-svg" alt="Arrow Icon"/></div><span class="button-text"><?php _e( 'Zurück zu allen Events', 'political-landingpages' ); ?></span></a>
                            </div>
                            <div class="calendar-wrapper">
                                <a class="text-link calender-link add-to-calendar">
                                    <!--<span class="button-text"><?php _e( 'Zum Kalender hinzufügen', 'political-landingpages' ); ?></span>-->
                                    
                                    <span class="addtocalendar">
                                        <var class="atc_event event_vars" hidden>
                                            <var class="atc_date_start"><?php echo $start_date->format( 'Y-m-d\TH:i:s' ); ?></var>
                                            <var class="atc_date_end"><?php echo $end_date->format( 'Y-m-d\TH:i:s' ); ?></var>
                                            <var class="atc_timezone">Europe/Berlin</var>
                                            <var class="atc_title"><?php echo esc_html(get_the_title()); ?></var>
                                            <var class="atc_description"><?php echo esc_html(get_the_excerpt()); ?></var>
                                            <var class="atc_location"><?php echo esc_html(get_field("event_location")); ?></var>
                                        </var>
                                        <span class="atcb-link button-text" id="" tabindex="1"><?php _e( 'Zum Kalender hinzufügen', 'political-landingpages' ); ?></span>
                                    </span>
                                    <div class="icon-wrapper"><img src="<?php echo get_template_directory_uri() . '/assets/icons/icon_calendar.svg'; ?>" class="arrow inline-svg" alt="Calendendar Icon"/></div>
                                </a>
                            </div>
                        </div>
                        <div class="divider divider-secondary"></div>
                        <div class="hero-events_content row align-items-center">
                            <div class="col-md-2">
                                <div class="date-wrapper">
                                    <h3 class="date-day"><?php echo $start_date->format( 'j.' ); ?></h3>
                                    <span class="date-month"><?php echo $start_date->format( 'F' ); ?></span>
                                </div>
                            </div>
                            <div class="col-md-8 text-align-center">
                                <?php the_title( '<h1 class="event-title">', '</h1>' ); ?>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="divider divider-secondary"></div>
                        <div class="hero-events_footer row justify-content-between row-cols-auto align-items-center">
                            <div class="location-wrapper">

                                <?php if ( get_field("event_end_date") ) : ?>
                                    <b class="text-size-regular post-meta-time"><?php echo $start_date->format( 'H:i' ) . " - " . $end_date->format( 'H:i' ); ?></b>
                                <?php else : ?>
                                    <b class="text-size-regular post-meta-time"><?php echo $start_date->format( 'H:i' ); ?></b>
                                <?php endif; ?>
                                
                                <?php if ( get_field("event_location") ) : ?>
                                <p class="text-size-regular"><?php echo get_field("event_location"); ?></p>
                                <?php endif; ?>
                                <?php if ( get_field("event_address") ) : ?>
                                <p class="text-size-regular"><?php echo get_field("event_address"); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="share-wrapper">
                                <a class="text-link share-link" href="#" data-copy-clipboard="click" data-copy-clickboard-text="Kopiert!"><span data-copy-clipboard="notice"><?php _e( 'Teilen', 'political-landingpages' ); ?></span><div class="icon-wrapper"><img src="<?php echo get_template_directory_uri() . '/assets/icons/icon_share.svg'; ?>" class="arrow inline-svg" alt="Share Icon"/></div></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

		<div class="container">
			<div class="section-padding-large">
                <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2">

				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', get_post_type() ); 
					
					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Vorheriges Event:', 'political-landingpages' ) . '</span> <span class="nav-title">%title</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Nächstes Event:', 'political-landingpages' ) . '</span> <span class="nav-title">%title</span>',
						)
					);

				endwhile; // End of the loop.
				?>
				</div>
			</div>
		</div><!-- .container -->
	</main><!-- #main -->

	<section class="section_more-posts background-color-secondary">
		<div class="section-padding-large">
			<div class="container">
				<h2 class=""><?php _e( 'Weitere Events', 'political-landingpages' ); ?></h2>
				<div class="spacer-medium"></div>
				<?php echo do_shortcode('[events filter="future" orderby="meta_value" meta_key="event_start_date" order="ASC" posts_per_page="3"]'); ?>
				<div class="spacer-medium"></div>
				<a href="<?php echo $overviewPageUrl; ?>" class="button button-secondary"><?php _e( 'Alle Events', 'political-landingpages' ); ?></a>
			</div>
		</div>
	</section>

<?php

// Load CTA Section
get_template_part('template-parts/section_cta'); 

// Load Contact Form Section
get_template_part('template-parts/section_contact-form'); 

get_footer();

