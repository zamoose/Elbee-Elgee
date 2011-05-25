<?php
/*
* Elbee Elgee Theme Hooks
*/

$lblg_meta_info = get_option('lblg_meta_info');
$lblg_options = get_option($lblg_meta_info['shortname'] . "_lblg_options" );

/*
*  Action hooks
*/
function lblg_set_themename(){
	do_action( 'lblg_set_themename' );
}

function lblg_print_title(){
	do_action( 'lblg_print_title' );
}

function lblg_print_menu(){
	do_action( 'lblg_print_menu' );
}

function lblg_above_content(){
	do_action( 'lblg_above_content' );
}

function lblg_sidebar_header(){
	do_action( 'lblg_sidebar_header' );
}

function lblg_sidebar_footer(){
	do_action( 'lblg_sidebar_footer' );
}

function lblg_meta_info(){
	do_action( 'lblg_meta_info' );
}

function lblg_print_copyright(){
	do_action( 'lblg_print_copyright' );
}

function lblg_print_credits(){
	do_action( 'lblg_print_credits' );
}

function lblg_print_options(){
	do_action( 'lblg_print_options' );
}

function lblg_enqueue_styles(){
	do_action( 'lblg_enqueue_styles' );
}

/**
* Output functions.
*
* These functions do useful things, like print the menu, the blog title, featured images, etc.
*
*/
// Output the blog title. Hook-able via lblg_print_title() action hook.
function lblg_title(){
	if(is_home()) { ?>
	<h1><span id="blogtitle"><a href="<?php echo home_url(); ?>"><?php echo get_bloginfo( 'name' ); ?></a></span></h1>
<?php
	} else { ?>
		<p class="blogtitle"><span id="blogtitle"><a href="<?php echo home_url(); ?>"><?php echo get_bloginfo( 'name' ); ?></a></span></p>
	<?php 
	}
}

// Output the primary menu. Hook-able via lblg_print_menu() action hook.
function lblg_menu(){
	if( function_exists( 'wp_nav_menu' ) ){
		wp_nav_menu( array( 'theme_location'	=> 'primary',  
							'container'			=> 'div',
							'container_id'		=> 'menu',
							'depth'				=> '1'
					) );
	} else {
	?>

	<?php
	}
}

function lblg_styles(){
	global $lblg_shortname, $lblg_options;
	$layout_handle = $lblg_shortname . '_layout_stylesheet';
	$alt_style_handle = $lblg_shortname . '_alt_stylesheet';
	$print_handle = $lblg_shortname . '_print_stylesheet';
	
	$layout_style_option = $lblg_options['layout_stylesheet'];
	$alt_style_option = $lblg_options['alt_stylesheet'];
	
	switch($layout_style_option){
		case '':
		case 'Select a layout:':
			$layout = get_template_directory_uri() . '/layouts/2-columns-fixed-sb-right.css';
		break;
		case '*none*':
			unset($layout);
		break;
		default:
			$layout = get_template_directory_uri() . '/layouts/' . $layout_style_option;
		break;
	}
	
	switch($alt_style_option){
		case '':
		case 'Select a stylesheet:':
			$alt_style = get_template_directory_uri() .'/styles/ng.css';
		break;
		case '*none*':
			unset($alt_style);
		break;
		default:
			$alt_style = get_template_directory_uri() .'/styles/'. $alt_style_option;
		break;
	}
	
	if( isset($layout) ){
		wp_enqueue_style( $layout_handle , $layout, '', '', 'screen' );
	}
	
	if( isset($alt_style) ){
		wp_enqueue_style( $alt_style_handle, $alt_style, '', '', 'screen' );
	}
	
	wp_enqueue_style($print_handle,  get_template_directory_uri() . '/print.css', '', '', 'print' );
}

function lblg_credits(){
	global $lblg_shortname, $lblg_options;
	$tmp_credits = $lblg_options['footer_credit_text'];
	if($tmp_credits != ''){
		$credits_text = $tmp_credits;
	}else{
		$credits_text = '<p>Powered by <a href="http://wordpress.org\">WordPress</a> ' . get_bloginfo('version');
		$credits_text .= ' and <a href="http://literalbarrage.org/blog/code/elbee-elgee">Elbee Elgee</a></p>';
	}
	echo $credits_text;
}

/*
* Copyright code, courtesy of Chip Bennett
* http://wordpress.stackexchange.com/questions/14492/how-do-i-create-a-dynamically-updated-copyright-statement
*/
function lblg_copyright() {
    global $wpdb;
    $copyright_dates = $wpdb->get_results("
        SELECT
            YEAR(min(post_date_gmt)) AS firstdate,
            YEAR(max(post_date_gmt)) AS lastdate
        FROM
            $wpdb->posts
        WHERE
            post_status = 'publish'
    ");
    $output = '';
    if($copyright_dates) {
        $copyright = "&copy; " . $copyright_dates[0]->firstdate;
            if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
                $copyright .= '-' . $copyright_dates[0]->lastdate;
            }
        $output = $copyright;
    }
    return $output;
}

function lblg_echo_copyright() {
	echo lblg_copyright();
}

// Output the Featured Image
function lblg_the_postimage() {
	if( has_post_thumbnail() ) {
		the_post_thumbnail();
	}
}

/*
*  Utility hooks for use inside <head> and admin <head>,
*  via wp_head() and admin_head(). Just in case.
*/
function lblg_wp_head() { 
	global $lblg_themename, $lblg_shortname, $lblg_options;
}

function lblg_admin_head(){ 
	global $lblg_themename, $lblg_shortname, $lblg_options;
}


// Elbee Elgee action hooks
add_action( 'lblg_set_themename', 'lblg_themename' );
add_action( 'lblg_print_title', 'lblg_title' );
add_action( 'lblg_print_menu', 'lblg_menu' );
add_action( 'lblg_print_copyright', 'lblg_echo_copyright' );
add_action( 'lblg_print_credits', 'lblg_credits' );
add_action( 'lblg_enqueue_styles', 'lblg_styles' );
add_action( 'lblg_print_options', 'lblg_options_walker' );

// WordPress core hooks
add_action( 'wp_head', 'lblg_wp_head' );
add_action( 'admin_init', 'lblg_admin_init' );
add_action( 'admin_head','lblg_admin_head' );
add_action( 'admin_menu', 'lblg_add_admin' ); 
add_action( 'wp_print_styles', 'lblg_enqueue_styles', 11 );
add_action( 'widgets_init', 'lblg_register_sidebars' );
add_action( 'widgets_init', 'lblg_widgets_init' );
add_action( 'after_setup_theme','lblg_options_init', 9 );

// Only load the BuddyPress menu code if BP is active
if( function_exists( 'bp_get_loggedin_user_nav' ) ){
	add_action( 'widgets_init', 'lblg_add_default_buddypress_menu' );
}

// Only load custom header code if the option is checked
if( 'true' == $lblg_options['use_custom_header'] ){
	add_action( 'after_setup_theme', 'lblg_register_headers', 11 );
}