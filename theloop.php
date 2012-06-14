<?php
/**
 * Template Name: The Loop
 * @package 	Elbee-Elgee
 * @copyright	Copyright (c) 2011, Doug Stewart
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Elbee-Elgee 1.0
 */

lblg_before_loop(); ?>
<?php 
	/* Start The Loop */ 
	if (have_posts()) { 
		while (have_posts()) { 
			the_post();
			/* Permalink navigation has to be inside the loop */ 
			if (is_single()) get_template_part('navigation'); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php lblg_before_post_title(); ?>
			
			<?php lblg_the_title(); ?>

			<?php lblg_before_itemtext(); ?>
			<div class="itemtext">
				<?php 
				if ( is_archive() or is_search() or is_tag() ) {
					the_excerpt();
					echo "<a href=\"";
					the_permalink();
					echo "\">Continue reading '" . the_title('', '', false) . "'</a>";
				} else {
					the_content('Continue reading'. " '" . the_title('', '', false) . "'");
					wp_link_pages( array( 'before' => '<div class="post-pagination">Pages: ', 'after' => '</div>', 'next_or_number' => 'number')); 
				}
				?>
			</div>
			<?php lblg_after_itemtext(); ?>
			<!--
				<?php trackback_rdf(); ?>
			-->
		</div>
	<?php } /* End while */
		if(is_home() || is_archive()) get_template_part('navigation');
	} /*End loop*/
	
	lblg_after_loop(); 
