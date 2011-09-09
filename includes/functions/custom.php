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