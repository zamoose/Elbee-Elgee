<?php
/**
* functions.php defines all manner of back-end coolness for
* Elbee Elgee.
*/

$parent_options_file = TEMPLATEPATH . '/includes/parent-options.php';
$child_options_file = STYLESHEETPATH . '/includes/child-options.php';

// Load parent options
$parent_theme_array = include( $parent_options_file );

$parent_options_array = $parent_theme_array[ 'options' ];

// Conditionally load child options
if( file_exists( $child_options_file ) ){
	$child_theme_array = include( $child_options_file );
	$child_options_array = $child_theme_array[ 'options' ];
	
	$themename = $child_theme_array[ 'child_themename' ];
	$shortname = $child_theme_array[ 'child_shortname' ];
	
	switch( $child_theme_array[ 'parent_options_action' ] ) {
		case 'prepend':
			//Prepend child theme options to options array
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
			$temp_options = $parent_options_array;
		break;
		case 'append':
		default:
			$temp_options = array_merge( $parent_options_array, $child_options_array );
		break;
	}
} else {
	$temp_options = $parent_options_array;
	$themename = $parent_theme_array[ 'parent_themename' ];
	$shortname = $parent_theme_array[ 'parent_shortname' ];
}

while(list( $key, $value ) = each( $temp_options)){
	$options[$shortname . "_" . $key] = $value;
}

if ( ! isset( $content_width ) ) $content_width = '640';

function lblg_register_options(){
	global $options, $shortname;
	foreach ( $options as $key => $value ){
		if ( $value['type'] != 'subhead' ){
			register_setting( $shortname.'_theme_options', $key );
		}
	}
}

function lblg_print_options( $options = array()){
	foreach ( $options as $key => $value ) { 
	
		switch ( $value['type'] ) {
			case 'subhead':
			?>
				</table>
				
				<h3><?php echo $value['name']; ?></h3>
				
				<table class="form-table">
			<?php
			break;
			case 'text':
			option_wrapper_header( $value );
			?>
			        <input name="<?php echo $key; ?>" id="<?php echo $key; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $key ) != "") { echo get_option( $key ); } else { echo $value['std']; } ?>" />
			<?php
			option_wrapper_footer( $value );
			break;
			
			case 'select':
			option_wrapper_header( $value );
			?>
		            <select name="<?php echo $key; ?>" id="<?php echo $key; ?>">
		                <?php foreach ( $value['options'] as $option) { ?>
		                <option<?php if ( get_option( $key ) == $option) { echo ' selected="selected"'; } elseif ( $option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
		                <?php } ?>
		            </select>
			<?php
			option_wrapper_footer( $value );
			break;
			
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
	
			case "radio":
			option_wrapper_header( $value );
			
	 		foreach ( $value['options'] as $key=>$option) { 
					$radio_setting = get_option( $key );
					if( $radio_setting != '' ){
			    		if ( $key == get_option( $key ) ) {
							$checked = "checked=\"checked\"";
							} else {
								$checked = "";
							}
					}else{
						if( $key == $value['std']){
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

function lblg_add_admin() {
    global $themename, $shortname, $options;
    lblg_register_options();
    add_theme_page( $themename." Settings", "$themename Settings", 'edit_themes', basename(__FILE__), 'lblg_admin' );
}

function lblg_title(){
	if(is_home()) { ?>
	<h1><span id="blogtitle"><a href="<?php echo home_url(); ?>"><?php echo get_bloginfo( 'name' ); ?></a></span></h1>
<?php
	} else { ?>
		<p class="blogtitle"><span id="blogtitle"><a href="<?php echo home_url(); ?>"><?php echo get_bloginfo( 'name' ); ?></a></span></p>
	<?php 
	}
}

function lblg_menu(){
	if( function_exists( 'wp_nav_menu' ) ){
		wp_nav_menu( array( 'theme_location'	=> 'primary',  
							'container'			=> 'div',
							'container_id'		=> 'menu',
							'depth'				=> '1'
					) );
	} else {
	?>
	<div id="menuwrap">
	        <ul id="menu" class="kwicks">
			<?php if ( is_home() || is_single() ) : ?>
	                <li class="current_page_item"><a href="<?php echo home_url(); ?>">Blog</a></li>
	                <?php wp_list_pages( 'sort_column=menu_order&depth=1&title_li=' ); ?>
					<?php wp_register( '<li class="admintab page_item">','</li>' ); ?>
			<?php else : ?>
	                <li class="page_item"><a href="<?php echo home_url(); ?>">Blog</a></li>
	                <?php wp_list_pages( 'sort_column=menu_order&depth=1&title_li=' ); ?>
					<?php wp_register( '<li class="admintab page_item">','</li>' ); ?>
			<?php endif; ?>
	        </ul>
	</div>
	<?php
	}
}

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

function option_wrapper_header( $values ){
	?>
	<tr valign="top"> 
	    <th scope="row"><?php echo $values['name']; ?>:</th>
	    <td>
	<?php
}

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
	register_sidebar(array( 'name'=>'Primary' ));
	register_sidebar(array( 'name'=>'Secondary', 
						   'before_widget' => '<li>', 
						   'after_widget' => '</li>', 
						   'before_title' => '<h4>', 
						   'after_title' => '</h4>' ));
	register_sidebar(array( 'name'=>'Bottom-Left' ));
	register_sidebar(array( 'name'=>'Bottom-Right' ));	
}

$use_custom_header = $shortname."_use_custom_header";
if(get_option( $use_custom_header) == true ){
	// Set up custom header code
	define( 'HEADER_TEXTCOLOR', 'cfcfd0' );
	define( 'HEADER_IMAGE', '%s/styles/default/newbanner2.png' );
	define( 'HEADER_IMAGE_WIDTH', '1024' );
	define( 'HEADER_IMAGE_HEIGHT', '279' );

	add_custom_image_header( 'lblg_header_style', 'lblg_admin_header_style' );
}

function lblg_the_postimage() {
	if( has_post_thumbnail() ) {
		the_post_thumbnail();
	}
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
	color:#<?php header_textcolor() ?>;
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
	background: url(<?php header_image() ?>) bottom right no-repeat;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width:<?php echo HEADER_IMAGE_WIDTH; ?>px;
  	padding:0 0 0 18px;
}

#headimg h1{
	padding-top:40px;
	margin: 0;
}
#headimg h1 a{
	color:#<?php header_textcolor() ?>;
	text-decoration: none;
	border-bottom: none;
}
#headimg #desc{
	color:#<?php header_textcolor() ?>;
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

function elbee_bpmenu_widget( $args ){
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

function elbee_widgets_init(){
	wp_register_sidebar_widget(__( 'Elbee Elgee BuddyPress Menu' ), 'elbee_bpmenu_widget', '' );
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
add_action( 'wp_head', 'lblg_wp_head' );
add_action( 'admin_head','lblg_admin_head' );
add_action( 'admin_menu', 'lblg_add_admin' ); 
// Register sidebars
add_action( 'widgets_init', 'lblg_register_sidebars' );
// Register LBBPMenuWidget widget
add_action( 'widgets_init', 'elbee_widgets_init' );

?>