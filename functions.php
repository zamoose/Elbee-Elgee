<?php
/**
* functions.php defines all manner of back-end coolness for
* Elbee Elgee.
*/

define( LBLG_FUNCTIONS_DIR,  get_template_directory() . '/includes/functions/' );

require_once( LBLG_FUNCTIONS_DIR . 'options.php' );

function lblg_wp_head() { 
	global $lblg_themename, $lblg_shortname, $lblg_options;
}

function lblg_admin_head(){ 
	global $lblg_themename, $lblg_shortname, $lblg_options;
}

if ( ! isset( $content_width ) ) $content_width = '640';

/*
 * lblg_print_options() is responsible for printing all the theme options in the theme's
 * options screen.
 */
function lblg_print_options( $options = array() ){
	foreach ( $options as $key => $value ) { 	
		switch ( $value['type'] ) {
			
			// Prints a subheader (useful for dividing options up into similar sections)
			case 'subhead':
			?>
				</table>
				
				<h3><?php echo $value['name']; ?></h3>
				
				<table class="form-table">
			<?php
			break;
			
			// Prints a simple text <input> element
			case 'text':
			lblg_option_wrapper_header( $value );
			?>
			        <input name="<?php echo $key; ?>" id="<?php echo $key; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $key ) != "") { echo get_option( $key ); } else { echo $value['std']; } ?>" />
			<?php
			lblg_option_wrapper_footer( $value );
			break;
			
			// Prints a drop-down <select> element
			case 'select':
			lblg_option_wrapper_header( $value );
			?>
		            <select name="<?php echo $key; ?>" id="<?php echo $key; ?>">
		                <?php foreach ( $value['options'] as $option) { ?>
		                <option<?php if ( get_option( $key ) == $option ) { echo ' selected="selected"'; } elseif ( $option == $value['std'] ) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
		                <?php } ?>
		            </select>
			<?php
			lblg_option_wrapper_footer( $value );
			break;
			
			// Prints a <textarea> element
			case 'textarea':
			$ta_options = $value['options'];
			lblg_option_wrapper_header( $value );
			?>
					<textarea name="<?php echo $key; ?>" id="<?php echo $key; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php 
					if( get_option( $key ) != "") {
							echo get_option( $key );
						}else{
							echo $value['std'];
					}?></textarea>
			<?php
			lblg_option_wrapper_footer( $value );
			break;
	
			// Prints a series of radio <input> elements
			case "radio":
			lblg_option_wrapper_header( $value );
			
	 		foreach ( $value['options'] as $key=>$option ) { 
					$radio_setting = get_option( $key );
					if( $radio_setting != '' ){
			    		if ( $key == get_option( $key ) ) {
							$checked = "checked=\"checked\"";
							} else {
								$checked = "";
							}
					}else{
						if( $key == $value['std'] ){
							$checked = "checked=\"checked\"";
						}else{
							$checked = "";
						}
					}?>
		            <input type="radio" name="<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
			<?php 
			}
			 
			lblg_option_wrapper_footer( $value );
			break;
			
			// Prints a checbox <input> element
			case "checkbox":
			lblg_option_wrapper_header( $value );
							if(get_option( $key ) ){
								$checked = "checked=\"checked\"";
							}else{
								$checked = "";
							}
						?>
			            <input type="checkbox" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="true" <?php echo $checked; ?> />
			<?php
			lblg_option_wrapper_footer( $value );
			break;
	
			default:
	
			break;
		}
	}

}

