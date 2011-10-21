<?php
/**
 * Elbee Elgee single post template
 *
 * Template Name: Single Post
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
		<?php comments_template(); ?>
	</div><!-- #lb-content -->
</div><!-- #wrapper -->

<?php get_sidebar(); ?>

</div><!-- #allwrapper -->

<?php get_footer(); ?>
