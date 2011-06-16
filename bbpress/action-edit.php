<?php

/**
 * Edit handler for topics and replies
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

<?php get_template_part( 'bbp-wrapper-header' ); ?>

				<?php while ( have_posts() ) the_post(); ?>

					<div id="bbp-edit-page" class="bbp-edit-page">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="entry-content">

							<?php bbp_breadcrumb(); ?>

							<?php if ( bbp_is_reply_edit() ) : ?>

								<?php bbp_get_template_part( 'bbpress/form', 'reply' ); ?>

							<?php elseif ( bbp_is_topic_edit() ) : ?>

								<?php bbp_get_template_part( 'bbpress/form', 'topic' ); ?>

							<?php endif; ?>

						</div>
					</div><!-- #bbp-edit-page -->

<?php get_template_part( 'bbp-wrapper-footer' ); ?>
