<?php

function lblg_extra_theme_headers( $headers ){
	if( !in_array( 'Short Name', $headers ) )
		$headers[] = 'Short Name';
	
	if( !in_array( 'Support URI', $headers) )
		$headers[] = 'Support URI';
	return $headers;
}

add_filter( 'extra_theme_headers', 'lblg_extra_theme_headers' );