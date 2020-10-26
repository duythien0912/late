<div class="os-form-sub-header"><h3><?php _e('Default Fields', 'latepoint-custom-fields'); ?></h3></div>
<div class="os-default-fields" data-route="<?php echo OsRouterHelper::build_route_name('custom_fields', 'update_default_fields') ?>">
	<form>
		<?php foreach($default_fields as $name => $default_field){ 
			$atts = [];
			if($default_field['locked']) $atts['disabled'] = 'disabled';
		?>
		<div class="os-default-field <?php echo $default_field['active'] ? '' : 'is-disabled'; ?>">
			<?php 
			if($default_field['locked']){ 
				echo '<div class="locked-field"><i class="latepoint-icon latepoint-icon-lock"></i><span>'.__('Email Address field can not be disabled.', 'latepoint-custom-fields').'</span></div>';
			}else{
				$active = $default_field['active'] ? '' : 'off';
				echo '<div class="os-toggler '.$active.'" data-for="default_fields['.$name.'][active]"><div class="toggler-rail"><div class="toggler-pill"></div></div></div>';
				echo OsFormHelper::hidden_field('default_fields['.$name.'][active]', $default_field['active']);
			} ?>
			<div class="os-field-name"><?php echo $default_field['label']; ?></div>
			<div class="os-field-setting">
				<?php echo OsFormHelper::checkbox_field('default_fields['.$name.'][required]', __('Required?', 'latepoint-custom-fields'), 'on', $default_field['required'], $atts); ?>
			</div>
			<div class="os-field-setting">
				<?php echo OsFormHelper::select_field('default_fields['.$name.'][width]', false, array( 'os-col-12' => __('Full Width', 'latepoint-custom-fields'), 'os-col-6' => __('Half Width', 'latepoint-custom-fields')), $default_field['width']); ?>
			</div>
		</div>
		<?php } ?>
	</form>
</div>
<div class="os-form-sub-header"><h3><?php _e('CUSTOM', 'latepoint-custom-fields'); ?></h3></div>
<div class="os-custom-fields-w os-custom-fields-ordering-w" data-order-update-route="<?php echo OsRouterHelper::build_route_name('custom_fields', 'update_order'); ?>" data-fields-for="customer">
	<?php foreach($custom_fields_for_customers as $custom_field){ ?>
		<?php include('_custom_field_form.php'); ?>
	<?php } ?>
</div>

<div class="os-add-box add-custom-field-box add-custom-field-trigger" data-os-params="fields_for=<?php echo $fields_for; ?>" data-os-action="<?php echo OsRouterHelper::build_route_name('custom_fields', 'new_form'); ?>" data-os-output-target-do="append" data-os-output-target=".os-custom-fields-w">
	<div class="add-box-graphic-w">
		<div class="add-box-plus"><i class="latepoint-icon latepoint-icon-plus4"></i></div>
	</div>
	<div class="add-box-label"><?php _e('Aggiungi nuovo campo', 'latepoint-custom-fields'); ?></div>
</div>
