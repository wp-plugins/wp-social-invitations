<?php
/**
 * Popup error template 
 *
 * @version	1.1
 * @since 1.4
 * @package	Wordpress Social Invitations
 * @author Timersys
 */
if ( ! defined( 'ABSPATH' ) ) exit; 

	if( isset($options['enable_dev']) && 'true' == $options['enable_dev'])
		{
			echo '<pre>';
			echo date('l jS \of F Y h:i:s A');
			var_dump($e);
			echo '</pre>';
		}
		
		$message = __("Unspecified error!", $WPB_PREFIX); 
		$hint    = ""; 
	
		if( isset($e) )
		{
			switch( $e->getCode() ){
				case 0 	: $message = __("Unspecified error.", $WPB_PREFIX); break;
				case 1 	: $message = __("Hybriauth configuration error.", $WPB_PREFIX); break;
				case 2 	: $message = __("Provider not properly configured.", $WPB_PREFIX); break;
				case 3 	: $message = __("Unknown or disabled provider.", $WPB_PREFIX); break;
				case 4 	: $message = __("Missing provider application credentials.", $WPB_PREFIX); 
						 $hint    = sprintf( __("<b>What does this error mean ?</b><br />Most likely, you didn't setup the correct application credentials for this provider. These credentials are required in order for <b>%s</b> users to access your website and for WordPress Social Login to work.", $WPB_PREFIX), $provider ) . __('<br />Instructions for use can be found in the <a href="http://hybridauth.sourceforge.net/wsl/configure.html" target="_blank">User Manual</a>.', $WPB_PREFIX); 
						 break;
				case 5 	: $message = __("Authentification failed. The user has canceled the authentication or the provider refused the connection.", $WPB_PREFIX); break; 
				case 6 	: $message = __("User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.", $WPB_PREFIX); 
						 if( is_object( $adapter ) ) $adapter->logout();
						 break;
				case 7 	: $message = __("User not connected to the provider.", $WPB_PREFIX); 
						 if( is_object( $adapter ) ) $adapter->logout();
						 break;
				case 8 	: $message = __("Provider does not support this feature.", $WPB_PREFIX); break;
		
				case 9 	: 
				case 10 : $message = $e->getMessage(); break;
				
			}
		}
		else
		{
			$message = __("Please double check your app API Key and Secret");
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
		<td align="center"><br /><img src="<?php echo $assets_url ?>alert.png" /></td>
		</tr>
		<tr>
		<td align="center"><br /><h4><?php _e("Something bad happen!", $WPB_PREFIX) ?></h4><br /></td> 
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