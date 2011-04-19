<?php
/**
* functions.php defines all manner of back-end coolness for
* Elbee Elgee.
*/


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

	// Child theme options override the short and long theme names
	$themename = $child_theme_array[ 'child_themename' ];
	$shortname = $child_theme_array[ 'child_shortname' ];
	

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
	$themename = $parent_theme_array[ 'parent_themename' ];
	$shortname = $parent_theme_array[ 'parent_shortname' ];
}

// Tack the theme's shortname onto the options to avoid potential namespacing issues
while( list( $key, $value ) = each( $temp_options) ){
	$options[$shortname . "_" . $key] = $value;
}

if ( ! isset( $content_width ) ) $content_width = '640';

// Register all the options using the Settings API
function lblg_register_options(){
	global $options, $shortname;
	foreach ( $options as $key => $value ){
		if ( $value['type'] != 'subhead' ){
			register_setting( $shortname.'_theme_options', $key );
		}
	}
}

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
			option_wrapper_header( $value );
			?>
			        <input name="<?php echo $key; ?>" id="<?php echo $key; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $key ) != "") { echo get_option( $key ); } else { echo $value['std']; } ?>" />
			<?php
			option_wrapper_footer( $value );
			break;
			
			// Prints a drop-down <select> element
			case 'select':
			option_wrapper_header( $value );
			?>
		            <select name="<?php echo $key; ?>" id="<?php echo $key; ?>">
		                <?php foreach ( $value['options'] as $option) { ?>
		                <option<?php if ( get_option( $key ) == $option ) { echo ' selected="selected"'; } elseif ( $option == $value['std'] ) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
		                <?php } ?>
		            </select>
			<?php
			option_wrapper_footer( $value );
			break;
			
			// Prints a <textarea> element
			case 'textarea':
			$ta_options = $value['options'];
			option_wrapper_header( $value );
			?>
					<textarea name="<?php echo $key; ?>" id="<?php echo $key; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php 
					if( get_option( $key ) != "") {
							echo get_option( $key );
						}else{
							echo $value['std'];
					}?></textarea>
			<?php
			option_wrapper_footer( $value );
			break;
	
			// Prints a series of radio <input> elements
			case "radio":
			option_wrapper_header( $value );
			
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
			 
			option_wrapper_footer( $value );
			break;
			
			// Prints a checbox <input> element
			case "checkbox":
			option_wrapper_header( $value );
							if(get_option( $key ) ){
								$checked = "checked=\"checked\"";
							}else{
								$checked = "";
							}
						?>
			            <input type="checkbox" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="true" <?php echo $checked; ?> />
			<?php
			option_wrapper_footer( $value );
			break;
	
			default:
	
			break;
		}
	}

}

