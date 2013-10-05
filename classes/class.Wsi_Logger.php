<?php
/**
 * Handles Logs and debug
 * @since 1.4
 * @version 1
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; 

$wsi = WP_Social_Invitations::get_instance();


class Wsi_Logger{
 
	private static $_options;
    
 	public function __construct()
 	{
 		global $wsi;
 		$this->_options			= $wsi->getOptions();
 	}
 	
 	public static function log( $message)
 	{
 		global $wsi;
 		
 		self::$_options			= $wsi->getOptions();
 		
 		if( self::$_options['enable_dev'] == 'true')
 			error_log($message,0);
 	
 	}
 	
 	public static function log_stat($provider, $user_id, $quantity, $queue_id, $display_name)
 	{

		global $wpdb;
		
		$wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->base_prefix}wsi_stats (provider, user_id, quantity, queue_id,display_name, i_datetime) VALUES (%s, %d, %d, %d, %s, NOW())", array($provider, $user_id, $quantity, $queue_id, $display_name)));
 		
 	
 	}
 	
} 	