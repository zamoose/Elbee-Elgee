<?php 
/**
 * This file is responsible for displaying both the comment form
 * and the list of comments on a post.
 *
 * @package     Elbee-Elgee
 * @copyright   Copyright (c) 2011, Doug Stewart
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since       Elbee-Elgee 1.0
 *
 */
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
} else {
	?><small>(Comments are closed)</small><?php
}
?>

