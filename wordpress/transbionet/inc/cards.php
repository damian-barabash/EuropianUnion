<?php
// Cards and rows that repeat across pages. Same markup as the React prototype, so the CSS is shared.
defined('ABSPATH') || exit;

function tbn_post_card(WP_Post $p): void {
	$cat = get_the_category($p->ID);
	?>
	<article class="post" data-reveal>
		<div class="post__media">
			<?php echo has_post_thumbnail($p) ? get_the_post_thumbnail($p, 'tbn-card', ['alt' => '', 'loading' => 'lazy']) : '<span class="post__noimg"></span>'; ?>
			<?php if ($cat) : ?><span class="post__cat"><?php echo esc_html($cat[0]->name); ?></span><?php endif; ?>
		</div>
		<div class="post__body">
			<time class="post__date" datetime="<?php echo esc_attr(get_the_date('Y-m-d', $p)); ?>"><?php echo esc_html(get_the_date('j F Y', $p)); ?></time>
			<h3><a href="<?php echo esc_url(get_permalink($p)); ?>"><?php echo esc_html(get_the_title($p)); ?></a></h3>
			<p class="post__excerpt"><?php echo esc_html(get_the_excerpt($p)); ?></p>
		</div>
		<div class="post__foot" aria-hidden="true">
			<span>Read more</span>
			<span class="post__arrow"><?php echo tbn_icon('arrow', 18); ?></span>
		</div>
	</article>
	<?php
}

function tbn_event_row(WP_Post $e): void {
	$d = tbn_dt(tbn_field('event_date', $e->ID));
	$meta = array_filter([tbn_field('event_time', $e->ID), tbn_field('event_place', $e->ID)]);
	?>
	<article class="event" data-reveal>
		<time class="event__date" datetime="<?php echo esc_attr($d ? $d->format('Y-m-d') : ''); ?>">
			<span class="event__day"><?php echo $d ? esc_html(wp_date('d', $d->getTimestamp())) : ''; ?></span>
			<span class="event__month"><?php echo $d ? esc_html(wp_date('M Y', $d->getTimestamp())) : ''; ?></span>
		</time>
		<div class="event__body">
			<?php if ($f = tbn_field('event_format', $e->ID)) : ?><span class="event__format"><?php echo esc_html($f); ?></span><?php endif; ?>
			<h3><a href="<?php echo esc_url(get_permalink($e)); ?>"><?php echo esc_html(get_the_title($e)); ?></a></h3>
			<?php if ($meta) : ?>
				<ul class="facts-inline"><?php foreach ($meta as $m) : ?><li><?php echo esc_html($m); ?></li><?php endforeach; ?></ul>
			<?php endif; ?>
		</div>
		<span class="event__arrow" aria-hidden="true"><?php echo tbn_icon('arrow'); ?></span>
	</article>
	<?php
}

