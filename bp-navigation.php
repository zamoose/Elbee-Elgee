<?php
/**
* Responsible for the search form and nav menu displayed in the header
* when an active BuddyPress install is detected.
*
* @package 		Elbee-Elgee
* @copyright	Copyright (c) 2011, Doug Stewart
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
*
* @since 		Elbee-Elgee 1.0
*/
?>
<div id="lb-bp-nav">

	<div id="lb-bp-search-bar">
		<div class="bp-padder">

		<?php if ( bp_search_form_enabled() ) : ?>

			<form action="<?php echo bp_search_form_action() ?>" method="post" id="search-form">
				<input type="text" id="search-terms" name="search-terms" value="" />
				<?php echo bp_search_form_type_select() ?>

				<input type="submit" name="search-submit" id="search-submit" value="<?php _e( 'Search', 'buddypress' ) ?>" />
				<?php wp_nonce_field( 'bp_search_form' ) ?>
			</form><!-- #search-form -->

		<?php endif; ?>

		<?php do_action( 'bp_search_login_bar' ) ?>

		</div><!-- .bp-padder -->
	</div><!-- #lb-bp-search-bar -->
	
	<?php
		wp_nav_menu( array( 'theme_location'	=> 'lblgbpmenu',  
							'container'			=> 'ul',
							'container_id'		=> 'lblgbpmenu',
							'depth'				=> '1'
				) );
	//echo bp_get_loggedin_user_nav();
	//echo bp_get_userbar();
	//echo bp_get_optionsbar();

	?>
	
</div><!-- #lb-bp-nav -->