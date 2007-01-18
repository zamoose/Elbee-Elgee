<div id="footer">
	<div id="footerleft">
		<ul>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom Left') ) : ?>
		<li><h2>Recent Posts</h2>
		<ul>
		<?php 
			/*$numposts = get_settings('posts_per_page');
			$poststring = 'paged=2&showposts=$numposts';*/
			query_posts('paged=2&showposts=7'); 
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
	        <?php if (function_exists(SimplePieWP)) { ?>
		        <li><h2>Elbee Elgee Development</h2>                <?php echo SimplePieWP('http://trac.zamoose.org/timeline?milestone=on&ticket=on&changeset=on&wiki=on&max=50&daysback=90&format=rss','items:5, showtitle:false, shortdesc:200, showdate:j M Y'); ?>
			</li>
		<?php } ?>

		<?php if ( function_exists('deepthoughts') && is_home() ) { ?>
			<li><h2>Deep Thoughts</h2>
				<?php deepthoughts(); ?>
			</li>
		<?php } ?>

	        <?php if (function_exists(SimplePieWP)) { ?>
			<li><h2>del.icio.us Links</h2>
		        	<?php echo SimplePieWP('http://del.icio.us/rss/zamoose','items:10, showdesc:false, showtitle:false'); ?>
			</li>
		<?php } ?>

			<li><h2>Meta</h2>
			<ul>
			<li><img src="<?php bloginfo('template_directory'); ?>/images/feed.png" /><a href="<?php bloginfo('rss2_url'); ?>">RSS Entries</a></li>
			<li><img src="<?php bloginfo('template_directory'); ?>/images/feed.png" /><a href="<?php bloginfo('comments_rss2_url'); ?>">RSS Comments</a></li>
			<li><a href="http://feeds.feedburner.com/literalbarrage"><img src="http://feeds.feedburner.com/~fc/literalbarrage?bg=CA1919&amp;fg=FFFFFF&amp;anim=0" height="26" width="88" style="border:0" alt="" /></a></li>
			</ul>
			</li>
		<?php endif; ?>
		</ul>
	</div>
	<div id="footercredits">
	<p><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> is powered by <a href="http://wordpress.org">WordPress</a> <?php bloginfo('version'); ?> and <a href="http://literalbarrage.org/blog/code/elbee-elgee">Elbee Elgee</a></p><p>&copy 2006 Doug Stewart</p>
	<!--WEBBOT bot="HTMLMarkup" startspan ALT="Site Meter" -->
	<script type="text/javascript" language="JavaScript">var site="s19literal"</script>
	<script type="text/javascript" language="JavaScript1.2" src="http://s19.sitemeter.com/js/counter.js?site=s19literal">
	</script>
	<noscript>
	<a href="http://s19.sitemeter.com/stats.asp?site=s19literal" border="0" target="_top">
	<img src="http://s19.sitemeter.com/meter.asp?site=s19literal" alt="Site Meter" border="0"/></a>
	</noscript>
	<!-- Copyright (c)2005 Site Meter -->
	<!--WEBBOT bot="HTMLMarkup" Endspan -->

<?php /* Try. to understand */ ?>

        <?php do_action('wp_footer'); ?>
	</div>
</div>
</div>
</body>
</html>
