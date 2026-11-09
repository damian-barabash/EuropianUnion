<?php
$s = $args;
$videos = [];
foreach ((array) ($s['items'] ?? []) as $v) {
	if (!empty($v['url'])) {
		$videos[] = ['title' => $v['title'] ?? '', 'url' => $v['url'], 'cover' => $v['cover'] ?? 0];
	}
}
if (!$videos) {
	foreach (get_posts(['post_type' => 'resource', 'numberposts' => -1, 'tax_query' => [['taxonomy' => 'resource_type', 'field' => 'slug', 'terms' => 'video']]]) as $r) {
		if ($url = tbn_field('resource_video', $r->ID)) {
			$videos[] = ['title' => get_the_title($r), 'url' => $url, 'cover' => tbn_field('resource_cover', $r->ID, 0)];
		}
	}
}
if (!$videos) {
	return;
}
?>
<section class="<?php echo esc_attr(tbn_bg_class($s)); ?>">
	<div class="container">
		<?php tbn_section_head((string) ($s['title'] ?? ''), (string) ($s['text'] ?? '')); ?>
		<?php if (count($videos) === 1) : ?>
			<div data-reveal><?php echo tbn_video($videos[0]['url'], $videos[0]['cover'], $videos[0]['title']); ?></div>
		<?php else : ?>
			<div class="grid grid--2">
				<?php foreach ($videos as $v) : ?>
					<figure class="videocard" data-reveal><?php echo tbn_video($v['url'], $v['cover'], $v['title']); ?><?php if ($v['title']) : ?><figcaption><?php echo esc_html($v['title']); ?></figcaption><?php endif; ?></figure>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
