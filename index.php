<?php get_header(); ?>

<div id="allwrapper">
	<div id="wrapper">
		<?php lblg_above_content(); ?>
		<div id="lb-content">
			<?php get_template_part( 'theloop' ); ?>
		</div> <!-- #lb-content -->
	</div> <!-- #wrapper -->

<?php get_sidebar(); ?>

</div> <!-- #allwrapper -->

<?php get_footer(); ?>
