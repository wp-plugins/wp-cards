<?php

/*
Template Name: WP Cards Template
*/

$page_name = $post->post_name;

get_header(); ?>
<div class="container <?php echo $page_name; ?>-container">
	<div id="content">
		<?php if ( ! dynamic_sidebar( $page_name . '-cards' ) ) : ?>
			<!-- Card Area -->
		<?php endif; ?>
	</div><!-- /#content -->
</div><!-- /.container -->
<?php get_footer(); ?>