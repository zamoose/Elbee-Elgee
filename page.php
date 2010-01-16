<?php
/*
Template Name: Page
*/
?>
<?php get_header(); ?>

<div id="allwrapper">
<div id="wrapper">
	<div id="content">
	<?php if (have_posts()) : while (have_posts()) : the_post();?>
	<div id="post-<?php the_ID(); ?>" class="wppost">
		<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php echo strip_tags(get_the_title()) ?>"><?php the_title(); ?></a></h3>        
<?php /*                <span class="post_header_img"><img src="<?php bloginfo('template_directory'); ?>/includes/timthumb.php?src=<?php lblg_the_postimage(); ?>&h=120&w=480" /></span> */ ?>
	        <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
	</div>
		    <?php endwhile; endif; ?>
		    <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	</div>
</div>

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
