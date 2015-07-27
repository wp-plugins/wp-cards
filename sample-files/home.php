<?php get_header(); ?>
<div class="container homepage-container">
	<div id="content">
		<?php if ( ! dynamic_sidebar( 'home_page_cards' ) ) : ?>
			<!-- Homepage Card Area -->
		<?php endif; ?>
	</div><!-- /#content -->
</div><!-- /.container -->
<?php get_footer(); ?>