<?php
$s = $args;
$posts = get_posts(['numberposts' => max(1, (int) ($s['count'] ?? 3))]);
if (!$posts) {
	return;
}
?>
<section class="<?php echo esc_attr(tbn_bg_class($s, 'orbs')); ?>">
	<div class="container">
		<?php tbn_section_head((string) ($s['title'] ?? '')); ?>
		<div class="grid grid--3"><?php foreach ($posts as $p) { tbn_post_card($p); } ?></div>
		<?php if (!empty($s['button']['url'])) : ?><div class="more"><?php echo tbn_button($s['button']); ?></div><?php endif; ?>
	</div>
</section>
