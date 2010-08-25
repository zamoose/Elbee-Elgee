<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>

<?php if(function_exists(arl_subtraction_archives_posts)){?>
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
<?php }else{ ?>
<div id="allwrapper">
<div id="wrapper">
	<div id="lb-content">
		<h3 class="archives">Archives</h3>
		<?php wp_smart_archives(); ?>
		
		<h3>Tag Cloud</h3>
		
		<?php wp_tag_cloud(); ?>
	</div>
</div>
<?php get_sidebar(); ?>
</div>
<?php } ?>
<?php get_footer(); ?>
