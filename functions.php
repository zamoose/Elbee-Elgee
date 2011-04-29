<?php
/**
* functions.php defines all manner of back-end coolness for
* Elbee Elgee.
*/


function lblg_get_default_options(){
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
		if( isset($child_theme_array[ 'child_themename' ]) ){
			$temp_themename = $child_theme_array[ 'child_themename' ];
		}
		if( isset($child_theme_array[ 'child_shortname' ]) ){
			$temp_shortname = $child_theme_array[ 'child_shortname' ];
		}

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
		$temp_themename = $parent_theme_array[ 'parent_themename' ];
		$temp_shortname = $parent_theme_array[ 'parent_shortname' ];
	}
	
	return array( 'shortname' => $temp_shortname, 'themename' => $temp_themename, 'options' => $temp_options );
}

function lblg_options_init(){
	global $lblg_options;
	$lblg_options = get_option('lblg_options');
	
	if(false === $lblg_options){
		$lblg_options = lblg_get_default_options();
	}
	update_option( 'lblg_options', $lblg_options );
}

if ( ! isset( $content_width ) ) $content_width = '640';

// Register all the options using the Settings API
/*function lblg_register_options(){
	global $options, $shortname;
	foreach ( $options as $key => $value ){
		if ( $value['type'] != 'subhead' ){
			register_setting( $shortname.'_theme_options', $key );
		}
	}
}*/

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
    $lblg_opts = get_option('lblg_options');
	$themename = $lblg_opts['themename'];
	$shortname = $lblg_opts['shortname'];
	$options = $lblg_opts['options'];

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

function lblg_wp_head() { 
	global $themename, $shortname, $options;
	
	$lblg_opts = get_option('lblg_options');
	print_r($lblg_opts);
	list($shortname, $themename, $options ) = $lblg_opts;
}

function lblg_admin_head(){ 
	global $themename, $shortname, $options;
	
	$lblg_opts = get_option('lblg_options');
	print_r($lblg_opts);
	list($shortname, $themename, $options ) = $lblg_opts;
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
if( true == get_option( $use_custom_header ) ){
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

function lblg_enqueue_styles(){
	do_action( 'lblg_enqueue_styles' );
}

function lblg_bpmenu_widget( $args ){
	extract( $args );
	
	if( $name ){
		echo $before_widget;
		echo $before_title . $name . $after_title;
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

class Lblg_Smart_Recent_Posts_Widget extends WP_Widget {
	function Lblg_Smart_Recent_Posts_Widget(){
		$widget_ops = array('classname' => 'lblg_smart_recent_posts_widget', 'description' => 'A widget that intelligently displays recent posts.' );
		$this->WP_Widget('Lblg_Smart_Recent_Posts_Widget', 'Elbee Elgee Smart Recent Posts', $widget_ops);		
	}
	
	function form( $instance ){
		$title = esc_attr($instance['title']);
		$lb_num_posts = esc_attr($instance['lb_num_posts'])
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('lb_num_posts'); ?>">Number of posts to display:<input class="widefat" id="<?php echo $this->get_field_id('lb_num_posts'); ?>" name="<?php echo $this->get_field_name('lb_num_posts'); ?>" type="text" value="<?php echo $lb_num_posts; ?>" /></label></p>
        <?php
	}
	
	function update( $new_instance, $old_instance ){
 		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		
		if( is_int($new_instance['lb_num_posts']) ){
			$instance['lb_num_posts'] = strip_tags($new_instance['lb_num_posts']);
		} else {
			$instance['lb_num_posts'] = get_option('posts_per_page');
		}
		
		return $instance;	
	}
	
	function widget( $args, $instance ){
		extract($args);
		
		if(is_home()) { 
			$tmp_query_string = 'paged=2&showposts=';
			$tmp_title = 'Recent Posts';
		} else {
			$tmp_query_string = 'paged=1&showposts=';
			$tmp_title = 'On The Front Page';
		}
		
		$tmp_query_string .= $instance['lb_num_posts'];
		$tmp_query = new WP_Query($tmp_query_string);
		
		echo $before_widget;
		if('' != $instance['title']){
			echo $before_title . $instance['title'] . $after_title;
		} else {
			echo $before_title . $tmp_title . $after_title;
		}
		echo '<ul>';

		while ($tmp_query->have_posts()) : $tmp_query->the_post(); ?>
		<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br /> published on <?php the_date("M jS, Y"); ?> in <?php the_category(', '); ?><?php the_excerpt(); ?></li>
		<?php 
		endwhile;

		echo '</ul>';
		echo $after_widget;
	}
}

class  Lblg_BP_Menu_Widget extends WP_Widget {

    function Lblg_BP_Menu_Widget() {
		$widget_ops = array('classname' => 'lblg_bp_menu_widget', 'description' => 'A basic top-level BuddyPress navigation menu.' );
		$this->WP_Widget('Lblg_BP_Menu_Widget', 'Elbee Elgee BP Menu', $widget_ops);
    }

    function form( $instance ) {                          
        $title = esc_attr($instance['title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <?php 
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function widget( $args, $instance ) {         
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
       
        echo $before_widget;
        if ( $title ) echo $before_title . $title . $after_title;
                echo '<ul id="lb-subnav">';
                
                if ( is_user_logged_in() ){
                        bp_get_loggedin_user_nav();                     
                } else {
                        bp_get_displayed_user_nav();
                }
                echo '</ul>';
                
                echo $after_widget;
    }
} // class LBBPMenuWidget

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
add_action('after_setup_theme','lblg_options_init', 9 );
?>