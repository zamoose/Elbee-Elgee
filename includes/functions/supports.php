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
	register_sidebar( array( 'name'=>'Bottom-Left' ) );
	register_sidebar( array( 'name'=>'Bottom-Right' ) );
}

/*
* Support 2.9, 3.0 and 3.1 coolness
*/
add_theme_support( 'nav-menus' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_custom_background();

register_nav_menus( array( 'primary' => __( 'Primary Menu' ), 'secondary' => __( 'Sub-Menu' ) ) );

if ( ! isset( $content_width ) ) $content_width = '640';