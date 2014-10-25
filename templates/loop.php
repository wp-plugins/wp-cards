<?php
	$view = wp_cards_get_view();

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();

			$args = array(
				'post_type'   => $post->post_type,
				'view'        => $view
			);
			wp_cards_excerpt( $args );
		}

		wp_cards_load_more( array( 'view' => $view, 'target' => 'some_id' ) );
		rewind_posts();
	}

?>