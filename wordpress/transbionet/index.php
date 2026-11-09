<?php
// Fallback template (search results, archives that have no own template).
get_header();
tbn_page_hero(wp_strip_all_tags(get_the_archive_title()) ?: 'Results');
?>
<section class="section">
	<div class="container">
		<?php if (have_posts()) : ?>
			<div class="grid grid--3">
				<?php while (have_posts()) : the_post(); tbn_post_card(get_post()); endwhile; ?>
			</div>
			<?php tbn_pagination(); ?>
		<?php else : ?>
			<p class="empty">Nothing found.</p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
