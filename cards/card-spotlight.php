<?php

class wp_cards_spotlight_widget extends WP_Widget {
	public static $classname = __CLASS__;
	
	public function __construct() {
		parent::__construct( __CLASS__, 'Card - Spotlight', array(
			'description' => 'A spotlight widget for full width "sidebars".',
			'classname'   => self::$classname
		) );
	}

	public function widget( $args, $params ) {
		extract( $params );

		if ( ! empty ( $args['before_widget'] ) ) {
			echo $args['before_widget'];
		}
		
		?>
		<!-- Three columns of text with circle images -->
		<div class="row spotlight-view">
			<div class="col col-md-4">
				<img class="img-circle" src="<?php echo $panel_1_image; ?>" alt="<?php echo $panel_1_title; ?>">
				<h2><?php echo $panel_1_title; ?></h2>
				<p><?php echo $panel_1_text; ?></p>
				<p><a class="btn btn-default" href="<?php echo $panel_1_url; ?>" role="button"><?php echo $panel_1_link_text; ?></a></p>
			</div><!-- /.col.col-md-4 -->
			<div class="col col-md-4">
				<img class="img-circle" src="<?php echo $panel_2_image; ?>" alt="<?php echo $panel_2_title; ?>">
				<h2><?php echo $panel_2_title; ?></h2>
				<p><?php echo $panel_2_text; ?></p>
				<p><a class="btn btn-default" href="<?php echo $panel_2_url; ?>" role="button"><?php echo $panel_2_link_text; ?></a></p>
			</div><!-- /.col.col-md-4 -->
			<div class="col col-md-4">
				<img class="img-circle" src="<?php echo $panel_3_image; ?>" alt="<?php echo $panel_3_title; ?>">
				<h2><?php echo $panel_3_title; ?></h2>
				<p><?php echo $panel_3_text; ?></p>
				<p><a class="btn btn-default" href="<?php echo $panel_3_url; ?>" role="button"><?php echo $panel_3_link_text; ?></a></p>
			</div><!-- /.col.col-md-4 -->
		</div><!-- /.spotlight -->
		<?php

		if ( ! empty ( $args['after_widget'] ) ) {
			echo $args['after_widget'];
		}
	}
	
