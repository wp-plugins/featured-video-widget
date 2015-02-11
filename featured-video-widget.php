<?php
/*
Plugin Name: Featured Video Widget
Plugin URI: http://qass.im/my-plugins/
Description: Add featured Youtube or Vimeo or Keek video in your sidebar easily, responsive and customize height.
Version: 1.0.1
Author: Qassim Hassan
Author URI: http://qass.im/
License: GPLv2 or later
*/

/*  Copyright 2014  Qassim Hassan  (email : qassim.pay@gmail.com)

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