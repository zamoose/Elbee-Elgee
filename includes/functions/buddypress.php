<?php
/**
 * Creates a WordPress custom menu based upon the default BuddyPress
 * activity areas when an active BP install is detected.
 * 
 * @global type $lblg_themename
 */
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
add_action( 'after_setup_theme', 'lblg_add_default_buddypress_menu' );

/**
 * Grabs the template part for the BuddyPress navigation elements.
 */
function lblg_bp_menu() {
		get_template_part( 'bp-navigation' );
}
add_action( 'lblg_print_bp_menu', 'lblg_bp_menu' );

/**
 * BuddyPress support code, adapted from the BuddyPress Template Pack
 * http://wordpress.org/extend/plugins/bp-template-pack/
 * By apeatling & boonebgorges
 * 
 * @global type $lblg_shortname, $lblg_options
 */
function lblg_bp_init(){
	global $lblg_shortname, $lblg_options;
	
	/* Load the default BuddyPress AJAX functions */
	if ( '1' != $lblg_options['disable_bp_js'] ) {
		require_once( BP_PLUGIN_DIR . '/bp-themes/bp-default/_inc/ajax.php' );

		/* Load the default BuddyPress javascript */
		wp_enqueue_script( 'lblg-bp-js', BP_PLUGIN_URL . '/bp-themes/bp-default/_inc/global.js', array( 'jquery' ) );
		//wp_enqueue_script( 'lblg-bp-fix', get_stylesheet_directory_uri() . '/includes/js/lblg-bp.js', array('jquery'), '20120312' );
	}
	
 	if ( ( '1' != $lblg_options['disable_bp_css'] ) && ( !is_admin() ) ){
		// Add the wireframe BP page styles
		wp_enqueue_style( 'lblg-bp-css', get_template_directory_uri() . '/includes/css/bp.css' );
		
		// Enqueue RTL styles for BP 1.5+
		if ( version_compare( BP_VERSION, '1.3', '>' ) && is_rtl() )
			wp_enqueue_style( 'bp-rtl',  plugins_url( '/bp-template-pack/' ) . 'bp-rtl.css', array( 'bp' ), $version );
	}

	if ( !is_admin() ) {
		// Register buttons for the relevant component templates
		// Friends button
		if ( bp_is_active( 'friends' ) )
			add_action( 'bp_member_header_actions',    'bp_add_friend_button' );

		// Activity button
		if ( bp_is_active( 'activity' ) )
			add_action( 'bp_member_header_actions',    'bp_send_public_message_button' );

		// Messages button
		if ( bp_is_active( 'messages' ) )
			add_action( 'bp_member_header_actions',    'bp_send_private_message_button' );

		// Group buttons
		if ( bp_is_active( 'groups' ) ) {
			add_action( 'bp_group_header_actions',     'bp_group_join_button' );
			add_action( 'bp_group_header_actions',     'bp_group_new_topic_button' );
			add_action( 'bp_directory_groups_actions', 'bp_group_join_button' );
		}

		// Blog button
		if ( bp_is_active( 'blogs' ) )
			add_action( 'bp_directory_blogs_actions',  'bp_blogs_visit_blog_button' );
	}
			
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

	wp_localize_script( 'lblg-bp-js', 'BP_DTheme', $params );
}
add_action( 'after_setup_theme', 'lblg_bp_init' );

/*****
 * Add support for showing the activity stream as the front page of the site
 */

/**
 * Filter the dropdown for selecting the page to show on front 
 * to include "Activity Stream"
 * 
 * @param type string $page_html
 */
function lblg_bp_wp_pages_filter( $page_html ) {
	if ( 'page_on_front' != substr( $page_html, 14, 13 ) )
		return $page_html;

	$selected = false;
	$page_html = str_replace( '</select>', '', $page_html );

	if ( lblg_bp_page_on_front() == 'activity' )
		$selected = ' selected="selected"';

	$page_html .= '<option class="level-0" value="activity"' . $selected . '>' . __( 'Activity Stream', 'buddypress' ) . '</option></select>';
	return $page_html;
}
//add_filter( 'wp_dropdown_pages', 'lblg_bp_wp_pages_filter' );

/** 
 * Hijack the saving of page on front setting to save the activity 
 * stream setting 
 * 
 * @param type string $oldvalue
 * @param type string $newvalue
 */
function lblg_bp_page_on_front_update( $oldvalue, $newvalue ) {
	if ( !is_admin() || !is_super_admin() )
		return false;

	if ( 'activity' == $_POST['page_on_front'] )
		return 'activity';
	else
		return $oldvalue;
}
add_action( 'pre_update_option_page_on_front', 'lblg_bp_page_on_front_update', 10, 2 );

/** 
 * Load the activity stream template if settings allow 
 * 
 * @param type string $template
 */
function lblg_bp_page_on_front_template( $template ) {
	global $wp_query;

	if ( empty( $wp_query->post->ID ) ) {
		return locate_template( array( 'activity/index.php' ), false );
	} else{
		return $template;
	}
}
add_filter( 'page_template', 'lblg_bp_page_on_front_template' );

/** 
 * Return the ID of a page set as the home page. 
 */
function lblg_bp_page_on_front() {
	if ( 'page' != get_option( 'show_on_front' ) )
		return false;

	return apply_filters( 'lblg_bp_page_on_front', get_option( 'page_on_front' ) );
}

/**
 *  Force the page ID as a string to stop the get_posts query from 
 * kicking up a fuss. 
 */
function lblg_bp_fix_get_posts_on_activity_front() {
	global $wp_query;

	if ( !empty($wp_query->query_vars['page_id']) && 'activity' == $wp_query->query_vars['page_id'] )
		$wp_query->query_vars['page_id'] = '"activity"';
}
add_action( 'pre_get_posts', 'lblg_bp_fix_get_posts_on_activity_front' );