<?php $s = $args; $people = array_values(array_filter((array) ($s['items'] ?? []), fn ($p) => !empty($p['name']))); if (!$people) { return; } ?>
<section class="<?php echo esc_attr(tbn_bg_class($s)); ?>">
	<div class="container">
		<?php tbn_section_head((string) ($s['title'] ?? '')); ?>
		<div class="quote" data-reveal data-quotes>
			<?php if (count($people) > 1) : ?><button class="quote__nav" type="button" data-step="-1" aria-label="Previous person"><?php echo tbn_icon('arrow'); ?></button><?php endif; ?>
			<?php foreach ($people as $i => $p) : ?>
				<figure class="quote__box" aria-live="polite"<?php echo $i ? ' hidden' : ''; ?>>
					<div class="quote__who">
						<?php echo tbn_img($p['photo'] ?? 0, 'thumbnail', ['alt' => '', 'width' => 160, 'height' => 160]); ?>
						<figcaption><strong><?php echo esc_html($p['name']); ?></strong><?php echo esc_html(implode(', ', array_filter([$p['role'] ?? '', $p['org'] ?? '']))); ?></figcaption>
					</div>
					<blockquote><?php echo esc_html($p['quote'] ?? ''); ?></blockquote>
				</figure>
			<?php endforeach; ?>
			<?php if (count($people) > 1) : ?><button class="quote__nav quote__nav--next" type="button" data-step="1" aria-label="Next person"><?php echo tbn_icon('arrow'); ?></button><?php endif; ?>
		</div>
	</div>
</section>
