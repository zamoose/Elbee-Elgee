<?php
/**
 * Elbee Elgee Theme Hooks
 *
 * @package 		Elbee-Elgee
 * @copyright	Copyright (c) 2011, Doug Stewart
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Elbee-Elgee 1.0
 */

/**
*  Action hooks
*/
function lblg_set_themename(){
	do_action( 'lblg_set_themename' );
}

function lblg_after_admin_header(){
	do_action( 'lblg_after_admin_header' );
}

function lblg_before_loop(){
	do_action( 'lblg_before_loop' );
}

function lblg_after_loop(){
	do_action( 'lblg_after_loop' );
}

function lblg_print_title(){
	do_action( 'lblg_print_title' );
}

function lblg_print_menu(){
	do_action( 'lblg_print_menu' );
}

function lblg_print_bp_menu(){
	do_action( 'lblg_print_bp_menu' );
}

function lblg_above_content(){
	do_action( 'lblg_above_content' );
}

function lblg_before_post_title(){
	do_action( 'lblg_before_post_title' );
}

function lblg_after_post_title(){
	do_action( 'lblg_after_post_title' );
}

function lblg_before_itemtext(){
	do_action( 'lblg_before_itemtext' );
}

function lblg_after_itemtext(){
	do_action( 'lblg_after_itemtext' );
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
add_action( 'wp_enqueue_scripts', 'lblg_enqueue_styles', 11 );

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
	echo '<div id="menu">';
	if( function_exists( 'wp_nav_menu' ) ){
		wp_nav_menu( array( 'theme_location'	=> 'primary' ) );
	} else {
	}
	echo '</div><!-- #menu -->';
}

function lblg_breadcrumbs(){
	if ( function_exists('yoast_breadcrumb') && !is_home() ) {
		yoast_breadcrumb('<p id="breadcrumbs">','</p>');
	}
}
add_action( 'lblg_before_loop', 'lblg_breadcrumbs' );

function lblg_post_info(){
		?>
		<div class="postinfo">
			<span class="postmeta">Posted by <?php the_author(); ?> on <a href="<?php the_permalink(); ?>"><?php the_time('F jS, Y'); ?></a> <?php if (!is_single() && !is_page() ){ ?>| <span class="commentlink"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span><?php } edit_post_link(' Edit this entry.', '', ''); ?></span>
			<?php if( !is_page() ) { ?>
			<span class="postcats">Posted in <?php the_category(', '); ?></span>
			<?php } ?>
			<?php if( is_single() ){?>
			<span class="posttags"><?php the_tags('Tagged as: ',','); ?></span>
		<?php }?>
		</div>	
		<?php
}
add_action( 'lblg_after_itemtext', 'lblg_post_info' );

function lblg_styles(){
	global $lblg_shortname, $lblg_options;
	$layout_handle = $lblg_shortname . '_layout_stylesheet';
	$alt_style_handle = $lblg_shortname . '_alt_stylesheet';
	$print_handle = $lblg_shortname . '_print_stylesheet';
	$normalize_handle = $lblg_shortname . '_normalize_stylesheet';
	
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
	
	//wp_enqueue_style( $normalize_handle, get_template_directory_uri() . '/includes/css/normalize.css/normalize.css', '', '', 'screen' );
	wp_enqueue_style($print_handle,  get_template_directory_uri() . '/print.css', '', '', 'print' );
}
add_action( 'lblg_enqueue_styles', 'lblg_styles' );


function lblg_credits(){
	global $lblg_shortname, $lblg_options;
	$tmp_credits = $lblg_options['footer_credit_text'];
	if($tmp_credits != ''){
		$credits_text = $tmp_credits;
	}else{
		$credits_text = 'Powered by <a href="http://wordpress.org\">WordPress</a> ' . get_bloginfo('version');
		$credits_text .= ' and <a href="http://literalbarrage.org/blog/code/elbee-elgee">Elbee Elgee</a>';
	}
	echo "<div id=\"credits-text\">$credits_text</div>";
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
	global $lblg_shortname, $lblg_options;
	$tmp_copyright = $lblg_options['footer_copyright'];
	if( $tmp_copyright != '' ){
		$copyright_text = $tmp_copyright;
	} else {
		$copyright_text = "<a href=\"" . get_home_url() . "\">" . get_bloginfo('name') . "</a> " . lblg_copyright();
	}
	
	echo "<div id=\"copyright-text\">$copyright_text</div>";
}

// Output the Featured Image
function lblg_the_postimage() {
	if( has_post_thumbnail() ) {
		the_post_thumbnail( 'lb-content-header' );
	}
}
add_action( 'lblg_before_itemtext', 'lblg_the_postimage' );

/*
*  Utility hooks for use inside <head> and admin <head>,
*  via wp_head() and admin_head(). Just in case.
*/
function lblg_wp_head() { 
	global $lblg_themename, $lblg_shortname, $lblg_options;
}
add_action( 'wp_head', 'lblg_wp_head' );

function lblg_admin_head(){ 
	global $lblg_themename, $lblg_shortname, $lblg_options;
}
add_action( 'admin_head','lblg_admin_head' );

// Elbee Elgee action hooks
add_action( 'lblg_set_themename', 'lblg_themename' );
add_action( 'lblg_print_title', 'lblg_title' );
add_action( 'lblg_print_menu', 'lblg_menu' );
add_action( 'lblg_print_copyright', 'lblg_echo_copyright' );
add_action( 'lblg_print_credits', 'lblg_credits' );