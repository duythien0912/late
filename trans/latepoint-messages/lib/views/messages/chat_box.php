<div class="booking-messages-panel side-sub-panel" data-route="<?php echo OsRouterHelper::build_route_name('messages', 'load_messages_for_booking'); ?>" data-check-unread-route="<?php echo OsRouterHelper::build_route_name('messages', 'check_unread_messages'); ?>">
  <div class="os-form-header">
    <h2><?php _e('Message History', 'latepoint-messages'); ?></h2>
    <a href="#" class="latepoint-messages-panel-close"><i class="latepoint-icon latepoint-icon-x"></i></a>
  </div>
  <div class="booking-messages-panel-i">
    <div class="booking-messages-list">
      <?php include('load_messages_for_booking.php'); ?>
    </div>
    <div class="os-booking-messages-input-w" data-avatar-url="<?php echo OsAuthHelper::get_admin_or_agent_avatar_url(); ?>" data-author-type="<?php echo OsAuthHelper::is_agent_logged_in() ? 'agent' : 'admin'; ?>" data-booking-id="<?php echo $booking_id; ?>" data-route="<?php echo OsRouterHelper::build_route_name('messages', 'create'); ?>">
      <input class="os-booking-messages-input" type="text" placeholder="<?php echo __('Type your message here..', 'latepoint-messages'); ?>"/>
      <div class="latepoint-btn latepoint-btn-primary os-bm-send-btn"><i class="latepoint-icon latepoint-icon-message-square"></i><span><?php echo __('Send', 'latepoint-messages'); ?></span></div>
      <div class="latepoint-btn latepoint-btn-secondary os-bm-upload-file-btn"><i class="latepoint-icon latepoint-icon-paperclip"></i><span><?php echo __('Attach File', 'latepoint-messages'); ?></span></div>
    </div>
  </div>
</div>
