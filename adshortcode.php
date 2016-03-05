<?php
/*
Plugin Name: Ad Shortcode
Plugin URI: http://github.com/raulabarca/ad-shortcode
Description: Short code to put Ad where you want in a post or page.
Version: 0.0.1
Author: Raúl Abarca
Author URI: http://raulabarca.com/
*/

if (!defined('WP_CONTENT_URL'))
      define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
if (!defined('WP_CONTENT_DIR'))
      define('WP_CONTENT_DIR', ABSPATH.'wp-content');
if (!defined('WP_PLUGIN_URL'))
      define('WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins');
if (!defined('WP_PLUGIN_DIR'))
      define('WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins');

function activate_adshortcode() {
  add_option('adcode', 'AABBCC');
}

function deactive_adshortcode() {
  delete_option('adcode');
}

function admin_init_adshorcode() {
  register_setting('web_ad_code', 'adcode');
}

function admin_menu_adshortcode() {
  add_options_page('Ad Shortcode', 'Ad Shortcode', 'manage_options', 'adshortcode', 'options_page_adshortcode');
}

function options_page_adshortcode() {
  include(WP_PLUGIN_DIR.'/adshortcode/options.php');
}

function adshortcode() {
  $web_ad_code = get_option('web_ad_code');
  function print_shortcode() {
    return $web_ad_code;
  };
  add_shortcode('ad', 'print_shortcode');
}

register_activation_hook(__FILE__, 'activate_adshortcode');
register_deactivation_hook(__FILE__, 'deactive_adshortcode');

if (is_admin()) {
  add_action('admin_init', 'admin_init_adshorcode');
  add_action('admin_menu', 'admin_menu_adshortcode');
}

if (!is_admin()) {
  add_action('wp_head', 'adshortcode');
}

?>
