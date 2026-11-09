<?php
$s = $args;
$partners = tbn_partners();
if (!$partners) {
	return;
}
$text = strtr((string) ($s['text'] ?? ''), ['{partners}' => count($partners), '{countries}' => tbn_partner_countries($partners)]);
$all = get_page_by_path('partners');
?>
<section class="<?php echo esc_attr(tbn_bg_class($s, 'orbs')); ?>">
	<div class="container">
		<?php tbn_section_head((string) ($s['title'] ?? ''), $text); ?>
		<ul class="logos" data-reveal>
			<?php foreach ($partners as $p) : ?>
				<li><a href="<?php echo esc_url(get_permalink($p)); ?>" aria-label="<?php echo esc_attr(get_the_title($p)); ?>" title="<?php echo esc_attr(get_the_title($p)); ?>"><?php echo tbn_partner_logo($p); ?></a></li>
			<?php endforeach; ?>
			<?php if ($all && !empty($s['all_label'])) : ?>
				<li class="logos__all"><a href="<?php echo esc_url(get_permalink($all)); ?>"><span><?php echo esc_html($s['all_label']); ?></span><?php echo tbn_icon('arrow'); ?></a></li>
			<?php endif; ?>
		</ul>
	</div>
</section>
