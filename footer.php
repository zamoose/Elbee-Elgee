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
		        <li><h2>Elbee Elgee Development</h2>                <?php echo SimplePieWP('http://trac.zamoose.org/timeline?milestone=on&ticket=on&changeset=on&wiki=on&max=50&daysback=90&format=rss','items:5, shortdesc:200, showdate:j M Y'); ?>
			</li>
		<?php } ?>

			<?php if ( function_exists('blc_latest_comments') ) { ?>
				<li><h2>Recent Comments</h2>
				<?php blc_latest_comments(); ?>
				</li>
			<?php } ?>
			<?php if ( function_exists('delicious') ) { ?>
				<li><h2>del.icio.us Links</h2>
					<?php delicious('zamoose'); ?>
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
	<script type="text/javascript">
	<?php
	global $userdata;
	if ($userdata) {
	 echo "z_user_name=\"" . $userdata->display_name . "\";\n";
	 echo "z_user_email=\"" . $userdata->user_email . "\";\n";
	}
	?>
	z_post_title="<?php the_title();?>";
	z_post_category="<?php $c=get_the_category();echo $c[0]->cat_name;?>";
	</script>
	<script id="stats_script" type="text/javascript" src="http://metrics.performancing.com/wp.js"></script>
	<br />
	<a href="http://performancing.com"><img src="http://metrics.performancing.com/logo_small.png" height="14" width="125" border="0" alt="Performancing"></a>
	</div>
</div>
</div>
<script type="text/javascript">
//<![CDATA[
  document.write('<scr'+'ipt src="http://crazyegg.com/pages/scripts/5418.js?'+(new Date()).getTime()+'" type="text/javascript"></scr'+'ipt>');
  //]]>
  </script>
</body>
</html>
