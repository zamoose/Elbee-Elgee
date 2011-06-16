<?php

/**
 * Split/merge topic page
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

<?php get_template_part( 'bbp-wrapper-header' ); ?>

				<?php do_action( 'bbp_template_notices' ); ?>

				<?php while ( have_posts() ) the_post(); ?>

					<div id="bbp-edit-page" class="bbp-edit-page">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="entry-content">

							<?php bbp_breadcrumb(); ?>

							<?php if ( bbp_is_topic_merge() ) : ?>

								<?php bbp_get_template_part( 'bbpress/form', 'merge' ); ?>

							<?php elseif ( bbp_is_topic_split() ) : ?>

								<?php bbp_get_template_part( 'bbpress/form', 'split' ); ?>

							<?php endif; ?>

						</div>
					</div><!-- #bbp-edit-page -->

<?php get_template_part( 'bbp-wrapper-footer' ); ?>
