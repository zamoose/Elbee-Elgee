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

require_once( LBLG_FUNCTIONS_DIR . 'buddypress.php' );

?>