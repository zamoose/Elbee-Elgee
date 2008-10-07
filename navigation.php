	<!--hr /-->

	<?php if (is_single()) { ?>

	<div class="navigation">
		<div class="left"><?php previous_post_link() ?></div>
		<div class="right"><?php next_post_link() ?></div>
		<div class="clear"></div>
	</div>

	<?php } else { ?>
		
	<div class="navigation">
		<div class="left"><?php next_posts_link('<span>&laquo;</span> Previous Entries') ?></div>
		<div class="right"><?php previous_posts_link('Next Entries <span>&raquo;</span>') ?></div>
		<div class="clear"></div>
	</div>

	<?php } ?>

	<!--hr /-->
