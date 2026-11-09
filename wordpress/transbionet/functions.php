<?php
/**
 * TransBioNet theme.
 *
 * inc/setup.php       theme supports, assets, menus, clean-up
 * inc/helpers.php     small render helpers (icons, dates, logos, queries)
 * inc/cards.php       cards and rows: news, events, calls, partners, resources, video
 * inc/post-types.php  events, open calls, partners, resources
 * inc/fields.php      custom fields (ACF PRO / Secure Custom Fields)
 * inc/menus.php       menu rendering, partners drop-down
 * inc/enquiries.php   contact form and the "Enquiries" inbox in the admin
 * inc/consent.php     cookie banner and Google Tag Manager after consent
 * inc/admin.php       admin clean-up for the project team
 */

defined('ABSPATH') || exit;

define('TBN_VERSION', '1.0.0');
define('TBN_DIR', get_template_directory());
define('TBN_URI', get_template_directory_uri());

foreach (['setup', 'helpers', 'cards', 'post-types', 'fields', 'menus', 'enquiries', 'consent', 'admin'] as $tbn_file) {
	require TBN_DIR . "/inc/{$tbn_file}.php";
}
