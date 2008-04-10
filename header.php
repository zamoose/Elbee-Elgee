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
	<title><?php wp_title(''); ?> <?php if( !(is_404()) && (is_single()) or (is_page()) or (is_archive()) ) { ?> at <?php } ?> <?php bloginfo('name');?></title>

	<?php 
	//Include Magpie RSS for make benefit glorious nation America.
	if ( file_exists(ABSPATH . WPINC . '/rss.php') )
		require_once(ABSPATH . WPINC . '/rss.php');
	else
		require_once(ABSPATH . WPINC . '/rss-functions.php');
	?>

	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	<meta name="description" content="<?php bloginfo('description'); ?>" />

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<?php if (is_single() or is_page()) { ?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php } ?>

	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/includes/css/yui/fonts.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/layouts/<?php echo get_option('lblg_layout_stylesheet'); ?>" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" />
	<?php
		$alt_style = get_option('lblg_alt_stylesheet');
		if (( $alt_style != '' ) && ($alt_style != 'Select a stylesheet:'))	{
			echo '<link rel="stylesheet" type="text/css" media="screen" href="'.get_bloginfo('template_directory').'/styles/'.get_option('lblg_alt_stylesheet').'" />';
		}

		wp_enqueue_script('jquery');
	?>

	<?php wp_head(); ?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
	// Hide the site-meta panel
	 jQuery('#meta-panel').hide();
	 jQuery('#quickpost-panel').hide();

	// Toggle site-meta panel visibilty and class when handle is clicked
	jQuery('#meta-anchor').click(function() {
	jQuery('#meta-panel').slideToggle(40);
	jQuery(this).toggleClass("active");
	return false;
	} );
	
	jQuery('#quickpost-anchor').click(function() {
		jQuery('#quickpost-panel').slideToggle(40);
		jQuery(this).toggleClass("active");
		return false;
	} );
	});
	</script>
	<META name="verify-v1" content="j+73ZfK0ZfqL/24QUywKgcbY+Xsr+P/6XUtDJpUl0wc=" />
</head>
<body>
<div id="container">
<?php if(is_user_logged_in()) {?>
<div id="site-quickpost">
	<div id="quickpost-panel">
	<?php
	if( current_user_can( 'publish_posts' ) ) {
		require_once dirname( __FILE__ ) . '/post-form.php';
	}
	?>
	</div>
</div>
<div id="site-meta">
	<div id="meta-panel">
		<ul>
			<?php wp_register();?>
			<li><?php wp_loginout(); ?></li>
		</ul>
	</div>
	<a href="" id="quickpost-anchor">Quick Post</a>
	<a href="" id="meta-anchor">Site Meta</a>
</div>
<?php } ?>
<div id="header">
	<h1><span><a href="<?php bloginfo('home'); ?>"><?php echo get_bloginfo('name'); ?></a></span></h1>
	<p class="description"><span><?php bloginfo('description'); ?></span></p>
</div>

        <ul id="menu">
		<?php if (is_home() || is_single()) : ?>
                <li class="current_page_item"><a href="<?php bloginfo('url'); ?>">Blog</a></li>
                <?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
				<?php wp_register('<li class="admintab page_item">','</li>'); ?>
		<?php else : ?>
                <li class="page_item"><a href="<?php bloginfo('url'); ?>">Blog</a></li>
                <?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
				<?php wp_register('<li class="admintab page_item">','</li>'); ?>
		<?php endif; ?>
        </ul>
<?php if (is_404()){ ?>
<div id="wrapper-404">
<?php }?>
