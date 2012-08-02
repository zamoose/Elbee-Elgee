<?php
/**
 * This file contains registration of default header images.
 *
 * @package     Elbee-Elgee
 * @copyright   Copyright (c) 2011, Doug Stewart
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since       Elbee-Elgee 1.0
 *
 */

/**
 * Check to see whether the user has custom header functionality enabled
 */
function lblg_custom_headers_check() {
	global $lblg_options;

	// Only load custom header code if the option is checked
	if( ( 1 == $lblg_options['use_custom_header'] ) && ( 'layoutgala.css' != $lblg_options['alt_stylesheet']) ){
		add_custom_image_header( 'lblg_header_style', 'lblg_admin_header_style' );
		add_action( 'after_setup_theme', 'lblg_register_headers', 11 );
	}	
}
add_action( 'after_setup_theme', 'lblg_custom_headers_check' );

/**
 * Register custom headers
 */
function lblg_register_headers(){
	$h_args = array(
					'height'				=> '200',
					'flex-height'			=> true,
					'width'					=> '960',
					'flex-width'			=> true,
					'default-text-color'	=> 'ffffff',
					'default-image'			=> '%s/images/headers/lakeshore.jpg',
					'wp-head-callback'		=> 'lblg_header_style',
					'admin-head-callback'	=> 'lblg_admin_header_style'	
	);
	if( function_exists( 'get_custom_header' )){		
		add_theme_support( 'custom-header', $h_args );
	} else {
		// Set up custom header code
		if( !defined('HEADER_IMAGE') )
			define( 'HEADER_IMAGE', '%s/images/headers/ivy_in_winter.jpg' );
		if( !defined('HEADER_TEXTCOLOR') )
			define( 'HEADER_TEXTCOLOR', $h_args['default-text-color'] );
		if( !defined('HEADER_IMAGE_WIDTH') )
			define( 'HEADER_IMAGE_WIDTH', $h_args['width'] );
		if( !defined('HEADER_IMAGE_HEIGHT') )
			define( 'HEADER_IMAGE_HEIGHT', $h_args['height'] );
	}
	register_default_headers( array(
		'fireworks' => array(
			'url' => '%s/images/headers/fireworks.jpg',
			'thumbnail_url' => '%s/images/headers/fireworks-thumbnail.jpg',
			'description' => 'Fireworks'
		),
		'ivy_in_winter' => array(
			'url' => '%s/images/headers/ivy_in_winter.jpg',
			'thumbnail_url' => '%s/images/headers/ivy_in_winter-thumbnail.jpg',
			'description' => 'Ivy in Winter'
		),
		'lakeshore' => array(
			'url' => '%s/images/headers/lakeshore.jpg',
			'thumbnail_url' => '%s/images/headers/lakeshore-thumbnail.jpg',
			'description' => 'Lakeshore'
		),
		'philly_sunset' => array(
			'url' => '%s/images/headers/philly_sunset.jpg',
			'thumbnail_url' => '%s/images/headers/philly_sunset-thumbnail.jpg',
			'description' => 'Philly Sunset'
		),
		'snowy_day' => array(
			'url' => '%s/images/headers/snowy_day.jpg',
			'thumbnail_url' => '%s/images/headers/snowy_day-thumbnail.jpg',
			'description' => 'Snowy Day'
		),
		'summer_dock' => array(
			'url' => '%s/images/headers/summer_dock.jpg',
			'thumbnail_url' => '%s/images/headers/summer_dock-thumbnail.jpg',
			'description' => 'Summer Dock'
		),
		'sunlight_streaming' => array(
			'url' => '%s/images/headers/sunlight_streaming.jpg',
			'thumbnail_url' => '%s/images/headers/sunlight_streaming-thumbnail.jpg',
			'description' => 'Sunlight Streaming'
		),
	) );
}

/**
 * Output custom-header-related CSS on the front end
 */
function lblg_header_style() {
?>
<style type="text/css">
#header{
	background: url(<?php header_image() ?>) bottom left no-repeat;
	/*background-size: cover;*/
	background-height: <?php get_custom_header()->height; ?>;
	background-width: <?php get_custom_header()->width; ?>;
	height: <?php get_custom_header()->height; ?>;
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header h1, #header #description {
	display: none;
}

#header div#titledesc {
	display: none;
}
<?php } else { ?>
#header h1 a, p.description {
	color:#<?php header_textcolor(); ?>;
}
<?php } ?>
</style>
<?php
}

/**
 * Output custom-header-related CSS on the back end
 */
function lblg_admin_header_style() {
?>
<style type="text/css">
#headimg{
	background: url(<?php header_image(); ?>) bottom left no-repeat;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width:<?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1{
	font-size: 3.5em;
	font-weight: bold;
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	padding-top: 0.5em;
}
#headimg h1 a{
	color:#<?php header_textcolor(); ?>;
	text-decoration: none;
	vertical-align: baseline;
	text-shadow: #000 2px 2px 1px;
}
#headimg #desc{
	color:#<?php header_textcolor(); ?>;
	font-style: italic;
	font-size: 1.2em;
	margin-left: 1.5em;
}

<?php if ( 'blank' == get_header_textcolor() ) { ?>
#headimg h1, #headimg #desc {
	display: none;
}

<?php } ?>

</style>
<?php
}
