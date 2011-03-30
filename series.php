<?php
/*
Template Name: Series Archive Page
*/

get_header(); ?>

<div id="allwrapper">
<div id="wrapper">
	<div id="lb-content">
 	    <h2 class="pagetitle">Archive for the &#8216;<?php single_series_title(); ?>&#8217; Series</h2>
		
		<p><?php //echo series_description(); ?></p>
	 	   <?php 
				get_template_part('theloop'); 

				get_template_part('navigation');
			?>
		
	</div>
</div>
<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
