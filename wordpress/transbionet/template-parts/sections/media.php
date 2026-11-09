<?php $s = $args; ?>
<section class="<?php echo esc_attr(tbn_bg_class($s)); ?>">
	<div class="container media<?php echo !empty($s['image_right']) ? ' media--flip' : ''; ?>">
		<?php $img = tbn_img($s['image'] ?? 0, 'large', ['class' => 'media__img', 'data-reveal' => '', 'sizes' => '(max-width: 900px) 100vw, 50vw']); ?>
		<?php if (empty($s['image_right'])) { echo $img; } ?>
		<div data-reveal>
			<?php if (!empty($s['title'])) : ?><h2><?php echo esc_html($s['title']); ?></h2><?php endif; ?>
			<?php echo wp_kses_post($s['text'] ?? ''); ?>
			<?php echo tbn_button($s['button'] ?? null, 'btn btn--outline'); ?>
		</div>
		<?php if (!empty($s['image_right'])) { echo $img; } ?>
	</div>
</section>
