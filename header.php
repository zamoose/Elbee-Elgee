<?php
global $themename, $shortname;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

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
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	<meta name="description" content="<?php bloginfo('description'); ?>" />

	<?php if (is_single() or is_page()) {
		if(function_exists('wp_ozh_yourls_head_linkrel')){
			wp_ozh_yourls_head_linkrel();
		}
	?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php } ?>

	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" />
	<?php
		$layout_style = get_option($shortname.'_layout_stylesheet');
		$alt_style = get_option($shortname.'_alt_stylesheet');
		switch($layout_style){
			case '':
			case 'Select a layout:':
				echo '<link rel="stylesheet" type="text/css" media="screen" href="' . get_template_directory_uri() . '/layouts/2-columns-fixed-sb-right.css" />';
			break;
			case '*none*':
			break;
			default:
				echo '<link rel="stylesheet" type="text/css" media="screen" href="' . get_template_directory_uri() . '/layouts/' . $layout_style . '" />';
			break;

		}

		echo "\n\t";
		
		switch($alt_style){
			case '':
			case 'Select a stylesheet:':
				echo '<link rel="stylesheet" type="text/css" media="screen" href="'. get_template_directory_uri() .'/styles/ng.css" />';
			break;
			case '*none*':
			break;
			default:
				echo '<link rel="stylesheet" type="text/css" media="screen" href="'. get_template_directory_uri() .'/styles/'. $alt_style .'" />';
			break;
		}
		
		echo "\n";
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/print.css" media="print">
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<div id="container">
<div id="header">
	<div id="blogtitle">
		<?php lblg_print_title(); ?>
		<p class="description"><span><?php bloginfo('description'); ?></span></p>
	</div>
</div>
<?php lblg_print_menu(); ?>