<div <?php post_class( 'entry' ); ?> id="excerpt-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>" data-view="spotlight">
	<div class="col col-6 col-sm-12 col-md-6 entry-thumb">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail( array( '460', '300' ), array( 'class' => "featurette-image img-responsive" ) ); ?>
		</a>
	</div>
	<div class="col col-6 col-sm-12 col-md-6">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
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
		<p><a href="<?php the_permalink(); ?>" rel="bookmark" class="btn btn-success"><?php _e( 'Continue Reading &raquo;', 'wp-cards' ); ?></a></p>
	</div>
</div><!-- /.entry -->