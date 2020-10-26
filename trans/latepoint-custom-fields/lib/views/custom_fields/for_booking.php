<div class="os-custom-fields-w os-custom-fields-ordering-w" data-order-update-route="<?php echo OsRouterHelper::build_route_name('custom_fields', 'update_order'); ?>" data-fields-for="booking">
	<?php foreach($custom_fields_for_booking as $custom_field){ ?>
		<?php include('_custom_field_form.php'); ?>
	<?php } ?>
</div>
<div class="os-add-box add-custom-field-box add-custom-field-trigger" data-os-params="fields_for=<?php echo $fields_for; ?>" data-os-action="<?php echo OsRouterHelper::build_route_name('custom_fields', 'new_form'); ?>" data-os-output-target-do="append" data-os-output-target=".os-custom-fields-w">
	<div class="add-box-graphic-w">
		<div class="add-box-plus"><i class="latepoint-icon latepoint-icon-plus4"></i></div>
	</div>
	<div class="add-box-label"><?php _e('Aggiungi nuovo campo', 'latepoint-custom-fields'); ?></div>
</div>
