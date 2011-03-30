<?php
/*
Template Name: Lifestream
*/
?>
<?php get_header(); ?>

<div id="allwrapper">
<div id="wrapper">
	<div id="lb-content">
	<h3>Lifestream</h3>
		<?php 
			if(function_exists('simplelife')){
				simplelife();
			}

			if(function_exists('lifestream')){
				lifestream();
			}
		?>
	</div>
</div>

<?php get_sidebar(); ?>

</div>
<?php get_footer(); ?>