// Set up the admin page &  register settings
function lblg_add_admin() {
    global $themename, $shortname, $options;
    lblg_register_options();
    add_theme_page( $themename." Settings", "$themename Settings", 'edit_themes', basename(__FILE__), 'lblg_admin' );
}

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

    global $themename, $shortname, $options;

    if ( isset( $_POST['save'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( isset( $_REQUEST['reset'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
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
function option_wrapper_header( $values ){
	?>
	<tr valign="top"> 
	    <th scope="row"><?php echo $values['name']; ?>:</th>
	    <td>
	<?php
}

// 
function option_wrapper_footer( $values ){
	?>
		<br /><br />
		<?php echo $values['desc']; ?>
	    </td>
	</tr>
	<?php 
}

function lblg_wp_head() { 
	
}

function lblg_admin_head(){ 

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

$use_custom_header = $shortname."_use_custom_header";
if( get_option( $use_custom_header ) == true ){
	// Set up custom header code
	define( 'HEADER_TEXTCOLOR', 'cfcfd0' );
	define( 'HEADER_IMAGE', '%s/styles/default/newbanner2.png' );
	define( 'HEADER_IMAGE_WIDTH', '1024' );
	define( 'HEADER_IMAGE_HEIGHT', '279' );

	add_custom_image_header( 'lblg_header_style', 'lblg_admin_header_style' );
}

function lblg_header_style() {
?>
<style type="text/css">
#header{
	background: url(<?php header_image() ?>) bottom right no-repeat;
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#header h1, #header #description {
	display: none;
}
<?php } else { ?>
#header h1 a, #description {
	color:#<?php header_textcolor(); ?>;
}
#desc {
	margin-right: 30px;
}
<?php } ?>
</style>
<?php
}

function lblg_admin_header_style() {
?>
<style type="text/css">
#headimg{
	background: url(<?php header_image(); ?>) bottom right no-repeat;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width:<?php echo HEADER_IMAGE_WIDTH; ?>px;
  	padding:0 0 0 18px;
}

#headimg h1{
	padding-top:40px;
	margin: 0;
}
#headimg h1 a{
	color:#<?php header_textcolor(); ?>;
	text-decoration: none;
	border-bottom: none;
}
#headimg #desc{
	color:#<?php header_textcolor(); ?>;
	font-size:1em;
	margin-top:-0.5em;
}

#desc {
	display: none;
}

<?php if ( 'blank' == get_header_textcolor() ) { ?>
#headimg h1, #headimg #desc {
	display: none;
}
#headimg h1 a, #headimg #desc {
	color:#<?php echo HEADER_TEXTCOLOR ?>;
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
	if($options[$shortname.'_footer_credit_text'] != ''){
		$credits_text = $options[$shortname.'_footer_credit_text'];
	}else{
		$credits_text = '<p>Powered by <a href="http://wordpress.org\>WordPress</a> ' . bloginfo('version');
		if($options[$shortname.'_display_footer_credit_text'] == true){
			$credits_text .= 'and <a href="http://literalbarrage.org/blog/code/elbee-elgee">Elbee Elgee</a></p>';
		}else{
			$credits_text .= '</p>';
		}
	}
	echo $credits_text;
}

/*
* Theme Hooks
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

function lblg_bpmenu_widget( $args ){
	extract( $args );
	
	if( $title ){
		echo $before_widget;
		echo $before_title . $title . $after_title;
	}?>
	<ul>
	<?php
	if ( is_user_logged_in() ){
		bp_get_loggedin_user_nav();			
	} else {
		bp_get_displayed_user_nav();
	}
	?>
	</ul>
	<?php
	echo $after_widget;
}

function lblg_widgets_init(){
	if( function_exists('bp_get_loggedin_user_nav') ){
		wp_register_sidebar_widget( 'lblgbpmenu', __( 'Elbee Elgee BuddyPress Menu' ), 'lblg_bpmenu_widget', 
									array(
										'title' 		=> 'BuddyPress Menu',
										'description'	=> 'Outputs the default BuddyPress navigational menu.'
									) );
	}
}

/*
* Support 2.9, 3.0 and 3.1 coolness
*/
add_theme_support( 'nav-menus' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_custom_background();

register_nav_menus( array( 'primary' => __( 'Primary Menu' ), 'secondary' => __( 'Sub-Menu' ) ) );

add_action( 'lblg_set_themename', 'lblg_themename' );
add_action( 'lblg_print_title', 'lblg_title' );
add_action( 'lblg_print_menu', 'lblg_menu' );
add_action( 'lblg_print_copyright', 'lblg_echo_copyright' );
add_action( 'lblg_print_credits', 'lblg_credits' );
add_action( 'wp_head', 'lblg_wp_head' );
add_action( 'admin_head','lblg_admin_head' );
add_action( 'admin_menu', 'lblg_add_admin' ); 
// Register sidebars
add_action( 'widgets_init', 'lblg_register_sidebars' );
// Register BuddyPress menu output
add_action( 'widgets_init', 'lblg_widgets_init' );

?>