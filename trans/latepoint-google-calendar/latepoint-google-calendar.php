<?php
/**
 * Plugin Name: AppoinTy Addon - Google Calendar
 * Plugin URI:  https://github.com/duythien0912/
 * Description: AppoinTy addon for google calendar integration
 * Version:     1.0.8
 * Author:      duythien0912@gmail.com
 * Author URI:  https://github.com/duythien0912/
 * Text Domain: latepoint-google-calendar
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

// If no LatePoint class exists - exit, because LatePoint plugin is required for this addon

if ( ! class_exists( 'LatePointAddonGoogleCalendar' ) ) :

/**
 * Main Addon Class.
 *
 */

class LatePointAddonGoogleCalendar {

  /**
   * Addon version.
   *
   */
  public $version = '1.0.8';
  public $db_version = '1.0.0';
  public $addon_name = 'latepoint-google-calendar';




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
    $this->define( 'LATEPOINT_TABLE_GCAL_EVENTS', $wpdb->prefix . 'latepoint_gcal_events');
    $this->define( 'LATEPOINT_TABLE_GCAL_RECURRENCES', $wpdb->prefix . 'latepoint_gcal_recurrences');

    $this->define( 'LATEPOINT_ADDON_GCAL_IMAGES_URL', LatePointAddonGoogleCalendar::images_url());
  }


  public static function public_stylesheets() {
    return plugin_dir_url( __FILE__ ) . 'public/stylesheets/';
  }

  public static function images_url(){
    return plugin_dir_url( __FILE__ ) . 'public/images/';
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

    // COMPOSER AUTOLOAD
    require (dirname( __FILE__ ) . '/vendor/autoload.php');

    // CONTROLLERS
    include_once(dirname( __FILE__ ) . '/lib/controllers/google_calendar_controller.php' );

    // HELPERS
    include_once(dirname( __FILE__ ) . '/lib/helpers/google_calendar_helper.php' );

    // MODELS
    include_once(dirname( __FILE__ ) . '/lib/models/google_calendar_event_model.php' );
    include_once(dirname( __FILE__ ) . '/lib/models/gcal_event_recurrence_model.php' );

  }

  public function add_menu_links($menus){
    if(!OsAuthHelper::is_admin_logged_in()) return $menus;
    for($i = 0; $i <= count($menus); $i++){
      if(isset($menus[$i]['id']) && ($menus[$i]['id'] == 'settings')) $menus[$i]['children'][] = array( 'label' => __( 'Google Calendar', 'latepoint-google-calendar' ), 'icon' => '', 'link' => OsRouterHelper::build_link(OsRouterHelper::build_route_name('settings', 'calendar_settings')));
    }
    return $menus;
  }

  public function init_hooks(){
    add_action('latepoint_includes', [$this, 'includes']);
    add_action('latepoint_wp_enqueue_scripts', [$this, 'load_front_scripts_and_styles']);
    add_action('latepoint_admin_enqueue_scripts', [$this, 'load_admin_scripts_and_styles']);
    add_action('latepoint_agent_form', [$this, 'agent_form_google_calendar']);
    add_action('latepoint_check_google_cal_watch_channels_refresh', [$this, 'refresh_google_cal_watch_channels']);
    add_action('latepoint_calendar_daily_timeline', [$this, 'daily_timeline'], 10, 2);
    add_action('latepoint_calendar_weekly_timeline', [$this, 'daily_timeline'], 10, 2);
    add_action('latepoint_appointments_timeline', [$this, 'appointments_timeline'], 10, 2);
    add_action('latepoint_booking_updated_admin', [$this, 'process_action_booking_updated'], 10, 2);
    add_action('latepoint_booking_created_admin', [$this, 'process_action_booking_created']);
    add_action('latepoint_booking_updated_frontend', [$this, 'process_action_booking_updated']);
    add_action('latepoint_booking_created_frontend', [$this, 'process_action_booking_created']);

    add_action( 'init', array( $this, 'init' ), 0 );

    add_filter('latepoint_installed_addons', [$this, 'register_addon']);
    add_filter('latepoint_localized_vars_admin', [$this, 'localized_vars_for_admin']);
    add_filter('latepoint_side_menu', [$this, 'add_menu_links']);
    add_filter('latepoint_addons_sqls', [$this, 'db_sqls']);
    add_filter('latepoint_filter_booked_periods', [$this, 'insert_events_into_booked_periods_arr'], 10, 3);
    add_filter('latepoint_filter_booked_periods_for_range', [$this, 'insert_events_into_booked_periods_arr_for_date_range'], 10, 4);

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

  public function load_plugin_textdomain() {
    load_plugin_textdomain('latepoint-google-calendar', false, dirname(plugin_basename(__FILE__)) . '/languages');
  }

  public function process_action_booking_status_changed($booking_id, $old_status){
    OsGoogleCalendarHelper::create_or_update_booking_in_gcal($booking_id);
  }

  public function process_action_booking_created($booking){
    OsGoogleCalendarHelper::create_or_update_booking_in_gcal($booking->id);
  }

  public function process_action_booking_updated($booking, $old_booking = false){
    // if agent changed - remove the event from old agent
    if($old_booking && $old_booking->agent_id != $booking->agent_id){
      OsGoogleCalendarHelper::remove_booking_from_gcal($booking->id, $old_booking->agent_id);
    }
    OsGoogleCalendarHelper::create_or_update_booking_in_gcal($booking->id);
  }

  public function insert_events_into_booked_periods_arr($booked_periods_arr, $target_date, $agent_id){
    $events = OsGoogleCalendarHelper::get_events_for_date($target_date, $agent_id);

    if($events){
      foreach($events as $event){
        $booked_periods_arr[] = $event->start_time. ':' .$event->end_time. ':0:0';
      }
    }
    return $booked_periods_arr;
  }


  public function insert_events_into_booked_periods_arr_for_date_range($booked_periods_arr, $date_from, $date_to, $args){
    if(!$date_from || !$date_to) return $booked_periods_arr;
    if(!isset($args['agent_id']) || empty($args['agent_id'])) return $booked_periods_arr;

    $date_from_obj = new DateTime( $date_from );
    $date_to_obj   = new DateTime( $date_to );

    $agents_arr = (is_array($args['agent_id'])) ? $args['agent_id'] : [$args['agent_id']];

    for($day = clone $date_from_obj; $day <= $date_to_obj; $day->modify('+1 day')){
      foreach($agents_arr as $agent_id){
        $booked_periods_arr['agent_'.$agent_id][$day->format('Y-m-d')] = $this->insert_events_into_booked_periods_arr($booked_periods_arr['agent_'.$agent_id][$day->format('Y-m-d')], $day->format('Y-m-d'), $agent_id);
      }
    }

    return $booked_periods_arr;
  }

  public function appointments_timeline($target_date, $args){
    $agent_id = isset($args['agent_id']) ? $args['agent_id'] : false;
    $events = OsGoogleCalendarHelper::get_events_for_date($target_date->format('Y-m-d'), $agent_id);
    if($events){
      foreach($events as $event){
        if(!$args['work_total_minutes']) continue;
        $width = ($event->end_time - $event->start_time) / $args['work_total_minutes'] * 100;
        $left = ($event->start_time - $args['work_start_minutes']) / $args['work_total_minutes'] * 100;
        
        if($width <= 0 || $left >= 100 || (($left + $width) <= 0)) continue;
        if($left < 0){
          $width = $width + $left;
          $left = 0;
        }
        if(($left + $width) > 100) $width = 100 - $left;

        echo '<div class="booking-block gcal-event-booking-block" style="left: '.$left.'%; width: '.$width.'%"><img src="'.LatePoint::images_url().'google-logo-compact.png"/></div>';
      }
    }
  }


  public function daily_timeline($target_date, $args){
    $agent_id = isset($args['agent_id']) ? $args['agent_id'] : false;
    $events = OsGoogleCalendarHelper::get_events_for_date($target_date->format('Y-m-d'), $agent_id);
    if($events){
      foreach($events as $event){
        if($event->start_time >= $args['work_end_minutes'] || $event->end_time <= $args['work_start_minutes']) continue;
        $event_duration = min($event->end_time, $args['work_end_minutes']) - max($event->start_time, $args['work_start_minutes']);
        $event_duration_percent = $event_duration * 100 / $args['work_total_minutes'];
        $event_start_percent = (max($event->start_time,$args['work_start_minutes']) - $args['work_start_minutes']) / ($args['work_end_minutes'] - $args['work_start_minutes']) * 100;
        if($event_start_percent < 0) $event_start_percent = 0;
        if($event_start_percent >= 100) continue;
        ?>
        <div class="ch-day-booking gcal-calendar-event" style="top: <?php echo $event_start_percent; ?>%; height: <?php echo $event_duration_percent; ?>%;">
          <div class="ch-day-booking-i">
            <div class="booking-service-name">
              <img src="<?php echo LatePoint::images_url().'google-logo-compact.png' ?>" alt="">
              <span><?php echo $event->summary; ?></span>  
            </div>
            <div class="booking-time"><?php echo OsTimeHelper::minutes_to_hours_and_minutes($event->start_time); ?> - <?php echo OsTimeHelper::minutes_to_hours_and_minutes($event->end_time); ?></div>
          </div>
        </div>
        <?php
      }
    }
  }


  public function refresh_google_cal_watch_channels(){
    $agent_meta = new OsAgentMetaModel();
    $channels_data = $agent_meta->where(['meta_key' => 'google_cal_agent_watch_channel'])->get_results_as_models();
    if(!$channels_data) return;
    foreach($channels_data as $channel_data){
      $channel_data_obj = json_decode($channel_data->meta_value);
      $seconds_left = ($channel_data_obj->expiration / 1000) - time();
      // less than 10 days before expiration - refresh
      if($seconds_left < (60*60*24*10)) OsGoogleCalendarHelper::refresh_watch($channel_data->object_id);
    }

  }

  public function on_deactivate(){
    wp_clear_scheduled_hook('latepoint_check_google_cal_watch_channels_refresh');
  }

  public function on_activate(){
    if (! wp_next_scheduled ( 'latepoint_check_google_cal_watch_channels_refresh' )) {
      wp_schedule_event(time(), 'daily', 'latepoint_check_google_cal_watch_channels_refresh');
    }
    if(class_exists('OsDatabaseHelper')) OsDatabaseHelper::check_db_version_for_addons();
  }

  public function register_addon($installed_addons){
    $installed_addons[] = ['name' => $this->addon_name, 'db_version' => $this->db_version, 'version' => $this->version];
    return $installed_addons;
  }

  public function db_sqls($sqls){

    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $sqls[] = "CREATE TABLE ".LATEPOINT_TABLE_GCAL_EVENTS." (
      id int(11) NOT NULL AUTO_INCREMENT,
      summary text,
      start_date date NOT NULL,
      end_date date,
      start_time mediumint(9) NOT NULL,
      end_time mediumint(9),
      agent_id mediumint(9) NOT NULL,
      google_event_id text,
      html_link text,
      created_at datetime,
      updated_at datetime,
      KEY start_date_index (start_date),
      KEY end_date_index (end_date),
      KEY agent_id_index (agent_id),
      PRIMARY KEY  (id)
    ) $charset_collate;";


    $sqls[] = "CREATE TABLE ".LATEPOINT_TABLE_GCAL_RECURRENCES." (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `until` date,
      `lp_event_id` mediumint(9) NOT NULL,
      `frequency` varchar(30),
      `interval` smallint(5),
      `count` smallint(5),
      `weekday` varchar(30),
      `created_at` datetime,
      `updated_at` datetime,
      KEY lp_event_id_index (lp_event_id),
      KEY frequency_index (frequency),
      PRIMARY KEY  (id)
    ) $charset_collate;";
    return $sqls;
  }



  public function agent_form_google_calendar($agent){
	  if(OsGoogleCalendarHelper::is_enabled()){ ?>
		    <div class="white-box">
		      <div class="white-box-header">
						<div class="os-form-sub-header"><h3><?php _e('Google Calendar Setup', 'latepoint-google-calendar'); ?></h3></div>
		      </div>
		      <div class="white-box-content">
            <?php if(OsGoogleCalendarHelper::is_agent_connected_to_gcal($agent->id)){ ?>
              <div class="channel-watch-status watch-status-on">
                <div class="status-watch-label">
                  <i class="latepoint-icon latepoint-icon-check"></i>
                  <span class="cw-status"><?php _e('LatePoint is Connected to', 'latepoint-google-calendar'); ?></span>
                  <?php echo OsFormHelper::select_field('selected_google_calendar_id', false, OsGoogleCalendarHelper::get_list_of_calendars_for_select($agent->id), OsGoogleCalendarHelper::get_selected_calendar_id($agent->id), ['class' => 'agent_google_calendar_selector', 'data-agent-id' => $agent->id, 'data-route' => OsRouterHelper::build_route_name('google_calendar', 'change_agent_calendar')]); ?>
                  <span><?php _e('Google Calendar', 'latepoint-google-calendar'); ?></span>
                </div>
                <a href="<?php echo OsRouterHelper::build_link(['google_calendar', 'list_bookings_for_sync'], ['agent_id' => $agent->id]); ?>" 
                        class="latepoint-link cw-enable">
                    <span class="latepoint-icon latepoint-icon-calendar"></span>
                    <span><?php _e('Open Event Manager', 'latepoint-google-calendar'); ?></span>
                </a>
                <a href="#" class="os-google-cal-signout-btn latepoint-link cw-danger" style="margin-left: auto;" 
                            data-os-prompt="<?php _e('Are you sure you want to disconnect Google Calendar? All events imported from Google Calendar will be removed.', 'latepoint-google-calendar'); ?>"  
                            data-os-success-action="reload" 
                            data-os-action="<?php echo OsRouterHelper::build_route_name('google_calendar', 'disconnect'); ?>" 
                            data-os-params="<?php echo OsUtilHelper::build_os_params(['agent_id' => $agent->id]) ?>" >
                  <span class="latepoint-icon latepoint-icon-slash"></span>
                  <span><?php _e('Disconnect', 'latepoint-google-calendar');?> </span>
                </a>
              </div>
            <?php }else{ ?>
              <div class="channel-watch-status watch-status-off">
                <div class="status-watch-label">
                  <i class="latepoint-icon latepoint-icon-bell-off"></i>
                  <span class="cw-status"><?php _e('Google Calendar is not Connected', 'latepoint-google-calendar'); ?></span>
                </div>
                <a href="#" class="os-google-cal-authorize-btn cw-enable" 
                            data-agent-id="<?php echo $agent->id; ?>" 
                            data-route="<?php echo OsRouterHelper::build_route_name('google_calendar', 'connect'); ?>">
                  <img src="<?php echo LATEPOINT_ADDON_GCAL_IMAGES_URL.'google_signin_btn.png'; ?>"/>
                </a>
              </div>
            <?php } ?>
					</div>
				</div>
	  <?php }
  }

  public function load_front_scripts_and_styles(){

  }

  public function load_admin_scripts_and_styles($localized_vars){
    if(OsGoogleCalendarHelper::is_enabled()){
      wp_enqueue_script( 'google-api', 'https://apis.google.com/js/api.js', false );
    }

    // Stylesheets
    wp_enqueue_style( 'latepoint-google-calendar', $this->public_stylesheets() . 'latepoint-google-calendar.css', false, $this->version );
  }


  public function localized_vars_for_admin($localized_vars){
    // Google Calendar
    if(OsGoogleCalendarHelper::is_enabled()){
      $localized_vars['google_calendar_is_enabled'] = true;
      $localized_vars['google_calendar_client_id'] = OsSettingsHelper::get_settings_value('google_calendar_client_id');
    }else{
      $localized_vars['google_calendar_is_enabled'] = false;
    }
    return $localized_vars;
  }

}

endif;

if ( in_array( 'latepoint/latepoint.php', get_option( 'active_plugins', array() ) )  || array_key_exists('latepoint/latepoint.php', get_site_option('active_sitewide_plugins', array())) ) {
	$LATEPOINT_ADDON_GOOGLE_CALENDAR = new LatePointAddonGoogleCalendar();
}
