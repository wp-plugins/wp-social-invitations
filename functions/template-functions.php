<?php
/**
 * get template,
 * passing atrributes and include the file
 */
function wsi_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	global $wsi;

	if ( $args && is_array($args) )
		extract( $args );

	$located = wsi_locate_template( $template_name, $template_path, $default_path );

	include( $located );
}


function wsi_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	global $wsi;

	if ( ! $template_path ) $template_path = $wsi->get_slug() . '/';
	if ( ! $default_path )  $default_path = $wsi->get_abs_path() . '/templates/';

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template )
		$template = $default_path . $template_name;

	// Return what we found
	return apply_filters('wsi_locate_template', $template, $template_name, $template_path);
}