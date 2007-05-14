<?php
$themename = "Elbee Elgee";
$shortname = "lblg";

$layout_path = TEMPLATEPATH . '/layouts/'; 
$layouts = array();

$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($layout_path) ) {
	if ($layout_dir = opendir($layout_path) ) { 
		while ( ($file = readdir($layout_dir)) !== false ) {
			if(stristr($file, ".css") !== false) {
				array_push($layouts, $file);
			}
		}	
	}
}	

if ( is_dir($alt_stylesheet_path) ) {
	if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
		while ( ($file = readdir($alt_stylesheet_dir)) !== false ) {
			if(stristr($file, ".css") !== false) {
				array_push($alt_stylesheets, $file);
			}
		}	
	}
}	


$layouts_tmp = asort($layouts);
$layouts_tmp = array_unshift($layouts, "Select a layout:");

$alt_stylesheets_tmp = asort($alt_stylesheets);
$alt_stylesheets_tmp = array_unshift($alt_stylesheets, "Select a stylesheet:");


$options = array (
	
				array(	"name" => "Use Custom Headers",
						"desc" => "Check this box if you wish to use WordPress's <a href=\"http://boren.nu/archives/2007/01/07/custom-image-header-api/\">Custom Header Image API</a> to define a custom image for your theme",
						"id" => $shortname."_use_custom_header",
						"std" => "false",
						"type" => "checkbox"),

				array(	"name" => "Display \"About\" Text",
						"id" => $shortname."_display_about",
						"std" => "false",
						"type" => "checkbox"),
						
				array(	"name" => "\"About\" Text",
						"id" => $shortname."_about_text",
						"std" => "This is a little blurb about your site.",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "40") ),
											
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
					
				array(	"name" => "Number of Previous Posts",
			    		"id" => $shortname."_previous_posts",
			    		"std" => "5",
			    		"type" => "text"),
			
				array(	"name" => "Del.icio.us Username",
					    "id" => $shortname."_delicious_username",
					    "std" => "zamoose",
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

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<div class="wrap">
<h2><?php echo $themename; ?> settings</h2>

<form method="post">

<table class="optiontable">

<?php foreach ($options as $value) { 
	
	switch ( $value['type'] ) {
		case 'text':
		option_wrapper_header($value);
		?>
		        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
		<?php
		option_wrapper_footer($value);
		break;
		
		case 'select':
		option_wrapper_header($value);
		?>
	            <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
	                <?php foreach ($value['options'] as $option) { ?>
	                <option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
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
				if( get_settings($value['id']) != "") {
						echo get_settings($value['id']);
					}else{
						echo $value['std'];
				}?></textarea>
		<?php
		option_wrapper_footer($value);
		break;

		case "radio":
		option_wrapper_header($value);
		
 		foreach ($value['options'] as $key=>$option) { 
				$radio_setting = get_settings($value['id']);
				if($radio_setting != ''){
		    		if ($key == get_settings($value['id']) ) {
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
						if(get_settings($value['id'])){
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
	    </td>
	</tr>
	<tr valign="top">
		<td>&nbsp;</td><td><small><?php echo $values['desc']; ?></small></td>
	</tr>
	<?php 
}

function mytheme_wp_head() { /*?>
<link href="<?php bloginfo('template_directory'); ?>/style.php" rel="stylesheet" type="text/css" />
<?php*/ }

if ( function_exists('register_sidebar') ) {
	register_sidebar(array('name'=>'Navigation'));
	register_sidebar(array('name'=>'Extra'));
	register_sidebar(array('name'=>'Bottom-Left'));
	register_sidebar(array('name'=>'Bottom-Right'));
}


$use_custom_header = $shortname."_use_custom_header";
if(get_settings($use_custom_header) == true){
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

add_action('wp_head', 'mytheme_wp_head');
add_action('admin_menu', 'mytheme_add_admin'); 
?>
