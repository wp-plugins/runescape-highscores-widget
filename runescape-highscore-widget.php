<?php
/*
Plugin Name: Runescape Highscore Widget
Plugin URI: 
Description: Display your Runescape Highscores
Author: Silabsoft
Version: 0.1
Author URI: http://silabsoft.org

/*  Copyright 2012  Silabsoft  (email : admin@silabsoft.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 * Adds Foo_Widget widget.
 */
class Runescape_Highscore_Widget extends WP_Widget {
    /**
     * PHP 4 constructor
     */
    function Runescape_Highscore_Widget() {
        Runescape_Highscore_Widget::__construct();
    }

    /**
     * PHP 5 constructor
     */
    function __construct() {
        $widget_ops = array('classname' => 'rs-hs-widget', 'description' => __('Display your Runescape Highscores'));
        parent::__construct(
	 		'rs-hs-widget', // Base ID
			'Runescape Highscore Widget', // Name
            $widget_ops
		);
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
		$imagedir = plugins_url('images/', __FILE__);
        extract($args);
        $username = $instance['username'];
        $show_activities = $instance['show_activities'];
        $title = "$username";

        echo $before_widget;
        echo $before_title . $title . $after_title;
		echo '<script src="' . plugins_url('runescape.js', __FILE__) . '" type="text/javascript"> </script>'; //In the future should probably use the Enqueue script function.
        echo '<div class="score_list"><ul id="rs-highscores" style="list-style:none">';
        echo '<li id="rs-loading">Fetching Highscores...</li>';
        echo '</ul>';
		echo '<a href="http://services.runescape.com/m=hiscore/compare.ws?user1='.$username.'" title="View '.$username.' highscore listings at runescape.com">'.$username.'@ Runescape</a>';	
		echo '</div>';
?>
<script type="text/javascript">
	runescape.showHighscore({
		user: '<?php echo $username; ?>',
		show_activities: <?php echo empty($show_activities) ? "false" : "true"; ?>,
	});
</script>
<?php
		echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['username'] = strip_tags($new_instance['username']);
        $instance['show_activities'] = $new_instance['show_activities'];
        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'username' => '', 'show_activities' => ''));
        $username = strip_tags($instance['username']);
        $show_activities = $instance['show_activities'];
        echo '<p><label for="'. $this->get_field_id('username') . '">' . __('Username') . ':';
        echo '<input class="widefat" id="' . $this->get_field_id('username') . '" ';
        echo 'name="' . $this->get_field_name('username') . '" type="text" ';
        echo 'value="' . attribute_escape($username) . '" />';
        echo '</label></p>';
        echo '<p><label for="' . $this->get_field_id('show_activities') . '">' . __('Show Activities') . ':';
        echo '<input class="checkbox" id="' . $this->get_field_id('show_activities') . '" ';
        echo 'name="' . $this->get_field_name('show_activities') . '" type="checkbox" value="true"';
        if($show_activities)
			echo ' checked';
		echo '/>';
        echo '</label></p>';
    }

} // class Foo_Widget

add_action( 'widgets_init', create_function( '', 'register_widget( "runescape_highscore_widget" );' ) );
wp_register_style( 'rs-highscore-style', plugins_url('stylesheet.css', __FILE__) );
wp_enqueue_style('rs-highscore-style');
?>
