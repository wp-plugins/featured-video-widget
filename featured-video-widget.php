<?php
/*
Plugin Name: Featured Video Widget
Plugin URI: http://wp-time.com
Description: Add featured Youtube or Vimeo or Keek video in your sidebar easily, responsive and customize height.
Version: 1.0.2
Author: Qassim Hassan
Author URI: http://qass.im
License: GPLv2 or later
*/

/*  Copyright 2015  Qassim Hassan  (email : qassim.pay@gmail.com)

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


// WP Time
if( !function_exists('WP_Time') ) {
	function WP_Time() {
		add_menu_page( 'WP Time', 'WP Time', 'update_core', 'WP_Time', 'WP_Time_Page', 'dashicons-admin-links');
		function WP_Time_Page() {
			?>
            	<div class="wrap">
                	<h2>WP Time</h2>
					<div class="tool-box">
                		<h3 class="title">Thanks for using our plugins!</h3>
                    	<p>For more plugins, please visit <a href="http://wp-time.com" title="Our Website" target="_blank">WP Time Website</a> and <a href="https://profiles.wordpress.org/qassimdev/#content-plugins" title="Our profile on WordPress" target="_blank">WP Time profile on WordPress</a>.</p>
                        <p>For contact or support, please visit <a href="http://wp-time.com/contact/" title="Contact us!" target="_blank">WP Time Contact Page</a>.</p>
                        <p>Follow WP Time owner on <a href="https://twitter.com/Qassim_Dev" title="Follow him!" target="_blank">Twitter</a>.</p>
					</div>
					<div class="tool-box">
						<h3 class="title">Beautiful WordPress Themes</h3>
						<p>Get collection of 87 WordPress themes for only $69, a lot of features and free support! <a href="http://j.mp/et_ref_wptimeplugins" title="Get it now!" target="_blank">Get it now</a>.</p>
                        <p>See also <a href="http://j.mp/cm_ref_wptimeplugins" title="CreativeMarket - WordPress themes" target="_blank">CreativeMarket</a> and <a href="http://j.mp/tf_ref_wptimeplugins" title="Themeforest - WordPress themes" target="_blank">Themeforest</a>.</p>
                        <p><a href="http://j.mp/et_ref_wptimeplugins" title="Get collection of 87 WordPress themes for only $69" target="_blank"><img src="http://www.elegantthemes.com/affiliates/banners/570x100.jpg"></a></p>
					</div>
                </div>
			<?php
		}
	}
	add_action( 'admin_menu', 'WP_Time' );
}


// Featured Video Widget
class QassimFeaturedVideoWidget extends WP_Widget {
	function QassimFeaturedVideoWidget() {
		parent::__construct( false, 'Featured Video', array('description' => 'Display featured video from youtube or vimeo or keek.') );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'];
		$video = $instance['videolink'];
		$height = $instance['height'];
		
		if( empty($height) ){
			$height = '220';
		}

		?>
            <?php 
			if( !empty($video) ){
				if( preg_match("/(youtube.com)+/", $video) or preg_match("/(youtu.be)+/", $video) ){
					$protocol 	= array('http://', 'https://', 'www.', 'youtube.com', 'youtu.be', 'embed', 'watch?v=', '/');
					$video_link = str_replace($protocol, '', $video);
					$the_result = '<iframe style="width:100%;max-width:100%;display:block;height:'.$height.'px;" src="http://youtube.com/embed/'.$video_link.'" allowfullscreen></iframe>';
				}
				elseif( preg_match("/(vimeo.com)+/", $video) ){
					$protocol 	= array('http://', 'https://', 'www.', 'vimeo.com', '/');
					$video_link = str_replace($protocol, '', $video);
					$the_result = '<iframe style="width:100%;max-width:100%;display:block;height:'.$height.'px;" src="http://player.vimeo.com/video/'.$video_link.'" allowfullscreen></iframe>';
				}
				elseif( preg_match("/(keek.com)+/", $video) ){
					$regex = array("/.*\\/(?=[^\\/]*\\/)|\\//m");
					$preg_replace = preg_replace($regex, "", $video);
					$str_replace = str_replace("keek", "", $preg_replace);
					$video_link = "https://www.keek.com/keek/$str_replace/embed?autoplay=0&mute=0&controls=1&loop=0";
					$the_result = '<iframe style="width:100%;max-width:100%;display:block;height:'.$height.'px;" src="'.$video_link.'" allowfullscreen></iframe>';
				}else{
					$the_result = '<ul><li>Error video link! Please add youtube or vimeo or keek video link only.</li></ul>';
				}
			}else{
				$the_result = '<ul><li>Please add youtube or vimeo or keek video link.</li></ul>';
			}
			?>
            
			<?php echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; ?>
            
			<?php echo $the_result; ?>
            
            <?php echo  $args['after_widget']; ?>
        <?php
	}//widget
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['videolink'] = strip_tags($new_instance['videolink']);
		$instance['height'] = strip_tags($new_instance['height']);
		return $instance;
	}//update
	
	function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance
		);
		
		$defaults = array(
			'title' 	=> 'Featured Video',
			'videolink' => '',
			'height' 	=> '220'
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$videolink = $instance['videolink'];
		$height = $instance['height'];
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
            
			<p>
				<label for="<?php echo $this->get_field_id('videolink'); ?>">Video Link:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id('videolink'); ?>" name="<?php echo $this->get_field_name('videolink'); ?>" type="text" value="<?php echo $videolink; ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('height'); ?>">Height:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" />
			</p>
        <?php
		
	}//form
	
}
add_action('widgets_init', create_function('', 'return register_widget("QassimFeaturedVideoWidget");') );

?>