<?php
/**
 * This file contains custom theme functions that don't readily
 * fit into the other functional areas of the theme.
 *
 * @package     Elbee-Elgee
 * @copyright   Copyright (c) 2011, Doug Stewart
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since       Elbee-Elgee 1.0
 *
 */

/**
 * Custom Theme Header Metadata
 * 
 * This function allows the default WordPress Theme Headers
 * handler (i.e. the code that parses the theme's style.css
 * to look for theme metadata) to look for custom meta values
 * such as the theme's short name, the URI for support forums,
 * etc.
 * 
 * @param array $headers
 * @return array 
 */
function lblg_extra_theme_headers( $headers ){
	if( !in_array( 'Short Name', $headers ) )
		$headers[] = 'Short Name';
	
	if( !in_array( 'Support URI', $headers) )
		$headers[] = 'Support URI';
	return $headers;
}
add_filter( 'extra_theme_headers', 'lblg_extra_theme_headers' );

/**
 * This function prints the post titles and alters display slightly
 * based upon the context it is called in.
 */
function lblg_print_the_title(){
	if( !is_single() && !is_page() ) { ?> 
		<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php echo strip_tags(get_the_title()) ?>"><?php the_title(); ?></a></h2>
	<?php 
	} else { ?>
		<h1><?php the_title(); ?></h1>
	<?php 
	}
}
add_action( 'lblg_the_title', 'lblg_print_the_title' );

function lblg_mobile_nav() {
	
}
add_action( 'lblg_before_container', 'lblg_mobile_nav' );

function lblg_mobile_nav_style() {
	echo "<!-- MOBILE NAV STYLE -->";
}
add_action( 'wp_head', 'lblg_mobile_nav_style' );