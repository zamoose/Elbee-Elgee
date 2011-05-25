<?php
global $lblg_themename, $lblg_shortname, $lblg_options;
?>
<div id="footer">
	<div id="footerwrapper">
	<div id="footerleft">
		<ul>
		<?php if ( !dynamic_sidebar('Bottom Left') ) : ?>
			<li><h4>Bottom-Left Sidebar</h4>
				This is the bottom-left sidebar. You may add widgets to it via the Appearance -&gt; Widgets administration screen.
			</li>
		<?php endif; ?>
		</ul>
	</div>
	<div id="footerright">
		<ul>
		<?php if ( !dynamic_sidebar('Bottom Right') ) : ?>
			<li><h4>Bottom-Right Sidebar</h4>
				This is the bottom-right sidebar. You may add widgets to it via the Appearance -&gt; Widgets administration screen.
			</li>
		<?php endif; ?>
		</ul>
	</div>
	<div id="footercredits">
	<?php 
		if( 'true' == $lblg_options['display_footer_copyright'] ) {
	?>
	<p><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a> <?php lblg_print_copyright(); ?></p>
	<?php }
		if( 'true' == $lblg_options['display_footer_credits'] ) {
			lblg_print_credits();
		}
		
		wp_footer(); 
	?>
	<!--<?php echo get_num_queries(); ?> queries-->
	</div>
	</div>
</div>
</div>
</body>
</html>
