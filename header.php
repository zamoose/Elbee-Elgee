<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title(''); ?> <?php if( !(is_404()) && (is_single()) or (is_page()) or (is_archive()) ) { ?> at <?php } ?> <?php bloginfo('name');?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	<meta name="description" content="<?php bloginfo('description'); ?>" />

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<?php if (is_single() or is_page()) { ?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php } ?>

	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/includes/css/yui/reset.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/includes/css/yui/fonts.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/layouts/<?php echo get_option('lblg_layout_stylesheet'); ?>" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" />
	<?php
		$alt_style = get_option('lblg_alt_stylesheet');
		if (( $alt_style != '' ) && ($alt_style != 'Select a stylesheet:'))	{
			echo '<link rel="stylesheet" type="text/css" media="screen" href="'.get_bloginfo('template_directory').'/styles/'.get_option('lblg_alt_stylesheet').'" />';
		}
	?>

	<?php wp_head(); ?>
	<META name="verify-v1" content="j+73ZfK0ZfqL/24QUywKgcbY+Xsr+P/6XUtDJpUl0wc=" />
</head>
<body>
<div id="container">
<div id="header">
	<h1><a href="<?php bloginfo('home'); ?>"><?php echo get_bloginfo('name'); ?></a></h1>
	<p class="description"><?php bloginfo('description'); ?></p>
</div>
        <ul id="menu">
                <li><a href="<?php bloginfo('url'); ?>" class="selected">Blog</a></li>
                <?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
				<?php wp_register('<li class="admintab">','</li>'); ?>
        </ul>
	
