<?php
defined('ABSPATH') || exit;

/* ---------- Fields ---------- */

// Custom field of a post (or of the current post). Works without ACF too: then it reads the raw meta.
function tbn_field(string $name, $post_id = false, $default = '') {
	if (function_exists('get_field')) {
		$v = get_field($name, $post_id);
	} else {
		$v = get_post_meta($post_id ?: get_the_ID(), $name, true);
	}
	return ($v === null || $v === '' || $v === false || $v === []) ? $default : $v;
}

// Field from "Site settings".
function tbn_option(string $name, $default = '') {
	return tbn_field($name, 'option', $default);
}

/* ---------- Icons ---------- */

function tbn_icon(string $name, int $size = 20): string {
	static $paths = [
		'arrow'    => 'M5 12h14m-6-6 6 6-6 6',
		'external' => 'M14 5h5v5m0-5-8 8M10 6H6a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4',
		'download' => 'M12 4v11m0 0-4-4m4 4 4-4M5 19h14',
		'calendar' => 'M7 3v3m10-3v3M4 9h16M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z',
		'pin'      => 'M12 21s7-6.1 7-11.5A7 7 0 0 0 5 9.5C5 14.9 12 21 12 21Zm0-9a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z',
		'clock'    => 'M12 7v5l3 2m6-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
		'menu'     => 'M4 7h16M4 12h16M4 17h16',
		'close'    => 'm6 6 12 12M18 6 6 18',
		'chevron'  => 'm6 9 6 6 6-6',
		'play'     => 'M9 7.5v9l7-4.5-7-4.5Z',
		'mail'     => 'M4 6h16a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1Zm0 1 8 6 8-6',
		'users'    => 'M9 11a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-6 9c0-3.3 2.7-6 6-6s6 2.7 6 6m1-9.5a3 3 0 1 0-1-5.8M17 14c2.4.5 4 2.8 4 6',
	];
	if (!isset($paths[$name])) {
		return '';
	}
	return sprintf(
		'<svg class="icon" width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="%2$s"/></svg>',
		$size,
		$paths[$name]
	);
}

/* ---------- Dates ---------- */

// ACF date fields are stored as Ymd. Returns a DateTimeImmutable in the site time zone, or null.
function tbn_dt($ymd): ?DateTimeImmutable {
	if (!$ymd) {
		return null;
	}
	$d = DateTimeImmutable::createFromFormat('Ymd H:i:s', preg_replace('/\D/', '', (string) $ymd) . ' 12:00:00', wp_timezone());
	return $d ?: null;
}

function tbn_date($ymd): string {
	$d = tbn_dt($ymd);
	return $d ? wp_date('j F Y', $d->getTimestamp()) : '';
}

function tbn_iso($ymd): string {
	$d = tbn_dt($ymd);
	return $d ? $d->format('Y-m-d') : '';
}

// Has the day (end of day) passed already?
function tbn_is_past($ymd): bool {
	$d = tbn_dt($ymd);
	return $d ? $d->setTime(23, 59, 59)->getTimestamp() < time() : false;
}

/* ---------- Brand ---------- */

function tbn_logo(bool $light = false): string {
	return sprintf(
		'<img class="logo" src="%s" alt="%s" width="214" height="30">',
		esc_url(TBN_URI . '/assets/brand/logo' . ($light ? '-light' : '') . '.svg'),
		esc_attr(get_bloginfo('name'))
	);
}

// European flag drawn to the official construction: 3:2 field, 12 stars on a circle of radius 1/3 of the height.
function tbn_eu_flag(): string {
	$pts = [];
	for ($i = 0; $i < 10; $i++) {
		$r = $i % 2 === 0 ? 1 : 0.382;
		$a = M_PI / 5 * $i - M_PI / 2;
		$pts[] = round(cos($a) * $r, 4) . ',' . round(sin($a) * $r, 4);
	}
	$star = implode(' ', $pts);
	$out = '<svg class="eu__flag" viewBox="0 0 90 60" role="img" aria-label="Flag of the European Union"><rect width="90" height="60" fill="#003399"/>';
	for ($i = 0; $i < 12; $i++) {
		$a = M_PI / 6 * $i;
		$out .= sprintf('<polygon points="%s" fill="#FFCC00" transform="translate(%.3F %.3F) scale(3.333)"/>', $star, 45 + sin($a) * 20, 30 - cos($a) * 20);
	}
	return $out . '</svg>';
}

