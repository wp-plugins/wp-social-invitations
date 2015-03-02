<?php
/**
 * Collector Footer
 * @link       http://wp.timersys.com/wordpress-social-invitations/
 * @since      2.5.0
 *
 * @package    Wsi
 * @subpackage Wsi/public/partials
 */
global $wp_scripts, $wp_styles, $wp_filter;

//remove all scripts and style
if( !empty( $wp_scripts->queue )) {
	foreach ($wp_scripts->queue as $handle) {
		wp_dequeue_script ($handle);
	}
}
if( !empty( $wp_styles->queue )) {
	foreach ($wp_styles->queue as $handle) {
		wp_dequeue_style ($handle);
	}
}
// add jquery
wp_enqueue_script('jquery');
//remove all actions
remove_all_actions('wp_footer',52);
//but print scripts
add_action('wp_footer','wp_print_footer_scripts',10);
?>
</form>
<div id="footer">
	<div id="credits">
		Powered by <a href="http://wp.timersys.com/wordpress-social-invitations/" target="_blank">Wordpress Social Invitations</a>
	</div>
</div>
<?php
	wp_footer();
	?>
	<script src="<?php echo WSI_PLUGIN_URL . 'public/assets/js/collector.js';?>"></script>
	<script src="<?php echo WSI_PLUGIN_URL . 'public/assets/js/jquery.lazyload.min.js';?>"></script>
<?php
if (!empty($provider->name) && 'live' == $provider->name ){?>
	<script src="<?php echo WSI_PLUGIN_URL . 'public/assets/js/jquery.iframe-transport.js';?>"></script>
	<script src="<?php echo WSI_PLUGIN_URL . 'public/assets/js/jquery.ui.widget.js';?>"></script>
	<script src="<?php echo WSI_PLUGIN_URL . 'public/assets/js/jquery.fileupload.js';?>"></script>
	<script src="<?php echo WSI_PLUGIN_URL . 'public/assets/js/live.js';?>"></script>
<?php
}
?>
</body>
</html>