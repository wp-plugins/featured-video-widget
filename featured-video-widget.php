<?php
/*
Plugin Name: Featured Video Widget
Plugin URI: http://wp-time.com/featured-video-widget/
Description: Add featured Youtube or Vimeo or Keek video in your sidebar easily, responsive and customize height.
Version: 1.3
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


// WP Time Menu
if( !function_exists('WPTime_Add_Admin_Bar_Menu_Aff') ) {

	function WPTime_Add_Admin_Bar_Menu_Aff() {

		global $wp_admin_bar;

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-parent',
				'parent'	=>		0,
				'title' 	=> 		'WP Time',
				'href' 		=> 		'http://wp-time.com',
				'meta'		=>		array('target' => '_blank')
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-gl',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'Best Gallery & Portfolio WordPress Plugins',
				'href' 		=> 		'http://j.mp/GL_WPTime',
				'meta'		=>		array('target' => '_blank')
			)
		);
		
		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-et',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'Collection Of 87 WP Themes For $69 Only',
				'href' 		=> 		'http://j.mp/ET_WPTime_ref_pl',
				'meta'		=>		array('target' => '_blank')
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-cm',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'WP Themes On Creative Market',
				'href' 		=> 		'http://j.mp/CM_WPTime',
				'meta'		=>		array('target' => '_blank')
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-tf',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'WP Themes On Themeforest',
				'href' 		=> 		'http://j.mp/TF_WPTime',
				'meta'		=>		array('target' => '_blank')
			)
		);
	
		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-cc',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'WP Plugins On Codecanyon',
				'href' 		=> 		'http://j.mp/CC_WPTime',
				'meta'		=>		array('target' => '_blank')
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-bh',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'Unlimited Web Hosting For $3.95 Only',
				'href' 		=> 		'http://j.mp/BH_WPTime',
				'meta'		=>		array('target' => '_blank')
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-cas',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'Contact And Support',
				'href' 		=> 		'http://wp-time.com/contact/',
				'meta'		=>		array('target' => '_blank')
			)
		);

	}
	
	add_action( 'wp_before_admin_bar_render', 'WPTime_Add_Admin_Bar_Menu_Aff');

}


// WP Time Page
if( !function_exists('WP_Time_Ghozylab_Aff') ) {
	function WP_Time_Ghozylab_Aff() {
		add_menu_page( 'WP Time', 'WP Time', 'update_core', 'WP_Time_Ghozylab_Aff', 'WP_Time_Ghozylab_Aff_Page');
		function WP_Time_Ghozylab_Aff_Page() {
			?>
            	<div class="wrap">
                	<h2>WP Time</h2>
					<div class="tool-box">
                		<h3 class="title">Thanks for using our plugins!</h3>
                    	<p>For more plugins, please visit <a href="http://wp-time.com" target="_blank">WP Time Website</a> and <a href="https://profiles.wordpress.org/qassimdev/#content-plugins" target="_blank">WP Time profile on WordPress</a>.</p>
                        <p>For contact or support, please visit <a href="http://wp-time.com/contact/" target="_blank">WP Time Contact Page</a>.</p>
					</div>
					<div class="tool-box">
						<h3 class="title">Great WordPress Plugins</h3>
						<p>Best Gallery & Portfolio WordPress Plugins <a href="http://j.mp/GL_WPTime" target="_blank">Download Now</a>.</p>
                        <p><a href="http://j.mp/GL_WPTime" target="_blank"><img src="http://content.ghozylab.com/partners/aff/images/global-aff-img.png" width="728" height="90"></a></p>
					</div>
                </div>
			<?php
		}
	}
	add_action( 'admin_menu', 'WP_Time_Ghozylab_Aff' );
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