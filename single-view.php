<?php

/**
 * Single View
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

						<?php bbp_get_template_part( 'bbpress/content', 'single-view' ); ?>

					</div>
				</div><!-- #bbp-view-<?php bbp_view_id(); ?> -->

<?php get_template_part( 'bbp-wrapper-footer' ); ?>