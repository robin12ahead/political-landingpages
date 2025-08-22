<?php
/**
 * Political Landingpages Theme Customizer
 *
 * @package Political_Landingpages
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

/*---------------------------------------------------------------------------
Arrays for Sections and Settings 
---------------------------------------------------------------------------*/
/**
 * (each will create customizer setting)
 */

/*--------------------------------------------
Sections
--------------------------------------------*/

$sections = array(
	'typography' => 'Typography',
	'base-colors' => 'Base Colors',
	'system-colors' => 'System Colors',
	'text-colors' => 'Text Colors',
	'background-colors' => 'Background Colors',
	'borders' => 'Borders',
	'grid' => 'Grid Settings',
	'divider' => 'Divider',
	'links' => 'Links',
	'buttons' => 'Buttons',
	'navigation' => 'Navigation',
	'icons' => 'Icons',
	'boxes' => 'Boxes',
	'fonts' => 'Fonts',
	'font-sizes' => 'Font Sizes',
	'forms' => 'Form Fields',
	'effects' => 'Effects',
);


/*--------------------------------------------
Settings / Controls
--------------------------------------------*/

// Font Sizes
$typography = array (
	'font-family-heading' => array (
		"label" => "Font Family Headings",
		"default" => "Arial",
		"section" => "typography",
	),
	'font-family-body' => array (
		"label" => "Font Family Body",
		"default" => "Arial",
		"section" => "typography",
	),
);

// Colors
$colors = array (
'base-color-black' => array (
		"label" => "Black",
		"default" => "#000000",
		"section" => "base-colors",
	),
'base-color-white' => array (
		"label" => "White",
		"default" => "#ffffff",
		"section" => "base-colors",
	),
'base-color-accent' => array (
		"label" => "Accent Color",
		"default" => "#E8308A",
		"section" => "base-colors",
	),
'base-color-primary' => array (
		"label" => "Primary Color",
		"default" => "#111111",
		"section" => "base-colors",
	),
'base-color-secondary' => array (
		"label" => "Secondary Color",
		"default" => "#074EA1",
		"section" => "base-colors",
	),
'base-color-tertiary' => array (
		"label" => "Tertiary Color",
		"default" => "#00A0E2",
		"section" => "base-colors",
	),
'system-color-error' => array (
		"label" => "Error Color",
		"default" => "#FF3D00",
		"section" => "system-colors",
	),
'system-color-success' => array (
		"label" => "Success Color",
		"default" => "#3ADD00",
		"section" => "system-colors",
	),
'system-color-warning' => array (
		"label" => "Warning Color",
		"default" => "#FFD600",
		"section" => "system-colors",
	),
'text-color-primary' => array (
		"label" => "Primary Text Color",
		"default" => "#111111",
		"section" => "text-colors",
	),
'text-color-secondary' => array (
		"label" => "Secondary Text Color",
		"default" => "#074EA1",
		"section" => "text-colors",
	),
'text-color-tertiary' => array (
		"label" => "Tertiary Text Color",
		"default" => "#00A0E2",
		"section" => "text-colors",
	),
'text-color-alternate' => array (
		"label" => "Alternate Text Color",
		"default" => "#ffffff",
		"section" => "text-colors",
	),
'text-color-white' => array (
		"label" => "Alternate Text Color",
		"default" => "#ffffff",
		"section" => "text-colors",
	),
'text-color-black' => array (
		"label" => "Alternate Text Color",
		"default" => "#000000",
		"section" => "text-colors",
	),
'text-color-accent' => array (
		"label" => "Accent Text Color",
		"default" => "#E8308A",
		"section" => "text-colors",
	),
'background-color-primary' => array (
		"label" => "Primary Background Color",
		"default" => "#074EA1",
		"section" => "background-colors",
	),
'background-color-secondary' => array (
		"label" => "Secondary Background Color",
		"default" => "#00A0E2",
		"section" => "background-colors",
	),
'background-color-tertiary' => array (
		"label" => "Tertiary Background Color",
		"default" => "#f5f5f5",
		"section" => "background-colors",
	),
'background-color-accent' => array (
		"label" => "Accent Background Color",
		"default" => "#E8308A",
		"section" => "background-colors",
	),
'background-color-body' => array (
		"label" => "Body Background Color",
		"default" => "#ffffff",
		"section" => "background-colors",
	),
'border-color-primary' => array (
		"label" => "Primary Border Color",
		"default" => "#000000",
		"section" => "borders",
	),
'border-color-secondary' => array (
		"label" => "Secondary Border Color",
		"default" => "#074EA1",
		"section" => "borders",
	),
'border-color-tertiary' => array (
		"label" => "Tertiary Border Color",
		"default" => "#00A0E2",
		"section" => "borders",
	),
'border-color-accent' => array (
		"label" => "Accent Border Color",
		"default" => "#E8308A",
		"section" => "borders",
	),
'links-color' => array (
		"label" => "Link Color",
		"default" => "#00A0E2",
		"section" => "links",
	),
'links-color-decoration' => array (
		"label" => "Link Decoration Color",
		"default" => "#00A0E2",
		"section" => "links",
	),
'links-color-hover' => array (
		"label" => "Link Hover Color",
		"default" => "#074EA1",
		"section" => "links",
	),
'buttons-color-background' => array (
		"label" => "Button Background Color",
		"default" => "#00A0E2",
		"section" => "buttons",
	),
'buttons-color-background-hover' => array (
		"label" => "Button Background Hover Color",
		"default" => "#074EA1",
		"section" => "buttons",
	),
'buttons-color-text' => array (
		"label" => "Button Text Color",
		"default" => "#ffffff",
		"section" => "buttons",
	),
'buttons-color-text-hover' => array (
		"label" => "Button Text Hover Color",
		"default" => "#ffffff",
		"section" => "buttons",
	),
'icons-color' => array (
		"label" => "Icon Color",
		"default" => "#E8308A",
		"section" => "icons",
	),
'icons-color-hover' => array (
		"label" => "Icon Hover Color",
		"default" => "#074EA1",
		"section" => "icons",
	),
'icons-color-background' => array (
		"label" => "Icon Background Color",
		"default" => "#F5F5F5",
		"section" => "icons",
	),
'forms-color-text' => array (
		"label" => "Form Fields Text Color",
		"default" => "#111111",
		"section" => "forms",
	),
'forms-color-placeholder' => array (
		"label" => "Form Fields Placeholder Color",
		"default" => "#666666",
		"section" => "forms",
	),
'forms-color-border' => array (
		"label" => "Form Fields Border Color",
		"default" => "#333333",
		"section" => "forms",
	),
'forms-color-border-focus' => array (
		"label" => "Form Fields Border Focus Color",
		"default" => "#E8308A",
		"section" => "forms",
	),
'boxes-background-color' => array (
		"label" => "Boxes Background Color",
		"default" => "#ffffff",
		"section" => "boxes",
	),
'effects-shadow-color' => array (
		"label" => "Effects Shadow Color",
		"default" => "#111111",
		"section" => "effects",
	),
);

