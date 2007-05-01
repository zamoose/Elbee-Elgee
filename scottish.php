<?php
/*
Template Name: Scottish
*/
?>
<?php get_header(); ?>

<div id="wrapper">
	<div id="content">
	<div id="post-<?php the_ID(); ?>" class="wppost">
		<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php echo strip_tags(get_the_title()) ?>"><?php the_title(); ?></a></h3>        <?php series_table_of_contents(); ?>
	</div>
		     <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	</div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
