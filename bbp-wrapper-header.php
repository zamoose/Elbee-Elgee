<?php
/**
* Simple wrapper template for the top of bbPress pages.
*
* @package 		Elbee-Elgee
* @copyright	Copyright (c) 2011, Doug Stewart
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
*
* @since 		Elbee-Elgee 1.0
*/

global $lblg_options;
?>
<div id="allwrapper">
	<div id="wrapper">
		<?php 
		if( 1 == $lblg_options['bbp_force_1_column'] ) $column_class = 'class="bp-full-width" ';
		echo "<div id=\"lb-content\" $column_class role=\"main\">";