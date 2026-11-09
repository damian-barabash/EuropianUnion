<?php $s = $args; if (empty($s['items'])) { return; } ?>
<section class="<?php echo esc_attr(tbn_bg_class($s)); ?>">
	<div class="container">
		<?php tbn_section_head((string) ($s['title'] ?? '')); ?>
		<ol class="timeline">
			<?php foreach ($s['items'] as $it) : ?>
				<li data-reveal<?php echo !empty($it['planned']) ? ' class="is-planned"' : ''; ?>>
					<?php if (!empty($it['period'])) : ?><span class="timeline__period"><?php echo esc_html($it['period']); ?></span><?php endif; ?>
					<h3><?php echo esc_html($it['title']); ?></h3>
					<?php if (!empty($it['text'])) : ?><p><?php echo esc_html($it['text']); ?></p><?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