function tbn_eu_emblem(bool $light = false, bool $stacked = false): string {
	$cls = 'eu' . ($light ? ' eu--light' : '') . ($stacked ? ' eu--stacked' : '');
	return sprintf(
		'<span class="%s">%s<span class="eu__text">%s<br>the European Union</span></span>',
		$cls,
		tbn_eu_flag(),
		esc_html(tbn_option('eu_label', 'Funded by'))
	);
}

/* ---------- Building blocks ---------- */

// ACF "link" field → button. $link = ['url' => …, 'title' => …, 'target' => …].
function tbn_button($link, string $class = 'btn btn--primary', string $icon = ''): string {
	if (empty($link['url'])) {
		return '';
	}
	$target = !empty($link['target']) ? ' target="_blank" rel="noopener noreferrer"' : '';
	$title = $link['title'] ?: 'Read more';
	return sprintf('<a class="%s" href="%s"%s>%s%s</a>', esc_attr($class), esc_url($link['url']), $target, esc_html($title), $icon ? ' ' . tbn_icon($icon, 18) : '');
}

function tbn_section_head(string $title, string $text = '', $action = null): void {
	if (!$title && !$text && empty($action['url'])) {
		return;
	}
	echo '<div class="sechead" data-reveal><div>';
	if ($title) {
		echo '<h2>' . esc_html($title) . '</h2>';
	}
	if ($text) {
		echo '<p>' . esc_html($text) . '</p>';
	}
	echo '</div>';
	echo tbn_button($action, 'btn btn--outline btn--sm');
	echo '</div>';
}

// $items: [['label' => …, 'url' => …], ['label' => …]] — the last one without url is the current page.
function tbn_breadcrumbs(array $items): void {
	echo '<nav class="crumbs" aria-label="Breadcrumb"><ol><li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
	foreach ($items as $i) {
		if (!empty($i['url'])) {
			echo '<li><a href="' . esc_url($i['url']) . '">' . esc_html($i['label']) . '</a></li>';
		} else {
			echo '<li aria-current="page">' . esc_html($i['label']) . '</li>';
		}
	}
	echo '</ol></nav>';
}

function tbn_page_hero(string $title, string $lead = '', array $crumbs = [], string $extra = ''): void {
	echo '<section class="pagehero orbs orbs--a"><div class="container pagehero__in">';
	tbn_breadcrumbs($crumbs ?: [['label' => $title]]);
	echo '<h1>' . esc_html($title) . '</h1>';
	if ($lead) {
		echo '<p class="pagehero__lead">' . esc_html($lead) . '</p>';
	}
	echo $extra; // already escaped by the caller
	echo '</div></section>';
}

// Crumb for a section page (e.g. "Partners") found by the page that lists the post type.
function tbn_listing_crumb(string $post_type): array {
	$pages = ['event' => 'events', 'open_call' => 'open-calls', 'partner' => 'partners', 'post' => 'news'];
	$page = get_page_by_path($pages[$post_type] ?? '');
	if ($post_type === 'post' && get_option('page_for_posts')) {
		$page = get_post(get_option('page_for_posts'));
	}
	// A listing page that is not published yet (e.g. Events while hidden) is not linked.
	return $page && $page->post_status === 'publish' ? ['label' => get_the_title($page), 'url' => get_permalink($page)] : [];
}

/* ---------- Images ---------- */

function tbn_img($id, string $size = 'large', array $attr = []): string {
	if (!$id) {
		return '';
	}
	$attr += ['loading' => 'lazy', 'decoding' => 'async'];
	return wp_get_attachment_image((int) $id, $size, false, $attr);
}

/* ---------- Open Calls ---------- */

// Status is worked out from the dates unless the team sets it by hand.
function tbn_call_status(int $id): string {
	$mode = tbn_field('call_status', $id, 'auto');
	if ($mode !== 'auto') {
		return $mode;
	}
	$opens = tbn_dt(tbn_field('call_opens', $id));
	if ($opens && $opens->setTime(0, 0)->getTimestamp() > time()) {
		return 'upcoming';
	}
	$deadline = tbn_field('call_deadline', $id);
	if ($deadline && tbn_is_past($deadline)) {
		return 'closed';
	}
	return $opens ? 'open' : 'upcoming';
}

function tbn_status_badge(string $status): string {
	$labels = ['open' => 'Open', 'upcoming' => 'Opens soon', 'closed' => 'Closed'];
	return '<span class="status status--' . esc_attr($status) . '">' . esc_html($labels[$status] ?? $status) . '</span>';
}

/* ---------- Queries ---------- */

