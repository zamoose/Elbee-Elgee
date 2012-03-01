<?php
/**
 * This file is responsible for registering all the extra core
 * WordPress functionality the theme supports.
 *
 * @package     Elbee-Elgee
 * @copyright   Copyright (c) 2011, Doug Stewart
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since       Elbee-Elgee 1.0
 *
 */

function lblg_register_sidebars() {
	register_sidebar( array( 'name'=>'Primary',
					       'before_widget' => '<li id="%1$s" class="widget %2$s">',
						   'after_widget' => '</li>', 
						   'before_title' => '<h4>', 
						   'after_title' => '</h4>' ) );
	register_sidebar( array( 'name'=>'Secondary', 
					       'before_widget' => '<li id="%1$s" class="widget %2$s">',
						   'after_widget' => '</li>', 
						   'before_title' => '<h4>', 
						   'after_title' => '</h4>' ) );
	register_sidebar( array( 'name'=>'Bottom-Left',
					       'before_widget' => '<li id="%1$s" class="widget %2$s">', 
						   'after_widget' => '</li>', 
						   'before_title' => '<h4>', 
						   'after_title' => '</h4>' ) );
	register_sidebar( array( 'name'=>'Bottom-Right',
					       'before_widget' => '<li id="%1$s" class="widget %2$s">', 
						   'after_widget' => '</li>', 
						   'before_title' => '<h4>', 
						   'after_title' => '</h4>' ) );
}
add_action( 'widgets_init', 'lblg_register_sidebars' );

/*
* Add support for various WordPress-native functionality
*/
if ( ! isset( $content_width ) ) $content_width = '640';
add_theme_support( 'nav-menus' );
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 64, 64, true );
add_image_size( 'lb-content-header', $content_width, 9999 );
add_theme_support( 'automatic-feed-links' );
add_custom_background();
add_editor_style();

register_nav_menu( 'primary', 'Primary Navigation Menu' );
if( function_exists( 'bp_get_loggedin_user_nav' ) ){
	register_nav_menu( 'lblgbpmenu', 'Default BuddyPress Menu' );
}