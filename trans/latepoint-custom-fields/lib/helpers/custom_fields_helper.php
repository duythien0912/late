<?php 

class OsCustomFieldsHelper {
  
  function __construct(){
  }

  public static function allowed_fields(){
    $allowed_params = array('label',
                            'placeholder',
                            'type',
                            'width',
                            'options',
                            'required',
                            'id');
    return $allowed_params;
  }

  public static function prepare_to_save($array_to_filter){
    // !!TODO
    return $array_to_filter;
  }

  public static function should_step_be_skipped($skip, $step_name, $booking_object){
    if($step_name == 'custom_fields_for_booking'){
      $custom_fields_for_booking = self::get_custom_fields_arr('booking', 'customer');
      if(empty($custom_fields_for_booking)) $skip = true;
    }
    return $skip;
  }

  public static function output_custom_fields_on_form($custom_fields, $model, $field_name = 'customer'){
    echo '<div class="os-row">';
      foreach($custom_fields as $custom_field){
        $required_class = ($custom_field['required'] == 'on') ? 'required' : '';
        switch ($custom_field['type']) {
          case 'text':
            echo OsFormHelper::text_field($field_name.'[custom_fields]['.$custom_field['id'].']', $custom_field['label'], $model->get_meta_by_key($custom_field['id'], ''), ['class' => $required_class, 'placeholder' => $custom_field['placeholder']], array('class' => $custom_field['width']));
            break;
          case 'textarea':
            echo OsFormHelper::textarea_field($field_name.'[custom_fields]['.$custom_field['id'].']', $custom_field['label'], $model->get_meta_by_key($custom_field['id'], ''), ['class' => $required_class, 'placeholder' => $custom_field['placeholder']], array('class' => $custom_field['width']));
            break;
          case 'select':
            echo OsFormHelper::select_field($field_name.'[custom_fields]['.$custom_field['id'].']', $custom_field['label'], OsFormHelper::generate_select_options_from_custom_field($custom_field['options']), $model->get_meta_by_key($custom_field['id'], ''), ['class' => $required_class, 'placeholder' => $custom_field['placeholder']], array('class' => $custom_field['width']));
            break;
          case 'checkbox':
            echo OsFormHelper::checkbox_field($field_name.'[custom_fields]['.$custom_field['id'].']', $custom_field['label'], 'on', ($model->get_meta_by_key($custom_field['id'], 'off') == 'on') , ['class' => $required_class], array('class' => $custom_field['width']));
            break;
        }
      }
    echo '</div>';
  }

  public static function has_validation_errors($custom_field){
  	$errors = [];
  	if(empty($custom_field['label'])) $errors[] = __('Field Label can not be empty', 'latepoint-custom-fields');
  	if(empty($custom_field['type'])){
  		$errors[] = __('Type can not be empty', 'latepoint-custom-fields');
  	}else{
  		if($custom_field['type'] == 'select'){
		  	if(empty($custom_field['options'])) $errors[] = __('Options for select box can not be blank', 'latepoint-custom-fields');
  		}
  	}
  	if(empty($errors)){
  		return false;
  	}else{
  		return $errors;
  	}
  }

  public static function validate_fields($fields_data, $fields_rules){
    $errors = [];
    foreach($fields_rules as $custom_field){
      if($custom_field['required'] == 'on'){
        // checkbox has different "required" validation
        if($custom_field['type'] == 'checkbox'){
          if(!isset($fields_data[$custom_field['id']]) || empty($fields_data[$custom_field['id']]) || $fields_data[$custom_field['id']] == 'off'){
            $is_valid = false;
            $error_message = sprintf( __( '%s field has to be checked', 'latepoint-custom-fields' ), $custom_field['label'] );
            $errors[] = ['type' => 'validation', 'message' => $error_message];
          }
        }else{
          if(!isset($fields_data[$custom_field['id']]) || empty($fields_data[$custom_field['id']])){
            $is_valid = false;
            $error_message = sprintf( __( '%s can not be blank', 'latepoint-custom-fields' ), $custom_field['label'] );
            $errors[] = ['type' => 'validation', 'message' => $error_message];
          }
        }
      }
    }
    return $errors;
  }

  public static function save($custom_field, $fields_for = 'customer'){
    $custom_fields = self::get_custom_fields_arr($fields_for, 'all');
    if(!isset($custom_field['id']) || empty($custom_field['id'])){
    	$custom_field['id'] = self::generate_custom_field_id($fields_for);
    }
    $custom_fields[$custom_field['id']] = $custom_field;
    return self::save_custom_fields_arr($custom_fields, $fields_for);
  }

  public static function delete($custom_field_id, $fields_for = 'customer'){
    if(isset($custom_field_id) && !empty($custom_field_id)){
	    $custom_fields = self::get_custom_fields_arr($fields_for, 'all');
	    unset($custom_fields[$custom_field_id]);
	    return self::save_custom_fields_arr($custom_fields, $fields_for);
	  }else{
	  	return false;
	  }
  }

  public static function generate_custom_field_id(){
  	return 'cf_'.OsUtilHelper::random_text('alnum', 8);
  }

  public static function get_custom_fields_arr($fields_for = 'customer', $visibilityLevel = 'customer'){
    switch($visibilityLevel){
      case 'all':
        $visibility = ['public', 'admin_agent', 'hidden'];
        break;
      case 'agent':
        $visibility = ['public', 'admin_agent'];
        break;
      case 'customer':
      default:
        $visibility = ['public'];
        break;
    }
    $custom_fields = OsSettingsHelper::get_settings_value('custom_fields_for_'.$fields_for, false);
    if($custom_fields){
      $custom_fields_arr = json_decode($custom_fields, true);
      $visible_fields = [];
      if($custom_fields_arr && is_array($visibility)){
        foreach($custom_fields_arr as $id => $custom_field){
          if(!isset($custom_field['visibility']) || in_array($custom_field['visibility'], $visibility)) $visible_fields[$id] = $custom_field;
        }
      }
	  	return $visible_fields;
    }else{
    	return [];
    }
  }

  public static function save_custom_fields_arr($custom_fields_arr, $fields_for = 'customer'){
    $custom_fields_arr = self::prepare_to_save($custom_fields_arr);
    return OsSettingsHelper::save_setting_by_name('custom_fields_for_'.$fields_for, json_encode($custom_fields_arr));
  }

}