function tbn_partners(): array {
	return get_posts(['post_type' => 'partner', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'publish']);
}

function tbn_partner_countries(array $partners): int {
	$c = [];
	foreach ($partners as $p) {
		$c[strtolower(trim((string) tbn_field('partner_country', $p->ID)))] = true;
	}
	unset($c['']);
	return count($c);
}

// $mode: upcoming | past | webinars | all
function tbn_events(string $mode = 'upcoming', int $limit = -1): array {
	$today = wp_date('Ymd');
	$args = ['post_type' => 'event', 'numberposts' => $limit, 'post_status' => 'publish', 'meta_key' => 'event_date', 'orderby' => 'meta_value', 'meta_type' => 'DATE'];
	if ($mode === 'past') {
		$args['order'] = 'DESC';
		$args['meta_query'] = [['key' => 'event_date', 'value' => $today, 'compare' => '<', 'type' => 'DATE']];
	} elseif ($mode !== 'all') {
		$args['order'] = 'ASC';
		$args['meta_query'] = [['key' => 'event_date', 'value' => $today, 'compare' => '>=', 'type' => 'DATE']];
		if ($mode === 'webinars') {
			$args['meta_query'][] = ['key' => 'event_webinar', 'value' => '1'];
		}
	}
	return get_posts($args);
}

// $mode: current (open + upcoming) | closed | all. Open first, then upcoming, then closed; newest deadline first.
function tbn_calls(string $mode = 'current'): array {
	$all = get_posts(['post_type' => 'open_call', 'numberposts' => -1, 'post_status' => 'publish', 'meta_key' => 'call_deadline', 'orderby' => 'meta_value', 'order' => 'DESC']);
	$rank = ['open' => 0, 'upcoming' => 1, 'closed' => 2];
	$list = [];
	foreach ($all as $p) {
		$s = tbn_call_status($p->ID);
		if ($mode === 'current' && $s === 'closed' || $mode === 'closed' && $s !== 'closed') {
			continue;
		}
		$list[] = [$rank[$s] ?? 3, $p];
	}
	usort($list, fn ($a, $b) => $a[0] <=> $b[0]);
	return array_column($list, 1);
}

/* ---------- Sections and pagination ---------- */

// Renders the "Sections" of a page: template-parts/sections/<layout>.php gets the section fields as $args.
function tbn_render_sections($post_id = false): void {
	$sections = tbn_field('sections', $post_id, []);
	if (!is_array($sections)) {
		return;
	}
	foreach ($sections as $i => $s) {
		if (!empty($s['hide']) || empty($s['acf_fc_layout'])) {
			continue;
		}
		$s['index'] = $i;
		get_template_part('template-parts/sections/' . sanitize_file_name($s['acf_fc_layout']), null, $s);
	}
}

// Section wrapper class from the "Background" choice.
function tbn_bg_class(array $s, string $default = 'white'): string {
	return [
		'white' => 'section',
		'grey' => 'section section--grey',
		'orbs' => 'section orbs orbs--b',
	][$s['bg'] ?? $default] ?? 'section';
}

function tbn_pagination(): void {
	$older = get_next_posts_link('Older news');
	$newer = get_previous_posts_link('Newer news');
	if (!$older && !$newer) {
		return;
	}
	echo '<nav class="more pager" aria-label="News pages">';
	if ($newer) {
		echo str_replace('<a ', '<a class="btn btn--outline" ', $newer);
	}
	if ($older) {
		echo str_replace('<a ', '<a class="btn btn--primary" ', $older);
	}
	echo '</nav>';
}

// Questions and answers; the first one is open. $items: [['q' => …, 'a' => …], …]
function tbn_accordion(array $items): void {
	static $n = 0;
	$n++;
	echo '<div class="acc">';
	foreach (array_values($items) as $i => $it) {
		if (empty($it['q'])) {
			continue;
		}
		$open = $i === 0;
		$id = "acc{$n}-{$i}";
		printf(
			'<div class="acc__item%1$s"><h3><button type="button" id="%2$s-b" aria-expanded="%3$s" aria-controls="%2$s-p">%4$s%5$s</button></h3><div id="%2$s-p" role="region" aria-labelledby="%2$s-b" class="acc__panel"%6$s>%7$s</div></div>',
			$open ? ' is-open' : '',
			esc_attr($id),
			$open ? 'true' : 'false',
			esc_html($it['q']),
			tbn_icon('chevron'),
			$open ? '' : ' hidden',
			wpautop(esc_html($it['a'] ?? ''))
		);
	}
	echo '</div>';
}
