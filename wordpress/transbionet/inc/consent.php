<?php
/**
 * Cookie banner + Google Tag Manager with Consent Mode v2.
 * GTM is on every page from the start (Google can detect the tag), but all storage is "denied" by default:
 * Google tags set no cookies until the visitor clicks "Accept all". The choice is kept in localStorage
 * ("cookie-consent": all | necessary); "Cookie settings" in the footer reopens the banner.
 */
defined('ABSPATH') || exit;

function tbn_gtm_id(): string {
	return preg_replace('/[^A-Z0-9-]/', '', strtoupper((string) tbn_option('gtm_id')));
}

// First thing in <head>: consent defaults, then the GTM loader.
add_action('wp_head', function () {
	$id = tbn_gtm_id();
	if (!$id) {
		return;
	}
	?>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
(function () {
	var ok = false;
	try { ok = localStorage.getItem('cookie-consent') === 'all'; } catch (e) {}
	gtag('consent', 'default', {
		analytics_storage: ok ? 'granted' : 'denied',
		ad_storage: 'denied', ad_user_data: 'denied', ad_personalization: 'denied',
		functionality_storage: 'granted', security_storage: 'granted',
		wait_for_update: 500
	});
	gtag('set', 'ads_data_redaction', true);
})();
gtag('js', new Date());
</script>
<script>dataLayer.push({'gtm.start': new Date().getTime(), event: 'gtm.js'});</script>
<script async src="https://www.googletagmanager.com/gtm.js?id=<?php echo esc_attr($id); ?>"></script>
	<?php
}, 1);

add_action('wp_footer', function () {
	$policy = get_page_by_path('cookie-policy');
	?>
	<div class="cookie" id="cookie" role="dialog" aria-labelledby="cookie-title" aria-describedby="cookie-text" hidden>
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
