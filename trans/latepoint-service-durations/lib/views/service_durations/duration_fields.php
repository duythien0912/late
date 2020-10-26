<div class="duration-box service-duration-box extra-duration">
  <h4><?php _e('Additional Duration', 'latepoint-service-durations'); ?></h4>
  <div class="os-row">
    <div class="os-col-lg-4">
      <?php echo OsFormHelper::text_field('service[durations]['.$duration['id'].'][duration]', __('Service Duration (minutes)', 'latepoint-service-durations'), $duration['duration']); ?>
    </div>
    <div class="os-col-lg-4">
      <?php echo OsFormHelper::text_field('service[durations]['.$duration['id'].'][charge_amount]', __('Charge Amount', 'latepoint-service-durations'), $duration['charge_amount']); ?>
    </div>
    <div class="os-col-lg-4">
      <?php echo OsFormHelper::text_field('service[durations]['.$duration['id'].'][deposit_amount]', __('Deposit Amount', 'latepoint-service-durations'), $duration['deposit_amount']); ?>
    </div>
  </div>
  <a href="#" class="os-remove-duration"><i class="latepoint-icon latepoint-icon-trash-2"></i></a>
</div>