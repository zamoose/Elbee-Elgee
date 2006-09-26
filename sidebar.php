<div id="navigation">
<ul>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
	<?php get_links_list(); ?>
	<?php endif; ?>
</ul>

</div>
<div id="extra">
<p>This is extra.</p>
</div>