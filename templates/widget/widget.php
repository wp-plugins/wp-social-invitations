<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
global $wp_query;
/**
 * Big widget template used in pages
 *
 * @version	1.1
 * @since 1.4
 * @package	Wordpress Social Invitations
 * @author Timersys
 */
?>
<style type="text/css">
<?php echo $options['custom_css'];?>
</style>

<?php do_action('wsi_before_widget');?>

<h2 class="wsi-title"><?php echo isset($title) && $title != '' ? $title : apply_filters('wsi_widget_title', sprintf(__('Invite your friends to join %s',$WPB_PREFIX), get_bloginfo('name')));?></h2>

<input type="hidden" id="wsi_base_url" value="<?php echo $CURRENT_URL;?>">
<input type="hidden" id="wsi_obj_id" value="<?php echo $wp_query->queried_object->ID;?>">


<div class="service-filter-content">
  <ul class="service-filters ">
<?php
	
	
	foreach ( $providers as $p => $p_name ):
		
		if( isset($options['enable_'.$p]) && $options['enable_'.$p] == 'true' ) :
		?>
			<li id="<?php echo $p;?>-provider" data-li-origin="<?php echo $p;?>">
	        <span class="ready-label hidden">Ready</span>
	            <a title="<?php echo $p_name;?>" href="#-service-<?php echo $p;?>" class="" data-provider="<?php echo $p;?>">
		            <i class="wsiicon-<?php echo $p;?>"></i>
	            </a>
	        
	      </li>
		
		<?php
		endif;
	endforeach;
?>		  
  </ul>
   <div class="wsi_success"><?php echo sprintf( __('Thanks for inviting your %s friends. Please try other network if you wish.',$WPB_PREFIX),'<span id="wsi_provider"></span>');?></div>
</div>

<?php do_action('wsi_after_widget');?>