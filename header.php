<?php
global $themename, $shortname;

$shortname = "lblg";
$themename = "Elbee Elgee";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
<?php
// Head that nasty "duplicate content" Google "feature" off at the pass.
if((is_single() || is_category() || is_page() || is_home()) && (!is_paged())){ 
?>
	<!-- ok google, index me! -->
<?php 
}else{
?>
	<!-- google, please ignore - thanks! -->
	<meta name="robots" content="noindex,follow">
<?php
}
?>
	<title><?php if(is_search()) { echo "Search Results &raquo; "; } else { wp_title('&raquo;', true, 'right'); } ?> <?php bloginfo('name');?></title>

	<?php 
	//Include Magpie RSS for make benefit glorious nation America.
	if ( file_exists(ABSPATH . WPINC . '/class-simplepie.php') )
		require_once(ABSPATH . WPINC . '/class-simplepie.php');
	else
		require_once(ABSPATH . WPINC . '/rss-functions.php');
	?>

	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	<meta name="description" content="<?php bloginfo('description'); ?>" />

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<?php if (is_single() or is_page()) {
		if(function_exists(wp_ozh_yourls_head_linkrel)){
			wp_ozh_yourls_head_linkrel();
		}
	?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php } ?>

	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/includes/css/yui/fonts.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/layouts/<?php echo get_option($shortname.'_layout_stylesheet'); ?>" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/print.css" media="print">
	<?php
		$alt_style = get_option($shortname.'_alt_stylesheet');
		if (( $alt_style != '' ) && ($alt_style != 'Select a stylesheet:'))	{
			echo '<link rel="stylesheet" type="text/css" media="screen" href="'.get_bloginfo('template_directory').'/styles/'.get_option($shortname.'_alt_stylesheet').'" />';
		}
	?>
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<?php wp_head(); ?>

</head>
<body>
<div id="container">
<div id="header">
	<?php lblg_print_title(); ?>
	<p class="description"><span><?php bloginfo('description'); ?></span></p>
</div>
<?php lblg_print_menu(); ?>