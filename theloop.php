	 <?php /* Start The Loop */ if (have_posts()) { while (have_posts()) { the_post(); ?>
		<?php /* Permalink navigation has to be inside the loop */ if (is_single()) include (TEMPLATEPATH . '/navigation.php'); ?>
		<div id="post-<?php the_ID(); ?>" class="wppost">
			<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php echo strip_tags(get_the_title()) ?>"><?php the_title(); ?></a></h3>	
			<span class="postmeta">Posted by <?php the_author(); ?> on <?php the_time('F jS, Y'); ?> | <span class="commentlink"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span><?php edit_post_link(' | Edit this entry.', '', ''); ?></span>
			<script src="http://feeds.feedburner.com/~s/literalbarrage?i=<?php the_permalink() ?>" type="text/javascript" charset="utf-8"></script>
			<div class="itemtext">
				<?php 
					$time = get_the_time('M d Y');
					list($mo, $da, $ye) = explode(" ", $time);
				?>
				<!--acronym class="published" title="<?php the_time('Y-m-d\TG:i:sO'); ?>">
					<span class="pub-month"><?php echo($mo); ?></span>
					<span class="pub-date"><?php echo($da); ?></span>
					<span class="pub-year"><?php echo($ye); ?></span>
				</acronym-->
					<?php if ( is_archive() or is_search() or (function_exists('is_tag') and is_tag()) ) {
						the_excerpt();
					} else {
						the_content('Continue reading'. " '" . the_title('', '', false) . "'");
					} ?>
					<div class="postinfo">
						<span class="postcats">Posted in <?php the_category(', '); ?></span>
					</div>
					<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
			</div>

			<!--
				<?php trackback_rdf(); ?>
			-->
		</div>
	<?php } /* End while */?>
	<?php if(is_home() || is_archive()) include(TEMPLATEPATH . "/navigation.php"); ?>
	<?php } /*End loop*/ ?>