function tbn_call_row(WP_Post $c): void {
	$status = tbn_call_status($c->ID);
	$is_open = $status === 'open';
	$opens = tbn_dt(tbn_field('call_opens', $c->ID));
	$deadline = tbn_dt(tbn_field('call_deadline', $c->ID));
	$days_left = $deadline ? max(0, (int) ceil(($deadline->setTime(23, 59, 59)->getTimestamp() - time()) / DAY_IN_SECONDS)) : 0;
	$progress = 4;
	if ($opens && $deadline) {
		$span = max(1, $deadline->setTime(23, 59, 59)->getTimestamp() - $opens->setTime(0, 0)->getTimestamp());
		$progress = min(100, max(4, (time() - $opens->setTime(0, 0)->getTimestamp()) / $span * 100));
	}
	$date_label = $status === 'upcoming' ? 'Opens' : 'Deadline';
	$date_value = tbn_date(tbn_field($status === 'upcoming' ? 'call_opens' : 'call_deadline', $c->ID));
	?>
	<article class="callp callp--<?php echo esc_attr($status); ?>" data-reveal>
		<div class="callp__top">
			<?php echo tbn_status_badge($status); ?>
			<?php if ($is_open && $deadline) : ?><p class="callp__left"><strong><?php echo (int) $days_left; ?></strong> <?php echo $days_left === 1 ? 'day' : 'days'; ?> left to apply</p><?php endif; ?>
		</div>
		<div class="callp__main">
			<h3><a href="<?php echo esc_url(get_permalink($c)); ?>"><?php echo esc_html(get_the_title($c)); ?></a></h3>
			<?php if (has_excerpt($c)) : ?><p><?php echo esc_html(get_the_excerpt($c)); ?></p><?php endif; ?>
		</div>
		<dl class="callp__facts">
			<?php if ($date_value) : ?><div><dt><?php echo esc_html($date_label); ?></dt><dd><?php echo esc_html($date_value); ?></dd></div><?php endif; ?>
			<?php if ($g = tbn_field('call_grant', $c->ID)) : ?><div><dt>Funding</dt><dd><?php echo esc_html($g); ?></dd></div><?php endif; ?>
			<?php if ($is_open && ($b = tbn_field('call_budget', $c->ID))) : ?><div><dt>Total budget</dt><dd><?php echo esc_html($b); ?></dd></div><?php endif; ?>
		</dl>
		<?php if ($is_open && $opens && $deadline) : ?>
			<div class="callp__bar" role="img" aria-label="<?php echo esc_attr('Application window: ' . tbn_date(tbn_field('call_opens', $c->ID)) . ' to ' . $date_value); ?>"><span style="width: <?php echo esc_attr(round($progress, 1)); ?>%"></span></div>
		<?php endif; ?>
		<div class="callp__foot" aria-hidden="true">
			<span>Call details</span>
			<span class="callp__arrow"><?php echo tbn_icon('arrow'); ?></span>
		</div>
	</article>
	<?php
}

function tbn_partner_logo(WP_Post $p, bool $large = false): string {
	$logo = tbn_field('partner_logo', $p->ID);
	$scale = (float) tbn_field('partner_logo_scale', $p->ID, 1) ?: 1;
	$inner = $logo
		? wp_get_attachment_image((int) $logo, 'medium', false, ['alt' => get_the_title($p) . ' logo', 'loading' => 'lazy'])
		: '<span class="plogo__name">' . esc_html(get_the_title($p)) . '</span>';
	return sprintf('<span class="plogo%s" style="--s: %s">%s</span>', $large ? ' plogo--lg' : '', esc_attr($scale), $inner);
}

function tbn_partner_card(WP_Post $p): void {
	$meta = array_filter([tbn_field('partner_country', $p->ID), tbn_field('partner_type', $p->ID)]);
	$role = tbn_field('partner_role', $p->ID, 'Partner');
	?>
	<article class="partner" data-reveal>
		<div class="partner__logo"><?php echo tbn_partner_logo($p, true); ?></div>
		<div class="partner__body">
			<h3><a href="<?php echo esc_url(get_permalink($p)); ?>"><?php echo esc_html(get_the_title($p)); ?></a></h3>
			<?php if ($meta) : ?><p class="partner__meta"><?php echo esc_html(implode(' · ', $meta)); ?></p><?php endif; ?>
			<?php if ($role !== 'Partner') : ?><span class="partner__role"><?php echo esc_html($role); ?></span><?php endif; ?>
		</div>
	</article>
	<?php
}

// Resource: uploaded file, external link or video. Returns [url, is_video, format, size].
function tbn_resource_info(WP_Post $r): array {
	$kind = tbn_field('resource_kind', $r->ID, 'file');
	if ($kind === 'video') {
		return [tbn_field('resource_video', $r->ID) ?: tbn_field('resource_video_url', $r->ID), true, 'Video', ''];
	}
	if ($kind === 'link') {
		return [tbn_field('resource_url', $r->ID), false, 'Link', ''];
	}
	$file = tbn_field('resource_file', $r->ID);
	$id = is_array($file) ? ($file['ID'] ?? 0) : (int) $file;
	if (!$id) {
		return ['', false, '', ''];
	}
	$path = get_attached_file($id);
	$ext = strtoupper(pathinfo((string) $path, PATHINFO_EXTENSION));
	$size = $path && file_exists($path) ? size_format(filesize($path), 1) : '';
	return [wp_get_attachment_url($id), false, $ext, $size];
}