// Sizes
$sizes = array (
	'border-width-default' => array (
		"label" => "Default Border Width",
		"default" => "1px",
		"section" => "borders",
	),
	'divider-width-default' => array (
		"label" => "Default Divider Width",
		"default" => "1px",
		"section" => "divider",
	),
	'grid-gutter-desk' => array (
		"label" => "Grid Gutter (Column Spacing)",
		"default" => "1.5rem",
		"section" => "grid",
	),
	'grid-gutter-tab' => array (
		"label" => "Grid Gutter on Tablet",
		"default" => "1.5rem",
		"section" => "grid",
	),
	'grid-gutter-mob' => array (
		"label" => "Grid Gutter on Mobile",
		"default" => "1.5rem",
		"section" => "grid",
	),
	'grid-container-width' => array (
		"label" => "Default Container max-width",
		"default" => "1280px",
		"section" => "grid",
	),
	'grid-container-padding' => array (
		"label" => "Default Container Padding (left - right)",
		"default" => "2rem",
		"section" => "grid",
	),
	'grid-breakpoint-tablet' => array (
		"label" => "Tablet Breakpoint",
		"default" => "1024px",
		"section" => "grid",
	),
	'grid-breakpoint-mobile' => array (
		"label" => "Mobile Breakpoint",
		"default" => "768px",
		"section" => "grid",
	),
	'spacer-tiny' => array (
		"label" => "Spacer Tiny",
		"default" => ".5rem",
		"section" => "grid",
	),
	'spacer-xxs' => array (
		"label" => "Spacer XXS",
		"default" => "1rem",
		"section" => "grid",
	),
	'spacer-xs' => array (
		"label" => "Spacer XS",
		"default" => "1.5rem",
		"section" => "grid",
	),
	'spacer-sm' => array (
		"label" => "Spacer Small",
		"default" => "2rem",
		"section" => "grid",
	),
	'spacer-md' => array (
		"label" => "Spacer Medium",
		"default" => "3rem",
		"section" => "grid",
	),
	'spacer-lg' => array (
		"label" => "Spacer Large",
		"default" => "4rem",
		"section" => "grid",
	),
	'spacer-xl' => array (
		"label" => "Spacer XL",
		"default" => "5rem",
		"section" => "grid",
	),
	'spacer-xxl' => array (
		"label" => "Spacer XXL",
		"default" => "6rem",
		"section" => "grid",
	),
	'spacer-huge' => array (
		"label" => "Spacer Huge",
		"default" => "7.5rem",
		"section" => "grid",
	),
	'spacer-xhuge' => array (
		"label" => "Spacer Xhuge",
		"default" => "10rem",
		"section" => "grid",
	),
	'buttons-padding-lr' => array (
		"label" => "Button Padding (left-right)",
		"default" => "2rem",
		"section" => "buttons",
	),
	'buttons-padding-tb' => array (
		"label" => "Button Padding (top-bottom)",
		"default" => "0.5rem",
		"section" => "buttons",
	),
	'buttons-spacing' => array (
		"label" => "Button Spacing (between text and icon)",
		"default" => "0.5rem",
		"section" => "buttons",
	),
	'buttons-border-radius' => array (
		"label" => "Button Border-Radius",
		"default" => "1rem",
		"section" => "buttons",
	),
	'icons-border-radius' => array (
		"label" => "Icons Border-Radius",
		"default" => "0.25rem",
		"section" => "icons",
	),
	'boxes-border-radius' => array (
		"label" => "Boxes Border-Radius",
		"default" => "0px",
		"section" => "boxes",
	),
	'boxes-border-width' => array (
		"label" => "Boxes Border Width",
		"default" => "0px",
		"section" => "boxes",
	),
	'boxes-padding-lr' => array (
		"label" => "Boxes Padding (left-right)",
		"default" => "2rem",
		"section" => "boxes",
	),
	'boxes-padding-tb' => array (
		"label" => "Boxes Padding (top-bottom)",
		"default" => "2rem",
		"section" => "boxes",
	),
	'forms-padding-lr' => array (
		"label" => "Form Field Padding (left-right)",
		"default" => "1.5rem",
		"section" => "forms",
	),
	'forms-padding-tb' => array (
		"label" => "Form Field Padding (top-bottom)",
		"default" => "1rem",
		"section" => "forms",
	),
	'forms-border-radius' => array (
		"label" => "Form Field Border-Radius",
		"default" => "1rem",
		"section" => "forms",
	),
	'forms-border-width' => array (
		"label" => "Form Field Border-Width",
		"default" => "1px",
		"section" => "forms",
	),
	'effects-shadow-size' => array (
		"label" => "Effects Shadow Size",
		"default" => "0px",
		"section" => "effects",
	),
	'effects-shadow-blur' => array (
		"label" => "Effects Shadow Blur",
		"default" => "1rem",
		"section" => "effects",
	),
);

