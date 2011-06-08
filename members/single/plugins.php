<?php get_header() ?>

	<?php get_template_part( 'bp-wrapper-header' ); ?>

			<?php do_action( 'bp_before_member_plugin_template' ) ?>

			<div id="item-header">
				<?php locate_template( array( 'members/single/member-header.php' ), true ) ?>
			</div><!-- #item-header -->

			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav">
					<ul>
						<?php bp_get_displayed_user_nav() ?>

						<?php do_action( 'bp_member_options_nav' ) ?>
					</ul>
				</div>
			</div><!-- #item-nav -->

			<div id="item-body">
				<?php do_action( 'bp_before_member_body' ) ?>

				<div class="item-list-tabs no-ajax" id="subnav">
					<ul>
						<?php bp_get_options_nav() ?>

						<?php do_action( 'bp_member_plugin_options_nav' ) ?>
					</ul>
				</div><!-- .item-list-tabs -->

				<?php do_action( 'bp_template_title' ) ?>

				<?php do_action( 'bp_template_content' ) ?>

				<?php do_action( 'bp_after_member_body' ) ?>

			</div><!-- #item-body -->

			<?php do_action( 'bp_after_member_plugin_template' ) ?>

<?php get_template_part( 'bp-wrapper-footer' ); ?>
<?php get_footer() ?>