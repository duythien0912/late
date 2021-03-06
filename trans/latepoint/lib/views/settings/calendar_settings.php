<div class="latepoint-settings-w os-form-w">
  <form action="" data-os-action="<?php echo OsRouterHelper::build_route_name('settings', 'update'); ?>">
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Settaggi Calendario', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <?php echo OsFormHelper::checkbox_field('settings[enable_google_calendar]', __('Abilita Google Calendar', 'latepoint'), 'on', OsSettingsHelper::is_on('enable_google_calendar'), array('data-toggle-element' => '.lp-google-settings')); ?>
        <div class="lp-form-checkbox-contents lp-google-settings" <?php echo (OsSettingsHelper::get_settings_value('enable_google_calendar') == 'on') ? '' : 'style="display: none;"' ?>>
          <h3><?php _e('API Credentials', 'latepoint'); ?></h3>
          <div class="os-row">
            <div class="os-col-12">
              <?php echo OsFormHelper::text_field('settings[google_calendar_client_id]', __('Google Calendar Client ID', 'latepoint'), OsSettingsHelper::get_settings_value('google_calendar_client_id')); ?>
            </div>
          </div>
          <div class="os-row">
            <div class="os-col-12">
              <?php echo OsFormHelper::password_field('settings[google_calendar_client_secret]', __('Google Calendar Client Secret', 'latepoint'), OsSettingsHelper::get_settings_value('google_calendar_client_secret')); ?>
            </div>
          </div>
          <h3><?php _e('Altre Impostazioni', 'latepoint'); ?></h3>
          <div class="os-row">
            <div class="os-col-12">
              <?php echo OsFormHelper::text_field('settings[google_calendar_event_summary_template]', __('Content For Event Summary', 'latepoint'), OsSettingsHelper::get_settings_value('google_calendar_event_summary_template', '{service_name}')); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo OsFormHelper::button('submit', __('Salva ', 'latepoint'), 'submit', ['class' => 'latepoint-btn']); ?>
  </form>
</div>
