<?php
get_header();
while (have_posts()) :
	the_post();
	$tbn_id = get_the_ID();
	$tbn_status = tbn_call_status($tbn_id);
	$tbn_apply = tbn_field('call_apply');
	$tbn_can_apply = $tbn_status === 'open' && $tbn_apply;
	$tbn_extra = '<div class="pagehero__row">' . tbn_status_badge($tbn_status)
		. ($tbn_can_apply ? '<a class="btn btn--primary" href="' . esc_url($tbn_apply) . '" target="_blank" rel="noopener noreferrer">Apply in the application system ' . tbn_icon('external', 18) . '</a>' : '') . '</div>';
	tbn_page_hero(get_the_title(), has_excerpt() ? get_the_excerpt() : '', array_values(array_filter([tbn_listing_crumb('open_call'), ['label' => get_the_title()]])), $tbn_extra);
	$tbn_steps = tbn_field('call_steps_hide') ? [] : (array) tbn_option('call_steps', []);
	$tbn_docs = (array) tbn_field('call_documents', false, []);
	$tbn_faq = (array) tbn_field('call_faq', false, []);
	$tbn_deadline = tbn_date(tbn_field('call_deadline'));
	?>
	<section class="section">
		<div class="container detail">
			<div class="detail__main">
				<?php if (has_post_thumbnail()) { the_post_thumbnail('tbn-wide', ['class' => 'detail__img', 'alt' => '']); } ?>
				<div class="prose"><?php the_content(); ?></div>

				<?php if ($tbn_steps) : ?>
					<h2 class="detail__h">How to apply</h2>
					<ol class="steps steps--stack">
						<?php foreach ($tbn_steps as $tbn_s) : ?><li><h3><?php echo esc_html($tbn_s['title']); ?></h3><p><?php echo esc_html($tbn_s['text']); ?></p></li><?php endforeach; ?>
					</ol>
				<?php endif; ?>

				<?php if ($tbn_docs) : ?>
					<h2 class="detail__h">Documents</h2>
					<ul class="docs"><?php foreach ($tbn_docs as $tbn_d) { if ($tbn_d instanceof WP_Post) { tbn_resource_row($tbn_d); } } ?></ul>
				<?php endif; ?>

				<?php if ($tbn_faq) : ?>
					<h2 class="detail__h">Questions and answers</h2>
					<?php tbn_accordion($tbn_faq); ?>
				<?php endif; ?>
			</div>

			<aside class="detail__side" aria-label="Key facts">
				<div class="sidecard">
					<h2>Key facts</h2>
					<dl>
						<div><dt>Status</dt><dd><?php echo tbn_status_badge($tbn_status); ?></dd></div>
						<?php if ($tbn_v = tbn_date(tbn_field('call_opens'))) : ?><div><dt>Opens</dt><dd><?php echo esc_html($tbn_v); ?></dd></div><?php endif; ?>
						<?php if ($tbn_deadline) : ?><div><dt>Deadline</dt><dd><?php echo esc_html($tbn_deadline . (($tbn_t = tbn_field('call_deadline_time')) ? ', ' . $tbn_t : '')); ?></dd></div><?php endif; ?>
						<?php if ($tbn_v = tbn_field('call_budget')) : ?><div><dt>Total budget</dt><dd><?php echo esc_html($tbn_v); ?></dd></div><?php endif; ?>
						<?php if ($tbn_v = tbn_field('call_grant')) : ?><div><dt>Funding</dt><dd><?php echo esc_html($tbn_v); ?></dd></div><?php endif; ?>
					</dl>
					<?php if ($tbn_can_apply) : ?>
						<a class="btn btn--primary btn--block" href="<?php echo esc_url($tbn_apply); ?>" target="_blank" rel="noopener noreferrer">Apply now <?php echo tbn_icon('external', 18); ?></a>
						<p class="note">Applications are submitted in an external application system.</p>
					<?php else : ?>
						<p class="note"><?php echo $tbn_status === 'upcoming' ? 'Applications open on the date above.' : ($tbn_status === 'closed' ? 'This call no longer accepts applications.' : 'The application link will be published here.'); ?></p>
					<?php endif; ?>
				</div>
				<div class="sidecard sidecard--plain">
					<h2>Need help?</h2>
					<p>Ask the Open Calls team before you apply.</p>
					<?php if ($tbn_contact = get_page_by_path('contact')) : ?><a class="btn btn--outline btn--sm" href="<?php echo esc_url(get_permalink($tbn_contact)); ?>">Contact us</a><?php endif; ?>
				</div>
			</aside>
		</div>
	</section>
	<?php
endwhile;
get_footer();
