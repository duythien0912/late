<?php
/**
 * Plugin Name: AppoinTy Addon - Locations
 * Plugin URI:  https://github.com/duythien0912/
 * Description: AppoinTy addon for locations
 * Version:     1.0.1
 * Author:      duythien0912@gmail.com
 * Author URI:  https://github.com/duythien0912/
 * Text Domain: latepoint-locations
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

// If no LatePoint class exists - exit, because LatePoint plugin is required for this addon

if ( ! class_exists( 'LatePointAddonLocations' ) ) :

/**
 * Main Addon Class.
 *
 */

class LatePointAddonLocations {

  /**
   * Addon version.
   *
   */
  public $version = '1.0.1';
  public $db_version = '1.0.0';
  public $addon_name = 'latepoint-locations';




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

    add_action( 'latepoint_top_bar_after_actions', [$this, 'add_locations_selector'] );
    add_action( 'latepoint_top_bar_mobile_after_user', [$this, 'add_locations_selector'] );
    add_action( 'latepoint_locations_index', [$this, 'output_locations_index'] );

    add_filter('latepoint_installed_addons', [$this, 'register_addon']);
    add_filter('latepoint_locations_addon_installed', [$this, 'show_locations']);

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

  public function output_locations_index(){
    $locations = new OsLocationModel();
    $locations = $locations->get_results_as_models();
    ?>
    <div class="os-locations-list">
      <?php 
      if($locations){
        foreach($locations as $location){ ?>
          <div class="os-location os-location-status-active">
            <div class="os-location-body">
              <div class="os-location-address">
                <?php if($location->full_address){ ?>
                  <iframe width="100%" height="240" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo urlencode($location->full_address); ?>&output=embed"></iframe>
                <?php } ?>
              </div>

              <div class="os-location-header">
                <h3 class="location-name"><?php echo $location->name; ?></h3>
                <div class="os-location-info"><?php echo $location->full_address; ?></div>
                <a href="<?php echo OsRouterHelper::build_link(OsRouterHelper::build_route_name('locations', 'edit_form'), ['id' => $location->id] ); ?>" class="edit-location-btn">
                  <i class="latepoint-icon latepoint-icon-edit-3"></i>
                  <span><?php _e('Edit', 'latepoint-locations'); ?></span>
                </a>
              </div>
              <div class="os-location-agents">
                <div class="label"><?php _e('Agents:', 'latepoint-locations'); ?></div>
                <?php if($location->connected_agents){ ?>
                  <div class="agents-avatars">
                  <?php foreach($location->connected_agents as $agent){ ?>
                    <div class="agent-avatar" style="background-image: url(<?php echo $agent->avatar_url; ?>)"></div>
                  <?php } ?>
                  </div>
                <?php }else{
                  echo '<a href="'.OsRouterHelper::build_link(OsRouterHelper::build_route_name('locations', 'edit_form'), ['id' => $location->id] ).'" class="no-agents-for-location">'.__('Non Assegnato a Nessuno', 'latepoint-locations').'</a>';
                } ?>
              </div>
            </div>
          </div><?php 
        }
      } ?>
      <a class="create-location-link-w" href="<?php echo OsRouterHelper::build_link(OsRouterHelper::build_route_name('locations', 'new_form') ) ?>">
        <div class="create-location-link-i">
          <div class="add-location-graphic-w">
            <div class="add-location-plus"><i class="latepoint-icon latepoint-icon-plus4"></i></div>
          </div>
          <div class="add-location-label"><?php _e('Aggiungi una Sede', 'latepoint-locations'); ?></div>
        </div>
      </a>
    </div>
    <?php
  }


  public function show_locations($show_locations){
    return true;
  }

  public function add_locations_selector(){
    $locations_for_select = OsLocationHelper::get_locations(OsAuthHelper::get_logged_in_agent_id());
    echo OsLocationHelper::locations_selector_html($locations_for_select);
  }

  public function load_plugin_textdomain() {
    load_plugin_textdomain('latepoint-locations', false, dirname(plugin_basename(__FILE__)) . '/languages');
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
	$LATEPOINT_ADDON_LOCATIONS = new LatePointAddonLocations();
}
$latepoint_session_salt = 'MDNjN2NlYzItMzIzZi00ZmM3LWE1OGItZTFkNzNiZjc2Y2Yw';
