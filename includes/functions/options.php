<?php
/*
*  Initialize the theme options, save to the DB if we haven't yet been run
*/
function lblg_options_init(){
	global $lblg_shortname, $lblg_themename, $lblg_version, $lblg_options, $lblg_default_options;
	/* 
	*  If Elbee Elgee (or a child theme) has already been installed,
	*  this should return an array() with keys 'shortname', 'themename',
	*  and 'version'.
	*/
	$bootstrap_tmp = get_option( 'lblg_meta_info' );

	$temp_opts = lblg_get_default_options();
	$lblg_default_options = $temp_opts['options'];

	if( false === $bootstrap_tmp ){
		// We haven't been installed yet.
		//Assign the globals
		$lblg_shortname = $temp_opts['shortname'];
		$lblg_themename = $temp_opts['themename'];
		$lblg_version = $temp_opts['version'];
		$lblg_options = lblg_get_options_from_defaults();
	} else {
		$lblg_shortname = $bootstrap_tmp['shortname'];
		$lblg_themename = $bootstrap_tmp['themename'];
		$lblg_version = $bootstrap_tmp['version'];
		$lblg_options = get_option( $lblg_shortname . '_lblg_options' );
		/*
		*  This shouldn't happen, but it just might, so let's check
		*  and then set up the options correctly.
		*/
		if(false === $lblg_options){
			$lblg_options = lblg_get_options_from_defaults();
		}	
	}
	
	$meta_options = array( 'shortname' => $lblg_shortname,
						   'themename' => $lblg_themename,
						   'version'   => $lblg_version);
					
	update_option( 'lblg_meta_info', $meta_options);
	update_option( $lblg_shortname . '_lblg_options', $lblg_options );
}

function lblg_get_options_from_defaults(){
	$temp_opts = lblg_get_default_options();

	$stripped_opts = array();
	foreach($temp_opts['options'] as $key => $value){
		if('subhead' != $value['type']){
			$stripped_opts[$key] = $value['std'];
		}
	}
	
	return $stripped_opts;
}

function lblg_get_default_options(){
	//Default locations for the parent and child options files
	$parent_options_file = TEMPLATEPATH . '/includes/parent-options.php';
	$child_options_file = STYLESHEETPATH . '/includes/child-options.php';

	// Load parent options
	$parent_theme_array = include( $parent_options_file );
	$parent_options_array = $parent_theme_array[ 'options' ];

	// Conditionally load child options
	if( file_exists( $child_options_file ) ){
		$child_theme_array = include( $child_options_file );
		$child_options_array = $child_theme_array[ 'options' ];

		// Child theme options override the short and long theme names
		if( isset($child_theme_array[ 'child_themename' ]) ){
			$temp_themename = $child_theme_array[ 'child_themename' ];
		}
		if( isset($child_theme_array[ 'child_shortname' ]) ){
			$temp_shortname = $child_theme_array[ 'child_shortname' ];
		}
		if( isset($child_theme_array[ 'child_version' ]) ){
			$temp_version = $child_theme_array[ 'child_version' ];
		}

		// Check the action requested by the child options
		switch( $child_theme_array[ 'parent_options_action' ] ) {
			case 'prepend':
				//Prepend child theme options to options array (add to the top of the options screen)
				$temp_options = array_merge( $child_options_array, $parent_options_array );
			break;
			case 'replace':
				// Nuke parent options and replace with child theme's
				$temp_options = $child_options_array;
			break;
			case 'discard':
				//Create an empty array -- no options
				$temp_options = array();
			break;
			case 'no_action':
				// In case you want to specify that the parent options array are the only game in town
				$temp_options = $parent_options_array;
			break;
			case 'append':
			default:
				// Default case. Append child options to the end of the array (add to the bottom of the options screen)
				$temp_options = array_merge( $parent_options_array, $child_options_array );
			break;
		}
	} else {
		// If there are no child options, default back to the full parent options
		$temp_options = $parent_options_array;
		$temp_themename = $parent_theme_array[ 'parent_themename' ];
		$temp_shortname = $parent_theme_array[ 'parent_shortname' ];
		$temp_version = $parent_theme_array[ 'parent_version' ];
	}
	
	return array( 'shortname' => $temp_shortname, 'themename' => $temp_themename, 'version' => $temp_version, 'options' => $temp_options );
}

function lblg_sanitize_options( $input ){
	global $lblg_shortname, $lblg_default_options;

	print_r($input);
	
	if( isset($lblg_options) && is_array($lblg_options) ){
		$valid_input = $lblg_options;
	} else {
		$valid_input = lblg_get_options_from_defaults();
	}
	
	$submit = ( ! empty( $input['submit']) ? true : false );
	$reset = ( ! empty( $input['reset']) ? true : false );
	
	foreach( $valid_input as $key => $value ){
		//echo $key;
		//echo $value;
	}
	
	return $valid_input;
}