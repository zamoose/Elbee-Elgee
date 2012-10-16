<?php
/**
 * This file is responsible for options handling.
 * It draws from static theme files and dynamic theme options
 * stored in the database.
 *
 * @package 		Elbee-Elgee
 * @copyright	Copyright (c) 2011, Doug Stewart
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Elbee-Elgee 1.0
 */

/**
 * Initialize the theme options, save to the DB if we haven't yet been run
 * 
 * @global string   $lblg_shortname
 * @global string   $lblg_themename
 * @global string   $lblg_version
 * @global array    $lblg_options
 * @global array    $lblg_default_options
 * @global array    $lblg_defaults
 */
function lblg_options_init(){
	global $lblg_shortname, $lblg_themename, $lblg_version, $lblg_options, $lblg_default_options, $lblg_defaults;
	
	// Grab theme metadata from parent/child style.css files.
	$parent_bootstrap = get_theme_data( trailingslashit( TEMPLATEPATH ) . 'style.css' );
	$child_bootstrap = get_theme_data( trailingslashit( STYLESHEETPATH ) . 'style.css' );
	
	/*
	*  If parent & child are the same theme, these should be equal
	*
 	*  This is mainly future-proofing. At the moment, if only a parent
	*  theme is active, STYLESHEETPATH and TEMPLATE PATH will be equal.
	*  I have no guarantees that this will continue to function, hence the 
	*  below code.
	*/
	if( $parent_bootstrap == $child_bootstrap ){
		$lblg_shortname = $parent_bootstrap['Short Name'];
		$lblg_themename = $parent_bootstrap['Name'];
		$lblg_version = $parent_bootstrap['Version'];
	} else {
		$lblg_shortname = $child_bootstrap['Short Name'];
		$lblg_themename = $child_bootstrap['Name'];
		$lblg_version = $child_bootstrap['Version'];
	}

	// Check to see whether we've been installed previously
	$lblg_stored_options = get_option( $lblg_shortname . '_theme_options' );

	// Pull the default options from the parent-options.php and, optionally, the
	// child-options.php file, if we're running as a child theme.
	$lblg_default_options = lblg_get_default_options();
	$lblg_defaults = lblg_get_options_from_defaults( $lblg_default_options );

	if( ( false === $lblg_stored_options ) || ( '' == $lblg_stored_options ) ){
		// We haven't been installed yet.
		$lblg_options = $lblg_defaults;
	} elseif( (version_compare( $lblg_version, $lblg_stored_options['version'], '!=' )) || (count($lblg_stored_options) != count($lblg_defaults))) {

		// New version of the options have been detected. Let's reload.
		$lblg_options = $lblg_stored_options + $lblg_defaults;
	} else {
		// We've previously been installed and the version number
		// hasn't changed. Assume no change and act accordingly.
		$lblg_options = $lblg_stored_options;
		/*
		*  This shouldn't happen, but it just might, so let's check
		*  and then set up the options correctly.
		*/
		if(false === $lblg_options){
			$lblg_options = lblg_get_options_from_defaults( $lblg_default_options );
		}	
	}

	$lblg_options['version'] = $lblg_version;
	update_option( $lblg_shortname . '_theme_options', $lblg_options );
}
add_action( 'after_setup_theme','lblg_options_init', 9 );

/**
 *
 * @param array $default_options
 * @return array
 */
function lblg_get_options_from_defaults( $default_options ){
	$stripped_opts = array();
	
	foreach( $default_options as $key => $value ){
		if( $key != "tabs" ){
			switch($value['type']){
				case 'tab':
					$stripped_opts = $stripped_opts + lblg_get_options_from_defaults($value['contents']);
				break;
				case 'subhead':
				break;
				default:
				$stripped_opts[$key] = $value['std'];
				break;
			}
		}
	}
	
	return $stripped_opts;
}

/**
 *
 * @return array
 */
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
	}
	
	return $temp_options;
}

/**
 * Sanitizes options before sending them to the databse.
 * 
 * @global  string $lblg_shortname
 * @global  array $lblg_default_options
 * @global  array $lblg_options
 * @param   array $input
 * @return  array
 */
function lblg_sanitize_options( $input ){
	global $lblg_shortname, $lblg_default_options, $lblg_options, $lblg_defaults;
	
	$submit = ( ! empty( $input['save']) ? true : false );
	$reset = ( ! empty( $input['reset']) ? true : false );
	$tabbed = ( !empty( $input['tab']) ? true : false );
		
	if( $reset ){
		$valid_input = $lblg_defaults;
	} elseif ( $submit ){
		// Check to see whether our options have actually been initialized
		// and exist in the database (they should!)
		if( isset($lblg_options) && is_array($lblg_options) ){
			$valid_input = $lblg_options;
		} else {
			// If they don't exist for some reason, we use the defaults
			// as our valid input test
			$valid_input = lblg_get_options_from_defaults( $lblg_default_options );
		}

		if( !isset( $lblg_default_options['tabs'] ) ){
			// Admin is one screen, no tabs, so all the options are displayed at once.
			foreach( $valid_input as $key => $value ){
				$tmp_type = $lblg_default_options[$key]['type'];
			
				switch( $tmp_type ){
					case 'text':
					case 'textarea':
						if( isset($input[$key]) ){
							$valid_input[ $key ] = wp_kses_post( $input[ $key ] );
						}
					break;

					case 'select':
					case 'radio':
						if( isset($input[$key]) ){
							$valid_input[$key] = ( in_array( $input[$key], $lblg_default_options[$key]['options']) ? $input[$key] : $valid_input[$key] );
						}
					break;

					case 'checkbox':
						$valid_input[$key] = (( isset($input[$key]) && ( '1' == $input[$key] ) ) ? '1' : '0' );
					break;
				
					default:
					break;
				}
			}
		} else {
				$tab = $input['tab'];
				foreach( $valid_input as $key => $value ){
					$tmp_type = $lblg_default_options[$tab]['contents'][$key]['type'];

					switch( $tmp_type ){
						case 'text':
						case 'textarea':
							if( isset($input[$key]) ){
								$valid_input[ $key ] = wp_kses_post( $input[ $key ] );
							}
						break;

						case 'select':
						case 'radio':
							if( isset($input[$key]) ){
								$valid_input[$key] = ( in_array( $input[$key], $lblg_default_options[$tab]['contents'][$key]['options']) ? $input[$key] : $valid_input[$key] );
							}
						break;

						case 'checkbox':
							$valid_input[$key] = (( isset($input[$key]) && ( '1' == $input[$key] ) ) ? '1' : '0' );
						break;

						default:
						break;
					}
				}
		}
	}

	return $valid_input;
}