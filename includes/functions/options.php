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
	
	$parent_bootstrap = get_theme_data( trailingslashit( TEMPLATEPATH ) . 'style.css' );
	$child_bootstrap = get_theme_data( trailingslashit( STYLESHEETPATH ) . 'style.css' );
	
	// If parent & child are the same theme, these should be equal
	if( $parent_bootstrap['Short Name'] == $child_bootstrap['Short Name'] ){
		$lblg_shortname = $parent_bootstrap['Short Name'];
		$lblg_themename = $parent_bootstrap['Theme Name'];
		$lblg_version = $parent_bootstrap['Version'];
	} else {
		$lblg_shortname = $child_bootstrap['Short Name'];
		$lblg_themename = $child_bootstrap['Theme Name'];
		$lblg_version = $child_bootstrap['Version'];
	}

	// Check to see whether we've been installed previously
	$lblg_stored_options = get_option( $lblg_shortname . '_theme_options' );
	
	$temp_opts = lblg_get_default_options();
	$lblg_default_options = $temp_opts['options'];

	if( false === $lblg_stored_options ){
		// We haven't been installed yet.
		$lblg_options = lblg_get_options_from_defaults();
	} elseif( version_compare( $lblg_version, $install_check['version'], '>' )) {
		// New version of the options have been detected. Let's reload.
		$lblg_options = $lblg_stored_options + $lblg_default_options;
	} else {
		// Nothing to see here. Move along. Move along.
		$lblg_options = get_option( $lblg_shortname . '_theme_options' );
		/*
		*  This shouldn't happen, but it just might, so let's check
		*  and then set up the options correctly.
		*/
		if(false === $lblg_options){
			$lblg_options = lblg_get_options_from_defaults();
		}	
	}

	update_option( $lblg_shortname . '_theme_options', $lblg_options );
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
	global $lblg_shortname, $lblg_default_options, $lblg_options;

	$submit = ( ! empty( $input['save']) ? true : false );
	$reset = ( ! empty( $input['reset']) ? true : false );
	
	if( $reset ){
		$valid_input = lblg_get_options_from_defaults();
	} elseif ( $submit ){
		// Check to see whether our options have actually been initialized
		// and exist in the database (they should!)
		if( isset($lblg_options) && is_array($lblg_options) ){
			$valid_input = $lblg_options;
		} else {
			// If they don't exist for some reason, we use the defaults
			// as our valid input test
			$valid_input = lblg_get_options_from_defaults();
		}

		foreach( $valid_input as $key => $value ){
			$tmp_type = $lblg_default_options[$key]['type'];
			
			switch( $tmp_type ){
				case 'text':
				case 'textarea':
					if( isset($input[$key]) ){
						$valid_input[ $key ] = esc_attr( $input[$key] );
					}
				break;

				case 'select':
				case 'radio':
					if( isset($input[$key]) ){
						$valid_input[$key] = ( in_array( $input[$key], $lblg_default_options[$key]['options']) ? $input[$key] : $valid_input[$key] );
					}
				break;

				case 'checkbox':
					$valid_input[$key] = (( isset($input[$key]) && ( 'true' == $input[$key] ) ) ? 'true' : 'false' );
				break;
				
				default:
				break;
			}
		}		
	}
		
	return $valid_input;
}