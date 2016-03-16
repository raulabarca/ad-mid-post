<?php
/**
 * Plugin Name: Ad Shortcode
 * Plugin URI: https://github.com/raulabarca/ad-shortcode
 * Description: Put your Adsense code in the middle of your wordpress post easily.
 * Version: 1.0.0
 * Author: Raúl Abarca
 * Author URI: http://raulabarca.com
 * License: GPL2
 */

 // Options page
 add_action('admin_menu', 'ad_shortcode_menu');

 function ad_shortcode_menu() {
 	add_menu_page('Ad Shortcode', 'Ad Code Options', 'administrator', 'ad_shortcode_settings', 'ad_shortcode_settings_page', 'dashicons-admin-generic');
 }

 function ad_shortcode_settings_page() {?>
   <div class="wrap">
<h2>Ad Shortcode Plugin Options</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'ad-shortcode-settings-group' ); ?>
    <?php do_settings_sections( 'ad-shortcode-settings-group' ); ?>
    <table class="form-table">
        <p>Add your Ad code:</p>
        <textarea rows="4" cols="40" name="ad_shortcode_name"><?php echo esc_attr( get_option('ad_shortcode_name') ); ?></textarea>
    </table>

    <?php submit_button(); ?>

</form>
<p>Add [adshortcode] where do you want to put your Ad.</p>
</div><?php
 }

 // Register the data
add_action( 'admin_init', 'ad_shortcode_settings' );

function ad_shortcode_settings() {
	register_setting( 'ad-shortcode-settings-group', 'ad_shortcode_name' );
}

// The shortcode is created

function ad_shortcode($content)
  {
    $shortcode = '[adshortcode]';
    $ad = get_option('ad_shortcode_name');
    $modcontent =  preg_replace(array('/[[]/','/]/'), '', $content);
      return preg_replace($shortcode, $ad, $modcontent);
  }
add_filter('the_content', 'ad_shortcode');


?>
