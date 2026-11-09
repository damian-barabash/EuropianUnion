<?php
// News: the page chosen as "Posts page" (Settings → Reading). Its title and lead are the header,
// its sections (if any) follow the list.
get_header();
$tbn_page = (int) get_option('page_for_posts');
$tbn_title = $tbn_page ? get_the_title($tbn_page) : 'News';
tbn_page_hero($tbn_title, (string) tbn_field('header_lead', $tbn_page), [['label' => $tbn_title]]);
?>
<section class="section">
	<div class="container">
		<?php if (have_posts()) : ?>
			<div class="grid grid--3">
				<?php while (have_posts()) : the_post(); tbn_post_card(get_post()); endwhile; ?>
			</div>
			<?php tbn_pagination(); ?>
		<?php else : ?>
			<p class="empty">No news yet.</p>
		<?php endif; ?>
	</div>
</section>
<?php
if ($tbn_page && !is_paged()) {
	tbn_render_sections($tbn_page);
}
get_footer();
