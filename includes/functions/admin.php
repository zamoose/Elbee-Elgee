<?php
/**
* This file is responsible for setting up and displaying the admin page
* and register settings
*
* @package 		Elbee-Elgee
* @copyright	Copyright (c) 2011, Doug Stewart
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
*
* @since 		Elbee-Elgee 1.0
*/

/**
 * Add theme options page to WordPress admin menu.
 *
 * @global string $lblg_themename 
 */
function lblg_add_admin() {
	global $lblg_themename;
    add_theme_page( "$lblg_themename Settings", "$lblg_themename Settings", 'edit_theme_options', 'lblg_options_page' , 'lblg_admin' );
}
add_action( 'admin_menu', 'lblg_add_admin' );

/**
 * Initialize/register the theme option that will be saved to the DB
 * in order to use the Settings API properly
 * 
 * @global string $lblg_shortname 
 */
function lblg_admin_init(){
	global $lblg_shortname;
	register_setting( $lblg_shortname . '_theme_options', $lblg_shortname . '_theme_options', 'lblg_sanitize_options' );
}
add_action( 'admin_init', 'lblg_admin_init' );

/**
 * Display tabbed options page if theme options request such.
 *
 * @global array $lblg_output_admin_tabs
 */
function lblg_output_admin_tabs(){
	global $lblg_default_options;
	
	$page = 'lblg_options_page';
	
	if( empty( $lblg_default_options['tabs']) && empty($lblg_default_options['child_tabs']) ){
		// If both sets of tab options are empty, don't output anything.
	} else {
		if( isset($_GET['tab'] )) {
			$current_tab = $_GET['tab'];
		} else {
			$current_tab = 'general';
		}
	
		$tabs = $lblg_default_options['tabs'];
		$child_tabs = $lblg_default_options['child_tabs'];
	
		echo '<h2 class="nav-tab-wrapper">';
	
		if( !empty($tabs) ){
			foreach( $tabs as $tab ){
				$name = $lblg_default_options[$tab]['name'];
				if( $current_tab == $tab ){
					$activeclass = ' nav-tab-active';
				} else {
					$activeclass = '';
				}
				echo "<a href=\"?page=$page&tab=$tab\" class=\"nav-tab$activeclass\">$name</a>";
			}
		}
	
		if( !empty($child_tabs) ){
			foreach( $child_tabs as $tab ){
				$name = $lblg_default_options[$tab]['name'];
				if( $current_tab == $tab ){
					$activeclass = ' nav-tab-active';
				} else {
					$activeclass = '';
				}
				echo "<a href=\"?page=$page&tab=$tab\" class=\"nav-tab$activeclass\">$name</a>";			
			}
		}
	
		echo "</h2>";
	}
}
add_action( 'lblg_after_admin_header', 'lblg_output_admin_tabs' );

/**
 * Display the theme options page
 *
 * @global string $lblg_shortname
 * @global string $lblg_themename
 * @global string $lblg_version
 * @global array $lblg_options
 * @global array $lblg_default_options 
 * 
 */
function lblg_admin() {
	global $lblg_shortname, $lblg_themename, $lblg_version, $lblg_options, $lblg_default_options;

	$options = $lblg_default_options;
?>
<div class="wrap">
<form method="post" action="options.php">
<?php screen_icon( 'themes' ); ?>
<h2 class="updatehook"><?php echo $lblg_themename; ?> settings 
<?php lblg_print_option_buttons(); ?>
</h2>
<?php
	lblg_after_admin_header();

	if ( isset( $_REQUEST['settings-updated'] ) ) echo '<div id="message" class="updated under-h2"><p><strong>'.$lblg_themename.' settings updated.</strong></p></div>';

	settings_fields( $lblg_shortname . '_theme_options' ); 
?>
<table class="form-table">
<tbody>

<?php lblg_print_options(); ?>

</tbody>
</table>

<p class="submit">
<?php lblg_print_option_buttons(); ?>
</p>
</form>

<?php
}

/**
 * Output Submit/Reset buttons
 *
 * @global string $lblg_shortname
 */
function lblg_print_option_buttons() {
	global $lblg_shortname;
	
	$save_name = $lblg_shortname . "_theme_options[save]";
	$reset_name = $lblg_shortname . "_theme_options[reset]";
	
	submit_button( "Save changes", "primary", $save_name, false );
 	submit_button( "Reset to defaults", "secondary", $reset_name, false );
}

/**
 * Output the per-option table row header markup
 *
 * @param array $values
 */
function lblg_option_wrapper_header( $values ){
	?>
	<tr valign="top"> 
	    <th scope="row"><?php echo $values['name']; ?>:</th>
	    <td>
	<?php
}

/**
 * Output the per-option table row footer markup
 *
 * @param array $values
 */
function lblg_option_wrapper_footer( $values ){
	?>
		<br /><br />
		<span class="description"><?php echo $values['desc']; ?></span>
	    </td>
	</tr>
	<?php 
}

/**
 * lblg_options_walker() is responsible for printing all the 
 * theme options in the theme's options screen.
 *
 * @param array $options
 * @param array $default_options
 * @param string $shortname 
 */
