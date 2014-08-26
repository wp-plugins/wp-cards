<?php

class wp_cards_category_carousel_widget extends WP_Widget {
	public static $classname = __CLASS__;
	
	public function __construct() {
		parent::__construct( __CLASS__, 'Card - Category Carousel', array(
			'description' => 'A category carousel card for full width "sidebars" (only shows top level categories).',
			'classname'   => self::$classname
		) );
	}

	public function widget( $args, $params ) {
		extract( $params );

		$exclude_arr[] = get_cat_ID( 'Uncategorized' );

		foreach ( $exclude as $key => $value ) {
			if ( 'on' === $value ) {
				$exclude_arr[] = $key;
			}
		}

		$exclude_string = implode( ',', $exclude_arr );
		$cat_args = array(
			'type'         => 'post',
			'order'        => 'ASC',
			'parent'       => 0,
			'hide_empty'   => 1,
			'hierarchical' => 0,
			'taxonomy'     => 'category',
			'exclude'      => $exclude_string
		);

		// Grab the categories from the database
		$categories = get_categories( $cat_args );
		$first_slide = true;

		// Begin outputting the widget HTML
		if ( ! empty ( $args['before_widget'] ) ) {
			echo $args['before_widget'];
		}
		?>
		<div id="<?php echo $args['widget_id']; ?>" class="section carousel category-carousel slide">
			<div class="carousel-inner">
			<?php foreach ( $categories as $category ) :
				if ( $first_slide ) {
					$active_class = ' active';
					$first_slide = false;
				} else {
					$active_class = '';
				} ?>
				<div class="item<?php echo $active_class; ?> <?php echo $category->slug; ?>">
					<h2 class="section-title ribbon ribbon-highlight"><a href="<?php echo get_category_link( $category->term_id ); ?>"><?php _e( $category->cat_name ); ?></a></h2>
					<div class="row entries">
					<?php
						// Create a new query instance
						$query_args = array(
							'post_type'        => 'post',
							'posts_per_page'   => $posts_per_page,
							'suppress_filters' => true,
							'category__in'     => array( $category->term_id )
						);
		
						wp_cards_query( $query_args );

						// Start the Loop.
						while ( have_posts() ) {
							the_post();
							global $post;
					?>
						<div <?php post_class( 'entry col col-3 col-sm-6 col-lg-3' ); ?>>
							<div class="excerpt-wrapper" id="excerpt-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>">
					<?php
							// Remove the word "Private" from the title
							$post_title = 'private' == $post->post_status ? str_replace('Private: ', '', $post->post_title) : $post->post_title;

							if ( $imgdata = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), array('300','200') ) )  : ?>
								<div class="panel panel-default has-thumb">
									<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wp-cards' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
										<div class="panel-heading excerpt-thumb" style="background-image:url('<?php echo $imgdata[0]; ?>');"></div>
										<h3><?php echo $post_title; ?></h3>
									</a>
							<?php else: ?>
								<div class="panel panel-default">
									<a href="<?php the_permalink(); ?>" target="_blank" title="<?php printf( esc_attr__( 'Permalink to %s', 'wp-cards' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
										<h3><?php echo $post_title; ?></h3>
									</a>
							<?php endif; ?>
								</div>
							

							</div>
						</div>
					<?php
			  			}

						// Reset Post Data
						wp_cards_reset_query(); 
					?>
						<div class="clearfix"></div>
					</div><!--/.row.entries-->
				</div><!--/.item-->
			<?php endforeach; // End category foreach ?>
			</div><!--/.carousel-inner-->
			<a class="left carousel-control" href="#<?php echo $args['widget_id']; ?>" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#<?php echo $args['widget_id']; ?>" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div><!-- /#<?php echo $args['widget_id']; ?> -->
		<?php

		if ( ! empty ( $args['after_widget'] ) ) {
			echo $args['after_widget'];
		}
	}
	
	public function form( $instance ) {
		global $wpdb;

		$defaults = array(
			'posts_per_page' => '4'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
                
?>
<p>
	<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Number of Posts', 'wp-cards' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo $instance['posts_per_page']; ?>" />
</p>
<p>
	<label><?php _e( 'Exclude Categories', 'wp-cards' ); ?>:</label>
</p>
<?php 
		$uncategorized_id = get_cat_ID( 'Uncategorized' );

		$cat_args = array(
			'type'         => 'post',
			'order'        => 'ASC',
			'orderby'      => 'name',
			'parent'       => 0,
			'hide_empty'   => 1,
			'hierarchical' => 0,
			'taxonomy'     => 'category',
			'exclude'      => $uncategorized_id
		);

		$categories = get_categories( $cat_args );
		foreach($categories as $category) : ?>
			<p><input class="checkbox" type="checkbox" <?php checked( (bool) $instance['exclude'][$category->term_id], true ); ?> name="<?php echo $this->get_field_name( 'exclude' ); ?>[<?php echo $category->term_id; ?>]"><?php echo $category->cat_name; ?></p>
		<?php endforeach;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;	
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );
		$uncategorized_id = get_cat_ID( 'Uncategorized' );

		$cat_args = array(
			'type'         => 'post',
			'order'        => 'ASC',
			'orderby'      => 'name',
			'parent'       => 0,
			'hide_empty'   => 1,
			'hierarchical' => 0,
			'taxonomy'     => 'category',
			'exclude'      => $uncategorized_id
		);

		$categories = get_categories( $cat_args );
		foreach( $categories as $category ) {
			// $instance['exclude'][ $category->term_id ] = ( 'on' == $new_instance['exclude'][ $category->term_id ] ) ? 'yes' : 'no';
			if ( isset( $new_instance['exclude'][ $category->term_id ] ) ) {
				$instance['exclude'][ $category->term_id ] = strip_tags( $new_instance['exclude'][ $category->term_id ] );
			} else {
				$instance['exclude'][ $category->term_id ] = 0;
			}
		}

		return $instance;
	}
}

?>