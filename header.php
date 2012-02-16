<?php
$lblg_meta = get_option('lblg_meta_info');
$lblg_themename = $lblg_meta['themename'];
$lblg_shortname = $lblg_meta['shortname'];
$lblg_options = get_option($lblg_shortname . '_theme_options' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
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

	if ( class_exists('All_in_One_SEO_Pack') || class_exists('HeadSpace_Plugin') || class_exists('Platinum_SEO_Pack') || class_exists('wpSEO') || defined('WPSEO_VERSION') ) {
	?>
	<title><?php wp_title(''); ?></title>
	<?php	
	} else {
	?>
	<title><?php if(is_search()) { echo "Search Results &raquo; "; } else { wp_title('&raquo;', true, 'right'); } ?> <?php bloginfo('name');?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<?php 
	}
	// Support for Ozh's YOURLs short-link plugin.
	// Highly-recommended.
	if (is_single() or is_page()) {
		if(function_exists('wp_ozh_yourls_head_linkrel')){
			wp_ozh_yourls_head_linkrel();
		}
	?>
	<?php } ?>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<div id="container">
<div id="header">
	<div id="titledesc">
		<?php lblg_print_title(); ?>
		<p class="description"><span><?php bloginfo( 'description' ); ?></span></p>
	</div>
	<?php lblg_print_bp_menu(); ?>
</div>
<?php lblg_print_menu(); ?>