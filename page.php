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
		<?php comments_template(); ?>
	</div>

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
