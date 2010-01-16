<?php
/**
* functions.php defines all manner of back-end coolness for
* Elbee Elgee.
*/

$parent_options = TEMPLATEPATH . '/includes/parent-options.php';
$child_options = STYLESHEETPATH . '/includes/child-options.php';

function lblg_themename(){
	global $themename, $shortname;
	
	$themename = "Elbee Elgee";
	$shortname = "lblg";
}

function lblg_autoload_options(){
	global $themename, $shortname, $parent_options, $child_options, $options;
	if(file_exists($child_options)){
		include($child_options);
		switch($parent_options_action) {
			case 'prepend':
				//Prepend child theme options to options array
				include($parent_options);
				$options = array_merge($child_options_array, $parent_options_array);
			break;
			case 'replace':
				// Nuke parent options and replace with child theme's
				$options = $child_options_array;
			break;
			case 'discard':
				//Create an empty array -- no options
				$options = array();
			break;
			case 'no_action':
				include($parent_options);
				$options = $parent_options_array;
			break;
			case 'append':
			default:
				include($parent_options);
				$options = array_merge($parent_options_array, $child_options_array);
			break;
		}
	} else {
		include($parent_options);
		$options = $parent_options_array;
	}
}

function lblg_register_options(){
	global $options, $shortname;
	foreach ( $options as $key => $value ){
		if ( $value['type'] != 'subhead'){
			register_setting($shortname.'_theme_options', $key);
		}
	}
}

