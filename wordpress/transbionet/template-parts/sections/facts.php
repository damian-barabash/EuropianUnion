<?php $s = $args; if (empty($s['items'])) { return; } ?>
<section class="factsband">
	<div class="container">
		<dl class="facts">
			<?php foreach ($s['items'] as $f) : ?>
				<div><dt><?php echo esc_html($f['label']); ?></dt><dd><?php echo esc_html($f['value']); ?></dd></div>
			<?php endforeach; ?>
		</dl>
	</div>
</section>
