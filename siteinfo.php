<?php
/**
* Wordpress Social Invitations
*/
/*!
* WordPress Social Login
*
* http://hybridauth.sourceforge.net/wsl/index.html | http://github.com/hybridauth/WordPress-Social-Login
*    (c) 2011-2013 Mohamed Mrassi and contributors | http://wordpress.org/extend/plugins/wordpress-social-login/
*/

/**
* Site Info 
* borrowed from http://wordpress.org/extend/plugins/easy-digital-downloads/
*/

// --------------------------------------------------------------------

global $wsi, $wpdb;

if( isset($_GET['support']) && $_GET['support'] == 'yes' && $_GET['page'] == 'wp-social-invitations')
{
	delete_option('wsi-lock-fb');
	delete_option('wsi-lock-tw');
	delete_option('wsi-lock-lk');
	delete_option('wsi-lock-emails');
}
?>


	
<p>You can do a simple test to see if you meet the <a href="http://wp.timersys.com/wordpress-social-invitations/docs/requirements/">requirements</a>: <a class="button-primary" href="<?php echo $wsi->WPB_PLUGIN_URL.'/test.php';?>" target="_blank">WSI TEST</a></p>
<p>Enable DEV mode to see errors and fill php logs with more debugging info</p>
	
 
<p>
	<b>Important</b>: 
</p>
<ul style="padding-left:15px;">
<li>Please include this information when posting support requests. It will help me immensely to better understand any issues.</li>

</ul>

<textarea readonly="readonly" style="height: 400px;overflow: auto;white-space: pre;width: 790px;">
EMAILS IN QUEUE:		  <?php echo $wpdb->get_var("SELECT count(*) FROM {$wpdb->base_prefix}wsi_queue WHERE provider = 'google' OR provider = 'yahoo' OR provider = 'live' OR provider = 'foursquare'"); echo "\n";?>
TW IN QUEUE:			  <?php echo $wpdb->get_var("SELECT count(*) FROM {$wpdb->base_prefix}wsi_queue WHERE provider = 'twitter'"); echo "\n";?>
LINKEDIN IN QUEUE:		  <?php echo $wpdb->get_var("SELECT count(*) FROM {$wpdb->base_prefix}wsi_queue WHERE provider = 'linkedin'"); echo "\n";?>
FACEBOOK IN QUEUE:		  <?php echo $wpdb->get_var("SELECT count(*) FROM {$wpdb->base_prefix}wsi_queue WHERE provider = 'facebook'"); echo "\n";?>
FB LOCKED:				  <?php echo get_option('wsi-lock-fb') == 'yes' ? 'Yes' : 'No'; echo "\n";?>
TW LOCKED:				  <?php echo get_option('wsi-lock-tw') == 'yes' ? 'Yes' : 'No'; echo "\n";?>
LK LOCKED:				  <?php echo get_option('wsi-lock-lk') == 'yes' ? 'Yes' : 'No'; echo "\n";?>
EMAILS LOCKED:			  <?php echo get_option('wsi-lock-emails') == 'yes' ? 'Yes' : 'No'; echo "\n";?>
SERVER_TIME:              <?php echo date('l jS \of F Y h:i:s A') . "\n"; ?>
SITE_URL:                 <?php echo site_url() . "\n"; ?>
PLUGIN_URL:               <?php echo plugins_url() . "\n"; ?>

HTTP_HOST:                <?php echo $_SERVER['HTTP_HOST'] . "\n"; ?>
SERVER_PORT:              <?php echo isset( $_SERVER['SERVER_PORT'] ) ? 'On (' . $_SERVER['SERVER_PORT'] . ')' : 'N/A'; echo "\n"; ?>
HTTP_X_FORWARDED_PROTO:   <?php echo isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) ? 'On (' . $_SERVER['HTTP_X_FORWARDED_PROTO'] . ')' : 'N/A'; echo "\n"; ?>

MULTI-SITE:               <?php echo is_multisite() ? 'Yes' . "\n" : 'No' . "\n" ?>

WSI VERSION:              <?php echo $wsi->WPB_VERSION . "\n"; ?>
WORDPRESS VERSION:        <?php echo get_bloginfo( 'version' ) . "\n"; ?>

PHP VERSION:              <?php echo PHP_VERSION . "\n"; ?>
MYSQL VERSION:            <?php echo mysql_get_server_info() . "\n"; ?>
WEB SERVER INFO:          <?php echo $_SERVER['SERVER_SOFTWARE'] . "\n"; ?>

SESSION:                  <?php echo isset( $_SESSION ) ? 'Enabled' : 'Disabled'; echo "\n"; ?>
SESSION:WSI               <?php echo $_SESSION["wsi::plugin"]; echo "\n"; ?>
SESSION:NAME:             <?php echo esc_html( ini_get( 'session.name' ) ); echo "\n"; ?>

COOKIE PATH:              <?php echo esc_html( ini_get( 'session.cookie_path' ) ); echo "\n"; ?>
SAVE PATH:                <?php echo esc_html( ini_get( 'session.save_path' ) ); echo "\n"; ?>
USE COOKIES:              <?php echo ini_get( 'session.use_cookies' ) ? 'On' : 'Off'; echo "\n"; ?>
USE ONLY COOKIES:         <?php echo ini_get( 'session.use_only_cookies' ) ? 'On' : 'Off'; echo "\n"; ?>

PHP/CURL:                 <?php echo function_exists( 'curl_init'   ) ? "Supported" : "Not supported"; echo "\n"; ?>
<?php if( function_exists( 'curl_init' ) ): ?>
PHP/CURL/VER:             <?php $v = curl_version(); echo $v['version']; echo "\n"; ?>
PHP/CURL/SSL:             <?php $v = curl_version(); echo $v['ssl_version']; echo "\n"; ?><?php endif; ?>
PHP/FSOCKOPEN:            <?php echo function_exists( 'fsockopen'   ) ? "Supported" : "Not supported"; echo "\n"; ?>
PHP/JSON:                 <?php echo function_exists( 'json_decode' ) ? "Supported" : "Not supported"; echo "\n"; ?>

ACTIVE PLUGINS:

<?php  
if( function_exists("get_plugins") ):
	$plugins = get_plugins();
	foreach ( $plugins as $plugin_path => $plugin ): 
		echo $plugin['Name']; echo $plugin['Name']; ?>: <?php echo $plugin['Version'] ."\n"; 
	endforeach;
else:
	$active_plugins = get_option( 'active_plugins', array() );
	foreach ( $active_plugins as $plugin ): 
		echo $plugin ."\n"; 
	endforeach;
endif; ?>

CURRENT THEME:

<?php
if ( get_bloginfo( 'version' ) < '3.4' ) {
	$theme_data = get_theme_data( get_stylesheet_directory() . '/style.css' );
	echo $theme_data['Name'] . ': ' . $theme_data['Version'];
} else {
	$theme_data = wp_get_theme();
	echo $theme_data->Name . ': ' . $theme_data->Version;
}
?>


# EOF</textarea>

