<?php
/**
 * @package WP_Analytics
 * @version 1.0
 */
/*
 Plugin Name: Analytics For Wordpress
 Plugin URI: http://wordpress.org/extend/plugins/wpanalytics/
 Description: Integrate google analytics in wordpress
 Author: tomatosoft
 Version: 3.0.1
 Author URI: http://www.tomatosoft.biz/blog/
 */

/*  Copyright 2011  LeLiao  (email : leliao@tomatosoft.biz)

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

class tomatosoft_wp_analytics{

	public function __construct(){
		// show analytics code
		add_action( 'wp_head', array($this, 'show_analytics_code'));
		if(is_admin()){
			// setup menu
			add_action('admin_menu', array($this, 'setup_menu'));
			// setup setting section
			add_action('admin_init', array($this, 'setup_section'));
		}
	}

	public function show_analytics_code() {
		echo get_option('tomatosoft_wp_analytics_code');
	}

	function setup_menu() {
		add_options_page('Wp Analytics Setting', 'WpAnalytics', 'manage_options',
		'tomatosoft_wpanalytics_menu', array($this, 'setting_page_html'));
	}

	function setting_page_html(){
		?>
<div>
	<h2>WP Analytics Settings</h2>
	<form action="options.php" method="post">
	<?php settings_fields('tomatosoft_wp_analytics'); ?>
	<?php do_settings_sections('tomatosoft_wpanalytics_menu'); ?>
		<input name="submit" type="submit" class="button-primary"
			value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
</div>
	<?php
	}

	function setup_section() {
		add_settings_section('tomatosoft_wpanalytics_code_section',
		'Google analytics code',
		array($this, 'section_description'),
		'tomatosoft_wpanalytics_menu');

		add_settings_field('tomatosoft_wpanalytics_code_field',
		'Code',
		array($this, 'code_field_html'),
		'tomatosoft_wpanalytics_menu',
		'tomatosoft_wpanalytics_code_section');

		register_setting('tomatosoft_wp_analytics', 'tomatosoft_wp_analytics_code');
		
		add_settings_section('tomatosoft_wpanalytics_donate_section',
		'If you like it, please donate to support the development',
		array($this, 'section_donate_description'),
		'tomatosoft_wpanalytics_menu');
	}

	function section_description() {
		echo 'Paste google analytics code below';
	}

	function code_field_html() {
		echo '<textarea style="width:100%;height:400px" name="tomatosoft_wp_analytics_code"> ' .  get_option('tomatosoft_wp_analytics_code') . '</textarea>';
	}
	
	function section_donate_description(){
		echo <<<DONATECODE
<a href="http://www.tomatosoft.biz/blog/make-a-donation-to-support-me/" target="_blank">Click to make a donation</a>
<br/><br/>
<a href="http://www.tomatosoft.biz/blog/2011/09/10/integrate-google-analytics-into-wordpress-with-wpanalytics/">Need custom features? Comment on the post here</a>
<br/><br/>
DONATECODE;
			
	}
}

new tomatosoft_wp_analytics();
