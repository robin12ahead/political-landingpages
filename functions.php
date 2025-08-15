<?php
/**
 * Political Landingpages functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Political_Landingpages
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', get_field('version', 'theme-options') );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function political_landingpages_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Political Landingpages, use a find and replace
		* to change 'political-landingpages' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'political-landingpages', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary-menu' => esc_html__( 'Primary Menu', 'political-landingpages' ),
			'footer-menu' => esc_html__( 'Footer menu', 'political-landingpages' ),
		)
	);

	/*
	* Add custom image sizes
	*
	* @link https://developer.wordpress.org/reference/functions/add_image_size/
	*/
	add_image_size( 'komitee', 300, 300, true );
	add_image_size( 'testimonial', 440, 440, true );

	/*
	* Switch default core markup for search form, comment form, and comments
	* to output valid HTML5.
	*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'political_landingpages_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'political_landingpages_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function political_landingpages_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'political_landingpages_content_width', 1280 );
}
add_action( 'after_setup_theme', 'political_landingpages_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function political_landingpages_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'political-landingpages' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'political-landingpages' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget 1', 'political-landingpages' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'political-landingpages' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'CTA Box 1', 'political-landingpages' ),
			'id'            => 'cta-1',
			'description'   => esc_html__( 'Add widgets here.', 'political-landingpages' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'CTA Box 2', 'political-landingpages' ),
			'id'            => 'cta-2',
			'description'   => esc_html__( 'Add widgets here.', 'political-landingpages' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'CTA Box 3', 'political-landingpages' ),
			'id'            => 'cta-3',
			'description'   => esc_html__( 'Add widgets here.', 'political-landingpages' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'political_landingpages_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function political_landingpages_scripts() {
	wp_enqueue_style( 'political-landingpages-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'political-landingpages-style', 'rtl', 'replace' );

	// load bootstrap
	wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/inc/bootstrap/js/bootstrap.min.js', array(), '5.0.1', false );
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/inc/bootstrap/css/bootstrap.min.css', array(), '5.0.1' );

	// // load jquery
	// wp_enqueue_script( 'jquery-3.7.1', get_template_directory_uri() . '/inc/jquery/jquery-3.7.1.min.js', array(), '3.5.1', false );

	// load slick slider
	wp_enqueue_script('slick', get_template_directory_uri() . '/inc/slick/slick.js', array(), '1.8.1', false );
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/inc/slick/slick.css', array(), '1.8.1');
	wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/inc/slick/slick-theme.css', array(), '1.8.1' );

	// Fonts
	$typographyOptions = get_field('typography', 'option');
	$fontFamilies = $typographyOptions["font_family"]
	if( $fontFamilies ) {
		foreach( $fontFamilies as $font ) {
			$fontLink = $font['font-url'];
			wp_enqueue_style($fontLink["title"], $fontLink["url"], array(), _S_VERSION );
		}
	}

	// Add to calender
	wp_enqueue_script('addtocalendar', get_template_directory_uri() . '/inc/addtocalendar/addtocalendar.min.js', array(), null, true);
	
	// load main compiled css
	wp_enqueue_style('theme', get_template_directory_uri() . '/css/_compiled/theme.css', array('acf-input', 'acf-global'), _S_VERSION );

	// load site.js
	wp_enqueue_script( 'site-js', get_template_directory_uri() . '/js/site.js', array(), _S_VERSION );

	wp_enqueue_script( 'political-landingpages-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'political_landingpages_scripts' );

/**
 * Login Style
 */
function custom_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/css/_compiled/login.css' );
}
add_action( 'login_enqueue_scripts', 'custom_login_stylesheet' );

// disable acf css on front-end acf forms
add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
 
function my_deregister_styles() {
//   wp_deregister_style( 'acf' );
//   wp_deregister_style( 'acf-field-group' );
//   wp_deregister_style( 'acf-global' );
//   wp_deregister_style( 'acf-input' );
//   wp_deregister_style( 'acf-datepicker' );
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// /**
//  * Global Styling Variables
//  */
// require get_template_directory() . '/inc/global-variables-styles.php';

/**
 * Register custom post types
 */

// Argumente
require get_template_directory() . '/post-types/post-type-argument.php';

// Forderungen
require get_template_directory() . '/post-types/post-type-forderung.php';

// Events
require get_template_directory() . '/post-types/post-type-event.php';

// Komitee
require get_template_directory() . '/post-types/post-type-komitee.php';

// Testimonials
require get_template_directory() . '/post-types/post-type-testimonial.php';

// Partner
require get_template_directory() . '/post-types/post-type-partner.php';

// FAQ
require get_template_directory() . '/post-types/post-type-faq.php';

// Downloads
require get_template_directory() . '/post-types/post-type-download.php';


/**
 * Load Shortcodes
 */

// Komitee
require get_template_directory() . '/shortcodes/shortcode-komitee-register.php';
require get_template_directory() . '/shortcodes/shortcode-komitee.php';

// Argumente
require get_template_directory() . '/shortcodes/shortcode-argumente.php'; 

// Forderungen
require get_template_directory() . '/shortcodes/shortcode-forderungen.php';

// News
require get_template_directory() . '/shortcodes/shortcode-news.php';

// Events
require get_template_directory() . '/shortcodes/shortcode-events.php';

// Partner
require get_template_directory() . '/shortcodes/shortcode-partner.php';

// Testimonials
require get_template_directory() . '/shortcodes/shortcode-testimonials.php';
require get_template_directory() . '/shortcodes/shortcode-testimonial-create.php';

// FAQs
require get_template_directory() . '/shortcodes/shortcode-faq.php';

// Downloads
require get_template_directory() . '/shortcodes/shortcode-downloads.php';