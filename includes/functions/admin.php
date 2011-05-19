<?php
// Set up the admin page &  register settings
function lblg_add_admin() {
    $lblg_meta = get_option( 'lblg_meta_info ');
	$themename = $lblg_meta['themename'];
    add_theme_page( $themename." Settings", "$themename Settings", 'edit_theme_options', 'lblg_options_page' , 'lblg_admin' );
}

function lblg_admin_init(){
	global $lblg_shortname;
	register_setting( $lblg_shortname . '_lblg_options', $lblg_shortname . '_lblg_options', 'lblg_sanitize_options' );
}

// Display the theme options page
function lblg_admin() {
	global $lblg_shortname, $lblg_themename, $lblg_version, $lblg_options, $lblg_default_options;

	$themename = $lblg_themename;
	$shortname = $lblg_shortname;
	$options = $lblg_default_options;

    if ( isset( $_GET['save'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( isset( $_GET['reset'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>
<div class="wrap">
<h2 class="updatehook"><?php echo $themename; ?> settings</h2>

<form method="post" action="options.php">

<?php 
	settings_fields( $lblg_shortname . '_lblg_options' ); 
	//do_settings_sections( 'lblg_options_group' );
?>
<table class="form-table">
<tbody>

<?php lblg_print_options(); ?>

</tbody>
</table>

<p class="submit">
<input name="<?php echo $lblg_shortname; ?>_lblg_options[save]" type="submit" class="button-primary" value="Save changes" />
<input name="<?php echo $lblg_shortname; ?>_lblg_options[reset]" type="submit" class="button-secondary" value="Reset to defaults" />
</p>
</form>

<?php
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
		<?php echo $values['desc']; ?>
	    </td>
	</tr>
	<?php 
}

/*
 * lblg_print_options() is responsible for printing all the theme options in the theme's
 * options screen.
 */
function lblg_print_options(){
	global $lblg_options, $lblg_default_options, $lblg_shortname;
	$section = '';
	$lblg_options_group = $lblg_shortname . '_lblg_options';
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
			        <input name="<?php echo $lblg_options_group . '[' . $key . ']'; ?>" id="<?php echo $key; ?>" type="<?php echo $value['type']; ?>" value="<?php if( "" != $options[$key] ) { echo $options[$key]; } else { echo $value['std']; } ?>" />
			<?php
			lblg_option_wrapper_footer( $value );
			break;
			
			// Prints a drop-down <select> element
			case 'select':
			add_settings_field( $key, $value['name'], '', $lblg_options_group, $section );
			lblg_option_wrapper_header( $value );
			?>
		            <select name="<?php echo $lblg_options_group . '[' . $key . ']'; ?>" id="<?php echo $key; ?>">
		                <?php foreach ( $value['options'] as $option) { 
								$selected = ( ($option == $lblg_options[$key]) ? 'selected="selected"' : '' );
						?>
		                <option <?php echo $selected; ?>><?php echo $option; ?></option>
		                <?php } ?>
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
					<textarea name="<?php echo $lblg_options_group . '[' . $key . ']'; ?>" id="<?php echo $key; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php echo $lblg_options[$key]; ?></textarea>
			<?php
			lblg_option_wrapper_footer( $value );
			break;
	
			// Prints a series of radio <input> elements
			case "radio":
			add_settings_field( $key, $value['name'], '', $lblg_options_group, $section );			
			lblg_option_wrapper_header( $value );
	 		foreach ( $value['options'] as $opt_key=>$opt_value ) {
					$radio_setting = $lblg_options[$key];
					echo "Radio: $radio_setting";
					if( '' != $radio_setting ){
			    		if ( $key == $options[$key] ) {
							$checked = 'checked="checked"';
							} else {
								$checked = "";
							}
					}else{
						if( $key == $value['std'] ){
							$checked = 'checked="checked"';
						}else{
							$checked = "";
						}
					}?>
		            <input type="radio" name="<?php echo $lblg_options_group . '[' . $key . ']'; ?>" value="<?php echo $opt_key; ?>" <?php echo $checked; ?> /><?php echo $opt_value; ?><br />
			<?php 
			}
			 
			lblg_option_wrapper_footer( $value );
			break;
			
			// Prints a checbox <input> element
			case "checkbox":
			
			add_settings_field( $key, $value['name'], '', $lblg_options_group, $section );
			lblg_option_wrapper_header( $value );
							if( $option[$key] ){
								$checked = 'checked="checked"';
							}else{
								$checked = "";
							}
						?>
			            <input type="checkbox" name="<?php echo $lblg_options_group . '[' . $key . ']'; ?>" id="<?php echo $key; ?>" value="true" <?php echo $checked; ?> />
			<?php
			lblg_option_wrapper_footer( $value );
			break;
	
			default:
	
			break;
		}
	}

}