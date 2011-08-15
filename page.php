<?php
/*
Template Name: Page
*/
?>
<?php get_header(); ?>

<div id="allwrapper">
<div id="wrapper">
	<div id="lb-content">
		<?php get_template_part( 'theloop' ); ?>
		<?php if( comments_open() ) comments_template(); ?>
	</div> <!-- #lb-content -->
</div> <!-- #wrapper -->
<?php get_sidebar(); ?>

</div><!-- #allwrapper -->

<?php get_footer(); ?>
