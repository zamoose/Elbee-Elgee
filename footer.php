<div id="footer">
	<div id="footerleft">
		<p>This is the footer.</p>
	</div>
	<div id="footerright">
		<ul>
			<li><a href="<?php get_bloginfo('rss2_url'); ?>">RSS Entries</a></li>
			<li><a href="<?php get_bloginfo('comments_rss2_url'); ?>">RSS Comments</a></li>
			<li><a href="http://feeds.feedburner.com/literalbarrage"><img src="http://feeds.feedburner.com/~fc/literalbarrage?bg=CA1919&amp;fg=FFFFFF&amp;anim=0" height="26" width="88" style="border:0" alt="" /></a></li>
		</ul>
		<p>This is the footer.</p>
	</div>
	<div id="footercredits">
	<!--WEBBOT bot="HTMLMarkup" startspan ALT="Site Meter" -->
	<script type="text/javascript" language="JavaScript">var site="s19literal"</script>
	<script type="text/javascript" language="JavaScript1.2" src="http://s19.sitemeter.com/js/counter.js?site=s19literal">
	</script>
	<noscript>
	<a href="http://s19.sitemeter.com/stats.asp?site=s19literal" border="0" target="_top">
	<img src="http://s19.sitemeter.com/meter.asp?site=s19literal" alt="Site Meter" border="0"/></a>
	</noscript>
	<!-- Copyright (c)2005 Site Meter -->
	<!--WEBBOT bot="HTMLMarkup" Endspan -->

<?php /* Try. to understand */ ?>

        <?php do_action('wp_footer'); ?>
	<script type="text/javascript">
	<?php
	global $userdata;
	if ($userdata) {
	 echo "z_user_name=\"" . $userdata->display_name . "\";\n";
	 echo "z_user_email=\"" . $userdata->user_email . "\";\n";
	}
	?>
	z_post_title="<?php the_title();?>";
	z_post_category="<?php $c=get_the_category();echo $c[0]->cat_name;?>";
	</script>
	<script id="stats_script" type="text/javascript" src="http://metrics.performancing.com/wp.js"></script>
	<br />
	<a href="http://performancing.com"><img src="http://metrics.performancing.com/logo_small.png" height="14" width="125" border="0" alt="Performancing"></a>
	</div>
</div>
</div>
</body>
</html>
