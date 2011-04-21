<?php 
if( have_comments() ) { ?>
	<h2 id="comments"><?php comments_number(); ?></h2>

		<ol class="commentlist">
			<?php wp_list_comments(); ?>
		</ol>
<?php 
	paginate_comments_links();
}
?>

<?php 
if( comments_open() ){
	comment_form(); 
}
?>

