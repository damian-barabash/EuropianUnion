<?php $s = $args; if (empty($s['items'])) { return; } ?>
<section class="<?php echo esc_attr(tbn_bg_class($s)); ?>">
	<div class="container">
		<?php tbn_section_head((string) ($s['title'] ?? ''), (string) ($s['text'] ?? '')); ?>
		<ol class="steps">
			<?php foreach ($s['items'] as $it) : ?><li data-reveal><h3><?php echo esc_html($it['title']); ?></h3><p><?php echo esc_html($it['text']); ?></p></li><?php endforeach; ?>
		</ol>
	</div>
</section>
