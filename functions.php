<?php
$themename = "Elbee Elgee";
$shortname = "lblg";
$theme_current_version = "0.9";
$theme_url = "http://literalbarrage.org/blog/code/elbee-elgee";

$layout_path = TEMPLATEPATH . '/layouts/'; 
$layouts = array();

$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($layout_path) ) {
	if ($layout_dir = opendir($layout_path) ) { 
		while ( ($layout_file = readdir($layout_dir)) !== false ) {
			if(stristr($layout_file, ".css") !== false) {
				$layouts[] = $layout_file;
			}
		}	
	}
}	

if ( is_dir($alt_stylesheet_path) ) {
	if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
		while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
			if(stristr($alt_stylesheet_file, ".css") !== false) {
				$alt_stylesheets[] = $alt_stylesheet_file;
			}
		}	
	}
}	

$lblg_categories = get_categories();
$lblg_categories_list = array();

foreach($lblg_categories as $lblcat){
	$lblg_categories_list[] = $lblcat->cat_name;
}

$layouts_tmp = asort($layouts);
$layouts_tmp = array_unshift($layouts, "Select a layout:");

$alt_stylesheets_tmp = asort($alt_stylesheets);
$alt_stylesheets_tmp = array_unshift($alt_stylesheets, "Select a stylesheet:");


$options = array (
		
				array(	"name" => "Style Options",
						"type" => "subhead"),

				array(	"name" => "Use Custom Headers",
						"desc" => "Check this box if you wish to use WordPress's <a href=\"http://boren.nu/archives/2007/01/07/custom-image-header-api/\">Custom Header Image API</a> to define a custom image for your theme",
						"id" => $shortname."_use_custom_header",
						"std" => "false",
						"type" => "checkbox"),

				array(	"name" => "Layout Stylesheet",
						"desc" => "Place additional layout stylesheets in the <code>layouts/</code> subdirectory to have them automatically included",
			    		"id" => $shortname."_layout_stylesheet",
			    		"std" => "Select a layout:",
			    		"type" => "select",
			    		"options" => $layouts),

				array(	"name" => "Theme Stylesheet",
						"desc" => "Place additional theme stylesheets and assets in the <code>styles/</code> subdirectory to have them automatically included",
					    "id" => $shortname."_alt_stylesheet",
					    "std" => "Select a stylesheet:",
					    "type" => "select",
					    "options" => $alt_stylesheets),
	
				array(	"name" => "Asides",
						"type" => "subhead"),

				array(	"name" => "Display Asides",
						"desc" => "\"Asides\" are small posts, usually dedicated to a single subject or link that are too lightweight to require a full post on their own.  (See <a href=\"http://codex.wordpress.org/Adding_Asides\">Adding Asides</a> on the WordPress Codex for more information). Posts saved in the category selected here will be displayed in such a way as to draw less attention to them.",
						"id" => $shortname."_display_asides",
						"std" => "false",
						"type" => "checkbox"),

				array(	"name" => "Asides Category",
					    "id" => $shortname."_asides_category",
					    "std" => "Select an Asides category:",
					    "type" => "select",
					    "options" => $lblg_categories_list),
	
				array(	"name" => "Blog Meta Info",
						"type" => "subhead"),

				array(	"name" => "Display \"About\" Text",
						"id" => $shortname."_display_about",
						"std" => "false",
						"type" => "checkbox"),
						
				array(	"name" => "\"About\" Text",
						"id" => $shortname."_about_text",
						"desc" => "This is a little blurb about your site. (Use HTML if you wish.)",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "40") ),

				array(	"name" => "Del.icio.us Username",
					    "id" => $shortname."_delicious_username",
						"desc" => "Enter your <a href='http://del.icio.us'>del.icio.us</a> username here to display your recently-shared links in the footer. Erase 'zamoose' to remove del.icio.us feed entirely.",
					    "std" => "zamoose",
					    "type" => "text"),

				array(	"name" => "Footer Text",
						"id" => $shortname."_footer_text",
						"desc" => "Footer text defaults to: <b><p><a href=".get_bloginfo('url').">".get_bloginfo('name')."</a> is powered by <a href='http://wordpress.org'>WordPress</a> ".get_bloginfo('version')." and <a href='http://literalbarrage.org/blog/code/elbee-elgee'>Elbee Elgee</a></p><p>&copy; 2003-2009 Doug Stewart</p></b> Change it to fit your site. (I'd appreciate the link love, though, if you'd leave it in...)  HTML should work just fine, raw PHP not so much. ",
						"std" => "",
						"type" => "textarea",
						"options" => array("rows" => "5",
										   "cols" => "40") ),
				
				array(	"name" => "Statistics Code",
						"id" => $shortname."_stats_code",
						"desc" => "If you need to enter SiteMeter, Google Analytics, etc. stat-tracking info in your footer, just plunk it here.",
						"std" => "",
						"type" => "textarea",
						"options" => array("rows" => "5",
										   "cols" => "40") ),
					
				array(	"name" => "Number of Previous Posts",
			    		"id" => $shortname."_previous_posts",
			    		"std" => "5",
			    		"type" => "text")
		  );

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
	global $theme_current_version;
	global $theme_url;
	global $themename;
	?>
	<script type="text/javascript">  
	 jQuery(document).ready(function() {  
	     jQuery.get('http://literalbarrage.org/lblgversion.txt', function(newversion){  
			if (<?php echo $theme_current_version; ?> < newversion) {
	         	jQuery('#wpbody > .wrap > h2.updatehook').after('<div id="message" class="updated fade"><p><strong>Theme Update available. Click <a href="<?php echo $theme_url;?>">here</a> for details.</strong></p></div>');
				jQuery('#rightnow .youare').after('<p class="themehas"><?php echo $themename; ?> has an <a href="<?php echo $theme_url; ?>">available update</a>.</p>');
			}  
	     });  
	 });  
	 </script>
<?php }

if ( function_exists('register_sidebar') ) {
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
	extract(args);
	
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

function elbee_meta_widget_init(){
	register_sidebar_widget(__('Elbee Meta'), 'elbee_meta_widget');
}

add_action('wp_head', 'mytheme_wp_head');
add_action('admin_head','mytheme_admin_head');
add_action('admin_menu', 'mytheme_add_admin'); 
add_action('template_redirect', 'elbee_enqueue_jscripts');
add_action('widgets_init', 'elbee_meta_widget_init');
?>
