	</div><!-- postbox-->
<div id="right-sidebar">	
<div id="sticky-anchor"></div>
<div class="postbox" id="sticky"> 
	<h3 style="cursor: default;" class="nowrap"><?php echo sprintf(__('Support %s', $this->WPB_PREFIX), $this->WPB_PLUGIN_NAME);?> </h3>
		<div class="inside">
			
				<?php
				$credits = $this->_credits;
				?>

				<div class="intro"><p><strong><?php _e('If you enjoyed, please support this plugin:', $this->WPB_PREFIX);?></strong></p></div>
				
				<p>
						<a href="http://codecanyon.net/item/wordpress-social-invitations/5026451?ref=chifliiiii"><?php _e('Buy the premium version on Codecanyon.net', $this->WPB_PREFIX);?></a>
				</p>
				<p>
						<a href="<?php echo $this->WPB_PLUGIN_URL.'/'.$this->WPB_PREFIX.'.po';?>"><?php _e('Translate the plugin to your language', $this->WPB_PREFIX);?></a>
				</p>
				
		
				<!--	<input type="submit" value="<?php _e('Save Settings','wsi');?>" class="button-large button-primary" name="save">-->
		</div>
</div>
 

</div><!--wsl_admin_tab_content-->

</div><!--wlsdiv-->