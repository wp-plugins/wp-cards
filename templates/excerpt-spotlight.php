<div <?php post_class( 'entry col col-md-4' ); ?> id="excerpt-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>" data-view="spotlight">
	<?php the_post_thumbnail( array( '300', '300' ), array( 'class' => "img-circle", 'alt' => get_the_title() ) ); ?>
	<h2 class="entry-title"><?php the_title(); ?></h2>
	<?php
		// Get the excerpt
		if ( ! empty( $post->post_excerpt ) ) {
			$excerpt = $post->post_excerpt;
		} else {
			$excerpt_args = array(
				'text'   => get_the_content(),
				'length' => 60
			);
			$excerpt = wp_cards_the_excerpt( $excerpt_args );
		}

		echo wpautop( $excerpt );
	?>
	<p><a class="btn btn-default" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wp-cards' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" role="button"><?php _e( 'Read more &raquo;', 'wp-cards' ); ?></a></p>
</div><!-- /.entry.col.col-md-4 -->