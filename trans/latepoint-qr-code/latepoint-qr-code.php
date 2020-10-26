<?php
/**
 * Plugin Name: AppoinTy Addon - QR Code
 * Plugin URI:  https://github.com/duythien0912/
 * Description: AppoinTy addon for qr code generation on booking confirmation page
 * Version:     1.0.0
 * Author:      duythien0912@gmail.com
 * Author URI:  https://github.com/duythien0912/
 * Text Domain: latepoint-qr-code
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

// If no LatePoint class exists - exit, because LatePoint plugin is required for this addon

if ( ! class_exists( 'LatePointAddonQRCode' ) ) :

/**
 * Main Addon Class.
 *
 */

class LatePointAddonQRCode {

  /**
   * Addon version.
   *
   */
  public $version = '1.0.0';
  public $db_version = '1.0.0';
  public $addon_name = 'latepoint-qr-code';




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

    // HELPERS

    // MODELS

  }

  public function init_hooks(){
    add_action('latepoint_includes', [$this, 'includes']);
    add_action( 'init', array( $this, 'init' ), 0 );
    add_action( 'latepoint_step_confirmation_head_info_before', [$this, 'generate_qr_code'] );

    add_filter('latepoint_installed_addons', [$this, 'register_addon']);

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


  public function generate_qr_code($booking){
    $ical_string = OsBookingHelper::generate_ical_event_string($booking);
    echo '<div class="qr-code-on-confirmation">';
    echo '<div class="qr-code-booking-info">';
      echo '<img src="'.esc_attr('http://chart.apis.google.com/chart?cht=qr&chs=350x350&chld=L&choe=UTF-8&chl='.$booking->id).'">';
      echo '<div class="qr-code-label">'.__('Scan on Arrival', 'latepoint-qr-code').'</div>';
    echo '</div>';
    echo '<div class="qr-code-vevent">';
      echo '<img src="'.esc_attr('http://chart.apis.google.com/chart?cht=qr&chs=350x350&chld=L&choe=UTF-8&chl='.urlencode($ical_string)).'">';
      echo '<div class="qr-code-label">'.__('Point your smartphone camera at the QR code and it will automatically add this appointment to your calendar', 'latepoint-qr-code').'</div>';
    echo '</div>';
    echo '<div class="qr-show-trigger">';
      echo '<div><i class="latepoint-icon latepoint-icon-qrcode"></i></div>';
      echo '<div class="qr-code-trigger-label">'.__('Show QR Code', 'latepoint-qr-code').'</div>';
    echo '</div>';
    echo '</div>';
  }

  public function load_plugin_textdomain() {
    load_plugin_textdomain('latepoint-qr-code', false, dirname(plugin_basename(__FILE__)) . '/languages');
  }

  public function on_deactivate(){
  }

  public function on_activate(){
    if(class_exists('OsDatabaseHelper')) OsDatabaseHelper::check_db_version_for_addons();
  }

  public function register_addon($installed_addons){
    $installed_addons[] = ['name' => $this->addon_name, 'db_version' => $this->db_version, 'version' => $this->version];
    return $installed_addons;
  }





}

endif;
if ( in_array( 'latepoint/latepoint.php', get_option( 'active_plugins', array() ) )  || array_key_exists('latepoint/latepoint.php', get_site_option('active_sitewide_plugins', array())) ) {
	$LATEPOINT_ADDON_QR_CODE = new LatePointAddonQRCode();
}
$latepoint_session_salt = 'MDNjN2NlYzItMzIzZi00ZmM3LWE1OGItZTFkNzNiZjc2Y2Yw';
