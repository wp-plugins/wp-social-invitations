<?php
/*
Plugin Name: WP Social Invitations
Plugin URI: http://www.timersys.com/plugins-wordpress/wordpress-social-invitations/
Description: Allow your visitors to invite friends of their social networks such as Google, Yahoo, Hotmail and more.
Version: 1.3
Author: timersys
Author URI: http://www.timersys.com
License: http://codecanyon.net/licenses/regular
Text Domain: wsi
Domain Path: languages
*/

/*

****************************************************************************
* License http://codecanyon.net/licenses/regular
****************************************************************************
*/


// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

require(dirname (__FILE__).'/WP_Plugin_Base.class.php');
  
class WP_Social_Invitations extends WP_Plugin_Base
{

	
	static $_options;
	var $_credits;
	var $_defaults;
	var $assets_url;
	private $hybridauth;
	protected $sections;
	public static $providers;
	 /** Refers to a single instance of this class. */
    private static $instance = null;
 
    /*--------------------------------------------*
     * Constructor
     *--------------------------------------------*/
 
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
    
	function __construct() {
		
		$this->WPB_PREFIX		=	'wsi';
		$this->WPB_SLUG			=	'wp-social-invitations'; // Need to match plugin folder name
		$this->WPB_PLUGIN_NAME	=	'WP Social Invitatios';
		$this->WPB_VERSION		=	'1.3';
		$this->PLUGIN_FILE		=   plugin_basename(__FILE__);
		$this->options_name		=   $this->WPB_PREFIX.'_settings';
		
		self::$providers 		= 	array('google' 		=> 'Gmail',
										  'yahoo'		=> 'Yahoo Mail',
										  'live'		=> 'Live, Hotmail',
										  'foursquare'	=> 'Foursquare'
									); 
		
		$this->sections['general']      		= __( 'Main Settings', $this->WPB_PREFIX );
		$this->sections['messages']        		= __( 'Default Messages', $this->WPB_PREFIX );
		$this->sections['upgrade']        		= __( 'Upgrade', $this->WPB_PREFIX );
		
		
		//activation hook
		register_activation_hook( __FILE__, array(&$this,'activate' ));        
		
		//deactivation hook
		register_deactivation_hook( __FILE__, array(&$this,'deactivate' ));   
		
		//admin menu
		add_action( 'admin_menu',array(&$this,'register_menu' ) );
		
		//load js and css 
		add_action( 'init',array(&$this,'load_scripts' ),50 );	
		
		#$this->upgradePlugin();
			
		$this->setDefaults();
		
		$this->loadOptions();
		
		
		//Ajax hooks here	
		add_action('wp_ajax_wsi_collect_emails', array(&$this,'send_emails_callback'));
		add_action('wp_ajax_nopriv_wsi_collect_emails', array(&$this,'send_emails_callback'));
		add_action('wp_ajax_wsi_order', array(&$this,'change_widget_order'));
		
		//Info boxes
		add_action('general_wpb_print_box' ,array(&$this,'print_general_box'));
		add_action('messages_wpb_print_box' ,array(&$this,'print_messages_box'));
		add_action('upgrade_wpb_print_box' ,array(&$this,'print_upgrade_box'));
		add_action('styling_wpb_print_box' ,array(&$this,'print_styling_box'));
		
		//hook to proccess auth if detected
		add_action( 'init', array(&$this, 'process_auth' ));
		
		parent::__construct();
		
		$this->WSI_HYBRIDAUTH_ENDPOINT_URL = $this->WPB_PLUGIN_URL. '/hybridauth/';
		$this->assets_url  		= $this->WPB_PLUGIN_URL . '/assets/img/';
		
	}	
		
	/**
	* Check technical requirements before activating the plugin. 
	* Wordpress 3.0 or newer required
	*/
	function activate()
	{
		parent::activate();
		
		$providers_order = get_option('wsi_widget_order',true);
		
		if( is_array($providers_order))
		{
			$missing_provider = array_diff(self::$providers , $providers_order);
			
			if( !empty($missing_provider))
			{
				$providers_order = $providers_order + $missing_provider;
				update_option( 'wsi_widget_order' , $providers_order);
			}
		}
		
		do_action( $this->WPB_PREFIX.'_activate' );
		
		
	}	

