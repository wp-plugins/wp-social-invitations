<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $wsi;
$CURRENT_URL = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

?>
<style type="text/css">
<?php echo $wsi->_options['custom_css'];?>
</style>
<?php do_action('wsi_before_widget');?>
<h2 class="wsi-title"><?php echo isset($title) && $title != '' ? $title : apply_filters('wsi_widget_title', sprintf(__('Invite your friends to join %s',$this->WPB_PREFIX), get_bloginfo('name')));?></h2>
<input type="hidden" id="wsi_base_url" value="<?php echo $CURRENT_URL;?>">
<div class="service-filter-content">
  <ul class="service-filters ">


<?php
	$providers = $wsi->get_providers();
	
	
	foreach ( $providers as $p => $p_name ):
		
		if( $wsi->_options['enable_'.$p] == 'true' ) :
		?>
			<li id="<?php echo $p;?>-provider" data-li-origin="<?php echo $p;?>">
	        <span class="ready-label hidden">Ready</span>
	            <a title="<?php echo $p_name;?>" href="#-service-<?php echo $p;?>" class="sprite sprite-<?php echo $p;?>" data-provider="<?php echo $p;?>"></a>
	        <div class="service-filter-name-container">
	          <div class="service-filter-name-outer">
	            <div class="service-filter-name-inner">
	                  <a rel="<?php echo $p_name;?>" href="#-service-<?php echo $p;?>" data-provider="<?php echo $p;?>">
	                    <?php echo $p_name;?>
	                  </a>
	            </div>
	          </div>
	        </div>
	      </li>
		
		<?php
		endif;
	endforeach;
?>		  
  </ul>
   <div class="wsi_success"><?php echo sprintf( __('Thanks for inviting your %s friends. Please try other network if you wish.',$this->WPB_PREFIX),'<span id="wsi_provider"></span>');?></div>
</div>

<?php do_action('wsi_after_widget');?>