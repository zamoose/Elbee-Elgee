<?php
/*
Template Name: Series Archive Page
*/

get_header(); ?>

<div id="allwrapper">
<div id="wrapper">
	<div id="lb-content">
 	    <h2 class="pagetitle">Series</h2>
		<?php wp_serieslist_display(); ?>	
	</div>
</div>
<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
