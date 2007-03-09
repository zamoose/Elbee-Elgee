<?php 
/*
Template Name: Single Post
*/

get_header(); ?>

<div id="wrapper">
	<div id="content">
		<?php include( TEMPLATEPATH . '/theloop.php' ); ?>
		<?php comments_template(); ?>
	</div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
