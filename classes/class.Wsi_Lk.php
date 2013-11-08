<?php
/**
 * Handles Linkedin invitations
 * @since 1.4
 * @version 1
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; 

$wsi = WP_Social_Invitations::get_instance();

require_once (dirname (__FILE__) . '/Googl.class.php');

class Wsi_Lk{
 
    private $_friends;
    private $_session_data;
    private $_message;
    private $_total_sent;
    private $_i_count;
    private $_user_data;
    private $_user_id;
    private $_display_name;
    private $_options;
    private $adapter;
	
	private $limit;
    
 	public function __construct( $queue_data ,$total_sent = 0)
 	{
 		global $wsi;
 		
 		$this->_id 				= $queue_data->id;
 		$this->_friends 		= unserialize($queue_data->friends);
 		$this->_options			= $wsi->getOptions();
 		$this->_message 		= stripslashes($queue_data->message);
 		$this->_subject 		= stripslashes($queue_data->subject);
 		$this->_i_count 		= $queue_data->i_count;
 		$this->_display_name	= $queue_data->display_name;
 		$this->_user_data 		= get_userdata($queue_data->user_id);
 		$this->_user_id 		= $queue_data->user_id;
 		$this->_total_sent 		= $total_sent;
 		$this->_session_data 	= $queue_data->sdata;
 		
 		try{
 			$hybrid 	= $wsi->create_hybridauth('linkedin');
	 		$hybrid->restoreSessionData(base64_decode($this->_session_data));
	 		
	 		$this->adapter = $hybrid->getAdapter('linkedin');
	 		

	 		
	    }
	 	catch( Exception $e ){
		 	 Wsi_Logger::log( " - Wsi_Lk: cannot load adapter " . $e->getMessage());
		}
		 
 		
 		// Sends a message to up to 10 connections
 		// Application: 5k
 		// Per User: 10
 		
 		
 		$this->_limit			= 5000; //250
 		$this->_every			= strtotime('tomorrow'); //tomorrow 00 utc
	 	
 	}
 	
 	function process(){
 		
 		global $wsi,$wpdb;
 		
 		$delete_row = true;
 		
 		$sent_on_batch = 0;

 		$sent_messages = 0;
 		
 		$this->replacePlaceholders();
 		
 		$status[0] = $this->_subject;
 		$status[1] = $this->_message;
 		
 		$this->adapter->setUserStatus( $status );
 		
 		
	 			 
	 	$this->_total_sent++;
	 			
	 	$sent_on_batch++;
	 			
 			
 		
 		Wsi_Logger::log_stat('linkedin',$this->_user_id, $sent_on_batch, $this->_id, $this->_display_name);
 		
 		// we finish with this row, lets delete it
 		if( $delete_row ) $wpdb->query("DELETE FROM {$wpdb->base_prefix}wsi_queue WHERE id ='$this->_id'");
 		
 		
 		//IF we finish our batch and we haven't reach our limit we proccess next row in db
 		if( $this->_total_sent < $this->_limit )
 		{ 		
 			//Let's see if we have more in queue
 			
 			$queue_data = $wpdb->get_row("SELECT id, sdata, friends, subject, message, send_at, i_count, user_id, display_name FROM {$wpdb->base_prefix}wsi_queue WHERE provider = 'linkedin' AND id > '$this->_id' AND display_name != '$this->_display_name' ORDER BY id ASC LIMIT 1");
 			
			//if we have more rows, proccess them
			if( isset($queue_data->id) )
			{
				$this->setNewData($queue_data, $this->_total_sent);
			
				try{
					$result = $this->process();
				}
				catch( Exception $e ){
						//delete it from queue to avoid same error everytime
						#$wpdb->query("DELETE FROM {$wpdb->base_prefix}wsi_queue WHERE id = $queue_data->id");
						Wsi_Logger::log( "Wsi_LK: Linkedin queue proccesing error - " . $e->getMessage());
				}

			}	
 		}	
 		
 		return $this->_total_sent;	
 	}
 	
 	private function setNewData( $queue_data ,$total_sent = 0)
 	{
 		global $wsi;
 		$this->_id 				= $queue_data->id;
 		$this->_friends 		= unserialize($queue_data->friends);
 		$this->_message 		= stripslashes($queue_data->message);
 		$this->_subject 		= stripslashes($queue_data->subject);
 		$this->_i_count 		= $queue_data->i_count;
 		$this->_total_sent 		= $total_sent;
 		
 		try{
 			$hybrid 	= $wsi->create_hybridauth('twitter');
	 		$hybrid->restoreSessionData(base64_decode($this->_session_data));
	 		
	 		$this->adapter = $hybrid->getAdapter('twitter');
	 		
	 		
	    }
	 	catch( Exception $e ){
		 	 Wsi_Logger::log( " - Wsi_Lk: cannot load adapter " . $e->getMessage());
		}	 	
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
		add_filter('wsi_placeholder_accepturl', array( $this, 'shortern_url'));
		
		$this->_message 			= Wsi_Queue::replacePlaceholders($display_name, $this->_id, $this->_user_id, $this->_message);
		$this->_subject 			= Wsi_Queue::replacePlaceholders($display_name, $this->_id, $this->_user_id, $this->_subject);
		
		
	}
	
	function shortern_url($url){
		$googl 		= new Googl();
		$shortened 	= $googl->shorten($url);
		unset($googl);
		
		return $shortened;
	}
	
}	