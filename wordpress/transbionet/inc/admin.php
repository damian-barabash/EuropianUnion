<?php
// Admin made simple for the project team.
defined('ABSPATH') || exit;

// Pages, partners and resources are forms (sections / fields), not the block editor.
add_filter('use_block_editor_for_post_type', fn ($use, $type) => in_array($type, ['page', 'partner', 'resource', 'enquiry'], true) ? false : $use, 10, 2);

// Without ACF the site still renders, but the team cannot edit sections: say so.
add_action('admin_notices', function () {
	if (!function_exists('acf_add_local_field_group') && current_user_can('activate_plugins')) {
		echo '<div class="notice notice-error"><p><strong>TransBioNet theme:</strong> activate the ACF PRO plugin (or Secure Custom Fields). Without it page sections and content fields cannot be edited.</p></div>';
	}
});

// No comments in the admin.
add_action('admin_menu', function () {
	remove_menu_page('edit-comments.php');
});
add_action('wp_before_admin_bar_render', function () {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
});

// Block editor: only blocks that the theme styles. Embeds (YouTube etc.), files and images stay.
add_filter('allowed_block_types_all', function ($allowed, $context) {
	if (!isset($context->post) || !in_array($context->post->post_type, ['post', 'event', 'open_call'], true)) {
		return $allowed;
	}
	return [
		'core/paragraph', 'core/heading', 'core/list', 'core/list-item', 'core/quote', 'core/image', 'core/gallery',
		'core/file', 'core/embed', 'core/video', 'core/table', 'core/separator', 'core/buttons', 'core/button', 'core/columns', 'core/column',
	];
}, 10, 2);

// Columns in the lists: what the team needs to see at a glance.
add_filter('manage_partner_posts_columns', function ($cols) {
	return ['cb' => $cols['cb'], 'tbn_logo' => 'Logo', 'title' => 'Name', 'tbn_country' => 'Country', 'tbn_role' => 'Role', 'date' => $cols['date']];
});
add_action('manage_partner_posts_custom_column', function ($col, $id) {
	if ($col === 'tbn_logo') {
		$logo = tbn_field('partner_logo', $id);
		echo $logo ? wp_get_attachment_image((int) $logo, 'thumbnail', false, ['style' => 'max-width:120px;height:auto;max-height:40px;object-fit:contain']) : '—';
	} elseif ($col === 'tbn_country') {
		echo esc_html(tbn_field('partner_country', $id, '—'));
	} elseif ($col === 'tbn_role') {
		echo esc_html(tbn_field('partner_role', $id, 'Partner'));
	}
}, 10, 2);

add_filter('manage_event_posts_columns', fn ($cols) => ['cb' => $cols['cb'], 'title' => 'Event', 'tbn_when' => 'Event date', 'tbn_place' => 'Place', 'date' => 'Published']);
add_action('manage_event_posts_custom_column', function ($col, $id) {
	if ($col === 'tbn_when') {
		$d = tbn_field('event_date', $id);
		echo esc_html(tbn_date($d)) . (tbn_is_past($d) ? ' <span style="color:#888">(past)</span>' : '');
	} elseif ($col === 'tbn_place') {
		echo esc_html(tbn_field('event_place', $id, '—'));
	}
}, 10, 2);

add_filter('manage_open_call_posts_columns', fn ($cols) => ['cb' => $cols['cb'], 'title' => 'Call', 'tbn_status' => 'Status', 'tbn_deadline' => 'Deadline', 'date' => 'Published']);
add_action('manage_open_call_posts_custom_column', function ($col, $id) {
	if ($col === 'tbn_status') {
		$labels = ['open' => 'Open', 'upcoming' => 'Opens soon', 'closed' => 'Closed'];
		echo esc_html($labels[tbn_call_status($id)] ?? '');
	} elseif ($col === 'tbn_deadline') {
		echo esc_html(tbn_date(tbn_field('call_deadline', $id)) ?: '—');
	}
}, 10, 2);

add_filter('manage_resource_posts_columns', fn ($cols) => ['cb' => $cols['cb'], 'title' => 'Title', 'taxonomy-resource_type' => 'Type', 'tbn_file' => 'File', 'date' => 'Date']);
add_action('manage_resource_posts_custom_column', function ($col, $id) {
	if ($col === 'tbn_file') {
		[$url, , $format, $size] = tbn_resource_info(get_post($id));
		echo $url ? '<a href="' . esc_url($url) . '" target="_blank">' . esc_html(trim($format . ($size ? ', ' . $size : '')) ?: 'Open') . '</a>' : '<span style="color:#b32d2e">No file</span>';
	}
}, 10, 2);

// Partners in the admin list in the same order as on the site.
add_action('pre_get_posts', function ($q) {
	if (is_admin() && $q->is_main_query() && $q->get('post_type') === 'partner' && !$q->get('orderby')) {
		$q->set('orderby', 'title');
		$q->set('order', 'ASC');
	}
});

// Dashboard: one box with shortcuts instead of WordPress news.
add_action('wp_dashboard_setup', function () {
	foreach (['dashboard_primary', 'dashboard_quick_press', 'dashboard_site_health', 'dashboard_activity'] as $box) {
		remove_meta_box($box, 'dashboard', in_array($box, ['dashboard_primary', 'dashboard_quick_press'], true) ? 'side' : 'normal');
	}
	wp_add_dashboard_widget('tbn_start', 'TransBioNet — quick actions', function () {
		$n = tbn_unread_count();
		$links = [
			['post-new.php', 'Add news'],
			['post-new.php?post_type=event', 'Add event'],
			['post-new.php?post_type=open_call', 'Add Open Call'],
			['post-new.php?post_type=partner', 'Add partner'],
			['post-new.php?post_type=resource', 'Add document or video'],
			['edit.php?post_type=page', 'Edit pages'],
			['admin.php?page=tbn-settings', 'Site settings'],
		];
		echo '<p><a class="button button-primary" href="' . esc_url(admin_url('edit.php?post_type=enquiry')) . '">Enquiries' . ($n ? " ({$n} new)" : '') . '</a></p><p>';
		foreach ($links as [$url, $label]) {
			echo '<a class="button" style="margin:0 6px 6px 0" href="' . esc_url(admin_url($url)) . '">' . esc_html($label) . '</a>';
		}
		echo '</p><p style="color:#646970">The guide for the team: Pages → "How to edit the site" (visible only to logged-in users).</p>';
	});
});

// Short hints at the top of the edit screens.
add_action('edit_form_after_title', function ($post) {
	$hints = [
		'page' => 'The page is built from <strong>Sections</strong> below: add, drag to reorder, or hide a section. The page title is the big heading at the top.',
		'partner' => 'Fill in the fields and press <strong>Publish</strong>. The partner appears on the Partners page, in the menu and among the logos on the home page.',
		'resource' => 'Pick the type on the right (Document, Deliverable, Promo material, Video), add the file or video link and press <strong>Publish</strong>.',
	];
	if (isset($hints[$post->post_type])) {
		echo '<p style="margin:12px 0 0;padding:10px 12px;background:#f0f6fc;border-left:4px solid #2D51AA">' . wp_kses_post($hints[$post->post_type]) . '</p>';
	}
});

add_filter('admin_footer_text', fn () => 'TransBioNet — website of the Horizon Europe project. Need help? Pages → "How to edit the site".');
