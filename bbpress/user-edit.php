<?php

/**
 * bbPress User Profile Edit
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php get_header(); ?>

<?php get_template_part( 'bbp-wrapper-header' ); ?>

				<?php do_action( 'bbp_template_notices' ); ?>

				<?php bbp_get_template_part( 'bbpress/user', 'details' ); ?>

				<div class="entry-content bbp-edit-user">

					<?php bbp_get_template_part( 'bbpress/form', 'user-edit' ); ?>

				</div>
				
<?php get_template_part( 'bbp-wrapper-footer' ); ?>
