<ul id="lb-bp-nav">

<?php
//echo bp_get_loggedin_user_nav();
//echo bp_get_userbar();
//echo bp_get_optionsbar();

	if ( 'activity' != bp_dtheme_page_on_front() && bp_is_active( 'activity' ) ) : ?>
		<li<?php if ( bp_is_page( BP_ACTIVITY_SLUG ) ) : ?> class="selected"<?php endif; ?>>
			<a href="<?php echo site_url() ?>/<?php echo BP_ACTIVITY_SLUG ?>/" title="<?php _e( 'Activity', 'buddypress' ) ?>"><?php _e( 'Activity', 'buddypress' ) ?></a>
		</li>
	<?php endif; ?>

	<li<?php if ( bp_is_page( BP_MEMBERS_SLUG ) || bp_is_member() ) : ?> class="selected"<?php endif; ?>>
		<a href="<?php echo site_url() ?>/<?php echo BP_MEMBERS_SLUG ?>/" title="<?php _e( 'Members', 'buddypress' ) ?>"><?php _e( 'Members', 'buddypress' ) ?></a>
	</li>

	<?php if ( bp_is_active( 'groups' ) ) : ?>
		<li<?php if ( bp_is_page( BP_GROUPS_SLUG ) || bp_is_group() ) : ?> class="selected"<?php endif; ?>>
			<a href="<?php echo site_url() ?>/<?php echo BP_GROUPS_SLUG ?>/" title="<?php _e( 'Groups', 'buddypress' ) ?>"><?php _e( 'Groups', 'buddypress' ) ?></a>
		</li>

		<?php if ( bp_is_active( 'forums' ) && ( function_exists( 'bp_forums_is_installed_correctly' ) && !(int) bp_get_option( 'bp-disable-forum-directory' ) ) && bp_forums_is_installed_correctly() ) : ?>
			<li<?php if ( bp_is_page( BP_FORUMS_SLUG ) ) : ?> class="selected"<?php endif; ?>>
				<a href="<?php echo site_url() ?>/<?php echo BP_FORUMS_SLUG ?>/" title="<?php _e( 'Forums', 'buddypress' ) ?>"><?php _e( 'Forums', 'buddypress' ) ?></a>
			</li>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( bp_is_active( 'blogs' ) && bp_core_is_multisite() ) : ?>
		<li<?php if ( bp_is_page( BP_BLOGS_SLUG ) ) : ?> class="selected"<?php endif; ?>>
			<a href="<?php echo site_url() ?>/<?php echo BP_BLOGS_SLUG ?>/" title="<?php _e( 'Blogs', 'buddypress' ) ?>"><?php _e( 'Blogs', 'buddypress' ) ?></a>
		</li>
	<?php endif; ?>

	<?php wp_list_pages( 'title_li=&depth=1&exclude=' . bp_dtheme_page_on_front() ); ?>

	<?php do_action( 'bp_nav_items' ); ?>
/**/
?>
</ul><!-- #lb-bp-nav -->

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