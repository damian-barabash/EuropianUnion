<?php $s = $args; ?>
<section class="cta">
	<div class="container cta__in" data-reveal>
		<div>
			<?php if (!empty($s['title'])) : ?><h2><?php echo esc_html($s['title']); ?></h2><?php endif; ?>
			<?php if (!empty($s['text'])) : ?><p><?php echo esc_html($s['text']); ?></p><?php endif; ?>
		</div>
		<div class="cta__actions">
			<?php echo tbn_button($s['button'] ?? null, 'btn btn--light'); ?>
			<?php echo tbn_button($s['button2'] ?? null, 'btn btn--outline-light'); ?>
		</div>
	</div>
</section>
