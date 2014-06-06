<?php
/**
 * Handles Facebook invitations
 * @since 1.4
 * @version 1.3
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

 		$this->_options			= $wsi->getOptions();
 		
 		$this->_display_name	= $queue_data->display_name;
 		$this->_user_data 		= get_userdata($queue_data->user_id);
 		$this->_user_id 		= $queue_data->user_id;
 		$this->_id				= $queue_data->id;
 		$this->_i_count 		= $queue_data->i_count;
 		

 	}
 	
 	function process(){
	 	
	 	global $wpdb;
	 	
	 	
					
		do_action('wsi_invitation_sent', $this->_user_id );									
					
				
 		//we shared once let save to stats
 		Wsi_Logger::log_stat('facebook',$this->_user_id, 1, $this->_id, $this->_display_name );
 		
 		$wpdb->query("DELETE FROM {$wpdb->base_prefix}wsi_queue WHERE id ='$this->_id'");
 		
 		
 		$queue_data = $wpdb->get_row("SELECT id, sdata, friends, subject, message, send_at, i_count, user_id, display_name FROM {$wpdb->base_prefix}wsi_queue WHERE provider = 'facebook' AND id > '$this->_id' ORDER BY id ASC LIMIT 1");
 			
 		//if we have more rows, proccess them
		if( isset($queue_data->id) )
		{
			$this->setNewData($queue_data, 0);
					
			$result = $this->process();
				
		}	
 			
 	}
 	 	
	
 	private function setNewData( $queue_data ,$total_sent = 0)
 	{
 		global $wsi;
 		
 		$this->_id 				= $queue_data->id;
 			
 	}		 	
 	
}