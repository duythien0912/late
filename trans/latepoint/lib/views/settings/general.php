<div class="latepoint-settings-w os-form-w">
  <form action="" data-os-action="<?php echo OsRouterHelper::build_route_name('settings', 'update'); ?>">
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Impostazioni degli Appuntamenti', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="os-row">
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::select_field('settings[default_booking_status]', __('Default degli Appuntamenti', 'latepoint'), OsBookingHelper::get_statuses_list(), OsBookingHelper::get_default_booking_status(), array('placeholder' => __('Set Default Status', 'latepoint'))); ?>
          </div>
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::select_field('settings[time_system]', __('Orario', 'latepoint'), OsTimeHelper::get_time_systems_list_for_select(), OsTimeHelper::get_time_system()); ?>
          </div>
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::select_field('settings[date_format]', __('Formato Data', 'latepoint'), OsTimeHelper::get_date_formats_list_for_select(), OsSettingsHelper::get_date_format()); ?>
          </div>
        </div>
        <div class="os-row">
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::text_field('settings[timeblock_interval]', __('Seleziona Tempo di Intervallo in Minuti', 'latepoint'), OsSettingsHelper::get_default_timeblock_interval()); ?>
          </div>
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::checkbox_field('settings[show_booking_end_time]', __('Mostra l\'ora di fine dell\'appuntamento', 'latepoint'), 'on', OsSettingsHelper::is_on('show_booking_end_time')); ?>
          </div>
          <div class="os-col-lg-4">
            <?php echo OsFormHelper::checkbox_field('settings[disable_verbose_date_output]', __('Disabilita output di date dettagliate', 'latepoint'), 'on', OsSettingsHelper::is_on('disable_verbose_date_output')); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Restizioni', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="latepoint-message latepoint-message-subtle"><?php _e('Puoi impostare restrizioni sulle prime / ultime date future quando il tuo cliente può fissare un appuntamento. Puoi utilizzare valori relativi come ad esempio "+1 mese", "+5 giorni", "+2 settimane" oppure puoi utilizzare una data fissa nel formato AAAA-MM-GG. Lascia vuoto per rimuovere eventuali limitazioni.', 'latepoint'); ?></div>
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[earliest_possible_booking]', __('Prima prenotazione possibile', 'latepoint'), OsSettingsHelper::get_settings_value('earliest_possible_booking')); ?>
          </div>
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[latest_possible_booking]', __('Ultima prenotazione possibile', 'latepoint'), OsSettingsHelper::get_settings_value('latest_possible_booking')); ?>
          </div>
        </div>
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[max_future_bookings_per_customer]', __('Numero massimo di prenotazioni future per Utente', 'latepoint'), OsSettingsHelper::get_settings_value('max_future_bookings_per_customer')); ?>
          </div>
        </div>
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::checkbox_field('settings[one_location_at_time]', __('Il Personale Scolastico può essere presente solo in una posizione alla volta', 'latepoint'), 'on', OsSettingsHelper::is_on('one_location_at_time')); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Currency Settings', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[currency_symbol_before]', __('--', 'latepoint'), OsSettingsHelper::get_settings_value('currency_symbol_before', '$')); ?>
          </div>
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[currency_symbol_after]', __('Currency symbol after the price', 'latepoint'), OsSettingsHelper::get_settings_value('currency_symbol_after')); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Informazioni di Contatto Telefonico', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[phone_format]', __('Maschera di input del telefono', 'latepoint'), OsSettingsHelper::get_phone_format()); ?>
          </div>
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::checkbox_field('settings[disable_phone_formatting]', __('Disabilita input del Telefono', 'latepoint'), 'on', OsUtilHelper::is_phone_formatting_disabled()); ?>
          </div>
        </div>
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[country_phone_code]', __('Prefisso telefonico per il tuo paese', 'latepoint'), OsSettingsHelper::get_country_phone_code()); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Appearance Settings', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::select_field('settings[color_scheme_for_booking_form]', __('Color Scheme for Booking Form', 'latepoint'), ['blue' => 'Blue', 'black' => 'Black', 'teal' => 'Teal', 'green' => 'Green', 'purple' => 'Purple', 'red' => 'Red', 'orange' => 'Orange'], OsSettingsHelper::get_booking_form_color_scheme()); ?>
          </div>
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::select_field('settings[border_radius]', __('Style', 'latepoint'), ['rounded' => 'Rounded Corners', 'flat' => 'Flat'], OsSettingsHelper::get_booking_form_border_radius()); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Login con i Social ', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <?php echo OsFormHelper::checkbox_field('settings[enable_google_login]', __('Effettua Login con Google', 'latepoint'), 'on', (OsSettingsHelper::get_settings_value('enable_google_login') == 'on'), array('data-toggle-element' => '.lp-google-settings')); ?>
        <div class="lp-form-checkbox-contents lp-google-settings" <?php echo (OsSettingsHelper::get_settings_value('enable_google_login') == 'on') ? '' : 'style="display: none;"' ?>>
          <h3><?php _e('Google Settings', 'latepoint'); ?></h3>
          <?php echo OsFormHelper::text_field('settings[google_client_id]', __('Google Client ID', 'latepoint'), OsSettingsHelper::get_settings_value('google_client_id')); ?>
          <?php echo OsFormHelper::password_field('settings[google_client_secret]', __('Google Client Secret', 'latepoint'), OsSettingsHelper::get_settings_value('google_client_secret')); ?>
        </div>
        <?php echo OsFormHelper::checkbox_field('settings[enable_facebook_login]', __('Effettua Login con Facebook', 'latepoint'), 'on', (OsSettingsHelper::get_settings_value('enable_facebook_login') == 'on'), array('data-toggle-element' => '.lp-facebook-settings')); ?>
        <div class="lp-form-checkbox-contents lp-facebook-settings" <?php echo (OsSettingsHelper::get_settings_value('enable_facebook_login') == 'on') ? '' : 'style="display: none;"' ?>>
          <h3><?php _e('Facebook Settings', 'latepoint'); ?></h3>
          <?php echo OsFormHelper::text_field('settings[facebook_app_id]', __('Facebook App ID', 'latepoint'), OsSettingsHelper::get_settings_value('facebook_app_id')); ?>
          <?php echo OsFormHelper::password_field('settings[facebook_app_secret]', __('Facebook App Secret', 'latepoint'), OsSettingsHelper::get_settings_value('facebook_app_secret')); ?>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Pagina di Configurazione', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[page_url_customer_dashboard]', __('URL della pagina del dashboard dell\'Utente', 'latepoint'), OsSettingsHelper::get_customer_dashboard_url()); ?>
          </div>
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[page_url_customer_login]', __('URL della pagina di accesso dell\'Utente', 'latepoint'), OsSettingsHelper::get_customer_login_url()); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="white-box">
      <div class="white-box-header">
        <div class="os-form-sub-header"><h3><?php _e('Altre Impostazioni', 'latepoint'); ?></h3></div>
      </div>
      <div class="white-box-content">
        <div class="os-row">
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[day_calendar_min_height]', __('Altezza minima calendario giornaliero (in pixel)', 'latepoint'), OsSettingsHelper::get_day_calendar_min_height()); ?>
          </div>
          <div class="os-col-lg-6">
            <?php echo OsFormHelper::text_field('settings[customer_dashboard_book_shortcode]', __('Shortcode per un pulsante del Sistema di Appuntamenti AppoinTy', 'latepoint'), OsSettingsHelper::get_settings_value('customer_dashboard_book_shortcode', '[latepoint_book_button]')); ?>
          </div>
        </div>
      </div>
    </div>
    <?php echo OsFormHelper::button('submit', __('Salva ', 'latepoint'), 'submit', ['class' => 'latepoint-btn']); ?>
  </form>
</div>
