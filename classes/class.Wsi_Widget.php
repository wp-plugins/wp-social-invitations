<?php
class Wsi_Widget extends WP_Widget {

	var $wpb_prefix;
	var $wsi;
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$this->wsi = WP_Social_Invitations::get_instance();
		$this->wpb_prefix = $this->wsi->get_domain();
		parent::__construct(
			'wsi_widget', // Base ID
			'Wordpress Social Invitations', // Name
			array( 'description' => __( 'Add a Wordpress Social Invitations sidebar widget. Only icons are displayed', $this->wpb_prefix ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$this->wsi->load_wsi_js();
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$CURRENT_URL = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
			?>
			<input type="hidden" id="wsi_base_url" value="<?php echo $CURRENT_URL;?>">
			<?php
			
			$providers = $this->wsi->get_providers();
			$options   = $this->wsi->getOptions();
		
			wsi_get_template('widget/sidebar-widget.php', array( 
				'WPB_PREFIX' 	=> $this->wpb_prefix, 
				'options' 		=> $options, 
				'providers' 	=> $providers,
				)
			);
		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Invite some friends!', $this->wpb_prefix);
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Foo_Widget