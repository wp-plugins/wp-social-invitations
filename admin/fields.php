<?php
	$options = get_option( $this->options_name );
	
	/* General Settings
	===========================================*/
	
	$this->settings['providers_heading'] = array(
		'section' 	=> 'wsi_general',
		'std'   	=> __( 'General settings' , $this->WPB_PREFIX), // Not used for headings.
		'title'		=> '',
		'desc'   	=> "<p>".__('If you have <a href="http://buddypress.org/">Buddypress</a> or the <a href="http://wordpress.org/plugins/invite-anyone/">Invite Anyone plugin</a> installed, you will be able to hook Wordpress Social Invitations into them from here.',$this->WPB_PREFIX)."</p><p>". __('Also if you wish you can set a redirection url to send users after they sent the invitations to one of the providers',$this->WPB_PREFIX)."</p>",
		'class'	 	=> '',
		'type'   	=> 'heading'
	);

	 if(!get_option('users_can_register') && !empty($bp)) :
		
		$this->settings['bypass_registration_lock'] = array(
				'title'   => __( 'Bypass Registration lock' , $this->WPB_PREFIX),
				'desc'    => __( 'Your site is blocked for new registations. Check here to bypass this on new Invitations' , $this->WPB_PREFIX),
				'std'     => '',
				'type'    => 'checkbox',
				'choices' => array(
					'yes' => __( 'Yes' , $this->WPB_PREFIX)
				),
				'section' => 'wsi_general'
			
		);	 
	 
	 
	 endif;
	
	$this->settings['redirect_url'] = array(
			'title'   => __( '"Redirect to" URL' , $this->WPB_PREFIX) . '<a href="http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free" target="_blank" style="color:red"> (Premium Only)</a>',
			'desc'    => __( 'Users will be redirected to this url after they send invitations' , $this->WPB_PREFIX),
			'std'     => '',
			'type'    => 'text',
			'disabled'=> 'yes',
			'section' => 'wsi_general'
		
	);
		
	If (is_active('buddypress/bp-loader.php')) {
	
		$this->settings['hook_buddypress'] = array(
			'title'   => __( 'Buddypress' , $this->WPB_PREFIX),
			'desc'    => __( 'Show in buddypress after user activates his new account' , $this->WPB_PREFIX),
			'std'     => 'true',
			'type'    => 'select',
			'section' => 'wsi_general',
			'choices' => array(
				'true' => __( 'Yes' , $this->WPB_PREFIX),
				'false' => __( 'No' , $this->WPB_PREFIX)
			)
		);
	}
	
	If (is_active('invite-anyone/invite-anyone.php')) {
	
		$this->settings['hook_invite_anyone'] = array(
			'title'   => __( 'Invite Anyone Plugin' , $this->WPB_PREFIX),
			'desc'    => __( 'Hook into Invite Anyone Plugin' , $this->WPB_PREFIX),
			'std'     => 'true',
			'type'    => 'select',
			'section' => 'wsi_general',
			'choices' => array(
				'true' => __( 'Yes' , $this->WPB_PREFIX),
				'false' => __( 'No' , $this->WPB_PREFIX)
			)
		);
	
	}
	$this->settings['providers_heading2'] = array(
		'section' 	=> 'wsi_general',
		'std'   	=> __( 'Providers' , $this->WPB_PREFIX), // Not used for headings.
		'title'		=> '',
		'desc'   	=> __('Please take your time and read documentation carefully. ',$this->WPB_PREFIX),
		'class'	 	=> '',
		'type'   	=> 'heading'
	);
	$this->settings['f_heading'] = array(
		'section' => 'wsi_general',
		'std'   => 'Facebook', // Not used for headings.
		'title'	=> '',
		'desc'    => '',
		'class'	  => 'facebook-heading wsi-providers',
		'type'    => 'heading'
	);
	$this->settings['enable_facebook'] = array(
		'title'   => __( 'Enabled' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable Facebook Invitations.' , $this->WPB_PREFIX). 'This will post to Facebook\'s wall. To deliver chat messages you need <a href="http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free" target="_blank" style="color:red">Premium version</a>',
		'std'     => 'false',
		'type'    => 'select',
		'section' => 'wsi_general',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);
	
	$this->settings['facebook_key'] = array(
		'title'   => __( 'Client ID' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#facebook' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);

	$this->settings['facebook_secret'] = array(
		'title'   => __( 'Client Secret' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#facebook' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);

	$this->settings['t_heading'] = array(
		'section' => 'wsi_general',
		'std'   => 'Twitter', // Not used for headings.
		'title'	=> '',
		'desc'    => '',
		'class'	  => 'twitter-heading wsi-providers',
		'type'    => 'heading'
	);
	$this->settings['enable_twitter'] = array(
		'title'   => __( 'Enabled' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable Twitter Invitations.' , $this->WPB_PREFIX). 'This will post a tweet. To deliver Direct Messages you need<a href="http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free" target="_blank" style="color:red">Premium Version</a>',
		'std'     => 'false',
		'type'    => 'select',
		'section' => 'wsi_general',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);
	
	$this->settings['twitter_key'] = array(
		'title'   => __( 'Consumer Key' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#twitter' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);

	$this->settings['twitter_secret'] = array(
		'title'   => __( 'Consumer Secret' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#twitter' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);
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
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#google' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);

	$this->settings['google_secret'] = array(
		'title'   => __( 'Client Secret' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#google' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);


	$this->settings['l_heading'] = array(
		'section' => 'wsi_general',
		'std'   => 'LinkedIn', // Not used for headings.
		'title'	=> '',
		'desc'    => '',
		'class'	  => 'linkedin-heading  wsi-providers',
		'type'    => 'heading'
	);
	$this->settings['enable_linkedin'] = array(
		'title'   => __( 'Enabled' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable Linkedin Invitations.' , $this->WPB_PREFIX). 'This will post to Linkedin\'s wall. To deliver private messages you need <a href="http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free" target="_blank" style="color:red">Premium version</a>',
		'std'     => 'false',
		'type'    => 'select',
		'section' => 'wsi_general',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);
	
	$this->settings['linkedin_key'] = array(
		'title'   => __( 'API Key' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#linkedin' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);

	$this->settings['linkedin_secret'] = array(
		'title'   => __( 'Secret Key' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#linkedin' ),
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
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#yahoo' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);

	$this->settings['yahoo_secret'] = array(
		'title'   => __( 'Consumer Secret' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#yahoo' ),
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
		'title'   => __( 'Client Key' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#foursquare' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);

	$this->settings['foursquare_secret'] = array(
		'title'   => __( 'Client Secret' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#foursquare' ),
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

/*	$this->settings['myspace_heading'] = array(
		'section' => 'wsi_general',
		'std'   => 'MySpace', // Not used for headings.
		'title'	=> '',
		'desc'    => '',
		'class'	  => 'myspace-heading  wsi-providers',
		'type'    => 'heading'
	);
	$this->settings['enable_myspace'] = array(
		'title'   => __( 'Enabled' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable MySpace.' , $this->WPB_PREFIX),
		'std'     => 'true',
		'type'    => 'select',
		'section' => 'wsi_general',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);
		$this->settings['myspace_key'] = array(
		'title'   => __( 'Consumer Key' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#myspace' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);

	$this->settings['myspace_secret'] = array(
		'title'   => __( 'Consumer Secret' , $this->WPB_PREFIX),
		'desc'    => sprintf(__( '<a href="%s" target="_blank">Where do i get this info?</a>' , $this->WPB_PREFIX), 'http://wp.timersys.com/wordpress-social-invitations/docs/configuration/#myspace' ),
		'std'     => '',
		'type'    => 'text',
		'section' => 'wsi_general'
	);*/
	
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
		'section' 	=> 'wsi_messages',
		'std'   	=> __( 'Default HTML Message for emails.' , $this->WPB_PREFIX), // Not used for headings.
		'title'		=> '',
		'desc'   	=> __( 'Emails are used with Gmail, Yahoo, Live, Foursquare' , $this->WPB_PREFIX),
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
		'desc'    => __( 'Enable / Disable users to change the default subject. Facebook, Twitter and Linkedin don\'t use subject field' , $this->WPB_PREFIX). '<a href="http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free" target="_blank" style="color:red"> (Premium Only)</a>',
		'std'     => 'true',
		'type'    => 'select',
		'disabled'=> 'yes',
		'section' => 'wsi_messages',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);
	$this->settings['html_message'] = array(
		'title'   => __( 'HTML Message' , $this->WPB_PREFIX),
		'desc'    => __('Default Message for HTML Invitations. <strong>Only supported by (Gmail, Yahoo, Foursquare and Live).</strong>',$this->WPB_PREFIX),
		'std'     => __('<h3>%%INVITERNAME%% just invited you!</h3><br>%%INVITERNAME%% would like you to join %%SITENAME%%.', $this->WPB_PREFIX),
		'type'    => 'html',
		'section' => 'wsi_messages'
	);
	
	$this->settings['html_message_editable'] = array(
		'title'   => __( 'Editable' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable users to change the default html message.' , $this->WPB_PREFIX). '<a href="http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free" target="_blank" style="color:red"> (Premium Only)</a>',
		'std'     => 'true',
		'type'    => 'select',
		'disabled'=> 'yes',
		'section' => 'wsi_messages',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);

	$this->settings['html_non_editable_message'] = array(
		'title'   => __( 'Non editable Message' , $this->WPB_PREFIX),
		'desc'    => __('This section will be added after normal message. It\'s not editable by users',$this->WPB_PREFIX),
		'std'     => __('Please accept the invitation in %%ACCEPTURL%% <br> Follow my twitter <a href="http://twitter.com/chifliiiii">@chifliiiii</a>', $this->WPB_PREFIX),
		'type'    => 'html',
		'section' => 'wsi_messages'
	);
		
	$this->settings['footer'] = array(
		'title'   => __( 'Footer Message' , $this->WPB_PREFIX),
		'desc'    => __('The footer it\'s only used by email providers. A good practice is to add your company address to avoid spam filters' ,$this->WPB_PREFIX). '<a href="http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free" target="_blank" style="color:red"> (Premium Only)</a>',
		'std'     => __('Powered by <a href="http://www.timersys.com/plugins/wordpress-social-invitations/">Wordpress Social Invitions</a>', $this->WPB_PREFIX),
		'type'    => 'disabled',
		'section' => 'wsi_messages'
	);
	
	$this->settings['default_heading2'] = array(
		'section' 	=> 'wsi_messages',
		'std'   	=> __( 'Default Text Message.' , $this->WPB_PREFIX), // Not used for headings.
		'title'		=> '',
		'desc'   	=> __( 'Text message don\'t allow HTML and are used for Facebook and Linkedin' , $this->WPB_PREFIX),
		'class'	 	=> '',
		'type'   	=> 'heading'
	);	
	
	$this->settings['text_subject'] = array(
		'title'   => __( 'Subject' , $this->WPB_PREFIX),
		'desc'    => __('Default Subject for Linkedin',$this->WPB_PREFIX),
		'std'     => sprintf(__('I invite you to join %s', $this->WPB_PREFIX), get_bloginfo('name')),
		'type'    => 'text',
		'section' => 'wsi_messages'
	);
	
	$this->settings['text_subject_editable'] = array(
		'title'   => __( 'Editable' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable users to change the default subject. Linkedin policy says that users must be able to edit this' , $this->WPB_PREFIX). '<a href="http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free" target="_blank" style="color:red"> (Premium Only)</a>',
		'std'     => 'true',
		'type'    => 'select',
		'disabled'=> 'yes',
		'section' => 'wsi_messages',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);
	
	$this->settings['message'] = array(
		'title'   => __( 'Text Message' , $this->WPB_PREFIX),
		'desc'    => sprintf(__('Default plain text Message for Linkedin invitations.Keep it under 200 characters(%%ACCEPTURL%% will be converted to a 22 characters string) Characters left: %s',$this->WPB_PREFIX),'<span id="char_left_lk">200</span>'),
		'std'     => __('%%INVITERNAME%% would like you to join %%SITENAME%% , click on %%ACCEPTURL%%', $this->WPB_PREFIX),
		'type'    => 'textarea',
		'section' => 'wsi_messages'
	);
	
	$this->settings['message_editable'] = array(
		'title'   => __( 'Editable' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable users to change the default message. Linkedin policy says that users must be able to edit this' , $this->WPB_PREFIX). '<a href="http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free" target="_blank" style="color:red"> (Premium Only)</a>',
		'std'     => 'true',
		'type'    => 'select',
		'disabled'=> 'yes',
		'section' => 'wsi_messages',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);
	
	$this->settings['default_heading4'] = array(
		'section' 	=> 'wsi_messages',
		'std'   	=> __( 'Facebook default text.' , $this->WPB_PREFIX), // Not used for headings.
		'title'		=> '',
		'desc'   	=> __( 'Default plain text Message for Facebook. HTML is not allowed.' , $this->WPB_PREFIX),
		'class'	 	=> '',
		'type'   	=> 'heading'
	);		

	$this->settings['fb_message'] = array(
		'title'   => __( 'Text Message' , $this->WPB_PREFIX),
		'desc'    => __('Default plain text Message for Facebook invitations.',$this->WPB_PREFIX),
		'std'     => __('%%INVITERNAME%% would like you to join %%SITENAME%%', $this->WPB_PREFIX),
		'type'    => 'textarea',
		'section' => 'wsi_messages'
	);
	$this->settings['fb_message_editable'] = array(
		'title'   => __( 'Editable' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable users to change the default Facebook message.' , $this->WPB_PREFIX). '<a href="http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free" target="_blank" style="color:red"> (Premium Only)</a>',
		'std'     => 'true',
		'type'    => 'select',
		'section' => 'wsi_messages',
		'disabled'=> 'yes',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);	
	$this->settings['text_non_editable_message'] = array(
		'title'   => __( 'Non editable Message' , $this->WPB_PREFIX),
		'desc'    => __('This section will be added after normal message. It\'s not editable by users',$this->WPB_PREFIX),
		'std'     => __('Please accept the invitation in %%ACCEPTURL%%', $this->WPB_PREFIX),
		'type'    => 'textarea',
		'section' => 'wsi_messages'
	);

	$this->settings['default_heading3'] = array(
		'section' 	=> 'wsi_messages',
		'std'   	=> __( 'Twitter default text.' , $this->WPB_PREFIX), // Not used for headings.
		'title'		=> '',
		'desc'   	=> __( 'This is only used for twitter. HTML is not allowed and it needs to be shorter than 140 characters' , $this->WPB_PREFIX),
		'class'	 	=> '',
		'type'   	=> 'heading'
	);		
	
	
	$this->settings['tw_message'] = array(
		'title'   => __( 'Twitter Message' , $this->WPB_PREFIX),
		'desc'    => sprintf(__('Default Message for Twitter. Keep it under 140 characters(%%ACCEPTURL%% will be converted to a 22 characters string) Characters left: %s',$this->WPB_PREFIX),'<span id="char_left">140</span>'),
		'std'     => __('%%INVITERNAME%% would like you to join %%SITENAME%% , click on %%ACCEPTURL%%', $this->WPB_PREFIX),
		'type'    => 'textarea',
		'section' => 'wsi_messages'
	);
	
	$this->settings['tw_message_editable'] = array(
		'title'   => __( 'Editable' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable users to change the default Twitter message.' , $this->WPB_PREFIX). '<a href="http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free" target="_blank" style="color:red"> (Premium Only)</a>',
		'std'     => 'true',
		'type'    => 'select',
		'disabled'=> 'yes',
		'section' => 'wsi_messages',
		'choices' => array(
			'true' => __( 'Yes' , $this->WPB_PREFIX),
			'false' => __( 'No' , $this->WPB_PREFIX)
		)
	);

	
	
	/**
	* EMAILS section
	*/
	
	$this->settings['send_with'] = array(
		'title'   => __( 'Send With...' , $this->WPB_PREFIX),
		'desc'    => '',
		'std'     => 'own',
		'type'    => 'select',
		'section' => 'wsi_emails',
		'class'	  => 'send_with',
		'choices' => array(
			'own'	=> __( 'Your own website' , $this->WPB_PREFIX),
			'gmail' => __( 'Gmail' , $this->WPB_PREFIX),
			'smtp'  => __( 'Third Party SMTP' , $this->WPB_PREFIX)
		)
	);
	
	$this->settings['gmail_heading'] = array(
		'section' 	=> 'wsi_emails',
		'std'   	=> __( 'Gmail Settings' , $this->WPB_PREFIX), // Not used for headings.
		'title'		=> '',
		'desc'   	=> '',
		'class'	 	=> 'gmail_settings',
		'type'   	=> 'heading'
	);	
		
	$this->settings['gmail_username'] = array(
	
		'title'		=> __( 'Username' , $this->WPB_PREFIX),
		'type'		=> 'text',
		'desc'		=> '',
		'std'		=> '',
		'disabled'=> 'yes',
		'section'	=> 'wsi_emails',
		'class'		=> 'gmail_settings'
	
	);

	$this->settings['gmail_pass'] = array(
	
		'title'		=> __( 'Password' , $this->WPB_PREFIX),
		'type'		=> 'password',
		'desc'		=> '',
		'std'		=> '',
		'disabled'=> 'yes',
		'section'	=> 'wsi_emails',
		'class'		=> 'gmail_settings'
	
	);

	$this->settings['smtp_heading'] = array(
		'section' 	=> 'wsi_emails',
		'std'   	=> __( 'SMTP Settings' , $this->WPB_PREFIX), // Not used for headings.
		'title'		=> '',
		'desc'   	=> '',
		'class'	 	=> 'smtp_settings',
		'type'   	=> 'heading'
	);	
		
	$this->settings['smtp_server'] = array(
	
		'title'		=> __( 'SMTP host' , $this->WPB_PREFIX),
		'type'		=> 'text',
		'desc'		=> __( 'E.g: smtp.gmail.com' , $this->WPB_PREFIX),
		'std'		=> '',
		'section'	=> 'wsi_emails',
		'disabled'=> 'yes',
		'class'		=> 'smtp_settings'
	
	);	
	
	$this->settings['smtp_username'] = array(
	
		'title'		=> __( 'Username' , $this->WPB_PREFIX),
		'type'		=> 'text',
		'desc'		=> '',
		'std'		=> '',
		'section'	=> 'wsi_emails',
		'disabled'=> 'yes',
		'class'		=> 'smtp_settings'
	
	);

	$this->settings['smtp_pass'] = array(
	
		'title'		=> __( 'Password' , $this->WPB_PREFIX),
		'type'		=> 'password',
		'desc'		=> '',
		'std'		=> '',
		'section'	=> 'wsi_emails',
		'disabled'=> 'yes',
		'class'		=> 'smtp_settings'
	
	);

	$this->settings['smtp_port'] = array(
	
		'title'		=> __( 'SMTP port' , $this->WPB_PREFIX),
		'type'		=> 'text',
		'desc'		=> '',
		'std'		=> '25',
		'section'	=> 'wsi_emails',
		'disabled'=> 'yes',
		'class'		=> 'smtp_settings'
	
	);	
	$this->settings['smtp_secure'] = array(
	
		'title'		=> __( 'Secure Connection' , $this->WPB_PREFIX),
		'type'		=> 'select',
		'desc'		=> '',
		'std'		=> '',
		'disabled'=> 'yes',
		'section'	=> 'wsi_emails',
		'class'		=> 'smtp_settings',
		'choices' => array(
			''		=> __( 'No' , $this->WPB_PREFIX),
			'ssl' 	=> __( 'SSL' , $this->WPB_PREFIX),
			'tls'  	=> __( 'TLS' , $this->WPB_PREFIX)
		)
	
	);	
		
	$this->settings['test_email_button'] = array(
		'title'   => __( 'Try yourself' , $this->WPB_PREFIX),
		'std'     => __( 'Send Test Email' , $this->WPB_PREFIX),
		'desc'	  => __( 'Please save before sending the test email.' , $this->WPB_PREFIX) . '<div id="sending" style="display:none"><img src="'.site_url('/wp-admin/images/wpspin_light.gif').'" alt=""/></div>',
		'type'	  => 'button',
		'section' => 'wsi_emails',
		'class'	  => 'wsi_test_email',
		'onclick' => 'javascript:return false;'
	);

	
	$this->settings['limit_heading'] = array(
		'section' 	=> 'wsi_emails',
		'std'   	=> __( 'Emails Limits' , $this->WPB_PREFIX), // Not used for headings.
		'title'		=> '',
		'desc'   	=> __( 'Your hosting has limits. Find out more here' , $this->WPB_PREFIX),
		'class'	 	=> '',
		'type'   	=> 'heading'
	);	
		
	$this->settings['emails_limit'] = array(
		'title'   => __( 'Send...' , $this->WPB_PREFIX),
		'desc'    => '',
		'std'     => '20',
		'type'    => 'text',
		'section' => 'wsi_emails'
	);


	$this->settings['emails_limit_time'] = array(
		'title'   => __( 'Every...' , $this->WPB_PREFIX),
		'desc'    => '',
		'std'     => '600',
		'type'    => 'select',
		'section' => 'wsi_emails',
		'class'	  => 'send_with',
		'choices' => array(
			'60'	=> __( 'Minute' , $this->WPB_PREFIX),
			'120' 	=> __( '2 Minutes' , $this->WPB_PREFIX),
			'300'  	=> __( '5 Minutes' , $this->WPB_PREFIX),
			'600'  	=> __( '10 Minutes' , $this->WPB_PREFIX),
			'900'  	=> __( '15 Minutes' , $this->WPB_PREFIX),
			'1800'  => __( '30 Minutes' , $this->WPB_PREFIX),
			'3600'  => __( 'Hour' , $this->WPB_PREFIX),
			'7200'  => __( '2 Hours' , $this->WPB_PREFIX)
		)
	);
	
	
		
	/**
	* Styling Section
	*/
	
	$this->settings['widget_order'] = array(
		'title'   => __( 'Widget Order' , $this->WPB_PREFIX),
		'desc'    => __('Drag and drop to order widget providers',$this->WPB_PREFIX). '<a href="http://wp.timersys.com/wordpress-social-invitations/?utm_source=wsi-free" target="_blank" style="color:red"> (Premium Only)</a>',
		'std'     => WP_Social_Invitations::get_providers(),
		'type'	  => 'sortable',
		'disabled'=> 'yes',
		'section' => 'wsi_styling'
	);
		
		
	
	$this->settings['custom_css'] = array(
		'title'   => __( 'Custom CSS' , $this->WPB_PREFIX),
		'desc'    => __('<p>Enter your custom CSS rules. By default WSI widget use the following structure:</p>',$this->WPB_PREFIX).' <pre style="background:#ccc;padding:10px;">&lt;li id="facebook-provider" data-li-origin="facebook"&gt;
	&lt;span class="ready-label hidden"&gt;Ready&lt;/span&gt;
	&lt;a title="Facebook" class="sprite sprite-facebook" &gt;&lt;/a&gt;
	&lt;div class="service-filter-name-container"&gt;
		&lt;div class="service-filter-name-outer"&gt;
			&lt;div class="service-filter-name-inner"&gt;
				&lt;a rel="Facebook" href="#-service-facebook"&gt;
				Facebook
				&lt;/a&gt;
			&lt;/div&gt;
		&lt;/div&gt;
	&lt;/div&gt;
&lt;/li&gt;</pre>',
		'std'     => '.service-filters {
}
.service-filters li {
}
.service-filters li a {
}
.service-filters li:hover, .service-filters li.selected,.service-filters li.completed {
}
.service-filters li.completed{
}
.ready-label.hidden{ display: none;}
}
.service-filters li .service-filter-name-container .service-filter-name-outer {
}
.service-filters li .service-filter-name-container .service-filter-name-outer .service-filter-name-inner {
}
.service-filters li .service-filter-name-container .service-filter-name-outer .service-filter-name-inner a {
}',
		'type'    => 'code',
		'section' => 'wsi_styling'
	);
	
/**
* DEBUG SECTION
*/
	$this->settings['enable_dev'] = array(
		'title'   => __( 'Dev Mode' , $this->WPB_PREFIX),
		'desc'    => __( 'Enable / Disable Development mode. Use it on dev site to print out errors' , $this->WPB_PREFIX),
		'std'     => 'false',
		'type'    => 'select',
		'section' => 'wsi_debug',
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