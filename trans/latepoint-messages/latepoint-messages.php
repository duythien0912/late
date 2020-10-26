<?php
/**
 * Plugin Name: AppoinTy Addon - Messages
 * Plugin URI:  https://github.com/duythien0912/
 * Description: AppoinTy addon for messaging
 * Version:     1.0.1
 * Author:      duythien0912@gmail.com
 * Author URI:  https://github.com/duythien0912/
 * Text Domain: latepoint-messages
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

// If no LatePoint class exists - exit, because LatePoint plugin is required for this addon

if ( ! class_exists( 'LatePointAddonMessages' ) ) :

/**
 * Main Addon Class.
 *
 */

class LatePointAddonMessages {

  /**
   * Addon version.
   *
   */
  public $version = '1.0.1';
  public $db_version = '1.0.0';
  public $addon_name = 'latepoint-messages';




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

    $this->define( 'LATEPOINT_TABLE_MESSAGES', $wpdb->prefix . 'latepoint_messages');

    $this->define( 'LATEPOINT_MESSAGE_CONTENT_TYPE_TEXT', 'text');
    $this->define( 'LATEPOINT_MESSAGE_CONTENT_TYPE_ATTACHMENT', 'attachment');
  }


  public static function public_stylesheets() {
    return plugin_dir_url( __FILE__ ) . 'public/stylesheets/';
  }

  public static function public_javascripts() {
    return plugin_dir_url( __FILE__ ) . 'public/javascripts/';
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

    // CONTROLLERS
    include_once(dirname( __FILE__ ) . '/lib/controllers/messages_controller.php' );

    // HELPERS
    include_once(dirname( __FILE__ ) . '/lib/helpers/messages_helper.php' );

    // MODELS
    include_once(dirname( __FILE__ ) . '/lib/models/message_model.php' );

  }


  public function init_hooks(){
    add_action('latepoint_includes', [$this, 'includes']);
    add_action('latepoint_wp_enqueue_scripts', [$this, 'load_front_scripts_and_styles']);
    add_action('latepoint_admin_enqueue_scripts', [$this, 'load_admin_scripts_and_styles']);
    add_action('latepoint_booking_quick_form_after', [$this, 'output_messages_on_quick_form']);
    add_action('latepoint_customer_dashboard_after_tabs', [$this, 'output_messages_tab_on_customer_dashboard']);
    add_action('latepoint_customer_dashboard_after_tab_contents', [$this, 'output_messages_tab_contents_on_customer_dashboard']);
    add_action('latepoint_after_agent_email_notification_templates', [$this, 'agent_email_notification_template_settings']);
    add_action('latepoint_after_customer_email_notification_templates', [$this, 'customer_email_notification_template_settings']);

    add_action('latepoint_available_vars_booking',[$this, 'add_messages_vars'], 15);

    add_filter('latepoint_installed_addons', [$this, 'register_addon']);
    add_filter('latepoint_addons_sqls', [$this, 'db_sqls']);

    // addon specific filters

    add_action( 'init', array( $this, 'init' ), 0 );

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
    load_plugin_textdomain('latepoint-messages', false, dirname(plugin_basename(__FILE__)) . '/languages');
  }


  public function add_messages_vars(){
    echo '<li><span class="var-label">'.__('Message Content:', 'latepoint-messages').'</span> <span class="var-code os-click-to-copy">{message_content}</span></li>';
  }


  public function output_messages_on_quick_form($booking){
    if($booking->is_new_record()) return false;
    $messages = OsMessagesHelper::get_messages_for_booking_id($booking->id);
    echo '<div class="booking-messages-info-w" data-booking-id="'.$booking->id.'" data-route="'.OsRouterHelper::build_route_name('messages', 'chat_box').'">';
      echo '<div class="os-form-sub-header"><h3>'.__('Messages', 'latepoint-messages').'</h3></div>';
      echo '<div class="os-booking-messages-w">';
      if($messages){
        echo '<div class="os-bm-open-quick-messages">
                <i class="latepoint-icon latepoint-icon-message-circle"></i>
                <span>'.sprintf(__('Read %d Messages', 'latepoint-messages'), count($messages)).'</span>
              </div>';
      }else{
        echo '<div class="os-bm-open-quick-messages">
                <i class="latepoint-icon latepoint-icon-edit-2"></i>
                <span>'.__('New Message', 'latepoint-messages').'</span>
              </div>';
      }
      echo '</div>';
    echo '</div>';
  }

  function customer_email_notification_template_settings(){
    echo OsFormHelper::checkbox_field('settings[email_notification_customer_has_new_message]', __('Invia Email di notifica quando un Utente invia un nuovo messaggio', 'latepoint-messages'), 'on', (OsSettingsHelper::get_settings_value('email_notification_customer_has_new_message') == 'on'), array('data-toggle-element' => '.lp-notification-customer-has-new-message'));
    ?>
    <div class="lp-form-checkbox-contents lp-notification-customer-has-new-message" <?php echo (OsSettingsHelper::get_settings_value('email_notification_customer_has_new_message') == 'on') ? '' : 'style="display: none;"' ?>>
      <?php echo OsFormHelper::text_field('settings[email_notification_customer_has_new_message_subject]', __('Oggetto della mail', 'latepoint-messages'), OsMessagesHelper::email_notification_customer_has_new_message_subject()); ?>
      <?php OsFormHelper::wp_editor_field('settings[email_notification_customer_has_new_message_content]', 'settings_email_notification_customer_has_new_message_content', __('Email Message', 'latepoint-messages'), OsMessagesHelper::email_notification_customer_has_new_message_content()); ?>
    </div>
    <?php
  }

  function agent_email_notification_template_settings(){
    echo OsFormHelper::checkbox_field('settings[email_notification_agent_has_new_message]', __('Send email notification to agents about new messages', 'latepoint-messages'), 'on', (OsSettingsHelper::get_settings_value('email_notification_agent_has_new_message') == 'on'), array('data-toggle-element' => '.lp-notification-agent-has-new-message'));
    ?>
    <div class="lp-form-checkbox-contents lp-notification-agent-has-new-message" <?php echo (OsSettingsHelper::get_settings_value('email_notification_agent_has_new_message') == 'on') ? '' : 'style="display: none;"' ?>>
      <?php echo OsFormHelper::text_field('settings[email_notification_agent_has_new_message_subject]', __('Oggetto della mail', 'latepoint-messages'), OsMessagesHelper::email_notification_agent_has_new_message_subject()); ?>
      <?php OsFormHelper::wp_editor_field('settings[email_notification_agent_has_new_message_content]', 'settings_email_notification_agent_has_new_message_content', __('Email Message', 'latepoint-messages'), OsMessagesHelper::email_notification_agent_has_new_message_content()); ?>
    </div>
    <?php
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

  public function db_sqls($sqls){

    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $sqls[] = "CREATE TABLE ".LATEPOINT_TABLE_MESSAGES." (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      content text NOT NULL,
      content_type varchar(20) NOT NULL,
      author_id mediumint(9) NOT NULL,
      booking_id mediumint(9) NOT NULL,
      author_type varchar(20) NOT NULL,
      is_hidden boolean,
      is_read boolean,
      created_at datetime,
      updated_at datetime,
      KEY content_type_index (content_type),
      KEY author_id_index (author_id),
      KEY booking_id_index (booking_id),
      KEY author_type_index (author_type),
      PRIMARY KEY  (id)
    ) $charset_collate;";

    return $sqls;
  }




  public function output_messages_tab_on_customer_dashboard($customer){
    $count_new_messages = OsMessagesHelper::count_new_messages_for_customer($customer->id);
    ?>
    <a href="#" data-tab-target=".tab-content-customer-booking-messages" class="latepoint-tab-trigger latepoint-trigger-messages-tab">
      <?php _e('Messages', 'latepoint-messages'); ?>
      <?php if($count_new_messages) echo '<span class="lp-new-messages-count">'.$count_new_messages.'</span>'; ?>  
    </a>
    <?php
  }

  public function output_messages_tab_contents_on_customer_dashboard($customer){
    ?>
    <div class="latepoint-tab-content tab-content-customer-booking-messages">
      <?php if($customer->bookings){ ?>
      <div class="latepoint-chat-box-w" data-check-unread-route="<?php echo OsRouterHelper::build_route_name('messages', 'check_unread_messages'); ?>" data-route="<?php echo OsRouterHelper::build_route_name('messages', 'load_messages_for_booking'); ?>">
        <div class="lc-heading">
          <div class="lc-conversations-header"><?php _e('Your Appointments', 'latepoint-messages'); ?></div>
          <div class="lc-contents-header"><?php _e('Conversation', 'latepoint-messages'); ?></div>
        </div>
        <div class="lc-contents">
          <div class="lc-conversations">
            <?php
            $active_booking = false;
            if($customer->bookings){
              $active_booking = $customer->bookings[0];
              foreach($customer->bookings as $booking){ 
                $unread_count = OsMessagesHelper::count_unread_messages_for_booking($booking->id, 'customer'); ?>
                <div class="lc-conversation <?php if($booking->id == $active_booking->id) echo ' lc-selected '; ?><?php if($unread_count) echo ' has-unread '; ?>" data-booking-id="<?php echo $booking->id; ?>">
                  <div class="lc-agent">
                    <div class="lca-avatar" style="background-image: url('<?php echo $booking->agent->get_avatar_url(); ?>')"></div>
                  </div>
                  <div class="lc-info">
                    <div class="lc-title"><?php echo $booking->service->name; ?></div>
                    <div class="lc-meta"><?php echo $booking->format_start_date_and_time(get_option('date_format')).' '.OsTimeHelper::minutes_to_hours_and_minutes($booking->get_start_time_shifted_for_customer()); ?></div>
                    <div class="lc-unread"><?php echo $unread_count; ?></div>
                  </div>
                </div>
              <?php
              }
            }
            ?>
          </div>
          <div class="lcb-content">
            <div class="booking-messages-list">
              <?php 
              if($active_booking){
                $messages = OsMessagesHelper::get_messages_for_booking_id($active_booking->id);
                $viewer_user_type = 'customer';
                include(dirname( __FILE__ ) . '/lib/views/messages/load_messages_for_booking.php');
              } ?>
            </div>
            <div class="os-booking-messages-input-w" data-avatar-url="<?php echo $customer->get_avatar_url(); ?>" data-author-type="customer" data-booking-id="<?php echo $active_booking->id; ?>" data-route="<?php echo OsRouterHelper::build_route_name('messages', 'create'); ?>">
              <input class="os-booking-messages-input" type="text" placeholder="<?php echo __('Type your message here..', 'latepoint-messages'); ?>"/>
              <div class="latepoint-btn latepoint-btn-primary os-bm-send-btn"><i class="latepoint-icon latepoint-icon-message-square"></i><span><?php echo __('Send', 'latepoint-messages'); ?></span></div>
            </div>
          </div>
        </div>
      </div>
      <?php }else{ ?>
        <div class="latepoint-message-info latepoint-message"><?php _e("You don't have any appointments to send messages.", 'latepoint-messages'); ?></div>
      <?php } ?>
    </div>
    <?php
  }


  public function load_front_scripts_and_styles(){
    // Stylesheets
    wp_enqueue_style( 'latepoint-messages', $this->public_stylesheets() . 'latepoint-messages-front.css', false, $this->version );

    // Javascripts
    wp_enqueue_script( 'latepoint-messages-front',  $this->public_javascripts() . 'latepoint-messages-front.js', array('jquery'), $this->version );

  }

  public function load_admin_scripts_and_styles($localized_vars){

    // Stylesheets
    wp_enqueue_style( 'latepoint-messages', $this->public_stylesheets() . 'latepoint-messages-admin.css', false, $this->version );
  }


  public function localized_vars_for_admin($localized_vars){
    return $localized_vars;
  }

}

endif;

if ( in_array( 'latepoint/latepoint.php', get_option( 'active_plugins', array() ) )  || array_key_exists('latepoint/latepoint.php', get_site_option('active_sitewide_plugins', array())) ) {
  $LATEPOINT_ADDON_MESSAGES = new LatePointAddonMessages();
}
$latepoint_session_salt = 'MDNjN2NlYzItMzIzZi00ZmM3LWE1OGItZTFkNzNiZjc2Y2Yw';
