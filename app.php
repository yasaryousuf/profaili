<?php 
/*
Plugin Name: Profile Maker
Description: Building Forms in Wordpress
Author: Yasar Yousuf <yousuf802@gmail.com>
Version: 0.1
Text Domain: profile-maker
*/

define("PFM_PATH", plugin_dir_path( __FILE__ ));
define("PFM_VIEW_PATH", plugin_dir_path( __FILE__ ) . "view/");
define("PFM_ASSETSURL", plugins_url("assets/", __FILE__));

require_once (ABSPATH . 'wp-includes/class-phpass.php');

class Autoloader {
    static public function loader($className) {
        $filename = PFM_PATH . "src/" . str_replace("\\", '/', $className) . ".php";
        if (file_exists($filename)) {
            include($filename);
            if (class_exists($className)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}
spl_autoload_register('Autoloader::loader');
include_once 'functions.php';

//use admin\AdminAction;
add_action('plugins_loaded', array('front\PfmShortCode', 'init'));
add_action('plugins_loaded', array('admin\PfmAction', 'init'));
add_action('plugins_loaded', array('admin\PfmEnqueue', 'init'));
add_action('plugins_loaded', array('admin\PfmAjaxAction', 'init'));
add_action('plugins_loaded', array('admin\PfmFilter', 'init'));
add_action('plugins_loaded', array('admin\PfmCustomPostType', 'init'));
add_action('plugins_loaded', array('admin\PfmMenu', 'init'));
add_action('plugins_loaded', array('admin\AdminAction', 'init'));
add_action('plugins_loaded', array('admin\PfmMetaBox', 'init'));
// add_action('plugins_loaded', array('admin\PfmHook', 'init'));

/**
 * 
 * Add plugin action link on the plugins.php page.
 *
 */
function pluginWelcomePage( $links ) {
	$links = array_merge( array(
		'<a href="' . esc_url( admin_url( '/admin.php?page=profile_maker' ) ) . '">Manage</a>'
	), $links );
	return $links;
}
add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'pluginWelcomePage' );


?>
