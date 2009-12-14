<?php

include(TEMPLATEPATH . '/includes/parent-options.php');

function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=functions.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=functions.php&reset=true");
            die;

        }
    }

    add_theme_page($themename." Options", "$themename Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');

}

//add_theme_page($themename . 'Header Options', 'Header Options', 'edit_themes', basename(__FILE__), 'headimage_admin');

function headimage_admin(){
	
}

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<div class="wrap">
<h2 class="updatehook"><?php echo $themename; ?> settings</h2>

<form method="post">

<table class="form-table">
<tbody>
<?php //option_wrapper_header(array("name"=>"Header Image")); ?>

<?php //option_wrapper_footer(array("desc"=>"If you have GD2 support enabled on your server and the style you've selected supports it, you can generate a header image automatically.")); ?>

<?php foreach ($options as $value) { 
	
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
		        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
		<?php
		option_wrapper_footer($value);
		break;
		
		case 'select':
		option_wrapper_header($value);
		?>
	            <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
	                <?php foreach ($value['options'] as $option) { ?>
	                <option<?php if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
	                <?php } ?>
	            </select>
		<?php
		option_wrapper_footer($value);
		break;
		
		case 'textarea':
		$ta_options = $value['options'];
		option_wrapper_header($value);
		?>
				<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php 
				if( get_option($value['id']) != "") {
						echo get_option($value['id']);
					}else{
						echo $value['std'];
				}?></textarea>
		<?php
		option_wrapper_footer($value);
		break;

		case "radio":
		option_wrapper_header($value);
		
 		foreach ($value['options'] as $key=>$option) { 
				$radio_setting = get_option($value['id']);
				if($radio_setting != ''){
		    		if ($key == get_option($value['id']) ) {
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
	            <input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
		<?php 
		}
		 
		option_wrapper_footer($value);
		break;
		
		case "checkbox":
		option_wrapper_header($value);
						if(get_option($value['id'])){
							$checked = "checked=\"checked\"";
						}else{
							$checked = "";
						}
					?>
		            <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
		<?php
		option_wrapper_footer($value);
		break;

		default:

		break;
	}
}
?>
</tbody>
</table>

<p class="submit">
<input name="save" type="submit" value="Save changes" />    
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
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

function mytheme_wp_head() { /*?>
<link href="<?php bloginfo('template_directory'); ?>/style.php" rel="stylesheet" type="text/css" />
<?php*/ }

function mytheme_admin_head(){ 
	global $themename;
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array('name'=>'BigBar'));
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

	add_custom_image_header('header_style', 'elbee_admin_header_style');
}

function elbee_the_postimage() {
	global $wpdb, $post;

	$thumb = $wpdb->get_row('SELECT ID, post_title, guid FROM '.$wpdb->posts.' WHERE post_parent = '.$post->ID.' AND post_mime_type LIKE \'image%\' ORDER BY menu_order');

	if(!empty($thumb)) {
		$image_url = $thumb->guid;
		
		$image = parse_url($image_url, PHP_URL_PATH);
		
		print $image;
	}
}

