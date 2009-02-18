<?php
/*
Template Name: 404'd
*/
?>
<?php header("HTTP/1.1 404 Not Found"); ?>
<?php header("Status: 404 Not Found"); ?>
<?php
if (function_exists(afdn_error_page)) {
	afdn_error_page(); 
} else {
?>
<?php get_header(); ?>

<div id="allwrapper">
	<div id="wrapper">
		<div id="content">
			<div class="wppost">
				<h3>Whoops.</h3>
				<div class="itemtext">
					<p>Looks like you managed to stumble across a link to a page that doesn't exist, but never fear, good citizen, for a wealth of options awaits you!</p>
					<p>Perhaps you could search for what you were looking for:</p>

					<?php if (smart404_loop()) : ?>
					<p>Or, you could always try one of these posts:</p>
					<?php while (have_posts()) : the_post(); ?>
					<h4><a href="<?php the_permalink() ?>"
					  rel="bookmark"
					  title="<?php the_title_attribute(); ?>">
					  <?php the_title(); ?></a></h4>
					    <p><?php the_excerpt(); ?></p>
					    <?php endwhile; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>

<?php } //end if... else ?>
