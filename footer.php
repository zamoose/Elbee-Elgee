<?php
global $themename, $shortname;
?>
<div id="footer">
	<div id="footerwrapper">
	<div id="footerleft">
		<ul>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom Left') ) : ?>
		<?php if(is_home()) { 
			query_posts('paged=2&showposts=7');?>
		<li><h2>Recent Posts</h2>
		<?php } else { 
			query_posts('paged=1'); ?>
		<li><h2>On The Front Page</h2>
		<?php } ?>
		<ul>
		<?php 
		while (have_posts()) : the_post(); ?>
		<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><br /> published on <?php the_date("M jS, Y"); ?> in <?php the_category(', '); ?><?php the_excerpt(); ?></li>
		<?php endwhile; ?>
		</ul>
		</li>
		<?php endif; ?>
		</ul>
	</div>
	<div id="footerright">
		<ul>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom Right') ) : ?>

		<?php endif; ?>
		</ul>
	</div>
	<div id="footercredits">
	<?php 
		$tmp_footer_text = get_option($shortname.'_footer_text');
		if($tmp_footer_text == ''){ 
	?>
	<p><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a> is powered by <a href="http://wordpress.org">WordPress</a> <?php bloginfo('version'); ?> and <a href="http://literalbarrage.org/blog/code/elbee-elgee">Elbee Elgee</a></p><p>&copy; 2003-2009 Doug Stewart</p>
	<?php
		}else{
			echo $tmp_footer_text;
		}

		wp_footer(); 
	?>
	<!--<?php echo get_num_queries(); ?> queries-->
	</div>
	</div>
</div>
</div>
</body>
</html>
