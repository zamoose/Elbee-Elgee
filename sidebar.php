<div id="navigation">
<ul>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Navigation') ) : ?>
	<li><h2>Search</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</li>

	<?php /*if(function_exists(sparkStats_imgURI)){?>
        	<li><h2><?php _e('Recent Activity'); ?></h2>
	    		<img src="<?php sparkStats_imgURI(); ?>" alt="SparkStats"/><br /><br />
	    		<img src="<?php sparkStats_legendURI(); ?>" alt="SparkStats Legend"/>
		</li>	
	<?php }*/ ?>
	<?php if ( function_exists('blc_latest_comments') ) { ?>
		<li><h2>Recent Comments</h2>
                        <?php blc_latest_comments(); ?>
		</li>
	<?php } ?>

	<?php /*if ( is_single() ) { ?>
	<li><h2>Post Info</h2>
		You are reading "<a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a>". It was posted on <?php the_date('l, F jS, Y','',''); ?> in <?php the_category(', '); ?><?php if(function_exists(UTW_ShowTagsForCurrentPost)) {?> and was tagged as <?php UTW_ShowTagsForCurrentPost("commalist"); } ?>.
	</li>
	<?php 
	}*/
	if (is_home()) {
		get_links_list(); 
	}
	
	if (is_single() || is_archive()) {
		if(function_exists(related_posts)){ ?>
	<li><h2>Possibly Related</h2>
	<?php related_posts(); ?>
	</li>
	<?php 
		}
	} ?>
	<?php endif; ?>
</ul>

</div>
<div id="extra">
<ul>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Extra') ) : ?>
	<?php if (function_exists(wpaudioscrobbler)) { ?>
	<li><h2>Now Listening</h2>
		<?php wpaudioscrobbler(); ?>
		<?php //get_scrobbler(); ?>
	</li>
	<?php } ?>
	<?php if (function_exists(nr_display)) { ?>
	<li><h2>Now Reading</h2>
		<?php nr_display(); ?>
	</li>
	<?php } ?>
        <?php if (function_exists(ttlb_ecosystem_details)) { ?>
        <li><h2>TTLB Info</h2>
		<?php ttlb_ecosystem_details('http://literalbarrage.org/blog'); ?>
	</li>
	<?php } ?>
	<li><h2>Meta</h2>
		<ul>
		 <li><img src="<?php bloginfo('template_directory'); ?>/images/feed.png" /><a href="<?php bloginfo('rss2_url'); ?>">RSS Entries</a></li>
		                         <li><img src="<?php bloginfo('template_directory'); ?>/images/feed.png" /><a href="<?php bloginfo('comments_rss2_url'); ?>">RSS Comments</a></li>
		<?php wp_register(); ?>
	        <li><?php wp_loginout(); ?></li>
		<li><a href="http://www.dreamhost.com/donate.cgi?id=5283"><img border="0" alt="Donate towards my web hosting bill!" src="https://secure.newdream.net/donate1.gif" /></a></li>
		<li><a href="http://feeds.feedburner.com/literalbarrage"><img src="http://feeds.feedburner.com/~fc/literalbarrage?bg=CA1919&amp;fg=FFFFFF&amp;anim=0" height="26" width="88" style="border:0" alt="" /></a></li>
		<li><a href="http://pr.blogflux.com/"><img src="http://pr.blogflux.com/pr.php" alt="Google PageRank Checker - Page Rank Calculator" width="80" height="15" border="0"></a></li>
		<li><a href="http://jesse.bur.st/" title="Current server load"><img src="/blog/wp-images/serverload.php" alt="Server Load" border="0"></a></li>
		<li><a href="http://www.poweredbywp.com/" title="WordPress Blogs"><img src="http://www.poweredbywp.com/images/wp2.png" alt="Powered by WordPress - WordPress Blogs Directory" border="0" /></a></li>
		</ul>
	</li>
	<?php endif; ?>
</ul>
</div>
