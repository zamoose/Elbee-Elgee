<?php if (is_404()){ ?>
</div><!--end 404-specific wrapper div -->
<?php }?>
<div id="footer">
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
		<?php if(function_exists(fetch_rss)) { ?>
			<li><h2>Elbee Elgee Development</h2>
				<ul>
			<?php	
				$url = 'http://trac.zamoose.org/timeline?milestone=on&ticket=on&changeset=on&wiki=on&max=50&daysback=90&format=rss';
				$lblgrss = fetch_rss($url);
				$rss_c = 0;
				
				foreach($lblgrss->items as $item){
					if($rss_c <=4){
						$title = $item['title'];
						$link = $item['link'];
						$description = $item['description'];
						echo "<li><a href=\"$link\">$title</a></li>\n";
					}
					$rss_c++;
				}
			?>
				</ul>
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
		<?php endif; ?>
		</ul>
	</div>
	<div id="footercredits">
	<p><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> is powered by <a href="http://wordpress.org">WordPress</a> <?php bloginfo('version'); ?> and <a href="http://literalbarrage.org/blog/code/elbee-elgee">Elbee Elgee</a></p><p>&copy; 2007 Doug Stewart</p>

<?php /* Try. to understand */ ?>

        <?php do_action('wp_footer'); ?>
	<!-- Site Meter -->
	<a href=" http://s40.sitemeter.com/stats.asp?site=s40literal" target="_top">
	<img src=" http://s40.sitemeter.com/meter.asp?site=s40literal" alt="Site Meter" border="0"/></a>
	<!-- Copyright (c)2006 Site Meter -->
	<!--<?php echo get_num_queries(); ?> queries-->
	</div>
</div>
</div>
</body>
</html>
