<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}


if ( ! class_exists( 'OsMessagesController' ) ) :


  class OsMessagesController extends OsController {



    function __construct(){
      parent::__construct();
      
      $this->views_folder = plugin_dir_path( __FILE__ ) . '../views/messages/';
      $this->vars['page_header'] = __('Messages', 'latepoint-messages');
      $this->vars['breadcrumbs'][] = array('label' => __('Messages', 'latepoint-messages'), 'link' => OsRouterHelper::build_link(OsRouterHelper::build_route_name('messages', 'index') ) );
    }


    function chat_box(){
    	$booking_id = $this->params['booking_id'];
	    $messages = OsMessagesHelper::get_messages_for_booking_id($booking_id);
	    $this->vars['booking_id'] = $booking_id;
	    $this->vars['messages'] = $messages;
	    
      $this->format_render(__FUNCTION__);
    }

    function check_unread_messages(){
      $booking_id = $this->params['booking_id'];
      $viewer_user_type = $this->params['viewer_user_type'];
      $unread_count = OsMessagesHelper::count_unread_messages_for_booking($booking_id, $viewer_user_type);
      $response_html = ($unread_count > 0) ? 'yes' : 'no';

      if($this->get_return_format() == 'json'){
        $this->send_json(array('status' => LATEPOINT_STATUS_SUCCESS, 'message' => $response_html));
      }
    }

    function view_attachment(){
    	$message_id = $this->params['message_id'];
    	$message = new OsMessageModel($message_id);
    	if(empty($message->id)) return;

    	$booking = new OsBookingModel($message->booking_id);
    	if(empty($booking->id)) return;

    	if(OsAuthHelper::is_admin_logged_in() || (OsAuthHelper::is_customer_logged_in() == $booking->customer_id) || (OsAuthHelper::get_logged_in_agent_id() == $booking->agent_id)){
    		$file_path = get_attached_file($message->content);
		    $file_content_type = get_post_mime_type($message->content);
		    $file_name = basename($file_path);
		    header('Content-Type: '.$file_content_type);
				header('Content-Disposition: attachment; filename="'.$file_name.'"');
				header('Pragma: no-cache');
				readfile($file_path);
    	}
    	return;
    }

    function load_messages_for_booking(){
    	if(!isset($this->params['booking_id']) || empty($this->params['booking_id'])) return;
    	$booking_id = $this->params['booking_id'];
      $this->vars['viewer_user_type'] = $this->params['viewer_user_type'];

	    $messages = OsMessagesHelper::get_messages_for_booking_id($booking_id);
	    $this->vars['booking_id'] = $booking_id;
	    $this->vars['messages'] = $messages;
	    
      $this->format_render(__FUNCTION__);
    }

    function create(){
    	$message_data = $this->params['message'];
    	$status = LATEPOINT_STATUS_SUCCESS;
    	if(($message_data['author_type'] == 'admin') && !OsAuthHelper::get_logged_in_admin_user_id()){
    		$status = LATEPOINT_STATUS_ERROR;
    		$response_html = __('Error! Invalid Admin ID', 'latepoint-messages');
    	}
    	if(($message_data['author_type'] == 'agent') && !OsAuthHelper::get_logged_in_agent_id()){
    		$status = LATEPOINT_STATUS_ERROR;
    		$response_html = __('Error! Invalid Agent ID', 'latepoint-messages');
    	}
    	if(($message_data['author_type'] == 'customer') && !OsAuthHelper::get_logged_in_customer_id()){
    		$status = LATEPOINT_STATUS_ERROR;
    		$response_html = __('Error! Invalid Customer ID', 'latepoint-messages');
    	}
    	if($status == LATEPOINT_STATUS_SUCCESS){
    		$message_model = new OsMessageModel();
    		$message_model->set_data($message_data);
    		if($message_data['author_type'] == 'agent'){
    			$message_model->author_id = OsAuthHelper::get_logged_in_agent_id();
    		}elseif($message_data['author_type'] == 'admin'){
    			$message_model->author_id = OsAuthHelper::get_logged_in_admin_user_id();
    		}elseif($message_data['author_type'] == 'customer'){
    			$message_model->author_id = OsAuthHelper::get_logged_in_customer_id();
    		}
    		if($message_model->save()){
          if($message_model->author_type == 'customer'){
            OsMessagesHelper::send_message_notification_to_agent($message_model);
          }
          if(in_array($message_model->author_type, ['agent', 'admin'])){
            OsMessagesHelper::send_message_notification_to_customer($message_model);
          }
          $response_html = __('Success', 'latepoint-messages');
        }else{
          $status = LATEPOINT_STATUS_ERROR;
      		$response_html = __('Error sending message. Try again later.', 'latepoint-messages');
        }
    	}
      if($this->get_return_format() == 'json'){
        $this->send_json(array('status' => $status, 'message' => $response_html));
      }
    }

  }
endif;
