<div id="navigation">
<ul>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
	<li><h2>Search</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</li>

	<?php if(function_exists(sparkStats_imgURI)){?>
        	<li><h2><?php _e('Recent Activity'); ?></h2>
	    		<img src="<?php sparkStats_imgURI(); ?>" alt="SparkStats"/><br /><br />
	    		<img src="<?php sparkStats_legendURI(); ?>" alt="SparkStats Legend"/>
		</li>	
	<?php } ?>
	<?php if ( function_exists('deepthoughts') ) { ?>
		<li><h2>Deep Thoughts</h2>
		<?php deepthoughts(); ?>
		</li>
	<?php } ?>
	<?php get_links_list(); ?>
	<?php endif; ?>
</ul>

</div>
<div id="extra">
<p>This is extra.</p>
</div>
