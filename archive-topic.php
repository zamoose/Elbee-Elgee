<?php

/**
 * bbPress - Topic Archive
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

<?php get_template_part( 'bbp-wrapper-header' ); ?>

				<?php do_action( 'bbp_template_notices' ); ?>

				<div id="topic-front" class="bbp-topics-front">
					<h1 class="entry-title"><?php bbp_topic_archive_title(); ?></h1>
					<div class="entry-content">

						<?php bbp_get_template_part( 'bbpress/content', 'archive-topic' ); ?>

					</div>
				</div><!-- #topics-front -->

<?php get_template_part( 'bbp-wrapper-footer' ); ?>