// Font Sizes
$font_sizes = array (
	'font-size-h1' => array (
		"label" => "Heading 1",
		"default" => "5rem",
		"section" => "font-sizes",
	),
	'font-size-h2' => array (
		"label" => "Heading 2",
		"default" => "4rem",
		"section" => "font-sizes",
	),
	'font-size-h3' => array (
		"label" => "Heading 3",
		"default" => "2.5rem",
		"section" => "font-sizes",
	),
	'font-size-h4' => array (
		"label" => "Heading 4",
		"default" => "2rem",
		"section" => "font-sizes",
	),
	'font-size-h5' => array (
		"label" => "Heading 5",
		"default" => "1.5rem",
		"section" => "font-sizes",
	),
	'font-size-h6' => array (
		"label" => "Heading 6",
		"default" => "1.125rem",
		"section" => "font-sizes",
	),
	'buttons-font-size' => array (
		"label" => "Button Font-Size",
		"default" => "1.25rem",
		"section" => "buttons",
	),
	'font-size-large' => array (
		"label" => "text-size-large",
		"default" => "1.5rem",
		"section" => "font-sizes",
	),
	'font-size-medium' => array (
		"label" => "text-size-medium",
		"default" => "1.25rem",
		"section" => "font-sizes",
	),
	'font-size-regular' => array (
		"label" => "text-size-regular",
		"default" => "1rem",
		"section" => "font-sizes",
	),
	'font-size-small' => array (
		"label" => "text-size-small",
		"default" => "0.875rem",
		"section" => "font-sizes",
	),
	'font-size-paragraph' => array (
		"label" => "Paragraph",
		"default" => "1rem",
		"section" => "font-sizes",
	),
	'font-size-body' => array (
		"label" => "Body",
		"default" => "1rem",
		"section" => "font-sizes",
	),
	'font-size-site-title' => array (
		"label" => "Site-Title Font Size",
		"default" => "2rem",
		"section" => "navigation",
	),
	'font-size-nav' => array (
		"label" => "Nav-Items Font Size",
		"default" => "1.25rem",
		"section" => "navigation",
	),
	'font-size-form-fields' => array (
		"label" => "Form Fields Font Size",
		"default" => "1.5rem",
		"section" => "forms",
	),

);

