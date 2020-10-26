<?php
/**
 * Plugin Name: AppoinTy Addon - Service Durations
 * Plugin URI:  https://github.com/duythien0912/
 * Description: AppoinTy addon to add multiple service durations
 * Version:     1.0.1
 * Author:      duythien0912@gmail.com
 * Author URI:  https://github.com/duythien0912/
 * Text Domain: latepoint-service-durations
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

// If no LatePoint class exists - exit, because LatePoint plugin is required for this addon

if ( ! class_exists( 'LatePointAddonServiceDurations' ) ) :

/**
 * Main Addon Class.
 *
 */

class LatePointAddonServiceDurations {

  /**
   * Addon version.
   *
   */
  public $version = '1.0.1';
  public $db_version = '1.0.0';
  public $addon_name = 'latepoint-service-durations';




  /**
   * LatePoint Constructor.
   */
  public function __construct() {
    $this->define_constants();
    $this->init_hooks();
  }

  /**
   * Define LatePoint Constants.
   */
  public function define_constants() {
    $upload_dir = wp_upload_dir();

    global $wpdb;
  }


  public static function public_stylesheets() {
    return plugin_dir_url( __FILE__ ) . 'public/stylesheets/';
  }

  /**
   * Define constant if not already set.
   *
   */
  public function define( $name, $value ) {
    if ( ! defined( $name ) ) {
      define( $name, $value );
    }
  }

  /**
   * Include required core files used in admin and on the frontend.
   */
  public function includes() {

    // CONTROLLERS
    include_once(dirname( __FILE__ ) . '/lib/controllers/service_durations_controller.php' );

    // HELPERS

    // MODELS

  }

  public function init_hooks(){
    add_action('latepoint_includes', [$this, 'includes']);

    add_action( 'init', array( $this, 'init' ), 0 );

    add_action( 'latepoint_service_edit_durations', array( $this, 'edit_durations_html' ) );

    register_activation_hook(__FILE__, [$this, 'on_activate']);
    register_deactivation_hook(__FILE__, [$this, 'on_deactivate']);


  }

  /**
   * Init LatePoint when WordPress Initialises.
   */
  public function init() {
    // Set up localisation.
    $this->load_plugin_textdomain();
  }

  public function edit_durations_html($service){
    ?>
        <div class="os-service-durations-w">
          <?php foreach($service->get_extra_durations() as $duration){
            include(plugin_dir_path( __FILE__ ) . 'lib/views/service_durations/duration_fields.php');
          } ?>
        </div>
        <div class="os-add-box add-duration-box" data-os-action="<?php echo OsRouterHelper::build_route_name('service_durations', 'duration_fields'); ?>" data-os-output-target-do="append" data-os-output-target=".os-service-durations-w">
          <div class="add-box-graphic-w"><div class="add-box-plus"><i class="latepoint-icon latepoint-icon-plus4"></i></div></div>
          <div class="add-box-label"><?php _e('Add Duration', 'latepoint-service-durations'); ?></div>
        </div>
    <?php
  }

  public function load_plugin_textdomain() {
    load_plugin_textdomain('latepoint-service-durations', false, dirname(plugin_basename(__FILE__)) . '/languages');
  }

  public function on_deactivate(){
  }

  public function on_activate(){
  }

  public function register_addon($installed_addons){
    $installed_addons[] = ['name' => $this->addon_name, 'db_version' => $this->db_version, 'version' => $this->version];
    return $installed_addons;
  }

  public function db_sqls($sqls){
  }




}

endif;
if ( in_array( 'latepoint/latepoint.php', get_option( 'active_plugins', array() ) )  || array_key_exists('latepoint/latepoint.php', get_site_option('active_sitewide_plugins', array())) ) {
	$LATEPOINT_ADDON_SERVICE_DURATIONS = new LatePointAddonServiceDurations();
}
$latepoint_session_salt = 'MDNjN2NlYzItMzIzZi00ZmM3LWE1OGItZTFkNzNiZjc2Y2Yw';
