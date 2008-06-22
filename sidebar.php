<div id="navigation">
<ul>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Navigation') ) : ?>
	<li><h2>Search</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</li>
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
	
	if ((is_single() || is_archive()) && function_exists(related_posts)){ ?>
	<li><h2>Possibly Related</h2>
	<?php related_posts(); ?>
	</li>
	<?php 
	}
	
	if ((is_single() || is_archive()) && function_exists(wp_related_posts)) {?>
	<li><h2>Possibly Related</h2>
	<?php wp_related_posts(); ?>
	</li>
	<?php 
	}?>
	<?php endif; ?>

	<li><h2>Quick Archives</h2>
	<form id="archiveform" action="">
	<select name="archive_chrono" onchange="window.location = (document.forms.archiveform.archive_chrono[document.forms.archiveform.archive_chrono.selectedIndex].value);">
	<option value=''>Select Month</option>
	<?php wp_get_archives('type=monthly&format=option'); ?>
	</select>
	</form>
	</li>

	<li><h2>Quick Categories</h2>
	<?php wp_dropdown_categories('orderby=name'); ?>
	</li>
</ul>

</div>
<div id="extra">
<ul>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Extra') ) : ?>
	<?php if (function_exists(wpaudioscrobbler)) { ?>
	<li><h2>Now Listening</h2>
		<?php wpaudioscrobbler(); ?>
	</li>
	<?php } ?>
	<?php if (function_exists(nr_display)) { ?>
	<li><h2>Now Reading</h2>
		<?php nr_display(); ?>
	</li>
	<?php } ?>
        <li><h2>TTLB Info</h2>
	<script language="javascript" src="http://truthlaidbear.com/MyDetails.php?url=http://literalbarrage.org/blog&style=javascript">
	</script>
	</li>
	<li><h2>Meta</h2>
		<ul>
			<li><img src="<?php bloginfo('template_directory'); ?>/images/feed.png" /><a href="<?php bloginfo('rss2_url'); ?>">RSS Entries</a></li>
		 	<li><img src="<?php bloginfo('template_directory'); ?>/images/feed.png" /><a href="<?php bloginfo('comments_rss2_url'); ?>">RSS Comments</a></li>
			<?php wp_register(); ?>
	        <li><?php wp_loginout(); ?></li>
			<li><a href="http://www.dreamhost.com/donate.cgi?id=5283"><img border="0" alt="Donate towards my web hosting bill!" src="https://secure.newdream.net/donate1.gif" /></a></li>
			<li><a href="http://feeds.feedburner.com/literalbarrage"><img src="http://feeds.feedburner.com/~fc/literalbarrage?bg=CA1919&amp;fg=FFFFFF&amp;anim=0" height="26" width="88" style="border:0" alt="" /></a></li>
			<li><a href="http://jesse.bur.st/" title="Current server load"><img src="/blog/wp-images/serverload.php" alt="Server Load" border="0"></a></li>
			<li><a href="http://macromates.com" title="Made with TextMate"><img src="<?php bloginfo('template_directory');?>/images/textmate_badge.png" style="border: 0;" /></a></li>
			<li><a href="http://macrabbit.com/cssedit" title="Made with CSSEdit"><img src="<?php bloginfo('template_directory');?>/images/BadgeS.png" style="border: 0;" /></a></li>
			<li><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/us/"><img alt="Creative Commons License" style="border-width:0" src="http://creativecommons.org/images/public/somerights20.png"/></a><!--br/>This <span xmlns:dc="http://purl.org/dc/elements/1.1/" href="http://purl.org/dc/dcmitype/Text" rel="dc:type">work</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://literalbarrage.org/blog/" property="cc:attributionName" rel="cc:attributionURL">http://literalbarrage.org/blog/</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/us/">Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License</a>.--></li>
		</ul>
	</li>
	<?php endif; ?>
</ul>
</div>
