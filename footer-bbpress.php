<?php
global $lblg_themename, $lblg_shortname, $lblg_options;
?>
<div id="footer">
	<div id="footerwrapper">
	<?php if( 1 != $lblg_options['bbp_disable_footer'] ) : ?>
		<div id="footerleft">
			<ul>
			<?php if ( !dynamic_sidebar('Bottom Left') ) : ?>
			<?php if( current_user_can('edit_theme_options') ){ ?>
				<li><h4>Bottom-Left Sidebar</h4>
					This is the bottom-left sidebar. You may add widgets to it via the Appearance -&gt; Widgets administration screen.
				</li>
			<?php } ?>
			<?php endif; ?>
			</ul>
		</div>
		<div id="footerright">
			<ul>
			<?php if ( !dynamic_sidebar('Bottom Right') ) : ?>
			<?php if( current_user_can('edit_theme_options') ){ ?>
				<li><h4>Bottom-Right Sidebar</h4>
					This is the bottom-right sidebar. You may add widgets to it via the Appearance -&gt; Widgets administration screen.
				</li>
			<?php } ?>
			<?php endif; ?>
			</ul>
		</div>
	<?php endif; ?>
	<div id="footercredits">
	<?php 
		if( $lblg_options['display_footer_copyright'] ) {
			lblg_print_copyright();
 		}

		if( $lblg_options['display_footer_credits'] ) {
			lblg_print_credits();
		}
	?>
	<!--<?php echo get_num_queries(); ?> queries-->
	</div>
	</div>
</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
