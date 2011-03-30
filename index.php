<?php get_header(); ?>

<div id="allwrapper">
	<div id="wrapper">
		<?php lblg_above_content(); ?>
		<div id="lb-content">
			<?php get_template_part( 'theloop' ); ?>
		</div>
	</div>

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
