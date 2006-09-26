	<?php /*
		This navigation is used on most pages to move back and forth in your archives.
		It has been placed in its own file so it's easier to change across all of K2
	*/ ?>

	<!--hr /-->

	<?php if (is_single()) { ?>

	<div class="navigation">
		<div class="left"><?php previous_post('<span>&laquo;</span> %','','yes') ?></div>
		<div class="right"><?php next_post(' % <span>&raquo;</span>','','yes') ?></div>
		<div class="clear"></div>
	</div>

	<?php } else { ?>
		
	<div class="navigation">
		<div class="left"><?php next_posts_link('<span>&laquo;</span> '.__('Previous Entries','k2_domain').'') ?></div>
		<div class="right"><?php previous_posts_link(''.__('Next Entries','k2_domain').' <span>&raquo;</span>') ?></div>
		<div class="clear"></div>
	</div>

	<?php } ?>

	<!--hr /-->
