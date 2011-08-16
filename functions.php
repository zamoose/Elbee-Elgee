<?php
/**
* functions.php defines all manner of back-end coolness for
* Elbee Elgee.
*/

define( 'LBLG_FUNCTIONS_DIR',  get_template_directory() . '/includes/functions/' );

// Functions and settings related to handling theme options
require_once( LBLG_FUNCTIONS_DIR . 'options.php' );

// Functions and settings related to handling the Custom Header functionality
require_once( LBLG_FUNCTIONS_DIR . 'headers.php' );

// Functions and settings related to the back-end theme admin page[s]
require_once( LBLG_FUNCTIONS_DIR . 'admin.php' );

// Functions and settings handling custom widgets functionality
require_once( LBLG_FUNCTIONS_DIR . 'widgets.php' );

// Registration of custom theme hooks
require_once( LBLG_FUNCTIONS_DIR . 'hooks.php' );

// Register theme support for various core WordPress functionality
require_once( LBLG_FUNCTIONS_DIR . 'supports.php' );

// Custom functionality that doesn't fit in any other area
require_once( LBLG_FUNCTIONS_DIR . 'custom.php' );

// BuddyPress-related code, only loaded if BP is active
if( function_exists( 'bp_init' ) )
	require_once( LBLG_FUNCTIONS_DIR . 'buddypress.php' );

// bbPress-related code, only loaded if bbP is active
if( function_exists( 'bbp_get_current_user_id' ) )
	require_once( LBLG_FUNCTIONS_DIR . 'bbpress.php' );
?>