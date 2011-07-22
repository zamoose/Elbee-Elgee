<?php 
	/* Start The Loop */ if (have_posts()) { while (have_posts()) { the_post(); ?>
		<?php /* Permalink navigation has to be inside the loop */ if (is_single()) get_template_part('navigation'); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if( !is_single() ) { ?><h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php echo strip_tags(get_the_title()) ?>"><?php the_title(); ?></a></h2>
			<?php } else { ?><h1><?php the_title(); ?></h1><?php } ?>
			<?php lblg_the_postimage(); ?>
			<div class="itemtext">
				<?php if ( is_archive() or is_search() or is_tag() ) {
					the_excerpt();
				} else {
					the_content('Continue reading'. " '" . the_title('', '', false) . "'");
				} ?>
				<div class="postinfo">
					<span class="postmeta">Posted by <?php the_author(); ?> on <a href="<?php the_permalink(); ?>"><?php the_time('F jS, Y'); ?></a> <?php if (!is_single()){ ?>| <span class="commentlink"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span><?php } edit_post_link(' Edit this entry.', '', ''); ?></span>
					<?php if( !is_page() ) { ?>
					<span class="postcats">Posted in <?php the_category(', '); ?></span>
					<?php } ?>
					<?php if( is_single() ){?>
					<span class="posttags"><?php the_tags('Tagged as: ',','); ?></span>
				<?php }?>
				</div>
				<?php wp_link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
			</div>

			<!--
				<?php trackback_rdf(); ?>
			-->
		</div>
	<?php } /* End while */?>
	<?php if(is_home() || is_archive()) get_template_part('navigation'); ?>
	<?php } /*End loop*/ ?>
