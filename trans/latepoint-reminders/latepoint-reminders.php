<?php
/**
 * Plugin Name: AppoinTy Addon - Reminders
 * Plugin URI:  https://github.com/duythien0912/
 * Description: AppoinTy addon for reminders
 * Version:     1.0.0
 * Author:      duythien0912@gmail.com
 * Author URI:  https://github.com/duythien0912/
 * Text Domain: latepoint-reminders
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

// If no LatePoint class exists - exit, because LatePoint plugin is required for this addon

if ( ! class_exists( 'LatePointAddonReminders' ) ) :

/**
 * Main Addon Class.
 *
 */

class LatePointAddonReminders {

  /**
   * Addon version.
   *
   */
  public $version = '1.0.1';
  public $db_version = '1.0.0';
  public $addon_name = 'latepoint-reminders';




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

    add_action( 'latepoint_reminders_index', [$this, 'output_reminders_index'] );

    add_filter('latepoint_installed_addons', [$this, 'register_addon']);
    add_filter('latepoint_reminders_addon_installed', [$this, 'show_reminders']);

    register_activation_hook(__FILE__, [$this, 'on_activate']);
    register_deactivation_hook(__FILE__, [$this, 'on_deactivate']);


  }


  public function show_reminders($show_reminders){
    return true;
  }


  /**
   * Init LatePoint when WordPress Initialises.
   */
  public function init() {
    // Set up localisation.
    $this->load_plugin_textdomain();
  }

  public function output_reminders_index(){
    $reminders = OsRemindersHelper::get_reminders_arr();
    ?>
    <div class="os-reminders-w">
      <?php foreach($reminders as $reminder){ ?>
        <?php include(LATEPOINT_VIEWS_ABSPATH.'reminders/new_form.php'); ?>
      <?php } ?>
    </div>
    <div class="add-reminder-box" data-os-action="<?php echo OsRouterHelper::build_route_name('reminders', 'new_form'); ?>" data-os-output-target-do="append" data-os-output-target=".os-reminders-w">
      <div class="add-custom-field-graphic-w">
        <div class="add-custom-field-plus"><i class="latepoint-icon latepoint-icon-plus4"></i></div>
      </div>
      <div class="add-custom-field-label"><?php _e('Add Reminder', 'latepoint'); ?></div>
    </div>
    <?php include(LATEPOINT_VIEWS_ABSPATH. 'notifications/_available_vars.php'); ?>
    <?php wp_enqueue_editor(); ?>
    <?php
  }



  public function load_plugin_textdomain() {
    load_plugin_textdomain('latepoint-reminders', false, dirname(plugin_basename(__FILE__)) . '/languages');
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
	$LATEPOINT_ADDON_REMINDERS = new LatePointAddonReminders();
}
$latepoint_session_salt = 'MDNjN2NlYzItMzIzZi00ZmM3LWE1OGItZTFkNzNiZjc2Y2Yw';
