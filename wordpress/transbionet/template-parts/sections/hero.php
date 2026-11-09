<?php $s = $args; ?>
<section class="hero orbs orbs--a">
	<div class="hero__text">
		<<?php echo $s['index'] === 0 ? 'h1' : 'h2'; ?> class="hero__title"><?php echo esc_html($s['title']); ?></<?php echo $s['index'] === 0 ? 'h1' : 'h2'; ?>>
		<?php if (!empty($s['text'])) : ?><p><?php echo esc_html($s['text']); ?></p><?php endif; ?>
		<?php if (!empty($s['button']['url'])) : ?><div class="hero__actions"><?php echo tbn_button($s['button']); ?></div><?php endif; ?>
	</div>
	<?php if (!empty($s['image'])) : ?>
		<div class="hero__media"><?php echo tbn_img($s['image'], 'tbn-hero', ['loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '(max-width: 760px) 100vw, 50vw']); ?></div>
	<?php endif; ?>
</section>
