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