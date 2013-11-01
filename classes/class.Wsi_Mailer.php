<?php
/**
 * Handles Mail invitations
 * @since 1.4
 * @version 1
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; 

$wsi = WP_Social_Invitations::get_instance();


class Wsi_Mailer{
 
    private $_friends;
    private $_session_data;
    private $_subject;
    private $_message;
    private $_total_sent;
    private $_i_count;
    private $_user_data;
    private $_user_id;
    private $_display_name;
    private $_options;
    private $_provider;
	
	private $limit;
    
 	public function __construct( $queue_data ,$total_sent = 0)
 	{
 		global $wsi;
	 	$this->_options			= $wsi->getOptions();
 		
 		if( isset($queue_data->id))
 		{
	 		$this->_id 				= $queue_data->id;
	 		$this->_friends 		= unserialize($queue_data->friends);
	 		$this->_message 		= stripslashes($queue_data->message .'
	 		'. $this->_options['html_non_editable_message']);
	 		$this->_subject 		= stripslashes($queue_data->subject);
	 		$this->_i_count 		= $queue_data->i_count;
	 		$this->_display_name	= $queue_data->display_name;
	 		$this->_user_data 		= get_userdata($queue_data->user_id);
	 		$this->_user_id 		= $queue_data->user_id;
	 		$this->_total_sent 		= $total_sent;
	 		$this->_provider		= $queue_data->provider;
 		}
 		
 		$this->_limit			= $this->_options['emails_limit'];
 		$this->_every			= $this->_options['emails_limit_time'];
 		

 			
 		add_action('wp_ajax_wsi_test_email', array($this, 'send_test_email'));
	 	
 	}
 	
 	function process(){
 		
 		global $wsi,$wpdb;
 		
 		$delete_row = true;
 		
 		$sent_on_batch = 0;
 		
 		$message_content = $this->getMessageContent();
 		
 		foreach( $this->_friends as $key => $f )
 		{
 			$this->send_email($f, $this->_subject, $message_content);
 		
 			$this->_total_sent++;
 		
 			$sent_on_batch++;
 			
 			unset($this->_friends[$key]);
 			
 			//if we reach our limit
 			if( $this->_total_sent == $this->_limit )
 			{
 				$send_at = time() + $this->_every; //when to send next bacth
 				
 				//if we still have mails on this batch
 				if( $sent_on_batch < $this->_i_count)
 				{
 					//we update count and send date
 					$mails_left = $this->_i_count - $sent_on_batch;
 					
 					$friends_a 	= serialize($this->_friends);
 					
 					$wpdb->query( "UPDATE {$wpdb->base_prefix}wsi_queue SET i_count = '$mails_left', send_at = '$send_at', friends = '$friends_a'  WHERE id = '$this->_id'");
 					
 					$delete_row = false; // we can't delete this yet
 				}
 				else //we don't have more mails on this batch but we reached our $this->_limit  limit every $this->_every
 				{
 					//be sure to update the next record in db that send emails
 					$next_id = $wpdb->get_var("SELECT id FROM {$wpdb->base_prefix}wsi_queue WHERE id > '$this->_id' AND (provider = 'google' OR provider = 'yahoo' OR provider = 'live' OR provider = 'foursquare') ORDER BY id ASC LIMIT 1");
 					
 					$wpdb->query( "UPDATE {$wpdb->base_prefix}wsi_queue SET send_at = '$send_at' WHERE id = '$next_id' ");
 				}
 				
 				//exit our sending routine
 				break;
 			}
 		
 		}//endforeach
 		
 		//save stats
 		Wsi_Logger::log_stat($this->_provider, $this->_user_id, $sent_on_batch, $this->_id, $this->_display_name);
 		
 		// we finish with this row, lets delete it
 		if( $delete_row ) $wpdb->query("DELETE FROM {$wpdb->base_prefix}wsi_queue WHERE id ='$this->_id'");
 		
 		//IF we finish our batch and we haven't reach our limit we proccess next row in db
 		if( $this->_total_sent < $this->_limit )
 		{
 			
 			$queue_data = $wpdb->get_row("SELECT id, sdata, friends, subject, message, send_at, i_count, user_id, display_name, provider FROM {$wpdb->base_prefix}wsi_queue WHERE provider = 'google' OR provider = 'yahoo' OR provider = 'live' OR provider = 'foursquare' ORDER BY id ASC LIMIT 1");
 			
 			//if we have more rows, proccess them
 			if( isset($queue_data->id) )
 			{
 				$this->setNewData($queue_data, $this->_total_sent);
 			
 				$this->process();
 			}	
 			
 		}
 		
 		return $this->_total_sent;	
 	}
 	
 	private function setNewData( $queue_data ,$total_sent = 0)
 	{
 		
 		$this->_id 				= $queue_data->id;
 		$this->_friends 		= unserialize($queue_data->friends);
 		$this->_message 		= stripslashes($queue_data->message .'
 		'. $this->_options['html_non_editable_message']);
 		$this->_subject 		= stripslashes($queue_data->subject);
 		$this->_i_count 		= $queue_data->i_count;
 		$this->_total_sent 		= $total_sent;
 		$this->_display_name	= $queue_data->display_name;
 		$this->_user_data 		= get_userdata($queue_data->user_id);
 		$this->_user_id 		= $queue_data->user_id;
	 	
 	}	
	 	
 	function send_email( $email_to, $subject, $content, $headers = "Content-Type: text/html\r\n", $content_type = 'text/html', $attachments = '' )
 	{

		$this->_mail_content_type = $content_type;

		add_filter( 'wp_mail_from', array( $this, 'get_from_email' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		add_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
		
	
		ob_start();
		@$result = wp_mail( $email_to, $subject, $content, $headers, $attachments );
		$errors  = ob_get_contents();
		ob_clean(); 
		if( $result === false )
		{
			Wsi_Logger::log( "Wsi_Queue: Mail queue proccesing error - " . $errors);
		}
		// Unhook filters
		remove_filter( 'wp_mail_from', array( $this, 'get_from_email' ) );
		remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		remove_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
		
		return $errors;
	}
	
	function get_from_email()
	{
		if( $this->_user_data ) return apply_filters( 'wsi_from_email',$this->_user_data->user_email);

		return apply_filters( 'wsi_from_email', get_bloginfo('admin_email') );
	}


	function get_from_name()
	{
		if( $this->_user_data ) return apply_filters( 'wsi_from_name',$this->_user_data->display_name);

		return apply_filters( 'wsi_from_name', get_bloginfo('name') );
	}

	function get_content_type()
	{
		return $this->_mail_content_type;
	}
	
	function getMessageContent(){
		
			$this->replacePlaceholders();
			$content = $this->load_content();

			return $content;
	}
	
	function load_content($subject = null, $footer = null, $message = null)
	{
		$subject  ? '' : $subject =  $this->_subject ;
		$footer   ? '' : $footer  =  $this->_options['footer'] ;
		$message  ? '' : $message =  $this->_message ;
		
		ob_start();

		wsi_get_template( 'email/email-body.php', array(
			'email_subject' => $subject,
			'email_footer'  => stripslashes($footer),
			'emailContent' 	=> $message
		) );
		
		return ob_get_clean();
	}	
	
	function replacePlaceholders(){
		
		if(	$this->_display_name != '' )
		{
			$display_name = $this->_display_name;
		}
		elseif( $this->_user_data )
		{
			$display_name = $this->_user_data->display_name;
		}
		else
		{
			$display_name = '%%INVITERNAME%%'; // need to fix this for live users non registered
		}
		$this->_message 			= Wsi_Queue::replacePlaceholders($display_name, $this->_id, $this->_user_id, $this->_message);
		$this->_subject 			= Wsi_Queue::replacePlaceholders($display_name, $this->_id, $this->_user_id, $this->_subject);
	}
	
	
	 function send_test_email(){
	
		$email_to = get_bloginfo('admin_email');
		$subject  = __('WSI email settings test', 'wsi');
		$content  = __('You email settings are working like a charm!', 'wsi');
		
		$message  = $this->load_content($subject, '', $content);
		
		$result   = $this->send_email($email_to, $subject, $message);
	
		echo $result;
	
		
		die();
	}
}	