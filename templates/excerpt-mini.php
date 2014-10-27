<div class="entry col col-sm-6 col-md-2 colheight-sm-1">
	<div class="excerpt-wrapper" id="excerpt-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>" data-view="mini">
		<?php
			$category_tag = '';
			$categories = get_the_category();
			if ( $categories ) {
				foreach( $categories as $category ) {
					if ( in_array( $category->term_id, array( $uncategorized_id ) ) ) // $current_category_id, 
						continue;
					$category_tag .= '<span class="category"><a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" class="' . $category->slug . '">' . $category->cat_name . '</a></span>';
				}
				echo '<div class="entry-meta">' . $category_tag . '</div>';
			}
		?>
		<h3 class="entry-title"><a href="<?php the_permalink(); ?>" target="_blank" title="<?php printf( esc_attr__( 'Permalink to %s', 'wp-cards' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
	</div><!--/excerpt-wrapper-->
</div><!-- /.entry -->