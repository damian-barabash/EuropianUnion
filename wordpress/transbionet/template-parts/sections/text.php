<?php $s = $args; if (empty($s['content']) && empty($s['title'])) { return; } ?>
<section class="<?php echo esc_attr(tbn_bg_class($s)); ?>">
	<div class="container article">
		<div class="prose">
			<?php if (!empty($s['title'])) : ?><h2><?php echo esc_html($s['title']); ?></h2><?php endif; ?>
			<?php echo $s['content']; // formatted by ACF (the_content filters: paragraphs, embeds, shortcodes) ?>
		</div>
	</div>
</section>
