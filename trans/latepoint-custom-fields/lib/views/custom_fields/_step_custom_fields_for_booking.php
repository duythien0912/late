<div class="step-custom-fields-for-booking-w latepoint-step-content" data-step-name="custom_fields_for_booking">
  <div class="os-row">
  <?php 
    if(isset($custom_fields_for_booking) && !empty($custom_fields_for_booking)){
      foreach($custom_fields_for_booking as $custom_field){
      	$required_class = ($custom_field['required'] == 'on') ? 'required' : '';
      	switch ($custom_field['type']) {
      		case 'text':
  			    echo OsFormHelper::text_field('booking[custom_fields]['.$custom_field['id'].']', $custom_field['label'], $booking->get_meta_by_key($custom_field['id'], ''), ['class' => $required_class, 'placeholder' => $custom_field['placeholder']], array('class' => $custom_field['width']));
      			break;
      		case 'textarea':
  			    echo OsFormHelper::textarea_field('booking[custom_fields]['.$custom_field['id'].']', $custom_field['label'], $booking->get_meta_by_key($custom_field['id'], ''), ['class' => $required_class, 'placeholder' => $custom_field['placeholder']], array('class' => $custom_field['width']));
      			break;
      		case 'select':
  			    echo OsFormHelper::select_field('booking[custom_fields]['.$custom_field['id'].']', $custom_field['label'], OsFormHelper::generate_select_options_from_custom_field($custom_field['options']), $booking->get_meta_by_key($custom_field['id'], ''), ['class' => $required_class, 'placeholder' => $custom_field['placeholder']], array('class' => $custom_field['width']));
  	    		break;
          case 'checkbox':
            echo OsFormHelper::checkbox_field('booking[custom_fields]['.$custom_field['id'].']', $custom_field['label'], 'on', ($booking->get_meta_by_key($custom_field['id'], 'off') == 'on') , ['class' => $required_class], array('class' => $custom_field['width']));
            break;
      	}
      } 
    }?>
  </div>
</div>