function lblg_print_options($options = array()){
	foreach ($options as $key => $value) { 
	
		switch ( $value['type'] ) {
			case 'subhead':
			?>
				</table>
				
				<h3><?php echo $value['name']; ?></h3>
				
				<table class="form-table">
			<?php
			break;
			case 'text':
			option_wrapper_header($value);
			?>
			        <input name="<?php echo $key; ?>" id="<?php echo $key; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $key ) != "") { echo get_option( $key ); } else { echo $value['std']; } ?>" />
			<?php
			option_wrapper_footer($value);
			break;
			
			case 'select':
			option_wrapper_header($value);
			?>
		            <select name="<?php echo $key; ?>" id="<?php echo $key; ?>">
		                <?php foreach ($value['options'] as $option) { ?>
		                <option<?php if ( get_option( $key ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
		                <?php } ?>
		            </select>
			<?php
			option_wrapper_footer($value);
			break;
			
			case 'textarea':
			$ta_options = $value['options'];
			option_wrapper_header($value);
			?>
					<textarea name="<?php echo $key; ?>" id="<?php echo $key; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php 
					if( get_option($key) != "") {
							echo get_option($key);
						}else{
							echo $value['std'];
					}?></textarea>
			<?php
			option_wrapper_footer($value);
			break;
	
			case "radio":
			option_wrapper_header($value);
			
	 		foreach ($value['options'] as $key=>$option) { 
					$radio_setting = get_option($key);
					if($radio_setting != ''){
			    		if ($key == get_option($key) ) {
							$checked = "checked=\"checked\"";
							} else {
								$checked = "";
							}
					}else{
						if($key == $value['std']){
							$checked = "checked=\"checked\"";
						}else{
							$checked = "";
						}
					}?>
		            <input type="radio" name="<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
			<?php 
			}
			 
			option_wrapper_footer($value);
			break;
			
			case "checkbox":
			option_wrapper_header($value);
							if(get_option($key)){
								$checked = "checked=\"checked\"";
							}else{
								$checked = "";
							}
						?>
			            <input type="checkbox" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="true" <?php echo $checked; ?> />
			<?php
			option_wrapper_footer($value);
			break;
	
			default:
	
			break;
		}
	}

}

function lblg_add_admin() {
    global $themename, $shortname, $options;
    lblg_set_themename();
    lblg_autoload_options();
    lblg_register_options();
    add_theme_page($themename." Options", "$themename Options", 'edit_themes', basename(__FILE__), 'lblg_admin');

}

//add_theme_page($themename . 'Header Options', 'Header Options', 'edit_themes', basename(__FILE__), 'headimage_admin');

function lblg_title(){
?>
	<h1><span id="blogtitle"><a href="<?php bloginfo('home'); ?>"><?php echo get_bloginfo('name'); ?></a></span></h1>
<?php
}

function lblg_menu(){
	?>
	<div id="menuwrap">
	        <ul id="menu" class="kwicks">
			<?php if (is_home() || is_single()) : ?>
	                <li class="current_page_item"><a href="<?php bloginfo('url'); ?>">Blog</a></li>
	                <?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
					<?php wp_register('<li class="admintab page_item">','</li>'); ?>
			<?php else : ?>
	                <li class="page_item"><a href="<?php bloginfo('url'); ?>">Blog</a></li>
	                <?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
					<?php wp_register('<li class="admintab page_item">','</li>'); ?>
			<?php endif; ?>
	        </ul>
	</div>
	<?php
}

function headimage_admin(){
	
}

function lblg_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<div class="wrap">
<h2 class="updatehook"><?php echo $themename; ?> settings</h2>

<form method="post" action="options.php">

<table class="form-table">
<tbody>

<?php lblg_print_options($options); ?>

</tbody>
</table>

<?php settings_fields($shortname . '_theme_options'); ?>

<p class="submit">
<input name="save" type="submit" class="button-primary" value="Save changes" />    
</p>
</form>

<?php
}

function option_wrapper_header($values){
	?>
	<tr valign="top"> 
	    <th scope="row"><?php echo $values['name']; ?>:</th>
	    <td>
	<?php
}

function option_wrapper_footer($values){
	?>
		<br /><br />
		<?php echo $values['desc']; ?>
	    </td>
	</tr>
	<?php 
}

function lblg_wp_head() { /*?>
<link href="<?php bloginfo('template_directory'); ?>/style.php" rel="stylesheet" type="text/css" />
<?php*/ }

function lblg_admin_head(){ 
	global $themename;
}

if ( function_exists('register_sidebar') ) {
	//register_sidebar(array('name'=>'BigBar'));
	register_sidebar(array('name'=>'Navigation'));
	register_sidebar(array('name'=>'Extra', 
						   'before_widget' => '<li>', 
						   'after_widget' => '</li>', 
						   'before_title' => '<h2>', 
						   'after_title' => '</h2>'));
	register_sidebar(array('name'=>'Bottom-Left'));
	register_sidebar(array('name'=>'Bottom-Right'));	
}


$use_custom_header = $shortname."_use_custom_header";
if(get_option($use_custom_header) == true){
	// Set up custom header code
	define('HEADER_TEXTCOLOR', 'cfcfd0');
	define('HEADER_IMAGE', '%s/styles/default/newbanner2.png');
	define('HEADER_IMAGE_WIDTH', '1024');
	define('HEADER_IMAGE_HEIGHT', '279');

	add_custom_image_header('header_style', 'lblg_admin_header_style');
}

function lblg_the_postimage() {
	global $wpdb, $post;

	$thumb = $wpdb->get_row('SELECT ID, post_title, guid FROM '.$wpdb->posts.' WHERE post_parent = '.$post->ID.' AND post_mime_type LIKE \'image%\' ORDER BY menu_order');

	if(!empty($thumb)) {
		$image_url = $thumb->guid;
		
		$image = parse_url($image_url, PHP_URL_PATH);
		
		print $image;
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
	do_action('lblg_set_themename');
}

function lblg_print_title(){
	do_action('lblg_print_title');
}

function lblg_print_menu(){
	do_action('lblg_print_menu');
}

function lblg_above_content(){
	do_action('lblg_above_content');
}

function lblg_sidebar_header(){
	do_action('lblg_sidebar_header');
}

function lblg_sidebar_footer(){
	do_action('lblg_sidebar_footer');
}

function lblg_meta_info(){
	do_action('lblg_meta_info');
}

add_action('lblg_set_themename', 'lblg_themename');
add_action('lblg_print_title', 'lblg_title');
add_action('lblg_print_menu', 'lblg_menu');
add_action('wp_head', 'lblg_wp_head');
add_action('admin_head','lblg_admin_head');
add_action('admin_menu', 'lblg_add_admin'); 
?>