function tbn_resource_types(WP_Post $r): array {
	$terms = get_the_terms($r->ID, 'resource_type');
	return $terms && !is_wp_error($terms) ? $terms : [];
}

function tbn_resource_row(WP_Post $r): void {
	[$url, $is_video, $format, $size] = tbn_resource_info($r);
	if (!$url) {
		return;
	}
	$types = tbn_resource_types($r);
	$slugs = implode(' ', wp_list_pluck($types, 'slug'));
	$is_link = tbn_field('resource_kind', $r->ID) === 'link';
	$target = $is_video || $is_link ? ' target="_blank" rel="noopener noreferrer"' : '';
	$action = $is_video ? 'Watch' : ($is_link ? 'Open' : 'Download');
	$icon = $is_video ? 'play' : ($is_link ? 'external' : 'download');
	?>
	<li class="doc" data-types="<?php echo esc_attr($slugs); ?>">
		<div class="doc__body">
			<a href="<?php echo esc_url($url); ?>"<?php echo $target; ?>><?php echo esc_html(get_the_title($r)); ?></a>
			<p class="doc__meta">
				<?php if ($types) : ?><span><?php echo esc_html($types[0]->name); ?></span><?php endif; ?>
				<time datetime="<?php echo esc_attr(get_the_date('Y-m-d', $r)); ?>"><?php echo esc_html(get_the_date('j F Y', $r)); ?></time>
				<?php if ($size) : ?><span><?php echo esc_html($format . ', ' . $size); ?></span><?php endif; ?>
			</p>
		</div>
		<a class="btn btn--outline btn--sm doc__action" href="<?php echo esc_url($url); ?>"<?php echo $target; ?> aria-label="<?php echo esc_attr($action . ': ' . get_the_title($r)); ?>"><?php echo tbn_icon($icon, 18) . esc_html($action); ?></a>
	</li>
	<?php
}

// Video that loads the player only after a click (no YouTube cookies before that).
function tbn_video(string $url, $cover_id = 0, string $title = ''): string {
	if (!$url) {
		return '';
	}
	$embed = tbn_video_embed_url($url);
	$cover = $cover_id ? wp_get_attachment_image((int) $cover_id, 'tbn-wide', false, ['alt' => '', 'loading' => 'lazy']) : '';
	if (!$cover && preg_match('~(?:youtu\.be/|v=|embed/|shorts/)([\w-]{11})~', $url, $m)) {
		$cover = '<img src="https://i.ytimg.com/vi/' . esc_attr($m[1]) . '/hqdefault.jpg" alt="" loading="lazy">';
	}
	if (!$embed) {
		return sprintf('<a class="video" href="%s" target="_blank" rel="noopener noreferrer">%s<span class="video__play">%s</span></a>', esc_url($url), $cover, tbn_icon('play', 30));
	}
	return sprintf(
		'<div class="video" data-embed="%s">%s<button class="video__play" type="button" aria-label="%s">%s</button></div>',
		esc_url($embed),
		$cover,
		esc_attr('Play video' . ($title ? ': ' . $title : '')),
		tbn_icon('play', 30)
	);
}

function tbn_video_embed_url(string $url): string {
	if (preg_match('~(?:youtu\.be/|v=|embed/|shorts/)([\w-]{11})~', $url, $m)) {
		return 'https://www.youtube-nocookie.com/embed/' . $m[1] . '?autoplay=1&rel=0';
	}
	if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
		return 'https://player.vimeo.com/video/' . $m[1] . '?autoplay=1&dnt=1';
	}
	return '';
}
