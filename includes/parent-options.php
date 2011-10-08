<?php
/**
 * parent-options.php handles the back-end options for Elbee Elgee
 *
 * @package		Elbee-Elgee
 * @copyright	Copyright (c) 2011, Doug Stewart
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since		Elbee-Elgee 1.0
 */

// Look for layout CSS files to auto-load
$layout_path = TEMPLATEPATH . '/layouts/'; 
$layouts = array();

// Look for color/design CSS files to auto-load
$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($layout_path) ) {
	if ($layout_dir = opendir($layout_path) ) { 
		while ( ($layout_file = readdir($layout_dir)) !== false ) {
			if(stristr($layout_file, ".css") !== false) {
				$layouts[] = $layout_file;
			}
		}	
	}
}	

if ( is_dir($alt_stylesheet_path) ) {
	if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
		while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
			if(stristr($alt_stylesheet_file, ".css") !== false) {
				$alt_stylesheets[] = $alt_stylesheet_file;
			}
		}	
	}
}	

$layouts_tmp = asort($layouts);
$layouts_tmp = array_unshift($layouts, "Select a layout:", "*none*");

$alt_stylesheets_tmp = asort($alt_stylesheets);
$alt_stylesheets_tmp = array_unshift($alt_stylesheets, "Select a stylesheet:", "*none*");

$parent_options_array = array(
	"tabs" => array( 'general' ),
	
	"general" => array(
			"name"		=> "General",
			"type"		=> "tab",
			"contents"	=> array(
				"style_options" => array(	"name" => "Style Options",
						"type" => "subhead"),

				"layout_stylesheet" => array(	"name" => "Layout Stylesheet",
						"desc" => "Place additional layout stylesheets in <code>" . TEMPLATEPATH . "/layouts/</code> to add them as layout options",
			    		"std" => "Select a layout:",
			    		"type" => "select",
			    		"options" => $layouts),

				"alt_stylesheet" => array(	"name" => "Theme Stylesheet",
						"desc" => "Place additional theme stylesheets and assets in <code>" . TEMPLATEPATH . "/styles/</code> to add them as styling options",
					    "std" => "Select a stylesheet:",
					    "type" => "select",
					    "options" => $alt_stylesheets),

				"use_custom_header" => array(	"name" => "Use Custom Headers",
						"desc" => 'Check this box if you wish to use WordPress\'s built-in <a href="http://codex.wordpress.org/Custom_Headers">Custom Header Image API</a> to define a custom image for your theme',
						"std" => "1",
						"type" => "checkbox"),

				"blog_meta_info" => array(	"name" => "Blog Meta Info",
						"type" => "subhead"),

				"display_footer_copyright" => array(	"name" => "Display Copyright",
						"desc" => "Check this box to display your copyright information in the footer.", 
						"std" => "1",
						"type" => "checkbox"),

				"footer_copyright" => array(	"name" => "Copyright Statement",
						"desc" => "The following text will be displayed by default: <b><p>" . get_bloginfo('name') . " " . lblg_copyright() . "</p></b>",
						"std" => "",
						"type" => "textarea",
						"options" => array("rows" => "5",
										   "cols" => "40") ),

				"display_footer_credits" => array(	"name" => "Display Credits",
						"desc" => "Check this box to display your site credits in the footer.", 
						"std" => "1",
						"type" => "checkbox"),

				"footer_credit_text" => array(	"name" => "Footer Credits",
						"desc" => "Footer credit text defaults to: <b><p>Powered by <a href=\"http://wordpress.org\">WordPress</a> " . get_bloginfo('version') . " and <a href=\"http://literalbarrage.org/blog/code/elbee-elgee\">Elbee Elgee</a></p></b> Change it to fit your site. (I'd appreciate the link love, though, if you'd leave it in...)  HTML should work just fine, raw PHP not so much. ",
						"std" => "",
						"type" => "textarea",
						"options" => array("rows" => "5",
										   "cols" => "40") ),
			)
	),


);

if( function_exists('bp_get_loggedin_user_nav') ) {
	$parent_options_array['tabs'][] = 'buddypress';
	$parent_options_array['buddypress'] = array(
		"name"		=> "BuddyPress",
		"type"		=> "tab",
		"contents"	=> array(
			"bp_subhead" => array( "name" => "BuddyPress-specific Options",
								   "type" => "subhead" ),
			
			"disable_bp_js" => array( "name" => "Disable BuddyPress JavaScript/AJAX",
									  "desc" => "Elbee Elgee automatically integrates the BuddyPress default theme javascript and AJAX functionality. You may switch this off, though the experience will degrade somewhat.",
									  "std" => "0",
									  "type" => "checkbox" ),
									
			"disable_bp_css" => array( "name" => "Disable BuddyPress CSS",
									   "desc" => "Elbee Elgee comes with basic CSS styles that give BuddyPress pages a standard look and feel. You can extend upon these styles in your child theme's CSS or simply disable them and construct your own.",
									   "std" => "0",
									   "type" => "checkbox" ),
		),
	);
}

if( function_exists( 'bbp_version' ) ){
	$parent_options_array['tabs'][] = 'bbpress';
	$parent_options_array['bbpress'] = array(
		"name"		=> "bbPress",
		"type"		=> "tab",
		"contents"	=> array(
			"bbp_subhead" => array( "name" => "bbPress-specific Options",
									"type" => "subhead"),
			"bbp_force_1_column" => array( "name" => "Disable Sidebar Widget Areas",
												  "desc" => "Disable the sidebar widget areas, essentially orcing all bbPress forum/topic screens to use 1 column layouts. <br /> (Can increase readability/functionality of bbPress forums, depending upon your chosen layout).",
												  "type" => "checkbox",
												  "std" => "0" ),
			"bbp_disable_footer" => array( "name" => "Disable Footer Widget Areas",
												  "desc" => "Disable the footer widget areas when viewing bbPress forums/topics.",
												  "type" => "checkbox",
												  "std" => "0" ),
		),
	);
}

$parent_theme_array[ 'options' ] = $parent_options_array;

return $parent_theme_array;
?>