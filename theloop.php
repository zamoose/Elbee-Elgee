<?php lblg_before_loop(); ?>
<?php 
	/* Start The Loop */ if (have_posts()) { while (have_posts()) { the_post(); ?>
		<?php /* Permalink navigation has to be inside the loop */ if (is_single()) get_template_part('navigation'); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php lblg_before_post_title(); ?>
			
			<?php lblg_the_title(); ?>

			<?php lblg_before_itemtext(); ?>
			<div class="itemtext">
				<?php 
				if ( is_archive() or is_search() or is_tag() ) {
					the_excerpt();
				} else {
					the_content('Continue reading'. " '" . the_title('', '', false) . "'");
				}
				wp_link_pages( array( 'before' => '<div class="post-pagination">Pages: ', 'after' => '</div>', 'next_or_number' => 'number')); 
				?>
			</div>
			<?php lblg_after_itemtext(); ?>
			<!--
				<?php trackback_rdf(); ?>
			-->
		</div>
	<?php } /* End while */?>
	<?php if(is_home() || is_archive()) get_template_part('navigation'); ?>
	<?php } /*End loop*/ ?>
<?php lblg_after_loop(); ?>