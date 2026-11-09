<?php
/**
 * Cookie banner. Google Tag Manager (and GA4 inside it) is loaded only after "Accept all".
 * The choice is kept in localStorage ("cookie-consent": all | necessary); "Cookie settings" in the footer reopens it.
 */
defined('ABSPATH') || exit;

add_action('wp_footer', function () {
	$gtm = preg_replace('/[^A-Z0-9-]/', '', strtoupper((string) tbn_option('gtm_id')));
	$policy = get_page_by_path('cookie-policy');
	?>
	<div class="cookie" id="cookie" role="dialog" aria-labelledby="cookie-title" aria-describedby="cookie-text" hidden data-gtm="<?php echo esc_attr($gtm); ?>">
		<h2 id="cookie-title"><?php echo esc_html(tbn_option('cookie_title', 'We use cookies')); ?></h2>
		<p id="cookie-text">
			<?php echo esc_html(tbn_option('cookie_text', 'Necessary cookies keep the site working. With your consent we also use analytics cookies to improve it.')); ?>
			<?php if ($policy && $policy->post_status === 'publish') : ?>
				Read the <a href="<?php echo esc_url(get_permalink($policy)); ?>">cookie policy</a>.
			<?php endif; ?>
		</p>
		<div class="cookie__actions">
			<button class="btn btn--primary btn--sm" type="button" data-consent="all">Accept all</button>
			<button class="btn btn--outline btn--sm" type="button" data-consent="necessary">Only necessary</button>
		</div>
	</div>
	<?php
}, 5);
