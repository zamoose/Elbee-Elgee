<?php
/**
 * This file contains the custom widget classes necessary to register and
 * display the custom widgets supplied with the theme.
 *
 * @package     Elbee-Elgee
 * @copyright   Copyright (c) 2011, Doug Stewart
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since       Elbee-Elgee 1.0
 *
 */

class Lblg_Smart_Recent_Posts_Widget extends WP_Widget {
	function Lblg_Smart_Recent_Posts_Widget(){
		$widget_ops = array('classname' => 'lblg_smart_recent_posts_widget', 'description' => 'A widget that intelligently displays recent posts.' );
		$this->WP_Widget('Lblg_Smart_Recent_Posts_Widget', 'Elbee Elgee Smart Recent Posts', $widget_ops);		
	}
	
	function form( $instance ){
		$title = esc_attr($instance['title']);
		$lb_num_posts = esc_attr($instance['lb_num_posts'])
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('lb_num_posts'); ?>">Number of posts to display:<input class="widefat" id="<?php echo $this->get_field_id('lb_num_posts'); ?>" name="<?php echo $this->get_field_name('lb_num_posts'); ?>" type="text" value="<?php echo $lb_num_posts; ?>" /></label></p>
        <?php
	}
	
	function update( $new_instance, $old_instance ){
 		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		
		if( is_int($new_instance['lb_num_posts']) ){
			$instance['lb_num_posts'] = strip_tags($new_instance['lb_num_posts']);
		} else {
			$instance['lb_num_posts'] = get_option('posts_per_page');
		}
		
		return $instance;	
	}
	
	function widget( $args, $instance ){
		extract($args);
		
		if(is_home()) { 
			$tmp_query_string = 'paged=2&showposts=';
			$tmp_title = 'Recent Posts';
		} else {
			$tmp_query_string = 'paged=1&showposts=';
			$tmp_title = 'On The Front Page';
		}
		
		$tmp_query_string .= $instance['lb_num_posts'];
		$tmp_query = new WP_Query($tmp_query_string);
		
		echo $before_widget;
		if('' != $instance['title']){
			echo $before_title . $instance['title'] . $after_title;
		} else {
			echo $before_title . $tmp_title . $after_title;
		}
		echo '<ul>';

		while ($tmp_query->have_posts()) : $tmp_query->the_post(); ?>
		<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br /> published on <?php the_date("M jS, Y"); ?> in <?php the_category(', '); ?><?php the_excerpt(); ?></li>
		<?php 
		endwhile;

		echo '</ul>';
		echo $after_widget;
	}
}

class  Lblg_BP_Menu_Widget extends WP_Widget {

    function Lblg_BP_Menu_Widget() {
		$widget_ops = array('classname' => 'lblg_bp_menu_widget', 'description' => 'A basic top-level BuddyPress navigation menu.' );
		$this->WP_Widget('Lblg_BP_Menu_Widget', 'Elbee Elgee BP Menu', $widget_ops);
    }

    function form( $instance ) {                          
        $title = esc_attr($instance['title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <?php 
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function widget( $args, $instance ) {         
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
       
        echo $before_widget;
        if ( $title ) echo $before_title . $title . $after_title;
                echo '<ul id="lb-subnav">';
                
                if ( is_user_logged_in() ){
                        bp_get_loggedin_user_nav();                     
                } else {
                        bp_get_displayed_user_nav();
                }
                echo '</ul>';
                
                echo $after_widget;
    }
} // class LBBPMenuWidget

function lblg_widgets_init(){
	if( function_exists('bp_get_loggedin_user_nav') ){
		register_widget( 'Lblg_BP_Menu_Widget' );
	}
	register_widget( 'Lblg_Smart_Recent_Posts_Widget' );
}
add_action( 'widgets_init', 'lblg_widgets_init' );
