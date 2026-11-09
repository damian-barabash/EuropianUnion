<?php
// News article.
get_header();
while (have_posts()) :
	the_post();
	$tbn_cat = get_the_category();
	$tbn_extra = '<p class="chips"><time class="chip-date" datetime="' . esc_attr(get_the_date('Y-m-d')) . '">' . esc_html(get_the_date('j F Y')) . '</time>'
		. ($tbn_cat ? '<span class="chip-cat">' . esc_html($tbn_cat[0]->name) . '</span>' : '') . '</p>';
	tbn_page_hero(get_the_title(), '', array_values(array_filter([tbn_listing_crumb('post'), ['label' => get_the_title()]])), $tbn_extra);
	?>
	<article class="section">
		<div class="container article">
			<?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('tbn-wide', ['class' => 'article__img', 'alt' => '', 'loading' => 'eager']); ?>
			<?php endif; ?>
			<div class="prose">
				<?php if (has_excerpt()) : ?><p class="prose__lead"><?php echo esc_html(get_the_excerpt()); ?></p><?php endif; ?>
				<?php the_content(); ?>
			</div>
			<?php $tbn_back = tbn_listing_crumb('post'); if ($tbn_back) : ?>
				<a class="btn btn--outline btn--sm" href="<?php echo esc_url($tbn_back['url']); ?>">Back to all news</a>
			<?php endif; ?>
		</div>
	</article>
	<?php
	$tbn_related = get_posts(['numberposts' => 3, 'post__not_in' => [get_the_ID()]]);
	if ($tbn_related) :
		?>
		<section class="section section--grey">
			<div class="container">
				<?php tbn_section_head('More news'); ?>
				<div class="grid grid--3"><?php foreach ($tbn_related as $tbn_p) { tbn_post_card($tbn_p); } ?></div>
			</div>
		</section>
		<?php
	endif;
endwhile;
get_footer();
