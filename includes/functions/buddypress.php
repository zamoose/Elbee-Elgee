<?php
function lblg_add_default_buddypress_menu(){
	global $lblg_themename;
	$menuname = $lblg_themename . ' BuddyPress Menu';
	$bpmenulocation = 'lblgbpmenu';
	// Does the menu exist already?
	$menu_exists = wp_get_nav_menu_object( $menuname );
	
	// If it doesn't exist, let's create it.
	if( !$menu_exists){
		$menu_id = wp_create_nav_menu($menuname);
		
		// Set up default BuddyPress links and add them to the menu.
		wp_update_nav_menu_item($menu_id, 0, array(
		    'menu-item-title' =>  __('Home'),
		    'menu-item-classes' => 'home',
		    'menu-item-url' => home_url( '/' ), 
		    'menu-item-status' => 'publish'));

		wp_update_nav_menu_item($menu_id, 0, array(
		    'menu-item-title' =>  __('Activity'),
		    'menu-item-classes' => 'activity',
		    'menu-item-url' => home_url( '/activity/' ), 
		    'menu-item-status' => 'publish'));

		wp_update_nav_menu_item($menu_id, 0, array(
		    'menu-item-title' =>  __('Members'),
		    'menu-item-classes' => 'members',
		    'menu-item-url' => home_url( '/members/' ), 
		    'menu-item-status' => 'publish'));

		wp_update_nav_menu_item($menu_id, 0, array(
		    'menu-item-title' =>  __('Groups'),
		    'menu-item-classes' => 'groups',
		    'menu-item-url' => home_url( '/groups/' ), 
		    'menu-item-status' => 'publish'));

		wp_update_nav_menu_item($menu_id, 0, array(
		    'menu-item-title' =>  __('Forums'),
		    'menu-item-classes' => 'forums',
		    'menu-item-url' => home_url( '/forums/' ), 
		    'menu-item-status' => 'publish'));
		
		// Grab the theme locations and assign our newly-created menu
		// to the BuddyPress menu location.
		if( !has_nav_menu( $bpmenulocation ) ){
			$locations = get_theme_mod('nav_menu_locations');
			$locations[$bpmenulocation] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
		
	} 
}
add_action( 'widgets_init', 'lblg_add_default_buddypress_menu' );

function lblg_bp_menu() {
		get_template_part( 'bp-navigation' );
}
add_action( 'lblg_print_bp_menu', 'lblg_bp_menu' );

/*
*  BuddyPress support code, adapted from the BuddyPress Template Pack
*  http://wordpress.org/extend/plugins/bp-template-pack/
*  By apeatling & boonebgorges
*/
function lblg_bp_init(){
	global $lblg_shortname, $lblg_options;
	
	echo "Oooooh rah!";
	/* Load the default BuddyPress AJAX functions */
	if ( 'true' != $lblg_options['disable_bp_js'] ) {
		require_once( BP_PLUGIN_DIR . '/bp-themes/bp-default/_inc/ajax.php' );

		/* Load the default BuddyPress javascript */
		wp_enqueue_script( 'lblg-bp-js', BP_PLUGIN_URL . '/bp-themes/bp-default/_inc/global.js', array( 'jquery' ) );
	}
	
	/* Add the wireframe BP page styles */
	if ( 'true' != $lblg_options['disable_bp_css'] )
		wp_enqueue_style( 'lblg-bp-css', get_template_directory_uri() . '/includes/css/bp.css' );
		
	// Add words that we need to use in JS to the end of the page so they can be 
	// translated and still used.
	$params = array(
		'my_favs'           => __( 'My Favorites', 'buddypress' ),
		'accepted'          => __( 'Accepted', 'buddypress' ),
		'rejected'          => __( 'Rejected', 'buddypress' ),
		'show_all_comments' => __( 'Show all comments for this thread', 'buddypress' ),
		'show_all'          => __( 'Show all', 'buddypress' ),
		'comments'          => __( 'comments', 'buddypress' ),
		'close'             => __( 'Close', 'buddypress' ),
		'mention_explain'   => sprintf( __( "%s is a unique identifier for %s that you can type into any message on this site. %s will be sent a notification and a link to your message any time you use it.", 'buddypress' ), '@' . bp_get_displayed_user_username(), bp_get_user_firstname( bp_get_displayed_user_fullname() ), bp_get_user_firstname( bp_get_displayed_user_fullname() ) )
	);

	wp_localize_script( 'bp-js', 'BP_DTheme', $params );
}
add_action( 'bp_init', 'lblg_bp_init' );
