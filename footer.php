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
		<?php if(function_exists(fetch_rss)) { ?>
		<div id="footertabs">			
			<ul class="idTabs">	
				<li><a href="#elbee">Elbee Elgee</a></li>
				<li><a href="#greader">Google Reader</a></li>
				<li><a href="#delicious">del.icio.us</a></li>
			</ul>	
		
			<div id="elbee">
				Elbee Elgee Development
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
			</div>
			<div id="greader">
				Google Reader
			</div>
			<div id="delicious">
				delicious Bookmarks
			</div>
		</div>
		<?php } ?>
		<ul>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom Right') ) : ?>

		<?php if(function_exists(wp_rss)) { ?>
			<li><h2><a href="http://trac.zamoose.org/timeline?milestone=on&ticket=on&changeset=on&wiki=on&max=50&daysback=90&format=rss" class="rssfeed">Elbee Elgee Development</a></h2>
				<ul>
			<?php	
				$url = 'http://trac.zamoose.org/timeline?milestone=on&ticket=on&changeset=on&wiki=on&max=50&daysback=90&format=rss';
				/*$lblgrss = fetch_rss($url);
				$rss_c = 0;*/

				wp_rss($url, 5);
				
				/*foreach($lblgrss->items as $item){
					if($rss_c <=4){
						$title = $item['title'];
						$link = $item['link'];
						$description = $item['description'];
						echo "<li><a href=\"$link\">$title</a></li>\n";
					}
					$rss_c++;
				}*/
			?>
				</ul>
			</li>
		<?php } ?>

		<?php
			if(function_exists(wp_rss)){
		?>
			<li><h2><a href="http://feeds.feedburner.com/zamooses-gr-shared-items" class="rssfeed">Google Reader</a></h2>
				<ul>
			<?php
				$url = "http://feeds.feedburner.com/zamooses-gr-shared-items";
				
				wp_rss($url,10);
			?>
				</ul>
			</li>
		<?php
			}
		?>

		<?php 
			$tmp_del_username = get_option('lblg_delicious_username');
			if(function_exists(wp_rss) && $tmp_del_username != '') { 
				$url = 'http://del.icio.us/rss/'.$tmp_del_username;
			?>
			<li><h2><a href="<?php echo $url; ?>" class="rssfeed">del.icio.us</a></h2>
				<ul>
			<?php	
				wp_rss($url, 10);
			?>
				</ul>
			</li>
		<?php } ?>

		<?php endif; ?>
		</ul>
	</div>
	<div id="footercredits">
	<?php 
		$tmp_footer_text = get_option('lblg_footer_text');
		if($tmp_footer_text == ''){ 
	?>
	<p><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> is powered by <a href="http://wordpress.org">WordPress</a> <?php bloginfo('version'); ?> and <a href="http://literalbarrage.org/blog/code/elbee-elgee">Elbee Elgee</a></p><p>&copy; 2003-2008 Doug Stewart</p>
	<?php
		}else{
			echo $tmp_footer_text;
		}
	/* Try. to understand */ ?>

        <?php do_action('wp_footer'); ?>
	<?php
		$tmp_stats_code = get_option('lblg_stats_code');
		if($tmp_stats_code != ''){
			echo $tmp_stats_code;
		}
	?>
	<!--<?php echo get_num_queries(); ?> queries-->
	</div>
	</div>
</div>
</div>
</body>
</html>
