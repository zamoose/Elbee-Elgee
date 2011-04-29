<?php
global $themename, $shortname;
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
		$tmp_footer_text = get_option($shortname.'_footer_text');
		if($tmp_footer_text == ''){ 
	?>
	<p><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a> <?php lblg_print_copyright(); ?></p>
	<?php lblg_print_credits(); ?>
	<?php
		}else{
			echo $tmp_footer_text;
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
