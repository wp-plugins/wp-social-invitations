<?php
/**
 * Handles all operations in queue for sending invitations
 * @version	1.1
 * @since 1.4
 */

if ( !defined( 'ABSPATH' ) ) exit;

$wsi = WP_Social_Invitations::get_instance();

if( defined('DOING_CRON'))
{
	require_once (dirname (__FILE__) . '/class.Wsi_Fb.php');
	require_once (dirname (__FILE__) . '/class.Wsi_Tw.php');
	require_once (dirname (__FILE__) . '/class.Wsi_Lk.php');
	require_once (dirname (__FILE__) . '/class.Wsi_Mailer.php');
	require_once (dirname (__FILE__) . '/Googl.class.php');

	set_time_limit(60*15);
}

if( defined('DOING_AJAX') && isset($_REQUEST['action']) && $_REQUEST['action'] == 'wsi_test_email' )
{

	require_once (dirname (__FILE__) . '/class.Wsi_Mailer.php');
	$test_email = new Wsi_Mailer(null);
}
if( !class_exists('Wsi_Queue') ) {


	class Wsi_Queue{

		private static $instance = null;
		//store user data
		private $_user;

		
		 
		 /**
	     * Creates or returns an instance of this class.
	     *
	     * @return  Foo A single instance of this class.
	     */
	    public static function get_instance() {
	 
	        if ( null == self::$instance ) {
	            self::$instance = new self;
	        }
	 
	        return self::$instance;
	 
	    } // end get_instance;
    
		function __construct()
		{
			// get user data
			if( is_user_logged_in() ){
				global $current_user;
				get_currentuserinfo();
	
				$this->_user = $current_user;
	
			} else {
				//not registered user
				$this->_user = false;
	
			} 
		
		}
		
		function add_to_queue($provider, $sesion_data, $friends, $subject, $message, $display_name)
		{
			global $wpdb;
			//añadir friend count para llevar stats
			
			$result = $wpdb->query(
				$wpdb->prepare("INSERT INTO {$wpdb->base_prefix}wsi_queue ( provider, sdata, friends, subject, message, i_count, user_id, display_name, date_added) VALUES (%s, %s, %s, %s, %s, %d, %d, %s, NOW())", 
								array(
									$provider,
									$sesion_data,
									serialize($friends),
									$subject,
									$message,
									count($friends),
									$this->_user ? $this->_user->ID : '',
									$display_name
								)
							)
			);
			
		}
		function process_queue()
		{
			global $wsi, $wpdb;
			
			//retrieve locks - We locks in case wp-cron is run multiple times
			$lock_fb 		= get_option('wsi-lock-fb'); //facebook
			$lock_tw 		= get_option('wsi-lock-tw'); //twitter
			$lock_lk 		= get_option('wsi-lock-lk'); //linkedin
			$lock_email 	= get_option('wsi-lock-emails'); //emails
			

			//proccess facebook invitations
			if( !$lock_fb )
			{
				//lock facebook  until we finish
				update_option('wsi-lock-fb','yes');
				try{
					//we don't knwo about fb limits , so lets run a whole row
					$queue_data = $wpdb->get_row("SELECT id, sdata, friends, subject, message, user_id, send_at, display_name FROM {$wpdb->base_prefix}wsi_queue WHERE provider = 'facebook' ORDER BY id ASC");
					
					//if we have something in queue
					if( isset($queue_data->id) )
					{
						$fb = new Wsi_Fb($queue_data);
						
						$status = $fb->process();
						
					}	
					delete_option('wsi-lock-fb');
				}
				catch( Exception $e ){
						//delete it from queue to avoid same error everytime
						$wpdb->query("DELETE FROM {$wpdb->base_prefix}wsi_queue WHERE id = $queue_data->id");
						Wsi_Logger::log( "# " .$e->getCode(). " Wsi_FB: Facebook(top) queue proccesing error - " . $e->getMessage());
		 		 		delete_option('wsi-lock-fb');
				}	
			}//lock_fb
			
			//proccess emails queue
			if ( !$lock_email )
			{
				//lock emails queue until we finish
				update_option('wsi-lock-emails','yes');
				try{
					//we get first row of emails
					$queue_data = $wpdb->get_row("SELECT id, sdata, friends, subject, message, send_at, i_count, user_id, display_name, provider FROM {$wpdb->base_prefix}wsi_queue WHERE provider = 'google' OR provider = 'yahoo' OR provider = 'live' OR provider = 'foursquare' ORDER BY id ASC");
					
					//if we have something in queue
					if( isset($queue_data->id) )
					{
						//we send the bactch if limit is ok and in time
						if( !isset($queue_data->sent_at) || $queue_data->sent_at <= time() )	
						{
							$mailer = new Wsi_Mailer($queue_data);
							
							$status = $mailer->process();
							
						}
						
					}
		 		 		delete_option('wsi-lock-emails');
				}				
		 	    catch ( phpmailerException $e )
		 		{
			 			Wsi_Logger::log( "Wsi_Queue: Mail queue proccesing error - " . $e->errorMessage());
			 			delete_option('wsi-lock-emails');
			 	}
			    catch( Exception $e ){
						Wsi_Logger::log( "Wsi_Queue: Mail queue proccesing error - " . $e->getMessage());
		 		 		delete_option('wsi-lock-emails');
		 	    }
			}//lock_email
			
			//proccess twitter invitations
			if( !$lock_tw )
			{
				//lock facebook  until we finish
				update_option('wsi-lock-tw','yes');
				try{
					//we don't knwo about fb limits , so lets run a whole row
					$queue_data = $wpdb->get_row("SELECT id, sdata, friends, subject, message, send_at, user_id, i_count, display_name FROM {$wpdb->base_prefix}wsi_queue WHERE provider = 'twitter' AND ( send_at is NULL OR send_at <= NOW() ) ORDER BY id ASC");
					
					//if we have something in queue
					if( isset($queue_data->id) )
					{
						
						$tw = new Wsi_Tw($queue_data);
						
						$status = $tw->process();
						
						
					}	
					delete_option('wsi-lock-tw');
				}
				catch( Exception $e ){
						//delete it from queue to avoid same error everytime
						$wpdb->query("DELETE FROM {$wpdb->base_prefix}wsi_queue WHERE id = $queue_data->id");
						Wsi_Logger::log("# " .$e->getCode(). " Wsi_Tw: Twitter queue proccesing error - " . $e->getMessage());

		 		 		delete_option('wsi-lock-tw');
				}	
			}//lock_tw
			
			//proccess linkedin invitations
			if( !$lock_lk )
			{
				//lock facebook  until we finish
				update_option('wsi-lock-lk','yes');
				try{
					//we don't knwo about fb limits , so lets run a whole row
					$queue_data = $wpdb->get_row("SELECT id, sdata, friends, subject, message, send_at, user_id, i_count, display_name FROM {$wpdb->base_prefix}wsi_queue WHERE provider = 'linkedin' AND ( send_at is NULL OR send_at <= NOW() ) ORDER BY id ASC");
					
					//if we have something in queue
					if( isset($queue_data->id) )
					{
						$lk = new Wsi_Lk($queue_data);
						
						$status = $lk->process();
						
					}	
					delete_option('wsi-lock-lk');
				}
				catch( Exception $e ){
						//delete it from queue to avoid same error everytime
						$wpdb->query("DELETE FROM {$wpdb->base_prefix}wsi_queue WHERE id = $queue_data->id");
						Wsi_Logger::log("# " .$e->getCode(). " Wsi_Lk: Linkedin queue proccesing error - " . $e->getMessage());

		 		 		delete_option('wsi-lock-lk');
				}	
			}//lock_lk
				
		}
	
		
		public static function replacePlaceholders($display_name, $queue_id, $user_id, $content)
		{
			/*
			%%INVITERNAME%%: Display name of the inviter
			%%SITENAME%%: Name of your website 
			%%ACCEPTURL%%: Link that invited users can click to accept the invitation and register
			%%INVITERURL%%: If available, URL to the profile of the inviter
			%%CUSTOMURL%%: A custom URL that you can edit with a simple filter
			*/
			$que = array(
				'%%INVITERNAME%%',
				'%%SITENAME%%',
				'%%ACCEPTURL%%',
				'%%INVITERURL%%',
				'%%CUSTOMURL%%'
			);
			$accept_url 	= '';
			$inviter_url 	= '';
			
			if( function_exists('bp_get_root_domain') )
			{
				//BP is alive
				$accept_url 	= bp_get_root_domain() . '/' . bp_get_signup_slug() . '/wsi-accept-invitation/' . base64_encode( $queue_id );
				$inviter_url 	= bp_core_get_user_domain($user_id);	
			}
			else
			{
				$accept_url 	= site_url('/wp-login.php?action=register&wsi-accept-invitation='.base64_encode( $queue_id ));
			}
			$por = array(
				apply_filters('wsi_placeholder_invitername'	, !empty($display_name) ? $display_name : __('A friend of you', 'wsi')),
				apply_filters('wsi_placeholder_sitename'	, get_bloginfo('name')),
				apply_filters('wsi_placeholder_accepturl'	, $accept_url),
				apply_filters('wsi_placeholder_inviter_url'	, $inviter_url),
				apply_filters('wsi_placeholder_custom_url'	, ''),
				
			);
	
			return str_replace($que, $por, $content);
		}	
		
		/**
		 * Shorten url using goo.gl
		 * @since v1.4.3
		 * @return string
		 */
		 public static function shorten_url($url){
			$googl 		= new Googl();
			$shortened 	= $googl->shorten($url);
			unset($googl);
			
			return $shortened;
		}	
		

	}//end of class	
}