<?php
$s = $args;
$events = tbn_events($s['show'] ?? 'upcoming', (int) ($s['limit'] ?? 0) ?: -1);
// Without events and without an "empty" text the whole section disappears.
if (!$events && empty($s['empty'])) {
	return;
}
$dark = !empty($s['dark']);
?>
<?php if ($dark) : ?>
	<section class="section section--dark">
		<div class="container darkgrid">
			<div class="darkgrid__head" data-reveal>
				<?php if (!empty($s['title'])) : ?><h2><?php echo esc_html($s['title']); ?></h2><?php endif; ?>
				<?php if (!empty($s['text'])) : ?><p><?php echo esc_html($s['text']); ?></p><?php endif; ?>
				<?php echo tbn_button($s['button'] ?? null, 'btn btn--outline-light'); ?>
			</div>
			<?php if ($events) : ?>
				<div class="events"><?php foreach ($events as $e) { tbn_event_row($e); } ?></div>
			<?php else : ?>
				<p class="empty"><?php echo esc_html($s['empty']); ?></p>
			<?php endif; ?>
		</div>
	</section>
<?php else : ?>
	<section class="section">
		<div class="container">
			<?php tbn_section_head((string) ($s['title'] ?? ''), (string) ($s['text'] ?? ''), $s['button'] ?? null); ?>
			<?php if ($events) : ?>
				<div class="events"><?php foreach ($events as $e) { tbn_event_row($e); } ?></div>
			<?php else : ?>
				<p class="empty"><?php echo esc_html($s['empty']); ?></p>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
