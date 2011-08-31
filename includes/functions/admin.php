<?php
// Set up the admin page &  register settings
function lblg_add_admin() {
	global $lblg_themename;
    add_theme_page( "$lblg_themename Settings", "$lblg_themename Settings", 'edit_theme_options', 'lblg_options_page' , 'lblg_admin' );
}
add_action( 'admin_menu', 'lblg_add_admin' );

function lblg_admin_init(){
	global $lblg_shortname;
	register_setting( $lblg_shortname . '_theme_options', $lblg_shortname . '_theme_options', 'lblg_sanitize_options' );
}
add_action( 'admin_init', 'lblg_admin_init' );

function lblg_output_admin_tabs(){
	if( isset($_GET['tab'] )) {
		$current_tab = $_GET['tab'];
	} else {
		$current_tab = 'general';
	}
	
	$tabs = lblg_get_admin_tabs();
	echo '<h2 class="nav-tab-wrapper">';
	echo '<a href="http://localhost" class="nav-tab">Localhost</a><a href="http://localhost" class="nav-tab nav-tab-active">Localhost Active</a></h2>';
}
//add_action( 'lblg_after_admin_header', 'lblg_output_admin_tabs' );

function lblg_get_admin_tabs(){
	global $lblg_default_options;
	
	print_r($lblg_default_options);
}

// Display the theme options page
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

// Output Submit/Reset buttons
function lblg_print_option_buttons() {
	global $lblg_shortname;
	
	$save_name = $lblg_shortname . "_theme_options[save]";
	$reset_name = $lblg_shortname . "_theme_options[reset]";
	
	submit_button( "Save changes", "primary", $save_name, false );
 	submit_button( "Reset to defaults", "secondary", $reset_name, false );
}

// Output the per-option table row header markup
function lblg_option_wrapper_header( $values ){
	?>
	<tr valign="top"> 
	    <th scope="row"><?php echo $values['name']; ?>:</th>
	    <td>
	<?php
}

// Output the per-option table row footer markup 
function lblg_option_wrapper_footer( $values ){
	?>
		<br /><br />
		<span class="description"><?php echo $values['desc']; ?></span>
	    </td>
	</tr>
	<?php 
}

/*
 * lblg_options_walker() is responsible for printing all the theme options in the theme's
 * options screen.
 */
function lblg_options_walker(){
	global $lblg_options, $lblg_default_options, $lblg_shortname;
		
	$section = '';
	$lblg_options_group = $lblg_shortname . '_theme_options';
	$options = $lblg_options;
	$default_options = $lblg_default_options;

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
									echo "<option" . selected( $option, $lblg_options[$key], false ) . ">$option</option>\n";
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
					<textarea name="<?php echo $lblg_options_group . '[' . $key . ']'; ?>" id="<?php echo $key; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php echo esc_html( $lblg_options[$key] ); ?></textarea>
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
			    		echo "<input type=\"radio\" name=\"$tmp_name\" value=\"$option\"" . checked( $option, $lblg_options[$key], false ) . " />$option<br />\n";
				}
			} else {
		 		foreach ( $value['options'] as $opt_key => $opt_value ) {
						$radio_setting = $lblg_options[$key];
						$tmp_name = $lblg_options_group . '['. $key . ']';
			    		echo "<input type=\"radio\" name=\"$tmp_name\" value=\"$opt_key\"" . checked( $opt_key, $lblg_options[$key], false ) . " />$opt_value<br />\n";
				}
			}
			 
			lblg_option_wrapper_footer( $value );
			break;
			
			// Prints a checbox <input> element
			case "checkbox":
			add_settings_field( $key, $value['name'], '', $lblg_options_group, $section );
			lblg_option_wrapper_header( $value );

			$tmp_name = $lblg_options_group . '['. $key . ']';
			echo "<input type=\"checkbox\" name=\"$tmp_name\" id=\"$key\" value=\"1\"" . checked( $lblg_options[$key], 1, false ) . " />\n";

			lblg_option_wrapper_footer( $value );
			break;
	
			default:
	
			break;
		}
	}

}