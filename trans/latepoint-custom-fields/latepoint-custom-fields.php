<?php
/**
 * Plugin Name: AppoinTy Addon - Custom Fields
 * Plugin URI:  https://github.com/duythien0912/
 * Description: AppoinTy addon for custom fields
 * Version:     1.0.3
 * Author:      duythien0912@gmail.com
 * Author URI:  https://github.com/duythien0912/
 * Text Domain: latepoint-custom-fields
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

// If no LatePoint class exists - exit, because LatePoint plugin is required for this addon

if ( ! class_exists( 'LatePointAddonCustomFields' ) ) :

/**
 * Main Addon Class.
 *
 */

class LatePointAddonCustomFields {

  /**
   * Addon version.
   *
   */
  public $version = '1.0.3';
  public $db_version = '1.0.0';
  public $addon_name = 'latepoint-custom-fields';




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
    include_once(dirname( __FILE__ ) . '/lib/controllers/custom_fields_controller.php' );

    // HELPERS
    include_once( dirname( __FILE__ ) . '/lib/helpers/custom_fields_helper.php' );

    // MODELS

  }

  public function init_hooks(){
    add_action('latepoint_includes', [$this, 'includes']);
    add_action('latepoint_wp_enqueue_scripts', [$this, 'load_front_scripts_and_styles']);
    add_action('latepoint_admin_enqueue_scripts', [$this, 'load_admin_scripts_and_styles']);
    add_action('latepoint_custom_step_info', [$this, 'show_step_info']);

    add_filter('latepoint_installed_addons', [$this, 'register_addon']);
    add_filter('latepoint_addons_sqls', [$this, 'db_sqls']);
    add_filter('latepoint_side_menu', [$this, 'add_menu_links']);


    add_filter('latepoint_step_names_in_order', [$this, 'add_step_for_custom_fields'], 10, 2);
    add_filter('latepoint_default_fields_for_customer', [$this, 'get_default_fields_for_customer']);

    add_filter('latepoint_steps_defaults', [$this, 'add_custom_fields_step_defaults']);
    add_filter('latepoint_step_show_next_btn_rules', [$this, 'add_step_show_next_btn_rules'], 10, 2);
    add_filter('latepoint_model_loaded_by_id', [$this, 'load_custom_fields_for_model']);
    add_filter('latepoint_get_results_as_models', [$this, 'load_custom_fields_for_model']);
    add_filter('latepoint_customer_model_validations', [$this, 'modify_customer_model_validations']);
    add_filter('latepoint_should_step_be_skipped', 'OsCustomFieldsHelper::should_step_be_skipped', 10, 3 );

    // CSV Export Filters
    add_filter('latepoint_bookings_data_for_csv_export', [$this, 'add_custom_fields_to_bookings_data_for_csv'], 10, 2);
    add_filter('latepoint_booking_row_for_csv_export', [$this, 'add_custom_fields_to_booking_row_for_csv'], 10, 3);
    add_filter('latepoint_customers_data_for_csv_export', [$this, 'add_custom_fields_to_customers_data_for_csv'], 10, 2);
    add_filter('latepoint_customer_row_for_csv_export', [$this, 'add_custom_fields_to_customer_row_for_csv'], 10, 3);
    // Template variables
    add_filter('latepoint_replace_booking_vars', [$this, 'replace_booking_vars_in_template'], 10, 2);
    add_filter('latepoint_replace_customer_vars', [$this, 'replace_customer_vars_in_template'], 10, 2);
    // Google calendar event description
    add_filter('latepoint_google_calendar_event_description', [$this, 'add_custom_fields_for_google_event'], 10, 2);

    add_action('latepoint_customer_dashboard_information_form_after',[$this, 'output_customer_custom_fields_on_customer_dashboard']);
    add_action('latepoint_customer_edit_form_after',[$this, 'output_customer_custom_fields_on_form']);
    add_action('latepoint_customer_quick_edit_form_after',[$this, 'output_customer_custom_fields_on_quick_form']);
    add_action('latepoint_booking_quick_edit_form_after',[$this, 'output_booking_custom_fields_on_quick_form']);
    add_action('latepoint_load_step',[$this, 'load_step_custom_fields_for_booking'], 10, 3);
    add_action('latepoint_process_step', [$this, 'process_step_custom_fields'], 10, 2);
    add_action('latepoint_step_verify_appointment_info', [$this, 'output_custom_fields_for_booking_values']);
    add_action('latepoint_step_verify_customer_info', [$this, 'output_custom_fields_for_customer_values'], 10, 2);
    add_action('latepoint_step_confirmation_appointment_info', [$this, 'output_custom_fields_for_booking_values']);
    add_action('latepoint_step_confirmation_customer_info', [$this, 'output_custom_fields_for_customer_values'], 10, 2);
    add_action('latepoint_available_vars_after', [$this, 'output_custom_fields_vars']);

    add_action('latepoint_model_set_data', [$this, 'set_custom_fields_data'], 10, 2);
    add_action('latepoint_model_save', [$this, 'save_custom_fields']);
    add_action('latepoint_model_validate', [$this, 'validate_custom_fields']);
    add_action('latepoint_booking_steps_contact_after', [$this, 'add_custom_fields_for_contact_step']);

    // addon specific filters

    add_action( 'init', array( $this, 'init' ), 0 );

    register_activation_hook(__FILE__, [$this, 'on_activate']);
    register_deactivation_hook(__FILE__, [$this, 'on_deactivate']);


  }

  public function add_custom_fields_for_google_event($description, $booking){
    $custom_fields_for_customer = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'agent');
    foreach($custom_fields_for_customer as $custom_field){
      $description.= $custom_field['label'].': '.$booking->customer->get_meta_by_key($custom_field['id'], '')."\r\n";
    }
    $custom_fields_for_booking = OsCustomFieldsHelper::get_custom_fields_arr('booking', 'agent');
    foreach($custom_fields_for_booking as $custom_field){
      $description.= $custom_field['label'].': '.$booking->get_meta_by_key($custom_field['id'], '')."\r\n";
    }
    return $description;
  }



  public function add_custom_fields_for_contact_step($customer){
    $custom_fields_for_customer = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'customer');
    if(isset($custom_fields_for_customer) && !empty($custom_fields_for_customer)){
      foreach($custom_fields_for_customer as $custom_field){
        $required_class = ($custom_field['required'] == 'on') ? 'required' : '';
        switch ($custom_field['type']) {
          case 'text':
            echo OsFormHelper::text_field('customer[custom_fields]['.$custom_field['id'].']', $custom_field['label'], $customer->get_meta_by_key($custom_field['id'], ''), ['class' => $required_class, 'placeholder' => $custom_field['placeholder']], array('class' => $custom_field['width']));
            break;
          case 'textarea':
            echo OsFormHelper::textarea_field('customer[custom_fields]['.$custom_field['id'].']', $custom_field['label'], $customer->get_meta_by_key($custom_field['id'], ''), ['class' => $required_class, 'placeholder' => $custom_field['placeholder']], array('class' => $custom_field['width']));
            break;
          case 'select':
            echo OsFormHelper::select_field('customer[custom_fields]['.$custom_field['id'].']', $custom_field['label'], OsFormHelper::generate_select_options_from_custom_field($custom_field['options']), $customer->get_meta_by_key($custom_field['id'], ''), ['class' => $required_class, 'placeholder' => $custom_field['placeholder']], array('class' => $custom_field['width']));
            break;
          case 'checkbox':
            echo OsFormHelper::checkbox_field('customer[custom_fields]['.$custom_field['id'].']', $custom_field['label'], 'on', ($customer->get_meta_by_key($custom_field['id'], 'off') == 'on') , ['class' => $required_class], array('class' => $custom_field['width']));
            break;
        }
      } 
    }
  }


  public function replace_customer_vars_in_template($text, $customer){
    if($customer){
      $custom_fields_for_customer = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'agent');
      if(!empty($custom_fields_for_customer)){
        $needles = [];
        $replacements = [];
        foreach($custom_fields_for_customer as $custom_field){
          $needles[] = '{'.$custom_field['id'].'}';
          $replacements[] = $customer->get_meta_by_key($custom_field['id'], '');
        }
        $text = str_replace($needles, $replacements, $text);
      }
    }
    return $text;
  }


  public function replace_booking_vars_in_template($text, $booking){
    if($booking){
      $custom_fields_for_booking = OsCustomFieldsHelper::get_custom_fields_arr('booking', 'agent');
      if(!empty($custom_fields_for_booking)){
        $needles = [];
        $replacements = [];
        foreach($custom_fields_for_booking as $custom_field){
          $needles[] = '{'.$custom_field['id'].'}';
          $replacements[] = $booking->get_meta_by_key($custom_field['id'], '');
        }
        $text = str_replace($needles, $replacements, $text);
      }
    }
    return $text;
  }

  public function add_custom_fields_to_bookings_data_for_csv($bookings_data, $params = []){

    $custom_fields_for_customer = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'agent');
    // update labels row
    foreach($custom_fields_for_customer as $custom_field){
      $bookings_data[0][] = $custom_field['label'];
    }
    $custom_fields_for_booking = OsCustomFieldsHelper::get_custom_fields_arr('booking', 'agent');
    // update labels row
    foreach($custom_fields_for_booking as $custom_field){
      $bookings_data[0][] = $custom_field['label'];
    }
    return $bookings_data;
  }

  public function add_custom_fields_to_booking_row_for_csv($booking_row, $booking, $params = []){

    $custom_fields_for_customer = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'agent');
    foreach($custom_fields_for_customer as $custom_field){
      $booking_row[] = $booking->customer->get_meta_by_key($custom_field['id'], '');
    }
    $custom_fields_for_booking = OsCustomFieldsHelper::get_custom_fields_arr('booking', 'agent');
    foreach($custom_fields_for_booking as $custom_field){
      $booking_row[] = $booking->get_meta_by_key($custom_field['id'], '');
    }
    return $booking_row;
  }

  public function add_custom_fields_to_customers_data_for_csv($customers_data, $params = []){

    $custom_fields_for_customer = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'agent');
    // update labels row
    foreach($custom_fields_for_customer as $custom_field){
      $customers_data[0][] = $custom_field['label'];
    }
    return $customers_data;
  }

  public function add_custom_fields_to_customer_row_for_csv($customer_row, $customer, $params = []){

    $custom_fields_for_customer = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'agent');
    foreach($custom_fields_for_customer as $custom_field){
      $customer_row[] = $customer->get_meta_by_key($custom_field['id'], '');
    }
    return $customer_row;
  }

  public function modify_customer_model_validations($validations){
    $default_fields = OsSettingsHelper::get_default_fields_for_customer();
    foreach($default_fields as $name => $field){
      if($field['required'] && $field['active']){
        $validations[$name][] = 'presence';
        $validations[$name] = array_unique($validations[$name]);
      }else{
        if(isset($validations[$name])){
          $validations[$name] = array_diff($validations[$name], ['presence']);
        }
      }
    }
    return $validations;
  }


  public function get_default_fields_for_customer($default_fields){
    $fields_from_db = OsSettingsHelper::get_settings_value('default_fields_for_customer', '');
    $fields_from_db_arr = json_decode($fields_from_db, true);
    if($fields_from_db_arr){
      foreach($fields_from_db_arr as $name => $field_from_db){
        if(isset($default_fields[$name])) $default_fields[$name] = $field_from_db;
      }
    }
    return $default_fields;
  }

  public function output_customer_custom_fields_on_customer_dashboard($customer){
    $custom_fields_for_customer = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'customer');
    if($custom_fields_for_customer) OsCustomFieldsHelper::output_custom_fields_on_form($custom_fields_for_customer, $customer, 'customer');
  }

  public function output_customer_custom_fields_on_form($customer){
    $custom_fields_for_customer = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'agent');
    if($custom_fields_for_customer){ ?>
        <div class="white-box">
          <div class="white-box-header">
            <div class="os-form-sub-header">
              <h3><?php _e('CUSTOM', 'latepoint-custom-fields'); ?></h3>
            </div>
          </div>
          <div class="white-box-content">
            <?php OsCustomFieldsHelper::output_custom_fields_on_form($custom_fields_for_customer, $customer, 'customer'); ?>
          </div>
        </div>
      <?php 
    }
  }


  public function output_booking_custom_fields_on_quick_form($booking){
    $custom_fields_for_booking = OsCustomFieldsHelper::get_custom_fields_arr('booking', 'agent');
    if(isset($custom_fields_for_booking) && !empty($custom_fields_for_booking)){ ?>
      <?php OsCustomFieldsHelper::output_custom_fields_on_form($custom_fields_for_booking, $booking, 'booking');
    }
  }

  public function output_customer_custom_fields_on_quick_form($customer){
    $custom_fields_for_customer = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'agent');
    if(isset($custom_fields_for_customer) && !empty($custom_fields_for_customer)){ ?>
      <?php OsCustomFieldsHelper::output_custom_fields_on_form($custom_fields_for_customer, $customer, 'customer');
    }
  }


  public function load_custom_fields_for_model($model){
    if(($model instanceof OsBookingModel) || ($model instanceof OsCustomerModel)){
      $fields_for = ($model instanceof OsBookingModel) ? 'booking' : 'customer';
      $custom_fields_structure = OsCustomFieldsHelper::get_custom_fields_arr($fields_for, 'agent');
      $metas = [];
      $model->custom_fields = [];
      if($model instanceof OsBookingModel){
        $metas = OsMetaHelper::get_booking_metas($model->id);
      }elseif($model instanceof OsCustomerModel){
        $metas = OsMetaHelper::get_customer_metas($model->id);
      }
      if($metas && $custom_fields_structure){
        foreach($custom_fields_structure as $key => $custom_field){
          if(isset($metas[$key])) $model->custom_fields[$key] = $metas[$key];
        }
      }
    }
  }


  public function set_custom_fields_data($model, $data = []){
    if(($model instanceof OsBookingModel) || ($model instanceof OsCustomerModel)){
      if($data && isset($data['custom_fields'])){
        $fields_for = ($model instanceof OsBookingModel) ? 'booking' : 'customer';
        $custom_fields_structure = OsCustomFieldsHelper::get_custom_fields_arr($fields_for, 'agent');
        if(!isset($model->custom_fields)) $model->custom_fields = [];
        foreach($data['custom_fields'] as $key => $custom_field){
          // check if data is allowed
          if(isset($custom_fields_structure[$key])) $model->custom_fields[$key] = $custom_field;
        }
      }
    }
  }

  public function validate_custom_fields($model){
    if(($model instanceof OsBookingModel) || ($model instanceof OsCustomerModel)){
      $fields_for = ($model instanceof OsBookingModel) ? 'booking' : 'customer';
      $custom_fields_structure = OsCustomFieldsHelper::get_custom_fields_arr($fields_for, 'agent');
      if(!isset($model->custom_fields)) $model->custom_fields = [];
      $errors = OsCustomFieldsHelper::validate_fields($model->custom_fields, $custom_fields_structure);
      if($errors){
        foreach($errors as $error){
          $model->add_error($error['type'], $error['message']);
        }
      }
    }
  }

  public function save_custom_fields($model){
    if($model->is_new_record()) return;
    if(($model instanceof OsBookingModel) || ($model instanceof OsCustomerModel)){
      $fields_for = ($model instanceof OsBookingModel) ? 'booking' : 'customer';
      $custom_fields_structure = OsCustomFieldsHelper::get_custom_fields_arr($fields_for, 'agent');
      if(!isset($model->custom_fields)) $model->custom_fields = [];
      if($custom_fields_structure){
        foreach($custom_fields_structure as $custom_field){
          if(isset($model->custom_fields[$custom_field['id']])){
            $model->save_meta_by_key($custom_field['id'], $model->custom_fields[$custom_field['id']]);
          }
        }
      }
    }
  }

  public function output_custom_fields_vars(){
    $custom_fields_for_booking = OsCustomFieldsHelper::get_custom_fields_arr('booking', 'agent');
    $custom_fields_for_customer = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'agent');

    if($custom_fields_for_booking || $custom_fields_for_customer){ ?>
      <div class="available-vars-block">
        <h4><?php _e('CUSTOM', 'latepoint-custom-fields'); ?></h4>
        <ul>
          <?php 
            if($custom_fields_for_customer){
              echo '<li><strong>'.__('For Customer:', 'latepoint-custom-fields').'</strong></li>';
              foreach($custom_fields_for_customer as $custom_field){ ?>
                <li><span class="var-label"><?php echo $custom_field['label']; ?></span> <span class="var-code os-click-to-copy">{<?php echo $custom_field['id']; ?>}</span></li>
              <?php }
            }
            if($custom_fields_for_booking){
              echo '<li style="padding-top: 10px;"><strong>'.__('For Booking:', 'latepoint-custom-fields').'</strong></li>';
              foreach($custom_fields_for_booking as $custom_field){ ?>
                <li><span class="var-label"><?php echo $custom_field['label']; ?></span> <span class="var-code os-click-to-copy">{<?php echo $custom_field['id']; ?>}</span></li>
              <?php }
            } ?>
        </ul>
      </div>
    <?php }
  }

  public function output_custom_fields_for_customer_values($customer, $booking){
    $custom_fields_structure = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'customer');
    if(isset($customer->custom_fields) && $customer->custom_fields){
      foreach($customer->custom_fields as $key => $custom_field){
        if(isset($custom_fields_structure[$key])) echo '<li>'.$custom_fields_structure[$key]['label'].': <strong>'.$custom_field.'</strong></li>';
      }
    }
  }

  public function output_custom_fields_for_booking_values($booking){
    $custom_fields_structure = OsCustomFieldsHelper::get_custom_fields_arr('booking', 'customer');
    if(isset($booking->custom_fields) && $booking->custom_fields){
      foreach($booking->custom_fields as $key => $custom_field){
        if(isset($custom_fields_structure[$key])) echo '<li>'.$custom_fields_structure[$key]['label'].': <strong>'.$custom_field.'</strong></li>';
      }
    }
  }

  public function process_step_custom_fields($step_name, $booking_object){
    if($step_name == 'custom_fields_for_booking'){

      $booking = OsParamsHelper::get_param('booking');
      $custom_fields_data = $booking['custom_fields'];
      $custom_fields_for_booking = OsCustomFieldsHelper::get_custom_fields_arr('booking', 'customer');

      $is_valid = true;
      $errors = OsCustomFieldsHelper::validate_fields($custom_fields_data, $custom_fields_for_booking);
      $error_messages = [];
      if($errors){
        $is_valid = false;
        foreach($errors as $error){
          $error_messages[] = $error['message'];
        }
      }
      if(!$is_valid){
        wp_send_json(array('status' => LATEPOINT_STATUS_ERROR, 'message' => $error_messages));
        return;
      }
    }
  }


  public function load_step_custom_fields_for_booking($step_name, $booking_object, $format = 'json'){
    if($step_name == 'custom_fields_for_booking'){
      $custom_fields_controller = new OsCustomFieldsController();
      $custom_fields_controller->vars['custom_fields_for_booking'] = OsCustomFieldsHelper::get_custom_fields_arr('booking', 'customer');
      $custom_fields_controller->vars['booking'] = $booking_object;
      $custom_fields_controller->vars['current_step'] = $step_name;
      $custom_fields_controller->set_layout('none');
      $custom_fields_controller->set_return_format($format);
      $custom_fields_controller->format_render('_step_custom_fields_for_booking', [], [
        'step_name'         => $step_name, 
        'show_next_btn'     => OsStepsHelper::can_step_show_next_btn($step_name), 
        'show_prev_btn'     => OsStepsHelper::can_step_show_prev_btn($step_name), 
        'is_first_step'     => OsStepsHelper::is_first_step($step_name), 
        'is_last_step'      => OsStepsHelper::is_last_step($step_name), 
        'is_pre_last_step'  => OsStepsHelper::is_pre_last_step($step_name)]);
    }
  }

  public function show_step_info($step_name = ''){
    if($step_name == 'custom_fields_for_booking' && !OsCustomFieldsHelper::get_custom_fields_arr('booking', 'customer')){
      echo '<a href="'. OsRouterHelper::build_link(OsRouterHelper::build_route_name('settings', 'payments') ).'" class="step-message">'.__('You have not created any custom fields for booking, this step will be skipped', 'latepoint-custom-fields').'</a>';
    }
  }


  public function add_step_show_next_btn_rules($rules, $step_name){
    $rules['custom_fields_for_booking'] = true;
    return $rules;
  }

  public function add_custom_fields_step_defaults($defaults){
    $defaults['custom_fields_for_booking'] = [ 'title' => __('CUSTOM', 'latepoint-custom-fields'),
                                    'order_number' => 3,
                                    'sub_title' => __('CUSTOM', 'latepoint-custom-fields'),
                                    'description' => __('Please answer this set of questions to proceed.', 'latepoint-custom-fields') ];
    return $defaults;
  }


  public function add_step_for_custom_fields($steps, $show_all_steps){
    if(array_search('custom_fields_for_booking', $steps) === false){
      // if services step exists - add after it
      if(array_search('services', $steps) !== false){
        array_splice($steps, (array_search('services', $steps) + 1), 0, 'custom_fields_for_booking');
      }else{
        array_push($steps, 'custom_fields_for_booking');
      }
    }
    return $steps;
  }


  public function add_menu_links($menus){
    if(!OsAuthHelper::is_admin_logged_in()) return $menus;
    $menus[] = ['id' => 'custom_fields', 'label' => __( 'CUSTOM', 'latepoint-custom-fields' ), 'icon' => 'latepoint-icon latepoint-icon-layers', 'link' => OsRouterHelper::build_link(['custom_fields', 'for_customer']),
                  'children' => [
                    ['label' => __( 'Campi per il cliente', 'latepoint-custom-fields' ), 'icon' => '', 'link' => OsRouterHelper::build_link(['custom_fields', 'for_customer'])],
                    ['label' => __( 'Campi per la prenotazione', 'latepoint-custom-fields' ), 'icon' => '', 'link' => OsRouterHelper::build_link(['custom_fields', 'for_booking'])],
                  ]
                ];
    return $menus;
  }

  /**
   * Init LatePoint when WordPress Initialises.
   */
  public function init() {
    // Set up localisation.
    $this->load_plugin_textdomain();
  }

  public function load_plugin_textdomain() {
    load_plugin_textdomain('latepoint-custom-fields', false, dirname(plugin_basename(__FILE__)) . '/languages');
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


    return $sqls;
  }


  public function load_front_scripts_and_styles(){
    // Stylesheets

    // Javascripts

  }

  public function load_admin_scripts_and_styles($localized_vars){
    // Stylesheets
    wp_enqueue_style( 'latepoint-custom-fields', $this->public_stylesheets() . 'latepoint-custom-fields-admin.css', false, $this->version );

    // Javascripts
    wp_enqueue_script( 'latepoint-custom-fields',  $this->public_javascripts() . 'latepoint-custom-fields-admin.js', array('jquery'), $this->version );
  }


  public function localized_vars_for_admin($localized_vars){
    return $localized_vars;
  }

}

endif;

if ( in_array( 'latepoint/latepoint.php', get_option( 'active_plugins', array() ) )  || array_key_exists('latepoint/latepoint.php', get_site_option('active_sitewide_plugins', array())) ) {
  $LATEPOINT_ADDON_CUSTOM_FIELDS = new LatePointAddonCustomFields();
}
$latepoint_session_salt = 'MDNjN2NlYzItMzIzZi00ZmM3LWE1OGItZTFkNzNiZjc2Y2Yw';
