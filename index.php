<?php get_header(); ?>

<div id="allwrapper">
	<div id="wrapper">
		<?php lblg_above_content(); ?>
		<div id="lb-content">
			<?php include( TEMPLATEPATH . '/theloop.php' ); ?>
		</div>
	</div>

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
