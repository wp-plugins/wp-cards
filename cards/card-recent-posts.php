<?php

class wp_cards_recent_posts_widget extends WP_Widget {
	public static $classname = __CLASS__;
	
	public function __construct() {
		parent::__construct( __CLASS__, 'Card - Recent Posts', array(
			'description' => 'A recent posts grid for full width "sidebars".',
			'classname'   => self::$classname
		) );
	}

	public function widget( $args, $params ) {
		extract( $params );

		// &order=DESC&post_status=publish
		$uncategorized_id = get_cat_ID( 'Uncategorized' );

		// Create a new query instance
		$query_args = array(
			'posts_per_page'   => $posts_per_page,
			'suppress_filters' => true
		);
		
		if ( ! empty( $category ) ) {
			$query_args[ 'category__in' ] = $category;
			$current_category_id = $category;
		} else {
			$current_category_id = NULL;
		}

		wp_cards_query( $query_args );
		
		if ( ! empty ( $args['before_widget'] ) ) {
			echo $args['before_widget'];
		}
		
		?>
		<div class="section content bg-base">
			<h2 class="section-title ribbon"><span><?php echo $title; ?></span></h2>
			<div class="entries row">
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="entry style-thumbnail-text col col-sm-6 col-md-2 colheight-sm-1">
					<?php
					$category_tag = '';
					$categories = get_the_category();
					if( $categories ) {
						foreach( $categories as $category ) {
							if ( in_array( $category->term_id, array( $uncategorized_id ) ) ) // $current_category_id, 
								continue;
							$category_tag .= '<span class="category"><a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" class="' . $category->slug . '">' . $category->cat_name . '</a></span>';
						}
						echo '<div class="entry-meta">' . $category_tag . '</div>';
					}
					?>
					<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					<!-- div class="entry-meta">
						<span class="entry-date"><?php _e( 'on', 'wp-cards' ) ?> <time datetime="<?php echo get_the_date( 'c' ); ?>" pubdate><?php echo date_i18n( get_option( 'date_format' ), strtotime( $post->post_date ) ); ?></time></span>
						</div -->
					</article>
				<?php endwhile; 
				
				// Reset Post Data
				wp_cards_reset_query(); ?>
			</div><!-- /.row.entries. -->
		</div><!--.section.content-->
		<?php

		if ( ! empty ( $args['after_widget'] ) ) {
			echo $args['after_widget'];
		}
	}
	
	public function form( $instance ) {
		global $wpdb;

		$defaults = array(
			'title' => __( 'Recent Posts', 'wp-cards' ),
			'posts_per_page' => '12',
			'category' => $instance['category']
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
                
?>
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wp-cards' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Number of Posts', 'wp-cards' ); ?>:</label> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo $instance['posts_per_page']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category', 'wp-cards' ); ?>:</label>
	<?php wp_dropdown_categories( array( 'hide_empty' => 0, 'name' => $this->get_field_name( 'category' ), 'orderby' => 'name', 'selected' => $instance['category'], 'hierarchical' => true, 'show_option_none' => __( 'None', 'wp-cards' ) ) ); ?>
</p>
<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );
		$instance['category'] = strip_tags( $new_instance['category'] );

		return $instance;  
	}
}

?>