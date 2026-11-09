<?php
get_header();
while (have_posts()) :
	the_post();
	if (!tbn_field('header_hide')) {
		$tbn_extra = '';
		$tbn_badge = tbn_field('header_badge');
		$tbn_btn = tbn_field('header_button');
		if ($tbn_badge || !empty($tbn_btn['url'])) {
			$tbn_extra = '<div class="pagehero__row">' . ($tbn_badge ? '<span class="status status--upcoming">' . esc_html($tbn_badge) . '</span>' : '') . tbn_button($tbn_btn, 'btn btn--primary', !empty($tbn_btn['target']) ? 'external' : '') . '</div>';
		}
		$tbn_crumbs = [];
		foreach (array_reverse(get_post_ancestors(get_the_ID())) as $tbn_anc) {
			$tbn_crumbs[] = ['label' => get_the_title($tbn_anc), 'url' => get_permalink($tbn_anc)];
		}
		$tbn_crumbs[] = ['label' => get_the_title()];
		tbn_page_hero(get_the_title(), (string) tbn_field('header_lead'), $tbn_crumbs, $tbn_extra);
	}
	tbn_render_sections();
	// A page without sections shows its plain text (pages made before the theme, or by mistake).
	if (!tbn_field('sections') && trim(get_the_content())) :
		?>
		<section class="section"><div class="container article"><div class="prose"><?php the_content(); ?></div></div></section>
		<?php
	endif;
endwhile;
get_footer();
