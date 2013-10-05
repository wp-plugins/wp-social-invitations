<!DOCTYPE html>
<head>
<meta name="robots" content="NOINDEX, NOFOLLOW">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php _e("Redirecting...", $WPB_PREFIX) ?></title>
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
    <td align="center" height="40px"><br /><br /><?php printf( __( "Contacting <b>%s</b>, please wait...", $WPB_PREFIX), ucfirst( $provider ) )  ?></td> 
  </tr> 
  <tr>
    <td align="center" height="80px" valign="middle"><img src="<?php echo $assets_url; ?>loading.gif" /></td>
  </tr> 
</table> 
</div> 
</body>
</html> 