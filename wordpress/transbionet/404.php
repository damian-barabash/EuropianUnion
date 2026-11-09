<?php get_header(); ?>
<section class="section notfound">
	<div class="container">
		<h1>Page not found</h1>
		<p>The page may have been moved or the address is wrong.</p>
		<a class="btn btn--primary" href="<?php echo esc_url(home_url('/')); ?>">Go to the home page</a>
	</div>
</section>
<?php get_footer(); ?>
