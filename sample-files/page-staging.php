<?php get_header(); ?>
<div class="container">
	<h1>Card Staging Area</h1>
<?php if ( ! dynamic_sidebar( 'card_staging' ) ) : ?>
	<!-- Card Staging -->
	<h2>Missing Plugin</h2>
	<p>This theme requires that the WP Cards plugin be installed and activated in order to render this page correctly.</p>
<?php endif; ?>
</div><!-- /.container -->
<?php get_footer(); ?>