<?php
get_header();
while (have_posts()) :
	the_post();
	$tbn_p = get_post();
	tbn_page_hero(get_the_title(), '', array_values(array_filter([tbn_listing_crumb('partner'), ['label' => get_the_title()]])));
	$tbn_desc = tbn_field('partner_description');
	$tbn_role_text = tbn_field('partner_role_text');
	?>
	<section class="section">
		<div class="container detail">
			<div class="detail__main prose">
				<?php if ($tbn_desc) : ?><h2>About the organisation</h2><?php echo wp_kses_post($tbn_desc); ?><?php endif; ?>
				<?php if ($tbn_role_text) : ?><h2>Role in the project</h2><p><?php echo esc_html($tbn_role_text); ?></p><?php endif; ?>
			</div>
			<aside class="detail__side">
				<div class="sidecard">
					<?php echo tbn_partner_logo($tbn_p, true); ?>
					<dl>
						<?php foreach (['partner_legal' => 'Legal name', 'partner_country' => 'Country', 'partner_type' => 'Type', 'partner_role' => 'Role'] as $tbn_k => $tbn_l) : ?>
							<?php if ($tbn_v = tbn_field($tbn_k)) : ?><div><dt><?php echo esc_html($tbn_l); ?></dt><dd><?php echo esc_html($tbn_v); ?></dd></div><?php endif; ?>
						<?php endforeach; ?>
					</dl>
					<?php if ($tbn_v = tbn_field('partner_website')) : ?><a class="btn btn--outline btn--block" href="<?php echo esc_url($tbn_v); ?>" target="_blank" rel="noopener noreferrer">Visit website <?php echo tbn_icon('external', 18); ?></a><?php endif; ?>
					<?php if ($tbn_v = tbn_field('partner_linkedin')) : ?><a class="btn btn--outline btn--block" href="<?php echo esc_url($tbn_v); ?>" target="_blank" rel="noopener noreferrer">LinkedIn <?php echo tbn_icon('external', 18); ?></a><?php endif; ?>
				</div>
				<?php if ($tbn_back = tbn_listing_crumb('partner')) : ?><a class="btn btn--outline btn--sm" href="<?php echo esc_url($tbn_back['url']); ?>">All partners</a><?php endif; ?>
			</aside>
		</div>
	</section>
	<?php
endwhile;
get_footer();
