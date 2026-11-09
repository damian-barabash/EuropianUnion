<?php $s = $args; if (empty($s['items'])) { return; } ?>
<section class="<?php echo esc_attr(tbn_bg_class($s)); ?>">
	<div class="container article">
		<?php tbn_section_head((string) ($s['title'] ?? '')); ?>
		<?php tbn_accordion($s['items']); ?>
	</div>
</section>
