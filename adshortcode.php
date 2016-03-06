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

add_action( 'admin_menu', 'adshortcode' );
function adshortcode_menu() {
    add_options_page( 'Ad Shortcode', 'Ad Shortcode', 'manage_options', 'adshortcode', 'adshortcode_options' );
  }

function ad_mid_content($content) {
    if( !is_single() )
      return $content;
    global $post; $postid = $post->ID;

    global $table_prefix;
    $dbh = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
    $table = $table_prefix.'options';
    $query_cantidad = "SELECT option_value FROM $table WHERE option_name = 'wp_middle_cantidad'";
    $query_adsense = "SELECT option_value FROM $table WHERE option_name = 'wp_middle_adsense'";
    $res_cantidad = $dbh->get_results( $query_cantidad );
    $res_adsense = $dbh->get_results( $query_adsense );

    $data_contenido = $res_cantidad[0]->option_value;
    $word_count = str_word_count(strip_tags($content));

    if($word_count < 190) return $content;

    $content = explode ( "</p>", $content );

    if($data_contenido == 'medio')
    {
      $data_contenido = array(ceil(count($content)/2));
    }else
    {
      $data_contenido = explode(', ', $data_contenido);
    }
    $nuevo_contenido = '';

    for ( $i = 0; $i < count ( $content ); $i ++) {
      if(in_array($i, $data_contenido)){
        $nuevo_contenido .= '<div class="anuncio_titulo" style="margin: 10px 0px !important;display: block;text-align: center;">';
        $nuevo_contenido .= stripslashes($res_adsense[0]->option_value);
        $nuevo_contenido .= '</div>';
      }
      $nuevo_contenido .= $content[$i] . "";
    }
    return $nuevo_contenido;
  }
  add_action('the_content','ad_mid_content' );



?>
