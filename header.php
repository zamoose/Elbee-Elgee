<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title(''); ?> <?php if( !(is_404()) && (is_single()) or (is_page()) or (is_archive()) ) { ?> at <?php } ?> <?php bloginfo('name');?></title>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/layouts/<?php echo get_option('lblg_layout_stylesheet'); ?>" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" />
	<?php
		if ( isset(get_option('lblg_alt_stylesheet')) )	{
			echo '<link rel="stylesheet" type="text/css" media="screen" href="<?php get_option('lblg_alt_stylesheet'); ?>" />';
		}
	?>

	<?php wp_head(); ?>
</head>
<body>
<div id="container">
<div id="header">
	<h1><a href="<?php bloginfo('home'); ?>"><?php bloginfo('name'); ?></a></h1>
	<p class="description"><?php bloginfo('description'); ?></p>
</div>
        <ul id="menu">
                <li><a href="<?php bloginfo('url'); ?>" class="selected">Blog</a></li>
                <?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
				<?php wp_register('<li class="admintab">','</li>'); ?>
        </ul>
	
