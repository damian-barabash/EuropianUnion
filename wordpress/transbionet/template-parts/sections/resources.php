<?php
$s = $args;
$types = array_filter(array_map('intval', (array) ($s['types'] ?? [])));
$video_term = get_term_by('slug', 'video', 'resource_type');
$q = ['post_type' => 'resource', 'numberposts' => -1, 'post_status' => 'publish', 'orderby' => 'date', 'order' => 'DESC'];
if ($types) {
	$q['tax_query'] = [['taxonomy' => 'resource_type', 'terms' => $types]];
} elseif ($video_term) {
	$q['tax_query'] = [['taxonomy' => 'resource_type', 'terms' => [$video_term->term_id], 'operator' => 'NOT IN']];
}
$items = get_posts($q);
// Filter chips only for the types that have files here.
$used = [];
foreach ($items as $r) {
	foreach (tbn_resource_types($r) as $t) {
		$used[$t->slug] = $t->name;
	}
}
?>
<section class="<?php echo esc_attr(tbn_bg_class($s)); ?>">
	<div class="container" data-filter-scope>
		<?php tbn_section_head((string) ($s['title'] ?? '')); ?>
		<?php if ($items) : ?>
			<?php if (!empty($s['filter']) && count($used) > 1) : ?>
				<div class="filter" role="group" aria-label="Filter by type">
					<button type="button" class="chip is-active" aria-pressed="true" data-filter="">All</button>
					<?php foreach ($used as $slug => $name) : ?><button type="button" class="chip" aria-pressed="false" data-filter="<?php echo esc_attr($slug); ?>"><?php echo esc_html($name); ?></button><?php endforeach; ?>
				</div>
			<?php endif; ?>
			<ul class="docs"><?php foreach ($items as $r) { tbn_resource_row($r); } ?></ul>
		<?php else : ?>
			<p class="notice"><?php echo esc_html($s['empty'] ?? 'Nothing here yet.'); ?></p>
		<?php endif; ?>
	</div>
</section>
