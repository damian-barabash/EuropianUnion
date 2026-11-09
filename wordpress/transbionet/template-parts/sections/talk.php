<?php $s = $args; ?>
<section class="talk orbs orbs--c">
	<div class="container talk__in">
		<div class="talk__text" data-reveal>
			<?php if (!empty($s['title'])) : ?><h2><?php echo esc_html($s['title']); ?></h2><?php endif; ?>
			<?php if (!empty($s['text'])) : ?><p><?php echo esc_html($s['text']); ?></p><?php endif; ?>
		</div>
		<div class="talk__form" data-reveal><?php tbn_contact_form(); ?></div>
	</div>
</section>
