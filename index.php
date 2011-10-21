<?php
/**
 * Elbee Elgee Default Template (index.php)
 *
 * @package 		Elbee-Elgee
 * @copyright	Copyright (c) 2011, Doug Stewart
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Elbee-Elgee 1.0
 */
?>
<?php get_header(); ?>

<div id="allwrapper">
	<?php lblg_above_content_and_sidebars(); ?>
	<div id="wrapper">
		<?php lblg_above_content(); ?>
		<div id="lb-content">
			<?php get_template_part( 'theloop' ); ?>
		</div> <!-- #lb-content -->
	</div> <!-- #wrapper -->

<?php get_sidebar(); ?>

</div> <!-- #allwrapper -->

<?php get_footer(); ?>
