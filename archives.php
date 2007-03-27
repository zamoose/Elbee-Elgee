<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>

<div id="archive-wrapper">
	<div id="archive-posts">
		<h2>Archives<br />By Date</h2>
		<?php arl_subtraction_archives_posts(); ?>
	</div>
</div>
<div id="archive-categories">
	<h2>Archives<br />By Category</h2>
	<?php arl_subtraction_archives_categories(); ?>
</div>

<?php get_footer(); ?>