	public function form( $instance ) {
		global $wpdb;
		$defaults = array(
			'panel_1_title'      => 'Title One',
			'panel_1_text'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat...',
			'panel_1_image'      => plugins_url( 'wp-cards/includes/images/250x250.gif' ),
			'panel_1_url'        => 'http://example.com/',
			'panel_1_link_text'  => __( 'View details &raquo;', 'wp-cards' ),
			'panel_2_title'      => 'Title Two',
			'panel_2_text'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat...',
			'panel_2_image'      => plugins_url( 'wp-cards/includes/images/250x250.gif' ),
			'panel_2_url'        => 'http://example.com/',
			'panel_2_link_text'  => __( 'View details &raquo;', 'wp-cards' ),
			'panel_3_title'      => 'Title Three',
			'panel_3_text'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat...',
			'panel_3_image'      => plugins_url( 'wp-cards/includes/images/250x250.gif' ),
			'panel_3_url'        => 'http://example.com/',
			'panel_3_link_text'  => __( 'View details &raquo;', 'wp-cards' )
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
                
?>
<h4>Panel 1</h4>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_1_title' ); ?>"><?php _e( 'Panel 1 Title' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_1_title' ); ?>" name="<?php echo $this->get_field_name( 'panel_1_title' ); ?>" value="<?php echo $instance['panel_1_title']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_1_text' ); ?>"><?php _e( 'Panel 1 Text' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_1_text' ); ?>" name="<?php echo $this->get_field_name( 'panel_1_text' ); ?>" value="<?php echo $instance['panel_1_text']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_1_image' ); ?>"><?php _e( 'Panel 1 Image' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_1_image' ); ?>" name="<?php echo $this->get_field_name( 'panel_1_image' ); ?>" value="<?php echo $instance['panel_1_image']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_1_url' ); ?>"><?php _e( 'Panel 1 URL' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_1_url' ); ?>" name="<?php echo $this->get_field_name( 'panel_1_url' ); ?>" value="<?php echo $instance['panel_1_url']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_1_link_text' ); ?>"><?php _e( 'Panel 1 Link Text' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_1_link_text' ); ?>" name="<?php echo $this->get_field_name( 'panel_1_link_text' ); ?>" value="<?php echo $instance['panel_1_link_text']; ?>" />
</p>
<h4>Panel 2</h4>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_2_title' ); ?>"><?php _e( 'Panel 2 Title' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_2_title' ); ?>" name="<?php echo $this->get_field_name( 'panel_2_title' ); ?>" value="<?php echo $instance['panel_2_title']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_2_text' ); ?>"><?php _e( 'Panel 2 Text' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_2_text' ); ?>" name="<?php echo $this->get_field_name( 'panel_2_text' ); ?>" value="<?php echo $instance['panel_2_text']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_2_image' ); ?>"><?php _e( 'Panel 2 Image' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_2_image' ); ?>" name="<?php echo $this->get_field_name( 'panel_2_image' ); ?>" value="<?php echo $instance['panel_2_image']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_2_url' ); ?>"><?php _e( 'Panel 2 URL' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_2_url' ); ?>" name="<?php echo $this->get_field_name( 'panel_2_url' ); ?>" value="<?php echo $instance['panel_2_url']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_2_link_text' ); ?>"><?php _e( 'Panel 2 Link Text' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_2_link_text' ); ?>" name="<?php echo $this->get_field_name( 'panel_2_link_text' ); ?>" value="<?php echo $instance['panel_2_link_text']; ?>" />
</p>
<h4>Panel 3</h4>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_3_title' ); ?>"><?php _e( 'Panel 3 Title' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_3_title' ); ?>" name="<?php echo $this->get_field_name( 'panel_3_title' ); ?>" value="<?php echo $instance['panel_3_title']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_3_text' ); ?>"><?php _e( 'Panel 3 Text' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_3_text' ); ?>" name="<?php echo $this->get_field_name( 'panel_3_text' ); ?>" value="<?php echo $instance['panel_3_text']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_3_image' ); ?>"><?php _e( 'Panel 3 Image' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_3_image' ); ?>" name="<?php echo $this->get_field_name( 'panel_3_image' ); ?>" value="<?php echo $instance['panel_3_image']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_3_url' ); ?>"><?php _e( 'Panel 3 URL' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_3_url' ); ?>" name="<?php echo $this->get_field_name( 'panel_3_url' ); ?>" value="<?php echo $instance['panel_3_url']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'panel_3_link_text' ); ?>"><?php _e( 'Panel 3 Link Text' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'panel_3_link_text' ); ?>" name="<?php echo $this->get_field_name( 'panel_3_link_text' ); ?>" value="<?php echo $instance['panel_3_link_text']; ?>" />
</p>
<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		// Panel 1
		$instance['panel_1_title'] = strip_tags( $new_instance['panel_1_title'] );
		$instance['panel_1_text'] = strip_tags( $new_instance['panel_1_text'] );
		$instance['panel_1_image'] = strip_tags( $new_instance['panel_1_image'] );
		$instance['panel_1_url'] = strip_tags( $new_instance['panel_1_url'] );
		$instance['panel_1_link_text'] = strip_tags( $new_instance['panel_1_link_text'] );
		// Panel 2
		$instance['panel_2_title'] = strip_tags( $new_instance['panel_2_title'] );
		$instance['panel_2_text'] = strip_tags( $new_instance['panel_2_text'] );
		$instance['panel_2_image'] = strip_tags( $new_instance['panel_2_image'] );
		$instance['panel_2_url'] = strip_tags( $new_instance['panel_2_url'] );
		$instance['panel_2_link_text'] = strip_tags( $new_instance['panel_2_link_text'] );
		// Panel 3
		$instance['panel_3_title'] = strip_tags( $new_instance['panel_3_title'] );
		$instance['panel_3_text'] = strip_tags( $new_instance['panel_3_text'] );
		$instance['panel_3_image'] = strip_tags( $new_instance['panel_3_image'] );
		$instance['panel_3_url'] = strip_tags( $new_instance['panel_3_url'] );
		$instance['panel_3_link_text'] = strip_tags( $new_instance['panel_3_link_text'] );

		return $instance;  
	}
}

?>