function political_landingpages_customize_register( $wp_customize ) {
/*---------------------------------------------------------------------------
Function Register (Add Functions)
---------------------------------------------------------------------------*/

	/*----------------------------------------------------------------------
    Custom sanitization callbacks
	----------------------------------------------------------------------*/
	
	//file input sanitization callback
	function theme_slug_sanitize_file( $file, $setting ) {
		
		//allowed file types
		$mimes = array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif'          => 'image/gif',
			'png'          => 'image/png',
			'svg'          => 'image/svg'
		);
			
		//check file type from file name
		$file_ext = wp_check_filetype( $file, $mimes );
			
		//if file has a valid mime type return it, otherwise return default
		return ( $file_ext['ext'] ? $file : $setting->default );
	}
	

	/*----------------------------------------------------------------------
    Transport existing Settings
	----------------------------------------------------------------------*/

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/*----------------------------------------------------------------------
	Remove existing Settings
	----------------------------------------------------------------------*/

	$wp_customize->remove_section("colors");
	$wp_customize->remove_section("background_image");
	$wp_customize->remove_control("header_image");

	/*----------------------------------------------------------------------
    Add Panels
	----------------------------------------------------------------------*/	
	
	// Theme Panel
	$panel_theme = 'theme';
	
	$wp_customize->add_panel( 
		$panel_theme, 
		array(
			'title'          => __('Theme Styling', 'political-landingpages'),
			'description'    => __('Theme-Anpassungen', 'political-landingpages'),
			'priority'       => 10,
		) 
	);

	/*----------------------------------------------------------------------
	Register Sections
	----------------------------------------------------------------------*/

	// // Colors Section
	// $section_colors = 'base-colors';

	// $wp_customize->add_section( 
	// 	$section_colors, 
	// 	array(
	// 		'title' => esc_html__( 'Base Colors', 'political-landingpages' ),
	// 		'priority' => 1,
	// 		'panel'  => $panel_theme,
	// 	)
	// );      

	// Loop through all sections from $sections array
	global $sections;
	foreach ($sections as $section_id => $section_label) {

		$wp_customize->add_section( 
			$section_id, 
			array(
				'title' => esc_html__( $section_label, 'political-landingpages' ),
				// 'priority' => 1,
				'panel'  => $panel_theme,
			)
		);     

	}
	   
	/*----------------------------------------------------------------------
	Settings & Controls
	----------------------------------------------------------------------*/

	/* Color Controls */
	global $colors;
	foreach ($colors as $setting_id => $setting_value) {

		$wp_customize->add_setting( 
			$setting_id, 
			array(
				'default' => $setting_value['default'],
				'sanitize_callback' => 'sanitize_hex_color' //validates 3 or 6 digit HTML hex color code
			)
		);
		
		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
			$wp_customize, 
			$setting_id, 
				array(              
					'label'      => __( $setting_value['label'], 'political-landingpages' ),
					'section'    => $setting_value['section'],    
				)
			) 
		); 
	}

	/* Sizes Controls */
	global $sizes;
	foreach ($sizes as $setting_id => $setting_value) {

		$wp_customize->add_setting( 
			$setting_id, 
			array(
				'default' => $setting_value['default'],
			)
		);
		
		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
			$wp_customize, 
			$setting_id, 
				array(              
					'label'      => __( $setting_value['label'], 'political-landingpages' ),
					'section'    => $setting_value['section'],    
					'type' => 'text',
				)
			) 
		); 
	}	

	/* Typography */
	global $typography;
	foreach ($typography as $setting_id => $setting_value) {

		$wp_customize->add_setting( 
			$setting_id, 
			array(
				'default' => $setting_value['default'],
			)
		);
		
		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
			$wp_customize, 
			$setting_id, 
				array(              
					'label'      => __( $setting_value['label'], 'political-landingpages' ),
					'section'    => $setting_value['section'],    
					'type' => 'text',
				)
			) 
		); 
	}
	
	/* Font Sizes Controls */
	global $font_sizes;
	foreach ($font_sizes as $setting_id => $setting_value) {

		$wp_customize->add_setting( 
			$setting_id, 
			array(
				'default' => $setting_value['default'],
			)
		);
		
		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
			$wp_customize, 
			$setting_id, 
				array(              
					'label'      => __( $setting_value['label'], 'political-landingpages' ),
					'section'    => $setting_value['section'],    
					'type' => 'text',
				)
			) 
		); 
	}

	/* Headvisual */
	$wp_customize->add_setting( 
		'headvisual-image', 
		array(
			'sanitize_callback' => 'theme_slug_sanitize_file',
			'transport' => 'refresh',
		)
	);
	
	$wp_customize->add_control( 
		new WP_Customize_Upload_Control( 
			$wp_customize, 
			'headvisual-image', 
			array(
				'label'      => __( 'Headvisual', 'political-landingpages' ),
				'description' => __( 'Bild hochladen oder aus Mediathek auswählen', 'political-landingpages' ),
				'section'    => 'title_tagline',    
				'settings'   => 'headvisual-image'             
			)
		) 
	);  
			
	/*----------------------------------------------------------------------
    Selective Refresh
	----------------------------------------------------------------------*/

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'political_landingpages_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'political_landingpages_customize_partial_blogdescription',
			)
		);
	}

}/*----------------------------------------------------------------------
Function Register END
-----------------------------------------------------------------------*/

