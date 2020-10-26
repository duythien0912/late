<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}


if ( ! class_exists( 'OsCustomFieldsController' ) ) :


  class OsCustomFieldsController extends OsController {



    function __construct(){
      parent::__construct();

      $this->views_folder = plugin_dir_path( __FILE__ ) . '../views/custom_fields/';
      $this->vars['breadcrumbs'][] = ['label' => __('CUSTOM', 'latepoint-custom-fields'), 'link' => OsRouterHelper::build_link(['custom_fields', 'for_booking'] )];
    }

    public function update_default_fields(){
      $updated_fields = $this->params['default_fields'];
      $default_fields = OsSettingsHelper::get_default_fields_for_customer();
      $fields_to_save = [];
      foreach($default_fields as $name => $default_field){
        $default_field['width'] = $updated_fields[$name]['width'];
        if(!$default_field['locked']){
          $default_field['required'] = ($updated_fields[$name]['required'] == 'off') ? false : true;
          $default_field['active'] = ($updated_fields[$name]['active']) ? true : false;
        }
        $fields_to_save[$name] = $default_field;
      }
      OsSettingsHelper::save_setting_by_name('default_fields_for_customer', json_encode($fields_to_save));
      if($this->get_return_format() == 'json'){
        $this->send_json(array('status' => LATEPOINT_STATUS_SUCCESS, 'message' => __('Defaults Fields Updated', 'latepoint-custom-fields')));
      }
    }

    public function delete(){
      if(isset($this->params['id']) && !empty($this->params['id'])){
        if(OsCustomFieldsHelper::delete($this->params['id'], $this->params['fields_for'])){
          $status = LATEPOINT_STATUS_SUCCESS;
          $response_html = __('Custom Field Removed', 'latepoint-custom-fields');
        }else{
          $status = LATEPOINT_STATUS_ERROR;
          $response_html = __('Error Removing Custom Field', 'latepoint-custom-fields');
        }
      }else{
        $status = LATEPOINT_STATUS_ERROR;
        $response_html = __('Invalid Field ID', 'latepoint-custom-fields');
      }
      if($this->get_return_format() == 'json'){
        $this->send_json(array('status' => $status, 'message' => $response_html));
      }
    }

    public function new_form(){
      $this->vars['fields_for'] = $this->params['fields_for'];
      $this->vars['custom_field'] = ['id' => OsCustomFieldsHelper::generate_custom_field_id(), 
      'label' => '', 
      'type' => '', 
      'required' => 'off', 
      'width' => 'os-col-12', 
      'placeholder' => '',
      'options' => ''];
      $this->set_layout('none');
      $this->format_render(__FUNCTION__);
    }

    public function save(){
      if($this->params['custom_fields']){
        foreach($this->params['custom_fields'] as $custom_field){
          $validation_errors = OsCustomFieldsHelper::has_validation_errors($custom_field);
          if(is_array($validation_errors)){
            $status = LATEPOINT_STATUS_ERROR;
            $response_html = implode(', ', $validation_errors);
          }else{
            if(OsCustomFieldsHelper::save($custom_field, $this->params['fields_for'])){
              $status = LATEPOINT_STATUS_SUCCESS;
              $response_html = __('Custom Field Saved', 'latepoint-custom-fields');
            }else{
              $status = LATEPOINT_STATUS_ERROR;
              $response_html = __('Error Saving Custom Field', 'latepoint-custom-fields');
            }
          }
        }
      }else{
        $status = LATEPOINT_STATUS_ERROR;
        $response_html = __('Invalid params', 'latepoint-custom-fields');
      }
      if($this->get_return_format() == 'json'){
        $this->send_json(array('status' => $status, 'message' => $response_html));
      }
    }

    public function update_order(){
      $fields_for = $this->params['fields_for'];
      $ordered_fields = $this->params['ordered_fields'];
      $fields_in_db = OsCustomFieldsHelper::get_custom_fields_arr($fields_for);
      $ordered_fields_in_db = [];
      foreach($ordered_fields as $field_id => $field_order){
        if(isset($fields_in_db[$field_id])){
          $ordered_fields_in_db[$field_id] = $fields_in_db[$field_id];
        }
      }
      if(OsCustomFieldsHelper::save_custom_fields_arr($ordered_fields_in_db, $fields_for)){
        $status = LATEPOINT_STATUS_SUCCESS;
        $response_html = __('Order Updated', 'latepoint-custom-fields');
      }else{
        $status = LATEPOINT_STATUS_ERROR;
        $response_html = __('Error Updating Order of Custom Fields', 'latepoint-custom-fields');
      }
      if($this->get_return_format() == 'json'){
        $this->send_json(array('status' => $status, 'message' => $response_html));
      }
    }

    public function for_booking(){
      $this->vars['page_header'] = OsMenuHelper::get_menu_items_by_id('custom_fields');
      $this->vars['custom_fields_for_booking'] = OsCustomFieldsHelper::get_custom_fields_arr('booking', 'all');
      $this->vars['fields_for'] = 'booking';
      $this->format_render(__FUNCTION__);
    }


    public function for_customer(){
      $this->vars['page_header'] = OsMenuHelper::get_menu_items_by_id('custom_fields');
      $this->vars['breadcrumbs'][] = array('label' => __('CUSTOM', 'latepoint-custom-fields'), 'link' => false );
      $this->vars['fields_for'] = 'customer';

      $this->vars['custom_fields_for_customers'] = OsCustomFieldsHelper::get_custom_fields_arr('customer', 'all');

      $this->vars['default_fields'] = OsSettingsHelper::get_default_fields_for_customer();

      $this->format_render(__FUNCTION__);

    }


  }

endif;
