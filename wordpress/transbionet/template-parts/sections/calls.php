<?php
$s = $args;
$calls = tbn_calls($s['show'] ?? 'current');
?>
<section class="<?php echo esc_attr(tbn_bg_class($s)); ?>">
	<div class="container">
		<?php tbn_section_head((string) ($s['title'] ?? ''), (string) ($s['text'] ?? ''), $s['button'] ?? null); ?>
		<?php if ($calls) : ?>
			<div class="callrows"><?php foreach ($calls as $c) { tbn_call_row($c); } ?></div>
		<?php else : ?>
			<p class="empty"><?php echo esc_html($s['empty'] ?? 'There are no calls in this group right now.'); ?></p>
		<?php endif; ?>
	</div>
</section>
