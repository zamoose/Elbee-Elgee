<?php
lblg_sidebar_header(); 
?>
<div id="primarysb">
<ul>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Primary') ) : ?>
	
	<li><h4>Primary Sidebar</h4>
		This is the primary sidebar. You may add widgets to it via the Appearance -&gt; Widgets administration screen.
	</li>
	<li><h4>Search</h4>
		<?php get_search_form(); ?>
	</li>

	<?php
	if (is_home()) {
		wp_list_bookmarks(); 
	}
	?>
	
	<?php endif; ?>
</ul>

</div>
<div id="secondarysb">
<ul>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Secondary') ) : ?>
	<li><h4>Secondary Sidebar</h4>
		This is the secondary sidebar. You may add widgets to it via the Appearance -&gt; Widgets administration screen.
	</li>
	<li><h4>Meta</h4>
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