function lblg_options_walker( $options, $default_options, $shortname ){

	$section = '';
	$lblg_options_group = $shortname . '_theme_options';

	add_settings_section( 'lblg_options', 'lblg', 'lblg_options', 'lblg' );

	foreach ( $default_options as $key => $value ) { 	
		switch ( $value['type'] ) {
			// Prints a subheader (useful for dividing options up into similar sections)
			case 'subhead':
			$section = 'lblg';
			//add_settings_section( $key, $section, '', 'lblg_options' );
			?>
				</tbody>
				</table>
			
				<h3><?php echo $value['name']; ?></h3>
			
				<table class="form-table">
				<tbody>
			<?php
			break;
		
			// Prints a simple text <input> element
			case 'text':
			add_settings_field( $key, $value['name'], '', $lblg_options_group, $section );
			lblg_option_wrapper_header( $value );
			?>
			        <input name="<?php echo $lblg_options_group . '[' . $key . ']'; ?>" id="<?php echo $key; ?>" type="<?php echo $value['type']; ?>" value="<?php if( "" != $options[$key] ) { echo esc_html( $options[$key] ); } else { echo $value['std']; } ?>" />
			<?php
			lblg_option_wrapper_footer( $value );
			break;
		
			// Prints a drop-down <select> element
			case 'select':
			add_settings_field( $key, $value['name'], '', $lblg_options_group, $section );
			lblg_option_wrapper_header( $value );
			?>
		            <select name="<?php echo $lblg_options_group . '[' . $key . ']'; ?>" id="<?php echo $key; ?>">
						<?php 
							if( $value['options'] === array_values($value['options'])){
								foreach ( $value['options'] as $option) { 
									echo "<option" . selected( $option, $options[$key], false ) . ">$option</option>\n";
								}
							} else {
								foreach ( $value['options'] as $key => $value ) { 
									echo "<option value=\"$key\"" . selected( $option, $lblg_options[$key], false ) .">$option</option>\n";
								}							
							}
						?>
		            </select>
			<?php
			lblg_option_wrapper_footer( $value );
			break;
		
			// Prints a <textarea> element
			case 'textarea':
			add_settings_field( $key, $value['name'], '', $lblg_options_group, $section );
			$ta_options = $value['options'];
			lblg_option_wrapper_header( $value );
			?>
					<textarea name="<?php echo $lblg_options_group . '[' . $key . ']'; ?>" id="<?php echo $key; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php echo esc_html( $options[$key] ); ?></textarea>
			<?php
			lblg_option_wrapper_footer( $value );
			break;

			// Prints a series of radio <input> elements
			case "radio":
			add_settings_field( $key, $value['name'], '', $lblg_options_group, $section );			
			lblg_option_wrapper_header( $value );
			if( $value['options'] === array_values($value['options'])){
		 		foreach ( $value['options'] as $option ) {
						$radio_setting = $lblg_options[$key];
						$tmp_name = $lblg_options_group . '['. $key . ']';
			    		echo "<input type=\"radio\" name=\"$tmp_name\" value=\"$option\"" . checked( $option, $options[$key], false ) . " />$option<br />\n";
				}
			} else {
		 		foreach ( $value['options'] as $opt_key => $opt_value ) {
						$radio_setting = $lblg_options[$key];
						$tmp_name = $lblg_options_group . '['. $key . ']';
			    		echo "<input type=\"radio\" name=\"$tmp_name\" value=\"$opt_key\"" . checked( $opt_key, $options[$key], false ) . " />$opt_value<br />\n";
				}
			}
		 
			lblg_option_wrapper_footer( $value );
			break;
		
			// Prints a checbox <input> element
			case "checkbox":
			add_settings_field( $key, $value['name'], '', $lblg_options_group, $section );
			lblg_option_wrapper_header( $value );

			$tmp_name = $lblg_options_group . '['. $key . ']';
			echo "<input type=\"checkbox\" name=\"$tmp_name\" id=\"$key\" value=\"1\"" . checked( $options[$key], 1, false ) . " />\n";

			lblg_option_wrapper_footer( $value );
			break;

			default:

			break;
		}
	}
}

/**
 * Wrapper function to intercept the current tab (if any)
 * and spawn the display of the current screen's options
 *
 * @global array $lblg_default_options
 * @global array $lblg_options
 * @global string $lblg_shortname
 */
function lblg_display_options(){
	global $lblg_default_options, $lblg_options, $lblg_shortname;
	
	if( empty($lblg_default_options['tabs']) && empty($lblg_default_options['child_tabs']) ){
		lblg_options_walker( $lblg_options, $lblg_default_options, $lblg_shortname );
	} else {
		if( isset($_GET['tab'] )) {
			$current_tab = esc_html( $_GET['tab'] );
		} else {
			$current_tab = 'general';
		}
		
		echo '<input type="hidden" name="' . $lblg_shortname . '_theme_options[tab]" value="' . $current_tab . '" />';

		lblg_options_walker( $lblg_options, $lblg_default_options[$current_tab]['contents'], $lblg_shortname );
	}
}
add_action( 'lblg_print_options', 'lblg_display_options' );