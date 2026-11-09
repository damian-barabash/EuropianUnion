<?php $s = $args; if (empty($s['items'])) { return; } ?>
<section class="<?php echo esc_attr(tbn_bg_class($s)); ?>">
	<div class="container">
		<?php tbn_section_head((string) ($s['title'] ?? '')); ?>
		<ul class="columns">
			<?php foreach ($s['items'] as $c) : ?>
				<li data-reveal><h3><?php echo esc_html($c['title']); ?></h3><p><?php echo esc_html($c['text']); ?></p></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
