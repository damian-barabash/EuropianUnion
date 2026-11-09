<?php $s = $args; ?>
<section class="bleed<?php echo !empty($s['image_right']) ? ' bleed--flip' : ''; ?>">
	<div class="bleed__media"><?php echo tbn_img($s['image'] ?? 0, 'tbn-hero', ['sizes' => '(max-width: 900px) 100vw, 50vw']); ?></div>
	<div class="bleed__panel bleed__panel--tint">
		<div data-reveal>
			<?php if (!empty($s['title'])) : ?><h2><?php echo esc_html($s['title']); ?></h2><?php endif; ?>
			<?php if (!empty($s['text'])) : ?><div class="bleed__text"><?php echo wp_kses_post($s['text']); ?></div><?php endif; ?>
			<?php echo tbn_button($s['button'] ?? null, 'btn btn--outline'); ?>
		</div>
	</div>
</section>
