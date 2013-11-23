<?php
/**
 * Popup email collector template 
 *
 * @version	1.0
 * @since 1.4
 * @package	Wordpress Social Invitations
 * @author Timersys
 */
 ?>
<div id="collect_container">
	<h2><?php _e("Select your friends", $WPB_PREFIX);?></h2>

	<form id="collect_emails" method="post" action="<?php echo $return_to.'&collected_data=true';?>">
		
		<input type="hidden" name="action" value="add_to_wsi_queue"/>
		<input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce( 'wsi-ajax-nonce' );?>"/>
		<input type="hidden" id="provider" name="provider" value="<?php echo $provider;?>"/>
		<input type="hidden" id="sdata" name="sdata" value='<?php echo base64_encode($hybridauth_session_data);?>'/>
		<input type="hidden" id="display_name" name="display_name" value='<?php echo $display_name;?>'/>
		
		<div class="box-wrapper">
             <div class="search-box">
                  <div class="unselect-all">
                     <a href="#" class="unselect" style="display: none"><?php _e('Unselect All',$WPB_PREFIX);?></a>
                     <a href="#" class="select" style="display: block"><?php _e('Select All',$WPB_PREFIX);?></a>
                  </div>
	              <div id="friendsSearch" class="textwrapper text-search labeloverlaywrapper">
	                    <label for="searchinput" class="labeloverlay" style="display: inline; left: 26px; top: 5px; padding: 0px; width: 312px;"><?php _e('Search friends',$WPB_PREFIX);?></label>
	                    <input type="text" class="form-text required defaultInvalid toggleval" id="searchinput" style="">
	              </div>
             </div>
             <div class="scroll-box">
                  <table id="FriendsList" class="friends_container" cellspacing="0" cellpadding="0">
                  	<tbody>
                  	<?php
                  	if( $provider != 'live' )
						@$friends = $adapter->getUserContacts();
			
					if(!empty($friends))
					{			
						
						foreach( $friends as $friend)
						{
							?>
							<tr>
								<td class="checkbox-container">
									<input type="checkbox" value="<?php WP_Social_Invitations::getValue($provider, $friend);?>" name="friend[]"/> 
								</td>
								<td class="user-img">
									<?php if( isset($friend->photoURL) && $friend->photoURL): ?>
									
										<img src="<?php echo $friend->photoURL;?>" alt=""/>
									
									<?php endif;?>
								</td>
								<td class="last-child">
									<?php WP_Social_Invitations::printName($friend->displayName);?>
								
									<em><?php echo $friend->email;?></em>
								</td>
							</tr>
							
							<?php
						}
					}
					elseif( $provider != 'live')
					{
						throw new Exception(__('Your contacts list on this provider is empty. Add some contacts first! - Providers like Yahoo or Mail only return contacts created with them, and not contacts imported from other networks.',$WPB_PREFIX),10);
					}
                  	?>
                  	</tbody>
                  </table>
          </div><!--scrollbox-->
   </div><!--box-wrapper-->
   
  <?php if ( !isset($_GET['wsi_hook']) || $_GET['wsi_hook'] != 'anyone') : ?>
   <div class="fields-wrapper">
	  
   		<?php WP_Social_Invitations::printSubjectField($provider, $settings);?>
  
  
  		<?php WP_Social_Invitations::printMessageField($provider, $settings);?>

   </div>		
   <a href="#" onclick="jQuery('#placeholders').slideToggle();return false;" class="place-link">Placeholders help</a>
	<ul id="placeholders" style="display:none">
		<li><strong>%%INVITERNAME%%</strong>: <?php _e('Display name of the inviter',$WPB_PREFIX);?></li>
		<li><strong>%%SITENAME%%</strong>: <?php _e('Name of your website',$WPB_PREFIX);?> - <?php echo bloginfo('name');?></li>
		<li><strong>%%ACCEPTURL%%</strong>: <?php _e('Link that invited users can click to accept the invitation and register',$WPB_PREFIX);?></li>
		<li><strong>%%INVITERURL%%</strong>: <?php _e('If Buddypress is enabled, URL to the profile of the inviter',$WPB_PREFIX);?></li>
	</ul>	
   	
  <?php
   endif;	
  ?>
                        
		<button type="submit" id="submit-button"><?php _e('Send', $WPB_PREFIX);?></button>
		</form>
                        

			<?php 

			if( $provider != 'live' )
				@$adapter->logout();
	
			?>
			<div style="clear:both;"></div>
		</div>
		
		
				
</div><!--collectcontainer-->
