<?php

/**
 * View Handler
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

<?php get_template_part( 'bbp-wrapper-header' ); ?>

				<?php do_action( 'bbp_template_notices' ); ?>

				<div id="bbp-view-<?php bbp_view_id(); ?>" class="bbp-view">
					<h1 class="entry-title"><?php bbp_view_title(); ?></h1>
					<div class="entry-content">

						<?php bbp_breadcrumb(); ?>

						<?php bbp_set_query_name( 'bbp_view' ); ?>

						<?php if ( bbp_view_query() ) : ?>

							<?php bbp_get_template_part( 'bbpress/loop', 'topics' ); ?>

						<?php else : ?>

							<p><?php _e( 'Oh bother! No topics were found here!', 'bbpress' ); ?></p>

						<?php endif; ?>

						<?php bbp_reset_query_name(); ?>

					</div>
				</div><!-- #bbp-view-<?php bbp_view_id(); ?> -->

<?php get_template_part( 'bbp-wrapper-footer' ); ?>
