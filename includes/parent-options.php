<?php

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

$lblg_categories = get_categories('hide_empty=0');
$lblg_categories_list = array();

foreach($lblg_categories as $lblcat){
	$lblg_categories_list[] = $lblcat->cat_name;
}

$layouts_tmp = asort($layouts);
$layouts_tmp = array_unshift($layouts, "Select a layout:");

$alt_stylesheets_tmp = asort($alt_stylesheets);
$alt_stylesheets_tmp = array_unshift($alt_stylesheets, "Select a stylesheet:");

$parent_options_array = array (
		
				$shortname."_style_options" => array(	"name" => "Style Options",
						"type" => "subhead"),

				$shortname."_use_custom_header" => array(	"name" => "Use Custom Headers",
						"desc" => "Check this box if you wish to use WordPress's <a href=\"http://boren.nu/archives/2007/01/07/custom-image-header-api/\">Custom Header Image API</a> to define a custom image for your theme",
						"std" => "false",
						"type" => "checkbox"),

				$shortname."_layout_stylesheet" => array(	"name" => "Layout Stylesheet",
						"desc" => "Place additional layout stylesheets in the <code>layouts/</code> subdirectory to have them automatically included",
			    		"std" => "Select a layout:",
			    		"type" => "select",
			    		"options" => $layouts),

				$shortname."_alt_stylesheet" => array(	"name" => "Theme Stylesheet",
						"desc" => "Place additional theme stylesheets and assets in the <code>styles/</code> subdirectory to have them automatically included",
					    "std" => "Select a stylesheet:",
					    "type" => "select",
					    "options" => $alt_stylesheets),
					
				$shortname."_display_bigbar" => array(	"name" => "Use \"Big Bar\" Side Bar ",
						"desc" => "Check this box to enable the big side bar component.", 
						"std" => "false",
						"type" => "checkbox"),
						
				$shortname."_asides" => array(	"name" => "Asides",
						"type" => "subhead"),

				$shortname."_display_asides" => array(	"name" => "Display Asides",
						"desc" => "\"Asides\" are small posts, usually dedicated to a single subject or link that are too lightweight to require a full post on their own.  (See <a href=\"http://codex.wordpress.org/Adding_Asides\">Adding Asides</a> on the WordPress Codex for more information). Posts saved in the category selected here will be displayed in such a way as to draw less attention to them.",
						"std" => "false",
						"type" => "checkbox"),

				$shortname."_asides_category" => array(	"name" => "Asides Category",
					    "std" => "Select an Asides category:",
					    "type" => "select",
					    "options" => $lblg_categories_list),
	
				$shortname."_blog_meta_info" => array(	"name" => "Blog Meta Info",
						"type" => "subhead"),

				$shortname."_display_about" => array(	"name" => "Display \"About\" Text",
						"std" => "false",
						"type" => "checkbox"),
						
				$shortname."_about_text" => array(	"name" => "\"About\" Text",
						"desc" => "This is a little blurb about your site. (Use HTML if you wish.)",
						"std" => "",
						"type" => "textarea",
						"options" => array(	"rows" => "5",
											"cols" => "40") ),

				$shortname."_delicious_username" => array(	"name" => "Del.icio.us Username",
						"desc" => "Enter your <a href='http://del.icio.us'>del.icio.us</a> username here to display your recently-shared links in the footer. Erase 'zamoose' to remove del.icio.us feed entirely.",
					    "std" => "zamoose",
					    "type" => "text"),

				$shortname."_footer_text" => array(	"name" => "Footer Text",
						"desc" => "Footer text defaults to: <b><p><a href=".get_bloginfo('url').">".get_bloginfo('name')."</a> is powered by <a href='http://wordpress.org'>WordPress</a> ".get_bloginfo('version')." and <a href='http://literalbarrage.org/blog/code/elbee-elgee'>Elbee Elgee</a></p><p>&copy; 2003-2009 Doug Stewart</p></b> Change it to fit your site. (I'd appreciate the link love, though, if you'd leave it in...)  HTML should work just fine, raw PHP not so much. ",
						"std" => "",
						"type" => "textarea",
						"options" => array("rows" => "5",
										   "cols" => "40") ),
				
				$shortname."_stats_code" => array(	"name" => "Statistics Code",
						"desc" => "If you need to enter SiteMeter, Google Analytics, etc. stat-tracking info in your footer, just plunk it here.",
						"std" => "",
						"type" => "textarea",
						"options" => array("rows" => "5",
										   "cols" => "40") ),
					
				$shortname."_previous_posts" => array(	"name" => "Number of Previous Posts",
			    		"std" => "5",
			    		"type" => "text")
		  );

?>