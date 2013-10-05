<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 *  Widget template used in sidebar
 *
 * @version	1.0
 * @since 1.4
 * @package	Wordpress Social Invitations
 * @author Timersys
 */
?>
<div class="service-filter-content ">
  <ul class="service-filters wsi-sidebar ">
<?php

	
	foreach ( $providers as $p => $p_name ):
		
		if( $options['enable_'.$p] == 'true' ) :
		?>
			<li id="<?php echo $p;?>-provider" data-li-origin="<?php echo $p;?>">
	             <a title="<?php echo $p_name;?>" href="#-service-<?php echo $p;?>" class="sprite sprite-<?php echo $p;?>" data-provider="<?php echo $p;?>"></a>
	        </li>
		
		<?php
		endif;
	endforeach;
?>		  
  </ul>
   <div class="wsi_success small"><?php echo sprintf( __('Thanks for inviting your %s friends. Please try other network if you wish.',$WPB_PREFIX),'<span id="wsi_provider"></span>');?></div>
</div>
