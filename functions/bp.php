<?php
 /**
  * Bp Setup globals slugs
  * @Since v2.1
  * @returns void
  */ 
function wsi_setup_globals() {
	global $bp, $wpdb;

	if ( !isset( $bp->wsi ) ) {
		$bp->wsi = new stdClass;
	}

	$bp->wsi->id = 'wsi';

	$bp->wsi->table_name = $wpdb->base_prefix . 'wsi';
	$bp->wsi->slug = 'wp-social-invitations';

	/* Register this in the active components array */
	$bp->active_components[$bp->wsi->slug] = $bp->wsi->id;
}


 /**
  * Bp Navs
  * @Since v2.1
  * @returns void
  */ 
function wsi_setup_nav() {
	global $bp;


	/* Add 'Send Social Invites' to the main user profile navigation */
	bp_core_new_nav_item( array(
		'name' => __( 'Send Social Invites', 'wsi' ),
		'slug' => $bp->wsi->slug,
		'position' => 80,
		'screen_function' => 'wsi_screen_one',
		'default_subnav_slug' => 'invite-new-members',
		'show_for_displayed_user' => wsi_access_test()
	) );

	$wsi_link = $bp->loggedin_user->domain . $bp->wsi->slug . '/';

/*	/* Create two sub nav items for this component 
	bp_core_new_subnav_item( array(
		'name' => __( 'Invite New Members', 'wsi' ),
		'slug' => 'invite-new-members',
		'parent_slug' => $bp->wsi->slug,
		'parent_url' => $wsi_link,
		'screen_function' => 'wsi_screen_one',
		'position' => 10,
		'user_has_access' => wsi_access_test()
	) );

	bp_core_new_subnav_item( array(
		'name' => __( 'Sent Invites', 'wsi' ),
		'slug' => 'sent-invites',
		'parent_slug' => $bp->wsi->slug,
		'parent_url' => $wsi_link,
		'screen_function' => 'wsi_screen_two',
		'position' => 20,
		'user_has_access' => wsi_access_test()
	) ); */
}
 /**
  * Bp access test check wheter to show or not bp screen
  * @Since v2.1
  * @returns bool
  */ 
function wsi_access_test() {
	global $current_user, $bp;

	if ( !is_user_logged_in() )
		return false;

	// The site admin can see all
	if ( current_user_can( 'bp_moderate' ) ) {
		return true;
	}

	if ( bp_displayed_user_id() && !bp_is_my_profile() )
		return false;

	return true;

}

 /**
  * Bp Screen one function to load screen content
  * @Since v2.1
  * @returns void
  */ 
function wsi_screen_one() {
	global $bp;


	/* Add a do action here, so your component can be extended by others. */
	do_action( 'wsi_screen_one' );

	/* bp_template_title ought to be used - bp-default needs to markup the template tag
	and run a conditional check on template tag true to hide empty element markup or not
	add_action( 'bp_template_title', 'invite_anyone_screen_one_title' );
	*/
	add_action( 'bp_template_content', 'wsi_screen_one_content' );

	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

 /**
  * Bp Wsi screen content
  * @Since v2.1
  * @returns void
  */ 
function wsi_screen_one_content(){
		
		$title = apply_filters('wsi_bp_title', sprintf(__('Invite your friends to join %s','wsi'), get_bloginfo('name')));
	
		WP_Social_Invitations::widget($title);
	
}

 /**
  * Bp Menu wsi. Modify bp admin bar to show links to Social Send Invites Screen
  * @Since v2.1
  * @returns void
  */ 
  function wsi_menu(){
  	global $bp, $wp_admin_bar;

	// Only show if viewing a user
	if ( !bp_is_user() )
		return false;
		
	$wp_admin_bar->add_menu( array(
		'parent' => 'my-account-friends',
		'id'     => 'my-account-friends-social-invites',
		'title'  => __( 'Send Social Invites', 'buddypress' ),
		'href'   => bp_displayed_user_domain() . 'wp-social-invitations/'
	) );
	$wp_admin_bar->add_menu( array(
		'parent' => 'my-account',
		'id'     => 'my-account-social-invites',
		'title'  => __( 'Send Social Invites', 'buddypress' ),
		'href'   => bp_displayed_user_domain() . 'wp-social-invitations/'
	) );
  }


