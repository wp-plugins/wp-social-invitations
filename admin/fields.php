<?php
	$options = get_option( $this->options_name );
	
	/* General Settings
	===========================================*/
	

	$this->settings['g_heading'] = array(
		'section' => 'wsi_general',
		'std'   => 'Google', // Not used for headings.
		'title'	=> '',
		'desc'    => '',
		'class'	  => 'google-heading  wsi-providers',
		'type'    => 'heading'
	);
	$this->settings['enable_google'] = array(
		'title'   => __( 'Enabled' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable Google Invitations.' , $this->WPB_PREFIX),
		'std'     => 'false',
		'type'    => 'select',
		'section' => 'wsi_general',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);
	
	$this->settings['google_key'] = array(
		'title'   => __( 'Client ID' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), $this->WPB_PLUGIN_URL.'/docs/index.html#google' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);

	$this->settings['google_secret'] = array(
		'title'   => __( 'Client Secret' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), $this->WPB_PLUGIN_URL.'/docs/index.html#google' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);


	$this->settings['yahoo_heading'] = array(
		'section' => 'wsi_general',
		'std'   => 'Yahoo', // Not used for headings.
		'title'	=> '',
		'desc'    => '',
		'class'	  => 'yahoo-heading  wsi-providers',
		'type'    => 'heading'
	);
	$this->settings['enable_yahoo'] = array(
		'title'   => __( 'Enabled' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable Yahoo Invitations.' , $this->WPB_PREFIX),
		'std'     => 'false',
		'type'    => 'select',
		'section' => 'wsi_general',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);
	
	$this->settings['yahoo_key'] = array(
		'title'   => __( 'Consumer Key' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), $this->WPB_PLUGIN_URL.'/docs/index.html#yahoo' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);

	$this->settings['yahoo_secret'] = array(
		'title'   => __( 'Consumer Secret' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), $this->WPB_PLUGIN_URL.'/docs/index.html#yahoo' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);

	$this->settings['foursquare_heading'] = array(
		'section' => 'wsi_general',
		'std'   => 'Foursquare', // Not used for headings.
		'title'	=> '',
		'desc'    => '',
		'class'	  => 'foursquare-heading  wsi-providers',
		'type'    => 'heading'
	);
	$this->settings['enable_foursquare'] = array(
		'title'   => __( 'Enabled' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable Foursquare Invitations.' , $this->WPB_PREFIX),
		'std'     => 'false',
		'type'    => 'select',
		'section' => 'wsi_general',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);
	
	$this->settings['foursquare_key'] = array(
		'title'   => __( 'Consumer Key' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), $this->WPB_PLUGIN_URL.'/docs/index.html#foursquare' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);

	$this->settings['foursquare_secret'] = array(
		'title'   => __( 'Consumer Secret' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), $this->WPB_PLUGIN_URL.'/docs/index.html#foursquare' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);
	
	$this->settings['live_heading'] = array(
		'section' => 'wsi_general',
		'std'   => 'Windows Live', // Not used for headings.
		'title'	=> '',
		'desc'    => '',
		'class'	  => 'live-heading  wsi-providers',
		'type'    => 'heading'
	);

	
	$this->settings['enable_live'] = array(
		'title'   => __( 'Enabled' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable Windows Live Invitations.' , $this->WPB_PREFIX),
		'std'     => 'true',
		'type'    => 'select',
		'section' => 'wsi_general',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);

	
	/**
	* Default Messages
	*/
	$this->settings['default_heading'] = array(
		'section' 	=> 'messages',
		'std'   	=> __( 'Default Invitation Message.' , $this->WPB_PREFIX), // Not used for headings.
		'title'		=> '',
		'desc'   	=> '',
		'class'	 	=> '',
		'type'   	=> 'heading'
	);
	$this->settings['subject'] = array(
		'title'   => __( 'Subject' , $this->WPB_PREFIX),
		'desc'    => __('Default Subject for invitations',$this->WPB_PREFIX),
		'std'     => sprintf(__('I invite you to join %s', $this->WPB_PREFIX), get_bloginfo('name')),
		'type'    => 'text',
		'section' => 'wsi_messages'
	);
	
	$this->settings['subject_editable'] = array(
		'title'   => __( 'Editable' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable users to change the default subject.' , $this->WPB_PREFIX),
		'std'     => 'true',
		'type'    => 'select',
		'section' => 'wsi_messages',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);
	$this->settings['message'] = array(
		'title'   => __( 'Message' , $this->WPB_PREFIX),
		'desc'    => __('Default Message for invitations',$this->WPB_PREFIX),
		'std'     => sprintf(__('I invite you to join %s', $this->WPB_PREFIX), get_bloginfo('name')),
		'type'    => 'textarea',
		'section' => 'wsi_messages'
	);
	
	$this->settings['message_editable'] = array(
		'title'   => __( 'Editable' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable users to change the default message.' , $this->WPB_PREFIX),
		'std'     => 'true',
		'type'    => 'select',
		'section' => 'wsi_messages',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);
	
		

	function is_active( $plugin ) {
	        return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || is_network_active( $plugin );
	}
		function is_network_active( $plugin ) {
	        if ( !is_multisite() )
	                return false;
	
	        $plugins = get_site_option( 'active_sitewide_plugins');
	        if ( isset($plugins[$plugin]) )
	                return true;
	
	        return false;
	}