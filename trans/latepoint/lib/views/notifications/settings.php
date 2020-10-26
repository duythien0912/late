<div class="latepoint-settings-w os-form-w">
  <form action="" data-os-action="<?php echo OsRouterHelper::build_route_name('settings', 'update'); ?>">
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Impostazioni delle Email', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <?php echo OsFormHelper::checkbox_field('settings[notifications_email]', __('Abilita Notifiche via Email', 'latepoint'), 'on', (OsSettingsHelper::get_settings_value('notifications_email') == 'on')); ?>
      </div>
    </div>
    
    
    
    <?php echo OsFormHelper::button('submit', __('Salva ', 'latepoint'), 'submit', ['class' => 'latepoint-btn']); ?>
  </form>
</div>
