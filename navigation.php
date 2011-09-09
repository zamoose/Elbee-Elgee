<?php
/**
 * 
 */
?>
	<!--hr /-->

	<?php if ( is_single() ) { ?>

	<div class="navigation">
		<div class="left"><?php previous_post_link() ?></div>
		<div class="right"><?php next_post_link() ?></div>
		<div class="clear"></div>
	</div>

	<?php } else { ?>
	<div class="navigation">
			<?php if(function_exists('wp_pagenavi')) {
 					wp_pagenavi(); 
				} else { ?>
		<div class="left"><?php next_posts_link('<span>&laquo;</span> Older Entries') ?></div>
		<div class="right"><?php previous_posts_link('Newer Entries <span>&raquo;</span>') ?></div>
		<div class="clear"></div>
			<?php } ?>
	</div>
	<?php } ?>

	<!--hr /-->
