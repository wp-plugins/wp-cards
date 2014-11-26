<?php get_header(); ?>
<div class="container">
<?php if ( ! dynamic_sidebar( 'home_page_cards' ) ) : ?>
<!-- Home Page Cards -->
<h2>Missing Plugin</h2>
<p>This theme requires that the WP Cards plugin be installed and activated in order to render the homepage correctly.</p>
<?php endif; ?>
</div><!-- /.container -->
<?php get_footer(); ?>