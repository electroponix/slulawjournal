<?php
/*
 Plugin Name: Wikiful
 Plugin URI: http://www.zingiri.com/plugins-and-addons/wikiful
 Description: Wikiful is a plugin that integrates the powerfull Mediawiki software with Wordpress.
 Author: zingiri
 Version: 1.0.2
 Author URI: http://www.zingiri.com/
 */

// Pre-2.6 compatibility for wp-content folder location
if (!defined("WP_CONTENT_URL")) {
	define("WP_CONTENT_URL", get_option("siteurl") . "/wp-content");
}
if (!defined("WP_CONTENT_DIR")) {
	define("WP_CONTENT_DIR", ABSPATH . "wp-content");
}


if (!defined("BLOGUPLOADDIR")) {
	$upload=wp_upload_dir();
	define("BLOGUPLOADDIR",$upload['path']);
}

require(dirname(__FILE__).'/includes/parser.inc.php');
require_once(dirname(__FILE__) . '/includes/bridge.class.php');
if (!class_exists('simple_html_dom_node')) require_once(dirname(__FILE__).'/includes/simple_html_dom.php');

$wikiful=new ccBridge('1.0.2','Wikiful','wikiful',dirname(__FILE__));
$wikiful->set('main','div[id=content]');
$wikiful->setSidebar('Navigation','div[id=p-navigation] div');
$wikiful->setSidebar('Search','div[id=p-search] div');
$wikiful->parser->set('href',array('/','URL'));
$wikiful->parser->set('action',array('/'));
$wikiful->parser->set('src',array('/'));
$wikiful->parser->set('',array('URL'));
$wikiful->hideId('siteSub');
$wikiful->hideClass('printfooter');
$wikiful->hideId('jump-to-nav');
add_shortcode( 'wikiful', array($wikiful,'shortcodeHandler') );

$wikiful_version=get_option("wikiful_version");
if ($wikiful->isActive()) {
	add_action("init",array($wikiful,"init"));
	add_filter('the_content', array($wikiful,'content'), 10, 3);
	add_filter('wp_title', array($wikiful,'title'));
	add_action('wp_head',array($wikiful,'header'));
	add_action("widgets_init",array($wikiful,'registerWidgets'));
}
add_action('admin_head',array($wikiful,'admin_header'));
add_action('admin_notices',array($wikiful,'admin_notices'));

register_activation_hook(__FILE__,array($wikiful,'activate'));
register_deactivation_hook(__FILE__,array($wikiful,'deactivate'));


require_once(dirname(__FILE__) . '/includes/http.class.php');
require_once(dirname(__FILE__) . '/controlpanel.php');

