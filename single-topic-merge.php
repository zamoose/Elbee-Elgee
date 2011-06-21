<?php

/**
 * Merge topic page
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

							<?php bbp_get_template_part( 'bbpress/form', 'topic-merge' ); ?>

						</div>
					</div><!-- #bbp-edit-page -->

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>