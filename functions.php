<?php
/**
* functions.php defines all manner of back-end coolness for
* Elbee Elgee.
*/

define( 'LBLG_FUNCTIONS_DIR',  get_template_directory() . '/includes/functions/' );

require_once( LBLG_FUNCTIONS_DIR . 'options.php' );

require_once( LBLG_FUNCTIONS_DIR . 'headers.php' );

require_once( LBLG_FUNCTIONS_DIR . 'admin.php' );

require_once( LBLG_FUNCTIONS_DIR . 'widgets.php' );

require_once( LBLG_FUNCTIONS_DIR . 'hooks.php' );

require_once( LBLG_FUNCTIONS_DIR . 'supports.php' );

// Only load the BuddyPress-related code if BP is active
//function lblg_bp_loader(){	
//	echo "Loader!";
if( function_exists( 'bp_init' ))
	require_once( LBLG_FUNCTIONS_DIR . 'buddypress.php' );
//}
//add_action( 'bp_include', 'lblg_bp_loader' );
?>