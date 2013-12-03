<?php
/**
 * Handles Facebook invitations
 * @since 1.4
 * @version 1.1
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; 

$wsi = WP_Social_Invitations::get_instance();


class Wsi_Fb{
 
    private $_friends;
    private $_session_data;
    private $_subject;
    private $_message;
	private $_display_name;
    private $_user_id;	
	private $_options;
    private $adapter;
    
 	public function __construct( $queue_data )
 	{
 		global $wsi;
 		

 		$this->_session_data 	= $queue_data->sdata;
 		$this->_friends 		= unserialize($queue_data->friends);
 		$this->_options			= $wsi->getOptions();
 		//this won't work with local url
 		$this->_message 		= stripslashes($queue_data->message .'
'. $this->_options['text_non_editable_message'].' ');

 		$this->_display_name	= $queue_data->display_name;
 		$this->_user_data 		= get_userdata($queue_data->user_id);
 		$this->_user_id 		= $queue_data->user_id;
 		$this->_id				= $queue_data->id;
 		
 		try{
 			$hybrid 	= $wsi->create_hybridauth('facebook');
	 		$hybrid->restoreSessionData(base64_decode($this->_session_data));
	 		
	 		$this->adapter = $hybrid->getAdapter('facebook');
	 		
	 		
	 	 }
	 	 catch( Exception $e ){
 	 		 	 Wsi_Logger::log( " - Wsi_FB: cannot load adapter " . $e->getMessage());

		 }	
	 	
 	}
 	
 	function process(){
	 	
	 	global $wpdb;
	 	
	 	$sent_on_batch = 0;
	 	$this->replacePlaceHolders();

 		
 		$profile = $this->adapter->getUserProfile();
 		$at 	 = $this->adapter->getAccessToken();
 		
 		$status  = false;
 		

		$options = array(
		    'uid' => $profile->identifier.'@chat.facebook.com',
		    'app_id' => $this->adapter->config['keys']['id'],
		    'server' => 'chat.facebook.com',
		   );
		
		
		   	$fp = ''; 

			if(! is_resource($fp))
			{
				#error_log("An error ocurred, could not connect to chat.facebook.com . Enable debug to see error - Falling back to post wall",0);
		    
				$this->post_to_wall();
				$sent_on_batch = 1;
			}
					  
		// we finish with this row, lets delete it
 		$wpdb->query("DELETE FROM {$wpdb->base_prefix}wsi_queue WHERE id ='$this->_id'");
 		
 		//we shared once let save to stats
 		Wsi_Logger::log_stat('facebook',$this->_user_id, $sent_on_batch, $this->_id, $this->_display_name );
 		
 		//Let's see if we have more in queue
 			
 		$queue_data = $wpdb->get_row("SELECT id, sdata, friends, subject, message, send_at, i_count, user_id, display_name FROM {$wpdb->base_prefix}wsi_queue WHERE provider = 'facebook' AND id > '$this->_id' ORDER BY id ASC LIMIT 1");
 			
		//if we have more rows, proccess them
		if( isset($queue_data->id) )
		{
			$this->setNewData($queue_data, 0);
		
			try{
				$result = $this->process();
			}
			catch( Exception $e ){
					//delete it from queue to avoid same error everytime
					#$wpdb->query("DELETE FROM {$wpdb->base_prefix}wsi_queue WHERE id = $queue_data->id");
					Wsi_Logger::log( "Wsi_FB: Facebook queue proccesing error - " . $e->getMessage());
			}	

			
		}	
		
		

 	}
 	
 	function post_to_wall(){
 			$attachment = array(
		    'message' => $this->_message, 
		   # 'name' => 'This is my demo Facebook application!',
		   # 'caption' => "Caption of the Post",
		   # 'link' => 'http://mylink.com',
		   # 'description' => 'this is a description',
		   # 'picture' => 'http://mysite.com/pic.gif',
		    'actions' => array(
		        array(
		            'name' => 'WP Social Invitations',
		            'link' => 'http://www.timersys.com/plugins-wordpress/wordpress-social-invitations/'
		        )
		    )
			);
		
			$result = $this->adapter->api()->api('/me/feed/', 'post', $attachment);	
 	
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

		add_filter('wsi_placeholder_accepturl', array( 'Wsi_Queue', 'shorten_url'));
		
		$this->_message 			= Wsi_Queue::replacePlaceholders($display_name, $this->_id, $this->_user_id, $this->_message);
	}


 	private function setNewData( $queue_data ,$total_sent = 0)
 	{
 		global $wsi;
 		
 		$this->_id 				= $queue_data->id;
 		$this->_friends 		= unserialize($queue_data->friends);
 		$this->_message 		= stripslashes($queue_data->message .'
 		'. $this->_options['text_non_editable_message']);
 		$this->_i_count 		= $queue_data->i_count;
 		$this->_total_sent 		= $total_sent;
 		
 		try{
 			$hybrid 	= $wsi->create_hybridauth('facebook');
	 		$hybrid->restoreSessionData(base64_decode($this->_session_data));
	 		
	 		$this->adapter = $hybrid->getAdapter('facebook');
	 		
	 		
	 	 }
	 	 catch( Exception $e ){
		 	 echo " - Wsi_FB: cannot load adapter " . $e->getMessage();
		 }		 	
 	}		
 		 	
 	
}