function header_style() {
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

function elbee_admin_header_style() {
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

function elbee_enqueue_jscripts() {
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('idTabs', get_bloginfo('template_directory').'/includes/js/jquery.idTabs.min.js');
	wp_enqueue_script('kwicks', get_bloginfo('template_directory').'/includes/js/jquery.kwicks-1.5.1.js');
	wp_enqueue_script('elbeeJS', get_bloginfo('template_directory').'/includes/js/elbeeFunctions.js');
}

function elbbee_tab_widget($args) {
	extract($args);
	
	echo $before_widget;
	echo $after_widget;
}

function elbee_meta_widget($args) {
	extract($args);
	
	echo $before_widget;
	echo $before_title; ?>Meta<?php echo $after_title;?>
		<ul>
			<li><img src="<?php bloginfo('template_directory'); ?>/images/feed.png" /><a href="<?php bloginfo('rss2_url'); ?>">RSS Entries</a></li>
		 	<li><img src="<?php bloginfo('template_directory'); ?>/images/feed.png" /><a href="<?php bloginfo('comments_rss2_url'); ?>">RSS Comments</a></li>
			<?php wp_register(); ?>
	        <li><?php wp_loginout(); ?></li>
			<li><a href="http://www.dreamhost.com/donate.cgi?id=5283"><img border="0" alt="Donate towards my web hosting bill!" src="https://secure.newdream.net/donate1.gif" /></a></li>
			<li><a href="http://feeds.feedburner.com/literalbarrage"><img src="http://feeds.feedburner.com/~fc/literalbarrage?bg=CA1919&amp;fg=FFFFFF&amp;anim=0" height="26" width="88" style="border:0" alt="" /></a></li>
			<li><a href="http://jesse.bur.st/" title="Current server load"><img src="/blog/wp-images/serverload.php" alt="Server Load" border="0"></a></li>
			<li><a href="http://macromates.com" title="Made with TextMate"><img src="<?php bloginfo('template_directory');?>/images/textmate_badge.png" style="border: 0;" /></a></li>
			<li><a href="http://macrabbit.com/cssedit" title="Made with CSSEdit"><img src="<?php bloginfo('template_directory');?>/images/BadgeS.png" style="border: 0;" /></a></li>
			<li><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/us/"><img alt="Creative Commons License" style="border-width:0" src="http://creativecommons.org/images/public/somerights20.png"/></a><!--br/>This <span xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://purl.org/dc/dcmitype/Text" rel="dc:type">work</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://literalbarrage.org/blog/" property="cc:attributionName" rel="cc:attributionURL">http://literalbarrage.org/blog/</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/us/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License</a>.--></li>
		</ul>
	
	<?php
	echo $after_widget;
}

function elbee_polaroid_widget($args){
?>
	<!--div id="imgmapdiv">  
	    <map name="imgmap">  
	        <area shape="poly" coords="88,227,195,229,196,101,90,100" href="#" alt="1">  
	        <area shape="poly" coords="88,214,54,226,19,122,89,102" href="#" alt="2">  
	        <area shape="poly" coords="198,224,213,229,247,127,199,109,200,111" href="#" alt="3">  
	        <area shape="poly" coords="45,112,37,59,127,47,133,86,132,95,93,100,47,110" href="#" alt="4">  
	        <area shape="poly" coords="134,80,137,41,226,51,221,116,200,109,198,100,137,98,135,82" href="#" alt="5">  
	        <area shape="poly" coords="230,190,263,199,293,92,229,73,226,117,251,127,231,191" href="#" alt="6">  
	    </map>  
	</div>  

	<p>  
	    <img src="<?php bloginfo('template_directory'); ?>/styles/ojg/polaroids.png" width="345" height="312" alt="Move mouse over image" usemap="#imgmap">  
	</p-->
	<img src="<?php bloginfo('template_directory'); ?>/styles/ojg/polaroids.png" alt="Do not taunt the Angry Bunny Man." title="Do not taunt the Angry Bunny Man."/>
<?php
}

function elbee_meta_widget_init(){
	register_sidebar_widget(__('Elbee Meta'), 'elbee_meta_widget');
	register_sidebar_widget(__('Elbee Polaroids'), 'elbee_polaroid_widget');
}

function elbee_sidebar_header(){
	do_action('elbee_sidebar_header');
}

function elbee_sidebar_footer(){
	do_action('elbee_sidebar_footer');
}

function elbee_meta_info(){
	do_action('elbee_meta_info');
}

function elbee_theme_name(){
	global $themename;
	do_action('elbee_theme_name', $themename);
}

function elbee_short_name(){
	global $shortname;
	do_action('elbee_short_name', $shortname);
}

function set_elbee_theme_name($themename){
	$themename = "Elbee Elgee";
	return $themename;
}

function set_elbee_short_name($shortname){
	$shortname = "lblg";
	return $shortname;
}

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
add_action('elbee_theme_name', 'set_elbee_theme_name');
add_action('elbee_short_name', 'set_elbee_short_name');
add_action('wp_head', 'mytheme_wp_head');
add_action('admin_head','mytheme_admin_head');
add_action('admin_menu', 'mytheme_add_admin'); 
add_action('template_redirect', 'elbee_enqueue_jscripts');
add_action('widgets_init', 'elbee_meta_widget_init');
?>