add_action( 'customize_register', 'political_landingpages_customize_register' );

/*----------------------------------------------------------------------
Customizer CSS and JS
-----------------------------------------------------------------------*/

// Live CSS
add_action( 'wp_head', 'add_customizer_live_css');
function add_customizer_live_css()
{
    ?>
    <style type="text/css" id="customizer-css">
	:root {

		/* Colors */
		<?php 
		global $colors;
		foreach ($colors as $setting_id => $setting_value) {
			echo '--' . $setting_id . ': ' . get_theme_mod( $setting_id, $setting_value['default'] ) . ';';
		} 
		?>
		
		/* Sizes */
		<?php
		global $sizes;
		foreach ($sizes as $setting_id => $setting_value) {
			echo '--' . $setting_id . ': ' . get_theme_mod( $setting_id, $setting_value['default'] ) . ';';
		} 
		?>

		/* Font-Sizes */
		<?php
		global $font_sizes;
		foreach ($font_sizes as $setting_id => $setting_value) {
			echo '--' . $setting_id . ': ' . get_theme_mod( $setting_id, $setting_value['default'] ) . ';';
		} 
		?>

		/* Typography */
		<?php
		global $typography;
		foreach ($typography as $setting_id => $setting_value) {
			echo '--' . $setting_id . ': ' . get_theme_mod( $setting_id, $setting_value['default'] ) . ';';
		} 
		?>

	}
    </style>
    <?php
}

/*----------------------------------------------------------------------
Other Stuff
-----------------------------------------------------------------------*/

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function political_landingpages_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function political_landingpages_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function political_landingpages_customize_preview_js() {
	wp_enqueue_script( 'political-landingpages-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'political_landingpages_customize_preview_js' );