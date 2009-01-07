<?php
/*
Template Name: Series Archive Page
*/

get_header(); ?>

<div id="wrapper">
	<div id="content">
 	    <h2 class="pagetitle">Archive for the &#8216;<?php single_series_title(); ?>&#8217; Series</h2>
		
		<p><?php //echo series_description(); ?></p>
	 	   <?php 
				include( TEMPLATEPATH . '/theloop.php'); 

				include(TEMPLATEPATH . "/navigation.php");
			?>
		
	</div>
</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>