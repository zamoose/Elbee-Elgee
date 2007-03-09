<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>

<div id="wrapper">
	<div id="content">
	<h2>Archives<br />By Date</h2>
	<?php arl_subtraction_archives_posts(); ?>
	</div>
</div>
<div id="navigation">
	<h2>Archives<br />By Category</h2>
	<?php arl_subtraction_archives_categories(); ?>
</div>
<div id="extra">
	&nbsp;
</div>

<?php get_footer(); ?>
