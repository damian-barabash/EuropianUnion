<?php
get_header();
while (have_posts()) :
	the_post();
	$tbn_id = get_the_ID();
	$tbn_start = tbn_field('event_date');
	$tbn_end = tbn_field('event_end');
	$tbn_when = $tbn_end && $tbn_end !== $tbn_start ? tbn_date($tbn_start) . ' – ' . tbn_date($tbn_end) : tbn_date($tbn_start);
	$tbn_past = tbn_is_past($tbn_end ?: $tbn_start);
	tbn_page_hero(get_the_title(), has_excerpt() ? get_the_excerpt() : '', array_values(array_filter([tbn_listing_crumb('event'), ['label' => get_the_title()]])));
	?>
	<section class="section">
		<div class="container detail">
			<div class="detail__main">
				<?php if (has_post_thumbnail()) { the_post_thumbnail('tbn-wide', ['class' => 'detail__img', 'alt' => '']); } ?>
				<div class="prose"><?php the_content(); ?></div>
			</div>
			<aside class="detail__side">
				<div class="sidecard">
					<h2>Details</h2>
					<ul class="sidecard__list">
						<?php if ($tbn_when) : ?><li><?php echo tbn_icon('calendar') . ' ' . esc_html($tbn_when); ?></li><?php endif; ?>
						<?php if ($tbn_v = tbn_field('event_time')) : ?><li><?php echo tbn_icon('clock') . ' ' . esc_html($tbn_v); ?></li><?php endif; ?>
						<?php if ($tbn_v = tbn_field('event_place')) : ?><li><?php echo tbn_icon('pin') . ' ' . esc_html($tbn_v); ?></li><?php endif; ?>
						<?php if ($tbn_v = tbn_field('event_format')) : ?><li><?php echo tbn_icon('users') . ' ' . esc_html($tbn_v); ?></li><?php endif; ?>
					</ul>
					<?php if ($tbn_past) : ?>
						<p class="note">This event has already taken place.</p>
					<?php elseif ($tbn_reg = tbn_field('event_register')) : ?>
						<a class="btn btn--primary btn--block" href="<?php echo esc_url($tbn_reg); ?>" target="_blank" rel="noopener noreferrer">Register for the event <?php echo tbn_icon('external', 18); ?></a>
					<?php endif; ?>
				</div>
				<?php if ($tbn_back = tbn_listing_crumb('event')) : ?><a class="btn btn--outline btn--sm" href="<?php echo esc_url($tbn_back['url']); ?>">All events</a><?php endif; ?>
			</aside>
		</div>
	</section>
	<?php
endwhile;
get_footer();
