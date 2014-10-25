<div <?php post_class( 'entry col-6 col-sm-6 col-lg-4' ); ?>>
	<div class="excerpt-wrapper" id="excerpt-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>" data-view="tile">
		<?php if ( $imgdata = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array('300','200') ) )  : ?>
		<div class="panel panel-default has-thumb">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wp-cards' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<div class="panel-heading excerpt-thumb" style="background-image:url('<?php echo $imgdata[0]; ?>');"></div>
				<h3><?php the_title(); ?></h3>
			</a>
		<?php else: ?>
		<div class="panel panel-default">
			<a href="<?php the_permalink(); ?>" target="_blank" title="<?php printf( esc_attr__( 'Permalink to %s', 'wp-cards' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<h3><?php the_title(); ?></h3>
			</a>
		<?php endif; ?>
		</div>
		<?php wp_cards_toolbar(); ?>
	</div><!--/excerpt-wrapper-->
</div><!-- /.entry -->