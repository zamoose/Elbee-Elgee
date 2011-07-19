<?php
function lblg_register_sidebars() {
	register_sidebar( array( 'name'=>'Primary',
						   'before_widget' => '<li>', 
						   'after_widget' => '</li>', 
						   'before_title' => '<h4>', 
						   'after_title' => '</h4>' ) );
	register_sidebar( array( 'name'=>'Secondary', 
						   'before_widget' => '<li>', 
						   'after_widget' => '</li>', 
						   'before_title' => '<h4>', 
						   'after_title' => '</h4>' ) );
	register_sidebar( array( 'name'=>'Bottom-Left',
						   'before_widget' => '<li>', 
						   'after_widget' => '</li>', 
						   'before_title' => '<h4>', 
						   'after_title' => '</h4>' ) );
	register_sidebar( array( 'name'=>'Bottom-Right',
						   'before_widget' => '<li>', 
						   'after_widget' => '</li>', 
						   'before_title' => '<h4>', 
						   'after_title' => '</h4>' ) );
}
add_action( 'widgets_init', 'lblg_register_sidebars' );

/*
* Support 2.9, 3.0 and 3.1 coolness
*/
if ( ! isset( $content_width ) ) $content_width = '640';
add_theme_support( 'nav-menus' );
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 64, 64, true );
add_image_size( 'lb-content-header', $content_width, 9999 );
add_theme_support( 'automatic-feed-links' );
add_custom_background();

register_nav_menu( 'primary', 'Primary Navigation Menu' );
if( function_exists( 'bp_get_loggedin_user_nav' ) ){
	register_nav_menu( 'lblgbpmenu', 'Default BuddyPress Menu' );
}