	/**
	* Run when plugin is deactivated
	* Wordpress 3.0 or newer required
	*/
	function deactivate()
	{
		
	#	global $wpdb;
	#	$wpdb->query("DROP TABLE  `".$wpdb->base_prefix."wsm_monitor_index`");
		
		do_action( $this->WPB_PREFIX.'_deactivate' );
	}
	


	/**
	* function that register the menu link in the settings menu	and editor section inside the option page
	*/
	 function register_menu()
	{
		add_menu_page( 'WP Social Invitations', 'WP Social Invitations', 'manage_options', $this->WPB_SLUG ,array(&$this, 'display_page') );
		
	}

	/**
	* Load scripts and styles
	*/
	function load_scripts()
	{
		if(!is_admin())
		{
			wp_enqueue_style('wsi-css', plugins_url( 'assets/css/style.css', __FILE__ ) ,'',$this->WPB_VERSION,'all' );
			wp_localize_script( 'jquery', 'MyAjax', array( 'url' => site_url( 'wp-login.php' ),'admin_url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'wsi-ajax-nonce' ) ) );
		}
		else
		{
			wp_enqueue_style('wsi-back-css', plugins_url( 'admin/assets/style.css', __FILE__ ) ,'',$this->WPB_VERSION, 'all' );
			wp_enqueue_script('codemirror');
		}

		
	}
	
	/**
	* Function to load the javscript for big widget
	*/
	static function load_wsi_js(){
	
			wp_enqueue_script('wsi-js', plugins_url( 'assets/js/wsi.js', __FILE__ ), array('jquery'),self::$WPB_VERSION,true);
	}

	
		
	/**
	* Create Widget
	*/
	function init_widget(){
	
		#register_widget('Twitter_Like_Box_Widget');
	
	}
	
	/**
	* Load options to use later
	*/	
	function loadOptions()
	{

		self::$_options = get_option($this->WPB_PREFIX.'_settings',$this->_defaults);

	}
	
		
	/**
	* loads plugins defaults
	*/
	function setDefaults()
	{
		$this->_defaults = array( 'version' => $this->WPB_VERSION, 'hook_buddypress' => 'true', 'hook_invite_anyone' => 'true' );		
	}
	
	/**
	* Print general section Box
	*/
	function print_general_box(){
	
	?>
		<div class="info-box">
		<h2><?php printf(__('Welcome to <a href="%s">Wordpress Social Invitations</a>!',$this->WPB_PREFIX),'http://www.timersys.com/en/wordpress-plugins/wordpress-social-invitations/');?></h2>
		<p><?php printf(__('To start using the plugin you need to fill out the OAuth settings of the following providers. If you need help, please read the <a href="%s" target="_blank">documentation</a> or go to the <a href="%s" target="_blank">support forum</a>.',$this->WPB_PREFIX),$this->WPB_PLUGIN_URL.'/docs/index.html','http://timersys.ticksy.com/');?></p>
		<p><?php _e('You can place the invitation widget on any page by using the following shortcode:',$this->WPB_PREFIX);?></p>
		<code>[wsi-widget title="Invite your friends"]</code>
		<p>Or you can place it in your templates with:</p>
		<code>WP_Social_Invitations::widget('Invite some friends!!');</code>
				
		</div><?php
	}

	/**
	* Print Default messages Box
	*/
	function print_messages_box(){
	
	?>
		<div class="info-box">
		<p><?php _e('By default your users will be able to edit the default invitation message. Here you will be able to change the default message and forbid users to change it.',$this->WPB_PREFIX);?></p>
				
		</div><?php
	}
	/**
	* Print Upgrade  Box
	*/
	function print_upgrade_box(){
	
	?>
		<div class="info-box">
			<h2>Check out all the features of Wordpress Social Invitations Premium:</h2>
			<ul style="list-style: square;margin-left: 30px;">
				<li>Facebook integration</li>
				<li>Linkedin integration</li>
				<li>Twitter integration</li>
				<li>Hooks with Invite Anyone Plugin</li>
				<li>Hooks with Buddypress</li>
				<li>You can change the widget order</li>
				<li>You can add custom CSS</li>
				<li>You can redirect users to a specific page after invitations are sent</li>
				<li>Free Support</li>
				<li>New features added every month</li>
			</ul>
			
			<h1><a href="http://codecanyon.net/item/wordpress-social-invitations/5026451?ref=chifliiiii" title="Download latest Version">Download latest Version</a></h1>
		</div><?php
	}

	/**
	* Print Styling  Box
	*/
	function print_styling_box(){
	
	?>
		<div class="info-box">
			<p><?php _e('Here you can drag and drop the providers to change the order in the widget and also you will be able to add custom CSS.',$this->WPB_PREFIX);?></p>
		</div><?php
	}

	
	/**
	* We change widget title for invite anyone plugin
	*/
	function widget_title($title){
	 	return __('You can also add email addresses from:', $this->WPB_PREFIX); 
	}
	
	/**
	* Function to display the extended widget
	*/
	static function display_widget()
	{

		require_once( dirname (__FILE__).'/widget/widget.php');
		
	}
	
	/**
	* Function to use inside themes that display widget and enqueue necessary js
	*/
	static function widget($title="")
	{
		self::load_wsi_js();
		require_once( dirname (__FILE__).'/widget/widget.php');
	}
	
	/**
	* Procces auth proccess capturing the popup
	*/
	function process_auth(){
	
		if( ! isset( $_REQUEST[ 'action' ] ) || $_REQUEST['action'] != 'wsi_authenticate'  )
		{
				return null;
		}
		
		if( $_REQUEST[ 'action' ] == "wsi_authenticate" )
		{
				$this->process_login_auth();
		}

	}
	
	
	/**
	* Function that handle auth
	*/
	function process_login_auth() {
	
		// let display a loading message. should be better than a white screen
		if( isset( $_REQUEST["provider"] ) && ! isset( $_REQUEST["redirect_to_provider"] ) ){
			$this->process_login_render_loading_page();
		}	
		try{
		
		$settings = self::$_options;
		$provider = @ trim( strip_tags( $_REQUEST["provider"] ) );
		if( $provider != 'live')
		{
			$adapter = $this->connect_to_provider();
			$hybridauth = $this->hybridauth;
		}	

		
		if( ! empty( $provider ) && ($provider == 'live' || $hybridauth->isConnectedWith( $provider ) ))
		{
			$return_to = @ $_GET['redirect_to'];
			$return_to = $return_to . ( strpos( $return_to, '?' ) ? '&' : '?' ) . "connected_with=" . $provider ;
			
			?>
			<html>
			<link rel="stylesheet" href="<?php echo plugins_url( 'assets/css/collector.css', __FILE__ );?>" type="text/css" media="all">
			<head>
			<title><?php _e('Select your Friends',$this->WPB_PREFIX);?> - Wordpress Social Invitations</title>
				<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
				<script>
					$(document).ready(function(){
						$('#nonce').val(window.opener.MyAjax.nonce);
						$('#select_all').click(function(){
							$('#collect_emails').find(':checkbox').prop('checked', this.checked);
						});
					<?php if ( isset($_GET['wsi_hook']) && $_GET['wsi_hook'] == 'anyone') : ?>
						$('#collect_emails').submit(function(e){
							e.preventDefault();
							$('body *').hide();
							$('#wsi_loading,#wsi_loading * ').fadeIn();
							var emails = '';
							$(".friends_container input:checkbox:checked").each(function(){
								emails += $(this).val()+'\n';
							});
							$('#invite-anyone-email-addresses',window.opener.document).html(emails);
							$('#<?php echo $provider;?>-provider',window.opener.document).addClass('completed');
							$('#wsi_provider',window.opener.document).html('<?php echo ucfirst($provider);?>');
							$('.wsi_success',window.opener.document).fadeIn('slow',function(){
								
								window.self.close();  
							});
								
						});	
					
					<?php else:?>
						$('#collect_emails').submit(function(e){
							e.preventDefault();
							$('body *').hide();
							$('#wsi_loading,#wsi_loading * ').fadeIn();
							
							<?php  
							//Jaxl seems to fail with wordpress ajax, so we cal lit directly
							$ajax_url = $provider == 'facebook' ?   '\''.$this->WPB_PLUGIN_URL.'/jaxl/xfacebook_platform_client.php\'' : 'window.opener.MyAjax.admin_url';?>
							$.post(<?php echo $ajax_url;?>, $('#collect_emails').serialize(), function(response){
								$('#<?php echo $provider;?>-provider',window.opener.document).addClass('completed');
								$('#wsi_provider',window.opener.document).html('<?php echo ucfirst($provider);?>');
								$('.wsi_success',window.opener.document).fadeIn('slow',function(){
								
								window.self.close();  
							<?php if( $settings['redirect_url'] != '' ) :?>	
								window.opener.location.href = '<?php echo $settings['redirect_url'];?>';
							<?php endif;?>	
							});

								
								
							});
							return false;							
						});
					<?php endif;?>	
					

						
					});			
				function init() {

	
					if(  window.opener ){
						
						window.opener.parent.location.href = "<?php echo $return_to; ?>";
					}
				
					window.self.close();
				}
				</script>
			</head>
			<body>
			<?php if( $provider == 'live' ) : ?>
					<link rel="stylesheet" href="<?php echo plugins_url( 'assets/css/jquery.fileupload-ui.css', __FILE__ );?>" type="text/css" media="all">
					<script src="<?php echo plugins_url( 'assets/js/jquery.ui.widget.js', __FILE__ );?>"></script>
					<script src="<?php echo plugins_url( 'assets/js/jquery.iframe-transport.js', __FILE__ );?>"></script>
					<script src="<?php echo plugins_url( 'assets/js/jquery.fileupload.js', __FILE__ );?>"></script>
					<script type="text/javascript">
					jQuery(function($){
						$('#collect_container').hide();
					});
					jQuery(document).ready(function($) { 
						$('#collect_container').hide();
						$('#fileupload').fileupload({
					        url: '<?php echo $this->WPB_PLUGIN_URL ?>/uploads/',
					        dataType: 'json',
					        start: function(){
					        	 $('#progress .bar').fadeIn();
					        	 $('.errors').hide();
					        },
					        done: function (e, data) {
					            $.each(data.result.files, function (index, file) {
					                 if ( file.error)
					                 {
					                 	$('.errors').html(file.error).fadeIn();
					                 }
					                 else
					                 {
					                 	var html_inputs = '';
					                 	var counter = 0;
					                 	var classstr= '';
					                 	persons = file.data;
					                 	for( i in persons)
					                 	{
					                 		counter++;
					                 		classstr= '';
					                 		if( counter == 3)
					                 		{
					                 			classstr = 'last';
					                 			counter = 0;
					                 		}	
					                 		html_inputs += '<div class="frien_item '+classstr+'"><input type="checkbox" value="'+persons[i]['E-mail Address']+'" name="friend[]" checked="true"/> '+persons[i]['First Name']+' '+persons[i]['Last Name']+'<span>'+persons[i]['E-mail Address']+'</span></div>';
					                 		
					                 	}
					                 	html_inputs += '<div style="clear:both;"></div>';
					                 	$('.friends_container').html(html_inputs);
					                 	$('#upload_container').hide();
					                 	$('#collect_container').fadeIn();
					                 }
					                 $('#progress .bar').fadeOut();
					            });
					        },
					        dropZone: $('#dropzone'),
					        progressall: function (e, data) {
					            var progress = parseInt(data.loaded / data.total * 100, 10);
					            $('#progress .bar').css(
					                'width',
					                progress + '%'
					            );
					        }    
					    });
					$(document).bind('dragover', function (e) {
					    var dropZone = $('#dropzone'),
					        timeout = window.dropZoneTimeout;
					    if (!timeout) {
					        dropZone.addClass('in');
					    } else {
					        clearTimeout(timeout);
					    }
					    var found = false,
					      	node = e.target;
					    do {
					        if (node === dropZone[0]) {
					       		found = true;
					       		break;
					       	}
					       	node = node.parentNode;
					    } while (node != null);
					    if (found) {
					        dropZone.addClass('hover');
					    } else {
					        dropZone.removeClass('hover');
					    }
					    window.dropZoneTimeout = setTimeout(function () {
					        window.dropZoneTimeout = null;
					        dropZone.removeClass('in hover');
					    }, 100);
					});
					}); 
					</script>
				<div id="upload_container">	
				    <span class="btn btn-success fileinput-button">
				        <h2>Live, Hotmail, Msn</h2>
				        <p><?php _e('To import your contacts emails addresses please follow these two simple steps',$this->WPB_PREFIX);?></p>
				        <ol>
				        	<li><?php _e('Download WLMContacts.csv to your computer by clicking',$this->WPB_PREFIX);?> :<a href="https://mail.live.com/mail/GetContacts.aspx" title="Download" class="button">Download</a></li>
				        	<li><?php _e('Find WLMContacts.csv in your computer, usually located in downloads folder and drag and drop it the "drag & drop" zone ',$this->WPB_PREFIX);?></li>
				        </ol>
				        
				        <div id="dropzone" class="fade well"><?php _e('Drop your files here',$this->WPB_PREFIX);?></div>
				        <!-- The file input field used as target for the file upload widget -->
				        <input id="fileupload" type="file" name="files[]" multiple>
			            <div id="progress" class="progress progress-animated progress-striped">
					        <div class="bar"></div>
					    </div>
					    <div class="errors alert-error alert" style="display:none;">
					    
					    </div>
				    </span>
				</div>
			<?php endif;?>
			<div id="collect_container">
				<h2><?php _e("Select who you want to send the invite email", $this->WPB_PREFIX);?></h2>
				<?php
				if( $provider != 'live')
				{
					$user_profile = $adapter->getUserProfile();
					$at =  $adapter->getAccessToken();
				}	
				?>
				<form id="collect_emails" method="post" action="<?php echo $return_to.'&collected_data=true';?>">
					
					<input type="hidden" name="action" value="<?php echo $provider == 'facebook'? 'wsi_facebook' : 'wsi_collect_emails';?>"/>
					<input type="hidden" id="nonce" name="nonce" value=""/>
					<input type="hidden" id="provider" name="provider" value="<?php echo $provider;?>"/>
				<?php if( $provider != 'live'):?>
					<input type="hidden" name="uid" value="<?php echo $user_profile->identifier;?>">
					<input type="hidden" name="app_id" value="<?php echo $adapter->config['keys']['id'];?>">
					<input type="hidden" name="access_token" value="<?php echo $at['access_token']?>">
				<?php endif;?>	
				
				<?php 
					if( $provider == 'live' )
					{
						global $current_user;
						get_currentuserinfo();
						?>
						<input type="hidden" name="user_id" id="user_id" value="<?php echo $current_user->display_name;?>"/>
						<?php
					}
					else
					{
						
						?>
						<input type="hidden" name="user_id" id="user_id" value="<?php echo utf8_decode($user_profile->displayName);?>"/>
						<?php
					}
					
					
					?>
					<div class="check_all">
						<input type="checkbox" id="select_all" value="true"> <?php _e('Check/Uncheck All', $this->WPB_PREFIX);?>
					</div>
					<div class="friends_container">	
						<?php 
						if ( $provider != 'live')
						{
							@$friends = $adapter->getUserContacts();
							$counter = 0;
							if(!empty($friends))
							{
								

								foreach( $friends as $friend)
								{
									$counter++; $class="";
									if( $counter == 3){
										$class = 'last';
										$counter = 0;
									}
									?>
									<div class="frien_item <?php echo $class;?>">
									
										<?php if( isset($friend->photoURL) && $friend->photoURL): ?>
										
											<img src="<?php echo $friend->photoURL;?>" alt=""/>
										
										<?php endif;?>
										<input type="checkbox" value="<?php echo $provider == 'linkedin' || $provider == 'google' || $provider == 'facebook' || $provider == 'twitter' ? $friend->identifier : $friend->email;?>" name="friend[]" checked="true"/> <?php echo utf8_decode($friend->displayName);?>
										<span><?php echo $friend->email;?></span>
									</div>
									
									<?php
								}
							}
							else
							{
								throw new Exception(__('Your contacts list on this provider is empty. Add some contacts first! - Providers like Yahoo or Mail only return contacts created with them, and not contacts imported from other networks.',$this->WPB_PREFIX),10);
							}
						}		
						//cant log out for linkedin
						#$adapter->logout();
						?>
						<div style="clear:both;"></div>
					</div>
					<?php if ( isset($_GET['wsi_hook']) && $_GET['wsi_hook'] == 'anyone') : ?>
					
					<?php else: ?>
						
					<h2><?php _e('Write your invitation message', $this->WPB_PREFIX);?></h2>
					
						<?php if($settings['subject_editable'] == 'false' || $provider == 'facebook' || $provider == 'linkedin' || $provider == 'twitter') :?>
						
							<input type="hidden" name="subject" value="<?php echo $settings['subject'];?>"/>
	
						<?php else: ?>
	
							<label for="subject"><?php _e('Subject', $this->WPB_PREFIX);?></label>
							<input type="text" name="subject" value="<?php echo $settings['subject'];?>" />
	
						<?php endif;?>
					
					
						<?php if($settings['message_editable'] == 'false') :?>
						
							<input type="hidden" name="subject" value="<?php echo $settings['message'];?>"/>
	
						<?php else: ?>
							<label for="subject"><?php _e('Message', $this->WPB_PREFIX);?></label>
							<textarea name="message"><?php echo $settings['message'];?></textarea>
						<?php endif;?>
					<?php endif;?>
					
					<button type="submit"><? _e('Send', $this->WPB_PREFIX);?></button>
					</form>
			</div><!--collectcontainer-->		
			<div id="wsi_loading">
			<table width="100%" border="0">
			  <tr>
			    <td align="center" height="40px"><br /><br /><?php _e( 'Sending Invitations, please wait...', $this->WPB_PREFIX);  ?></td> 
			  </tr> 
			  <tr>
			    <td align="center" height="80px" valign="middle"><img src="<?php echo $this->assets_url; ?>loading.gif" /></td>
			  </tr> 
			</table> 
			</div> 
			</body>
			</html>
			<?php
		}
	}
	catch( Exception $e ){
		@$this->process_login_render_error_page( $e, $config, $hybridauth, $adapter, $profile );
	} 

	die();
	}
		
		
	/**
	* AJAX Callback that send emails
	*/	
	function send_emails_callback(){

			
			$nonce = $_POST['nonce'];
			if ( ! wp_verify_nonce( $nonce, 'wsi-ajax-nonce' ) )
				 die ( 'Not good not good');
			
			$emails		= $_REQUEST['friend'];
			$subject 	= $_REQUEST['subject'];
			$message 	= $_REQUEST['message'];
			set_time_limit(60*10);
			
			if( $_REQUEST['provider'] == 'linkedin')
			{
				$linkedin = $this->connect_to_provider('linkedin');
				
				$args = array('body' => $message, 'subject' => $subject,'recipients' => $emails);
			 	$linkedin->sendMessages($args);
			 	
			 	$linkedin->logout();
			}
			elseif( $_REQUEST['provider'] == 'twitter')
			{	
				$twitter = $this->connect_to_provider('twitter');
				foreach( $emails as $uid)
				{
					$twitter->sendDM(array('uid'=> $uid,'msg' => $message));
					sleep(1);
				}	
			} 
			else
			{
			$site_url 	= str_replace(array('http://','https://'), '', site_url());
			$headers = 'From: '.$_POST['user_id'].' <no-reply@'.$site_url.'>' . "\r\n";
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			
			
			if( count($emails) < 40 ){
				
				foreach( $emails as $email )
				{
					wp_mail( $email, $subject, $message, $headers);
					sleep(1);
				}
				
			}
			else
			{
				$counter = 0;
				//Lets create batches
				foreach( $emails as $email )
				{
					$counter++;
					wp_mail( $email, $subject, $message, $headers);
					sleep(1);
					
					if( $counter == 50 )
					{
						sleep(10);
						$counter = 0;
					}
				}
			}
			}
		echo 'Invitations Sent!';
		die();			 
	}//send emails
	
	/**
	* Loading Page
	*/
	function process_login_render_loading_page()
	{
		
	
		// selected provider 
		$provider = @ trim( strip_tags( $_REQUEST["provider"] ) ); 

		?>
		<!DOCTYPE html>
		<head>
		<meta name="robots" content="NOINDEX, NOFOLLOW">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php _e("Redirecting...", $this->WPB_PREFIX) ?></title>
		<head> 
		<script>
		function init(){
			setTimeout( function(){window.location.href = window.location.href + "&redirect_to_provider=true"}, 750 );
		}
		</script>
		<style>
		html {
		    background: #f9f9f9;
		}
		#wsl {
			background: #fff;
			color: #333;
			font-family: sans-serif;
			margin: 2em auto;
			padding: 1em 2em;
			-webkit-border-radius: 3px;
			border-radius: 3px;
			border: 1px solid #dfdfdf;
			max-width: 700px;
			font-size: 14px;
		}  
		</style>
		</head>
		<body onload="init();">
		<div id="wsl">
		<table width="100%" border="0">
		  <tr>
		    <td align="center" height="40px"><br /><br /><?php printf( __( "Contacting <b>%s</b>, please wait...", $this->WPB_PREFIX), ucfirst( $provider ) )  ?></td> 
		  </tr> 
		  <tr>
		    <td align="center" height="80px" valign="middle"><img src="<?php echo $this->assets_url; ?>loading.gif" /></td>
		  </tr> 
		</table> 
		</div> 
		</body>
		</html> 
		<?php
			die();
	}
	
	/**
	* Errors pages
	*/
	function process_login_render_error_page( $e, $config, $hybridauth, $adapter, $profile )
	{
	
		$message = __("Unspecified error!", $this->WPB_PREFIX); 
		$hint    = ""; 
	
		switch( $e->getCode() ){
			case 0 	: $message = __("Unspecified error.", $this->WPB_PREFIX); break;
			case 1 	: $message = __("Hybriauth configuration error.", $this->WPB_PREFIX); break;
			case 2 	: $message = __("Provider not properly configured.", $this->WPB_PREFIX); break;
			case 3 	: $message = __("Unknown or disabled provider.", $this->WPB_PREFIX); break;
			case 4 	: $message = __("Missing provider application credentials.", $this->WPB_PREFIX); 
					 $hint    = sprintf( __("<b>What does this error mean ?</b><br />Most likely, you didn't setup the correct application credentials for this provider. These credentials are required in order for <b>%s</b> users to access your website and for WordPress Social Login to work.", $this->WPB_PREFIX), $provider ) . __('<br />Instructions for use can be found in the <a href="http://hybridauth.sourceforge.net/wsl/configure.html" target="_blank">User Manual</a>.', $this->WPB_PREFIX); 
					 break;
			case 5 	: $message = __("Authentification failed. The user has canceled the authentication or the provider refused the connection.", $this->WPB_PREFIX); break; 
			case 6 	: $message = __("User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.", $this->WPB_PREFIX); 
					 if( is_object( $adapter ) ) $adapter->logout();
					 break;
			case 7 	: $message = __("User not connected to the provider.", $this->WPB_PREFIX); 
					 if( is_object( $adapter ) ) $adapter->logout();
					 break;
			case 8 	: $message = __("Provider does not support this feature.", $this->WPB_PREFIX); break;
	
			case 9 	: 
			case 10 : $message = $e->getMessage(); break;
			
		}
	
		@ session_destroy();
	?>
	<!DOCTYPE html>
	<head>
	<meta name="robots" content="NOINDEX, NOFOLLOW">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title></title>
	<style> 
	HR {
		width:100%;
		border: 0;
		border-bottom: 1px solid #ccc; 
		padding: 50px;
	}
	html {
	    background: #f9f9f9;
	}
	#wsl {
		background: #fff;
		color: #333;
		font-family: sans-serif;
		margin: 2em auto;
		padding: 1em 2em;
		-webkit-border-radius: 3px;
		border-radius: 3px;
		border: 1px solid #dfdfdf;
		max-width: 700px;
		font-size: 14px;
	}  
	</style>
	<head>  
	<body>
	<div id="wsl">
	<table width="100%" border="0">
		<tr>
		<td align="center"><br /><img src="<?php echo $this->assets_url ?>alert.png" /></td>
		</tr>
		<tr>
		<td align="center"><br /><h4><?php _e("Something bad happen!", $this->WPB_PREFIX) ?></h4><br /></td> 
		</tr>
		<tr>
		<td align="center">
			<p style="line-height: 20px;padding: 8px;background-color: #FFEBE8;border:1px solid #CC0000;border-radius: 3px;padding: 10px;text-align:center;">
				<?php echo $message ; ?> 
			</p>
		</td> 
		</tr> 
	
		
	</table>  
	</div> 
	</body>
	</html> 
	<?php
		die();
	}// error page
	
	
	private function connect_to_provider($provider = '')
	{
		$settings = self::$_options;
		
		# Hybrid_Auth already used?
		if ( class_exists('Hybrid_Auth', false) ) {
			return wsl_render_notices_pages( __("Error: Another plugin seems to be using HybridAuth Library and made WordPress Social Invitation unusable. We use a custom version of HybridAuth but it should work with other plugins", $this->WPB_PREFIX) ); 
		}

		// load hybridauth
		require_once $this->WPB_ABS_PATH . "/hybridauth/Hybrid/Auth.php";

		// selected provider name 
		$provider = @ $provider != '' ? $provider : trim( strip_tags( $_REQUEST["provider"]));

		$provider = strtolower($provider);
		// build required configuratoin for this provider
		
		if( !isset( $settings['enable_'.$provider] ) || $settings['enable_'.$provider] != 'true' ){
			throw new Exception( _e( 'Unknown or disabled provider', $this->WPB_PREFIX) );
		}

		// default endpoint_url/callback_url
		$endpoint_url = $this->WSI_HYBRIDAUTH_ENDPOINT_URL;
		$callback_url = null; // autogenerated by hybridauth


		// check hybridauth_base_url
		if( ! strstr( $endpoint_url, "http://" ) && ! strstr( $endpoint_url, "https://" ) ){
			throw new Exception( 'Invalid base_url: ' . $endpoint_url, 9 );
		}

		$config = array();
		$config["base_url"]  = $endpoint_url; 
		$config["providers"] = array();
		$config["providers"][$provider] = array();
		$config["providers"][$provider]["enabled"] = true;

		// provider application id ?
		if( isset($settings[$provider.'_key']) && $settings[$provider.'_key'] != '' ) {
			$config["providers"][$provider]["keys"]["id"] = $settings[$provider.'_key'];
			$config["providers"][$provider]["keys"]["key"] = $settings[$provider.'_key'];
		}

		

		// provider application secret ?
		if( isset($settings[$provider.'_secret']) && $settings[$provider.'_secret'] != '' ){
			$config["providers"][$provider]["keys"]["secret"] = $settings[$provider.'_secret'];
		}


		// reset scopes
		if( strtolower( $provider ) == "google" ){
			$config["providers"][$provider]["scope"]   = "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.google.com/m8/feeds/";  
		}

		// create an instance for Hybridauth
		$hybridauth = new Hybrid_Auth( $config );

		// try to authenticate the selected $provider
		$params  = array();

		// if callback_url defined, overwrite Hybrid_Auth::getCurrentUrl(); 
		if( $callback_url ){
			$params["hauth_return_to"] = $callback_url;
		}
		
		$this->hybridauth = $hybridauth;
		$adapter = $hybridauth->authenticate( $provider, $params );
		return $adapter;
	}
	
	/**
	* Return plugin providers
	*/
	
	public static function get_providers(){
		$providers = get_option('wsi_widget_order',true);
		return is_array($providers) ? $providers : self::$providers;
	}
	
	/**
	* Ajax function that handle widget order
	*/
	function change_widget_order(){
	
		$providers = self::get_providers();
		$new_order = array();
		$order = explode(',', $_POST['order']);
		foreach( $order as $p )
		{
			$new_order[$p] = $providers[$p]; 
		}
		
		update_option('wsi_widget_order', $new_order);
		
		die();
	}
}

WP_Social_Invitations::get_instance();

add_shortcode('wsi-widget','wsi_shortcode_func');

function wsi_shortcode_func($atts){
	extract( shortcode_atts( array(
		'title' => ''
	), $atts ) );
	ob_start();
	WP_Social_Invitations::widget($title);
	$widget = ob_get_contents();
	ob_clean();
	return $widget;

}

	//   WP_Social_Invitations::widget('Invite some friends!!');
	//<?php echo do_shortcode('[wsi-widget title="Invite your friends"]');?>