// Set up the admin page &  register settings
function lblg_add_admin() {
    $lblg_opts = get_option('lblg_options');
	$themename = $lblg_opts['themename'];
    add_theme_page( $themename." Settings", "$themename Settings", 'edit_theme_options', basename(__FILE__), 'lblg_admin' );
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

// Output the Featured Image
function lblg_the_postimage() {
	if( has_post_thumbnail() ) {
		the_post_thumbnail();
	}
}

// Display the theme options page
function lblg_admin() {
	global $lblg_shortname, $lblg_themename, $lblg_version, $lblg_options;

	$themename = $lblg_themename;
	$shortname = $lblg_shortname;
	$options = $lblg_options;

	if ( isset( $_GET['settings-updated'] ) ) {
	    echo "<div class='updated'><p>Theme settings updated successfully.</p></div>";
	}
    if ( isset( $_GET['save'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( isset( $_GET['reset'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<div class="wrap">
<h2 class="updatehook"><?php echo $themename; ?> settings</h2>

<form method="post" action="options.php">

<table class="form-table">
<tbody>

<?php lblg_print_options( $options ); ?>

</tbody>
</table>

<?php settings_fields( $shortname . '_theme_options' ); ?>

<p class="submit">
<input name="save" type="submit" class="button-primary" value="Save changes" />    
</p>
</form>

<?php
}

// 
function lblg_option_wrapper_header( $values ){
	?>
	<tr valign="top"> 
	    <th scope="row"><?php echo $values['name']; ?>:</th>
	    <td>
	<?php
}

// 
function lblg_option_wrapper_footer( $values ){
	?>
		<br /><br />
		<?php echo $values['desc']; ?>
	    </td>
	</tr>
	<?php 
}

function lblg_register_sidebars() {
	register_sidebar( array( 'name'=>'Primary',
						   'before_widget' => '<li>', 
						   'after_widget' => '</li>', 
						   'before_title' => '<h4>', 
						   'after_title' => '</h4>' ) );
	register_sidebar( array( 'name'=>'Secondary', 
						   'before_widget' => '<li>', 
						   'after_widget' => '</li>', 
						   'before_title' => '<h4>', 
						   'after_title' => '</h4>' ) );
	register_sidebar( array( 'name'=>'Bottom-Left' ) );
	register_sidebar( array( 'name'=>'Bottom-Right' ) );
}

function lblg_register_headers(){
	$lblg_opts = get_option($shortname. '_lblg_options');
	if( true === get_option( $use_custom_header ) ){
		// Set up custom header code
		if( !defined('HEADER_IMAGE') ){
			define( 'HEADER_IMAGE', '%s/images/headers/snowy_day.jpg' );
		}
		if( !defined('HEADER_TEXTCOLOR') ){	
			define( 'HEADER_TEXTCOLOR', 'ffffff' );
		}
		if( !defined('HEADER_IMAGE_WIDTH') ) {
			define( 'HEADER_IMAGE_WIDTH', '960' );
		}
		if( !defined('HEADER_IMAGE_HEIGHT') ){
			define( 'HEADER_IMAGE_HEIGHT', '200' );
		}

		add_custom_image_header( 'lblg_header_style', 'lblg_admin_header_style' );
	
		register_default_headers( array(
			'fireworks' => array(
				'url' => '%s/images/headers/fireworks.jpg',
				'thumbnail_url' => '%s/images/headers/fireworks-thumbnail.jpg',
				'description' => 'Fireworks'
			),
			'ivy_in_winter' => array(
				'url' => '%s/images/headers/ivy_in_winter.jpg',
				'thumbnail_url' => '%s/images/headers/ivy_in_winter-thumbnail.jpg',
				'description' => 'Ivy in Winter'
			),
			'lakeshore' => array(
				'url' => '%s/images/headers/lakeshore.jpg',
				'thumbnail_url' => '%s/images/headers/lakeshore-thumbnail.jpg',
				'description' => 'Lakeshore'
			),
			'philly_sunset' => array(
				'url' => '%s/images/headers/philly_sunset.jpg',
				'thumbnail_url' => '%s/images/headers/philly_sunset-thumbnail.jpg',
				'description' => 'Philly Sunset'
			),
			'snowy_day' => array(
				'url' => '%s/images/headers/snowy_day.jpg',
				'thumbnail_url' => '%s/images/headers/snowy_day-thumbnail.jpg',
				'description' => 'Snowy Day'
			),
			'summer_dock' => array(
				'url' => '%s/images/headers/summer_dock.jpg',
				'thumbnail_url' => '%s/images/headers/summer_dock-thumbnail.jpg',
				'description' => 'Summer Dock'
			),
			'sunlight_streaming' => array(
				'url' => '%s/images/headers/sunlight_streaming.jpg',
				'thumbnail_url' => '%s/images/headers/sunlight_streaming-thumbnail.jpg',
				'description' => 'Sunlight Streaming'
			),
		) );
	}
}

function lblg_header_style() {
?>
<style type="text/css">
#header{
	background: url(<?php header_image() ?>) bottom left no-repeat;
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header h1, #header #description {
	display: none;
}
<?php } else { ?>
#header h1 a, p.description {
	color:#<?php header_textcolor(); ?>;
}
<?php } ?>
</style>
<?php
}

function lblg_admin_header_style() {
?>
<style type="text/css">
#headimg{
	background: url(<?php header_image(); ?>) bottom left no-repeat;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width:<?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1{
	font-size: 3.5em;
	font-weight: bold;
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	padding-top: 0.5em;
}
#headimg h1 a{
	color:#<?php header_textcolor(); ?>;
	text-decoration: none;
	vertical-align: baseline;
	text-shadow: #000 2px 2px 1px;
}
#headimg #desc{
	color:#<?php header_textcolor(); ?>;
	font-style: italic;
	font-size: 1.2em;
	margin-left: 1.5em;
}

<?php if ( 'blank' == get_header_textcolor() ) { ?>
#headimg h1, #headimg #desc {
	display: none;
}

<?php } ?>

</style>
<?php
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

function lblg_credits(){
	global $shortname, $options;
	$tmp_credits = get_option($shortname . '_footer_credit_text');
	if($tmp_credits != ''){
		$credits_text = $tmp_credits;
	}else{
		$credits_text = '<p>Powered by <a href="http://wordpress.org\">WordPress</a> ' . get_bloginfo('version');
		$credits_text .= ' and <a href="http://literalbarrage.org/blog/code/elbee-elgee">Elbee Elgee</a></p>';
	}
	echo $credits_text;
}

function lblg_styles(){
	global $shortname;
	$layout_handle = $shortname . '_layout_stylesheet';
	$alt_style_handle = $shortname . '_alt_stylesheet';
	$print_handle = $shortname . '_print_stylesheet';
	
	$layout_style_option = get_option($shortname.'_layout_stylesheet');
	$alt_style_option = get_option($shortname.'_alt_stylesheet');
	
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


require_once( LBLG_FUNCTIONS_DIR . 'hooks.php' );

require_once( LBLG_FUNCTIONS_DIR . 'widgets.php' );

function lblg_widgets_init(){
	if( function_exists('bp_get_loggedin_user_nav') ){
		register_widget( 'Lblg_BP_Menu_Widget' );
	}
	register_widget( 'Lblg_Smart_Recent_Posts_Widget' );
}

/*
* Support 2.9, 3.0 and 3.1 coolness
*/
add_theme_support( 'nav-menus' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_custom_background();

register_nav_menus( array( 'primary' => __( 'Primary Menu' ), 'secondary' => __( 'Sub-Menu' ) ) );

// Elbee Elgee action hooks
add_action( 'lblg_set_themename', 'lblg_themename' );
add_action( 'lblg_print_title', 'lblg_title' );
add_action( 'lblg_print_menu', 'lblg_menu' );
add_action( 'lblg_print_copyright', 'lblg_echo_copyright' );
add_action( 'lblg_print_credits', 'lblg_credits' );
add_action( 'lblg_enqueue_styles', 'lblg_styles' );

// WordPress core hooks
add_action( 'wp_head', 'lblg_wp_head' );
add_action( 'admin_head','lblg_admin_head' );
add_action( 'admin_menu', 'lblg_add_admin' ); 
add_action( 'wp_print_styles', 'lblg_enqueue_styles', 11 );
add_action( 'widgets_init', 'lblg_register_sidebars' );
add_action( 'widgets_init', 'lblg_widgets_init' );
add_action( 'after_setup_theme','lblg_options_init', 9 );
?>