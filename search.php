<?php
/*
Template Name: Search
*/

get_header(); ?>

<div id="allwrapper">
<div id="wrapper">
	<div id="lb-content">
	<?php if ( have_posts() ) : ?>

			<h1 class="searchresults"><?php printf( __( 'Search Results for: %s', 'lblgtextdomain' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php lblg_before_post_title(); ?>
				<?php if( !is_single() && !is_page() ) { ?><h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php echo strip_tags(get_the_title()) ?>"><?php the_title(); ?></a></h2>
				<?php } else { ?><h1><?php the_title(); ?></h1><?php } ?>

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


		<?php endwhile;
		get_template_part('navigation');
		else : ?>
		<h1 class="searchresults"><?php printf( __( 'Nothing matching "%s" found.', 'lblgtextdomain' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		<div class="itemtext">
			<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'lblgtextdomain' ); ?></p>
			<?php 
			echo get_search_form();
			?>
		</div>

	<?php endif; ?>
	</div><!-- #lb-content -->
</div><!-- #wrapper -->

<?php get_sidebar(); ?>

</div><!-- #allwrapper -->

<?php get_footer(); ?>
