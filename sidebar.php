<?php
lblg_sidebar_header(); 
?>
<div id="navigation">
<ul>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Navigation') ) : ?>
	<li><h2>Search</h2>
		<?php get_search_form(); ?>
	</li>
	<?php if ( function_exists('blc_latest_comments') ) { ?>
		<li><h2>Recent Comments</h2>
                        <?php blc_latest_comments(); ?>
		</li>
	<?php } ?>

	<?php
	if (is_home()) {
		wp_list_bookmarks(); 
	}
	
	if ((is_single() || is_archive()) && function_exists('related_posts')){ ?>
	<li><h2>Possibly Related</h2>
	<?php related_posts(); ?>
	</li>
	<?php 
	}
	
	if ((is_single() || is_archive()) && function_exists('wp_related_posts')) {?>
	<li><h2>Possibly Related</h2>
	<?php wp_related_posts(); ?>
	</li>
	<?php 
	}?>
	<?php endif; ?>

</ul>

</div>
<div id="extra">
<ul>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Extra') ) : ?>
	<li><h2>Meta</h2>
		<ul>
			<li><img src="<?php get_template_directory_uri(); ?>/images/feed.png" /><a href="<?php bloginfo('rss2_url'); ?>">RSS Entries</a></li>
		 	<li><img src="<?php get_template_directory_uri(); ?>/images/feed.png" /><a href="<?php bloginfo('comments_rss2_url'); ?>">RSS Comments</a></li>
			<?php wp_register(); ?>
	        <li><?php wp_loginout(); ?></li>
		</ul>
	</li>
	<?php endif; ?>
</ul>
</div>
<?php
lblg_sidebar_footer();
?>
