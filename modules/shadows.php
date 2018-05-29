<?php
/*
 * Plugin name: Shadows
 * Description: Add a page to list shadows and transfer data between them and
 * production.
 * TODO: Should we also prevent the loading of this module in WP Network sites
 * to prevent disaster?
 */

namespace Seravo;

require_once dirname( __FILE__ ) . '/../lib/helpers.php';
require_once dirname( __FILE__ ) . '/../lib/shadows-ajax.php';

if ( ! class_exists('Shadows') ) {
  class Shadows {

    public static function load() {
      // Load only in production
      if ( Helpers::is_production() ) {
        add_action( 'admin_menu', array( __CLASS__, 'register_shadows_page' ) );
        wp_register_script( 'seravo_shadows', plugin_dir_url( __DIR__ ) . '/js/shadows.js' );
        wp_enqueue_script( 'seravo_shadows' );
        add_action( 'wp_ajax_seravo_reset_shadow' , 'seravo_reset_shadow' );
      }
    }
    public static function register_shadows_page() {
      add_submenu_page( 'tools.php', __('Shadows', 'seravo'),
      __('Shadows', 'seravo'), 'manage_options', 'shadows_page',
      array( __CLASS__, 'load_shadows_page' ) );
    }
    public static function load_shadows_page() {
      require_once dirname( __FILE__ ) . '/../lib/shadows-page.php';
    }
  }
  Shadows::load();
}
