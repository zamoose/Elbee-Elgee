<?php
global $lblg_options;
lblg_sidebar_header(); 
?>
<?php if( 1 != $lblg_options['bbp_force_1_column'] ) { ?>
<div id="primarysb">
	<ul>
		<?php if ( !dynamic_sidebar('Primary') ) : ?>
		<?php if( current_user_can('edit_theme_options') ){ ?>
		<li><h4>Primary Sidebar</h4>
			This is the primary sidebar. You may add widgets to it via the Appearance -&gt; Widgets administration screen.
		</li>
		<?php } ?>
		<li><h4>Search</h4>
			<?php get_search_form(); ?>
		</li>

		<?php endif; ?>
	</ul>
</div> <!-- #primarysb -->

<div id="secondarysb">
	<ul>
		<?php if ( !dynamic_sidebar('Secondary') ) : ?>
		<?php if( current_user_can('edit_theme_options') ){ ?>
		<li><h4>Secondary Sidebar</h4>
			This is the secondary sidebar. You may add widgets to it via the Appearance -&gt; Widgets administration screen.
		</li>
		<?php } ?>
		<li><h4>Meta</h4>
			<ul>
				<li><img src="<?php echo get_template_directory_uri(); ?>/images/feed.png" /><a href="<?php bloginfo('rss2_url'); ?>">RSS Entries</a></li>
			 	<li><img src="<?php echo get_template_directory_uri(); ?>/images/feed.png" /><a href="<?php bloginfo('comments_rss2_url'); ?>">RSS Comments</a></li>
				<?php wp_register(); ?>
		        <li><?php wp_loginout(); ?></li>
			</ul>
		</li>
		<?php endif; ?>
	</ul>
</div> <!-- #secondarysb -->
<?php
} //endif
lblg_sidebar_footer();
?>
