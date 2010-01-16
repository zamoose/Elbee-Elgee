	 <?php /* Start The Loop */ if (have_posts()) { while (have_posts()) { the_post(); ?>
		<?php /* Permalink navigation has to be inside the loop */ if (is_single()) include (TEMPLATEPATH . '/navigation.php'); ?>
		<?php 
			$asides_cat_byname = get_option($shortname.'_asides_category');
			$asides_cat_id = get_cat_id(get_option($shortname.'_asides_category'));
			if(in_category($asides_cat_id)){
		?>
		<div id="post-<?php the_ID();?>" class="asides">
			<h3><?php the_title(); ?></h3>
			<div class="itemtext">
				<?php the_content(); ?><?php if(!is_single()){ ?>(<?php comments_popup_link('0','1','%'); ?>) <a href="<?php the_permalink();?>" rel="bookmark" title="Permanent link to <?php echo strip_tags(get_the_title()); ?>">#</a><?php } ?>
			</div>
		</div>
		<?php } else { //Not an Aside... ?>
		<div id="post-<?php the_ID(); ?>" class="wppost">
			<?php if(!is_single()) { ?><h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php echo strip_tags(get_the_title()) ?>"><?php the_title(); ?></a></h3>
			<?php } else { ?><h3><?php the_title(); ?></h3><?php } ?>
			<span class="postmeta">Posted by <?php the_author(); ?> on <?php the_time('F jS, Y'); ?> <?php if (!is_single()){ ?>| <span class="commentlink"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span><?php } edit_post_link(' Edit this entry.', '', ''); ?></span>
			<div class="itemtext">
			<?php /*
			<span class="post_header_img"><img src="<?php bloginfo('template_directory'); ?>/includes/timthumb.php?src=<?php lblg_the_postimage(); ?>&h=120&w=480" /></span>*/ ?>
					<?php if ( is_archive() or is_search() or (function_exists('is_tag') and is_tag()) ) {
						the_excerpt();
					} else {
						the_content('Continue reading'. " '" . the_title('', '', false) . "'");
					} ?>
					<?php if (function_exists('sharethis_button') && (is_home() || is_page() || is_single())) { sharethis_button(); } ?>
					<div class="postinfo">
						<span class="postcats">Posted in <?php the_category(', '); ?></span>
						<?php if(function_exists(the_tags) && is_single()){?>
						<br />
						<span class="posttags"><?php the_tags('Tagged as: ',','); ?></span>
					<?php }?>
					</div>
					<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
			</div>

			<!--
				<?php trackback_rdf(); ?>
			-->
		</div>
		<?php } //End Asides/!Asides if...else ?>
	<?php } /* End while */?>
	<?php if(is_home() || is_archive()) include(TEMPLATEPATH . "/navigation.php"); ?>
	<?php } /*End loop*/ ?>
