<?php
$s = $args;
$email = tbn_option('email');
$social = array_filter((array) tbn_option('social', []), fn ($x) => !empty($x['label']));
?>
<section class="section">
	<div class="container contact">
		<div>
			<?php if ($email) : ?>
				<?php if (!empty($s['title'])) : ?><h2><?php echo esc_html($s['title']); ?></h2><?php endif; ?>
				<ul class="contact__list"><li><?php echo tbn_icon('mail'); ?><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></li></ul>
			<?php endif; ?>
			<?php if ($social) : ?>
				<?php if (!empty($s['social_title'])) : ?><h2><?php echo esc_html($s['social_title']); ?></h2><?php endif; ?>
				<ul class="contact__social">
					<?php foreach ($social as $x) : ?>
						<li><?php echo !empty($x['url']) ? '<a href="' . esc_url($x['url']) . '" target="_blank" rel="noopener noreferrer">' . esc_html($x['label']) . '</a>' : '<span>' . esc_html($x['label']) . '</span>'; ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<div class="contact__form">
			<?php if (!empty($s['form_title'])) : ?><h2><?php echo esc_html($s['form_title']); ?></h2><?php endif; ?>
			<?php tbn_contact_form(); ?>
		</div>
	</div>
</section>
