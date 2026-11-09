<?php
/**
 * Contact form → "Enquiries" in the admin. Nothing is e-mailed: the team reads messages in WordPress.
 * Spam protection without cookies or third parties: hidden honeypot field, minimum fill time, limit per IP.
 */
defined('ABSPATH') || exit;

const TBN_ENQ_FIELDS = [
	'first_name' => 'First name',
	'last_name'  => 'Last name',
	'email'      => 'E-mail',
	'org_type'   => 'Type of organisation',
	'topic'      => 'Topic',
	'newsletter' => 'Wants news and updates',
];

add_action('init', function () {
	register_post_type('enquiry', [
		'labels' => [
			'name' => 'Enquiries', 'singular_name' => 'Enquiry', 'menu_name' => 'Enquiries', 'all_items' => 'All enquiries',
			'edit_item' => 'Enquiry', 'search_items' => 'Search enquiries', 'not_found' => 'No enquiries yet', 'not_found_in_trash' => 'No enquiries in the bin',
		],
		'public' => false, 'show_ui' => true, 'show_in_rest' => false, 'menu_position' => 4, 'menu_icon' => 'dashicons-email-alt',
		'supports' => false, 'rewrite' => false, 'map_meta_cap' => true,
		'capabilities' => ['create_posts' => 'do_not_allow'],
	]);
});

function tbn_lines(string $option, array $default): array {
	$v = trim((string) tbn_option($option));
	return $v ? array_values(array_filter(array_map('trim', preg_split('/\R/', $v)))) : $default;
}

function tbn_form_topics(): array {
	return tbn_lines('form_topics', ['General enquiry', 'Open calls', 'Collaboration', 'Training and community', 'Media enquiry']);
}

function tbn_form_org_types(): array {
	return tbn_lines('form_org_types', ['Start-up', 'SME', 'Large company', 'University or research centre', 'Innovation support organisation', 'Research infrastructure or service provider', 'Public body', 'Investor', 'Other']);
}

function tbn_form_token(): string {
	$t = (string) time();
	return $t . '.' . hash_hmac('sha256', $t, wp_salt('nonce'));
}

/* ---------- Front end ---------- */

function tbn_contact_form(): void {
	$state = sanitize_key($_GET['enquiry'] ?? '');
	if ($state === 'sent') {
		echo '<div class="form form--done" id="contact-form" role="status" tabindex="-1"><h3>Message sent</h3><p>' . esc_html(tbn_option('form_done', 'Thank you. We will reply to the e-mail address you gave us.')) . '</p>';
		echo '<a class="btn btn--outline" href="' . esc_url(remove_query_arg('enquiry')) . '#contact-form">Send another message</a></div>';
		return;
	}
	$privacy = tbn_option('privacy_url', 'https://innostars.org/privacy-notice/');
	?>
	<form class="form" id="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
		<?php if ($state === 'error') : ?>
			<p class="form__error" role="alert">Please fill in your name, a valid e-mail address and the message, and accept the privacy notice.</p>
		<?php elseif ($state === 'limit') : ?>
			<p class="form__error" role="alert">Too many messages from this connection. Please try again in an hour or write to us by e-mail.</p>
		<?php endif; ?>
		<input type="hidden" name="action" value="tbn_enquiry">
		<input type="hidden" name="tbn_t" value="<?php echo esc_attr(tbn_form_token()); ?>">
		<input type="hidden" name="tbn_back" value="<?php echo esc_url(remove_query_arg('enquiry')); ?>">
		<div class="form__hp" aria-hidden="true"><label>Leave this empty <input name="website" tabindex="-1" autocomplete="off"></label></div>
		<div class="form__row">
			<label>First name <input name="first_name" autocomplete="given-name" required maxlength="100"></label>
			<label>Last name <input name="last_name" autocomplete="family-name" required maxlength="100"></label>
		</div>
		<label>E-mail <input type="email" name="email" autocomplete="email" required maxlength="200"></label>
		<div class="form__row">
			<label>Type of organisation
				<select name="org_type">
					<option value="" selected disabled>Choose one</option>
					<?php foreach (tbn_form_org_types() as $o) : ?><option><?php echo esc_html($o); ?></option><?php endforeach; ?>
				</select>
			</label>
			<label>Topic
				<select name="topic">
					<?php foreach (tbn_form_topics() as $o) : ?><option><?php echo esc_html($o); ?></option><?php endforeach; ?>
				</select>
			</label>
		</div>
		<label>Message <textarea name="message" rows="5" required maxlength="5000"></textarea></label>
		<label class="form__check">
			<input type="checkbox" name="privacy" value="1" required>
			<span>I have read the <a href="<?php echo esc_url($privacy); ?>" target="_blank" rel="noopener noreferrer">privacy notice</a> and agree to the processing of my data to answer this message.</span>
		</label>
		<label class="form__check">
			<input type="checkbox" name="newsletter" value="1">
			<span>I would like to receive news and updates about <?php echo esc_html(get_bloginfo('name')); ?>.</span>
		</label>
		<button class="btn btn--primary" type="submit">Send message</button>
	</form>
	<?php
}

function tbn_enquiry_handle(): void {
	$back = esc_url_raw(wp_unslash($_POST['tbn_back'] ?? ''));
	if (!$back || wp_parse_url($back, PHP_URL_HOST) !== wp_parse_url(home_url(), PHP_URL_HOST)) {
		$back = home_url('/contact/');
	}
	$go = function (string $state) use ($back) {
		wp_safe_redirect(add_query_arg('enquiry', $state, $back) . '#contact-form', 303);
		exit;
	};

	// Bots: honeypot filled, token forged or form sent faster than 3 s after the page was made. Pretend success.
	// No upper age limit: pages are cached, so the token can be days old for a real visitor.
	[$t, $sig] = array_pad(explode('.', (string) ($_POST['tbn_t'] ?? '')), 2, '');
	$age = time() - (int) $t;
	if (!empty($_POST['website']) || !hash_equals(hash_hmac('sha256', $t, wp_salt('nonce')), $sig) || $age < 3) {
		$go('sent');
	}

	$ip_key = 'tbn_enq_' . md5(($_SERVER['REMOTE_ADDR'] ?? '') . wp_salt('nonce'));
	$count = (int) get_transient($ip_key);
	if ($count >= 5) {
		$go('limit');
	}

	$data = [
		'first_name' => sanitize_text_field(wp_unslash($_POST['first_name'] ?? '')),
		'last_name'  => sanitize_text_field(wp_unslash($_POST['last_name'] ?? '')),
		'email'      => sanitize_email(wp_unslash($_POST['email'] ?? '')),
		'org_type'   => sanitize_text_field(wp_unslash($_POST['org_type'] ?? '')),
		'topic'      => sanitize_text_field(wp_unslash($_POST['topic'] ?? '')),
		'newsletter' => empty($_POST['newsletter']) ? 'No' : 'Yes',
	];
	$message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));
	if (!$data['first_name'] || !$data['last_name'] || !is_email($data['email']) || !$message || empty($_POST['privacy'])) {
		$go('error');
	}

	$id = wp_insert_post([
		'post_type' => 'enquiry',
		'post_status' => 'publish',
		'post_title' => mb_substr($data['first_name'] . ' ' . $data['last_name'] . ($data['topic'] ? ' — ' . $data['topic'] : ''), 0, 200),
		'post_content' => mb_substr($message, 0, 5000),
	], true);
	if (is_wp_error($id)) {
		$go('error');
	}
	foreach ($data as $k => $v) {
		update_post_meta($id, "_tbn_{$k}", mb_substr($v, 0, 200));
	}
	update_post_meta($id, '_tbn_privacy', 'Accepted ' . wp_date('Y-m-d H:i'));
	update_post_meta($id, '_tbn_page', $back);
	update_post_meta($id, '_tbn_new', 1);
	set_transient($ip_key, $count + 1, HOUR_IN_SECONDS);
	$go('sent');
}
add_action('admin_post_nopriv_tbn_enquiry', 'tbn_enquiry_handle');
add_action('admin_post_tbn_enquiry', 'tbn_enquiry_handle');

/* ---------- Admin: inbox ---------- */

function tbn_enq(int $id, string $key): string {
	return (string) get_post_meta($id, "_tbn_{$key}", true);
}

function tbn_unread_count(): int {
	global $wpdb;
	return (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->postmeta} m JOIN {$wpdb->posts} p ON p.ID = m.post_id WHERE m.meta_key = '_tbn_new' AND p.post_type = 'enquiry' AND p.post_status = 'publish'");
}

// Number of unread enquiries next to the menu item.
add_action('admin_menu', function () {
	global $menu;
	$n = tbn_unread_count();
	if (!$n) {
		return;
	}
	foreach ($menu as &$m) {
		if (($m[2] ?? '') === 'edit.php?post_type=enquiry') {
			$m[0] .= ' <span class="awaiting-mod count-' . $n . '"><span class="pending-count">' . $n . '</span></span>';
		}
	}
}, 99);

add_filter('manage_enquiry_posts_columns', fn () => [
	'cb' => '<input type="checkbox">',
	'tbn_from' => 'From',
	'tbn_topic' => 'Topic',
	'tbn_org' => 'Organisation',
	'tbn_msg' => 'Message',
	'tbn_news' => 'News',
	'date' => 'Received',
]);

add_action('manage_enquiry_posts_custom_column', function ($col, $id) {
	switch ($col) {
		case 'tbn_from':
			$new = get_post_meta($id, '_tbn_new', true);
			printf(
				'%s<strong><a href="%s">%s</a></strong><br><a href="mailto:%s">%s</a>',
				$new ? '<span class="tbn-new">New</span> ' : '',
				esc_url(get_edit_post_link($id)),
				esc_html(tbn_enq($id, 'first_name') . ' ' . tbn_enq($id, 'last_name')),
				esc_attr(tbn_enq($id, 'email')),
				esc_html(tbn_enq($id, 'email'))
			);
			break;
		case 'tbn_topic':
			echo esc_html(tbn_enq($id, 'topic'));
			break;
		case 'tbn_org':
			echo esc_html(tbn_enq($id, 'org_type'));
			break;
		case 'tbn_msg':
			echo esc_html(wp_trim_words(get_post_field('post_content', $id), 22));
			break;
		case 'tbn_news':
			echo tbn_enq($id, 'newsletter') === 'Yes' ? 'Yes' : '—';
			break;
	}
}, 10, 2);

add_filter('post_row_actions', function ($actions, $post) {
	if ($post->post_type !== 'enquiry') {
		return $actions;
	}
	unset($actions['inline hide-if-no-js'], $actions['view']);
	if (isset($actions['edit'])) {
		$actions['edit'] = '<a href="' . esc_url(get_edit_post_link($post->ID)) . '">Open</a>';
	}
	$mail = tbn_enq($post->ID, 'email');
	if ($mail && $post->post_status !== 'trash') {
		$subject = rawurlencode('Re: ' . (tbn_enq($post->ID, 'topic') ?: get_bloginfo('name')));
		$actions = ['reply' => '<a href="mailto:' . esc_attr($mail) . '?subject=' . $subject . '">Reply by e-mail</a>'] + $actions;
	}
	return $actions;
}, 10, 2);

add_filter('bulk_actions-edit-enquiry', function ($actions) {
	unset($actions['edit']);
	return ['tbn_read' => 'Mark as read', 'tbn_unread' => 'Mark as new'] + $actions;
});

add_filter('handle_bulk_actions-edit-enquiry', function ($redirect, $action, $ids) {
	foreach ($ids as $id) {
		if ($action === 'tbn_read') {
			delete_post_meta($id, '_tbn_new');
		} elseif ($action === 'tbn_unread') {
			update_post_meta($id, '_tbn_new', 1);
		}
	}
	return $redirect;
}, 10, 3);

// Single enquiry: read-only view. Opening it marks it as read.
add_action('add_meta_boxes_enquiry', function ($post) {
	delete_post_meta($post->ID, '_tbn_new');
	remove_meta_box('submitdiv', 'enquiry', 'side');
	add_meta_box('tbn_enquiry', 'Message', function ($post) {
		$id = $post->ID;
		echo '<table class="form-table tbn-enq"><tbody>';
		printf('<tr><th>Received</th><td>%s</td></tr>', esc_html(get_the_date('j F Y, H:i', $post)));
		foreach (TBN_ENQ_FIELDS as $k => $label) {
			$v = tbn_enq($id, $k);
			if ($k === 'email' && $v) {
				$v = '<a href="mailto:' . esc_attr($v) . '?subject=' . rawurlencode('Re: ' . (tbn_enq($id, 'topic') ?: get_bloginfo('name'))) . '">' . esc_html($v) . '</a>';
			} else {
				$v = esc_html($v ?: '—');
			}
			printf('<tr><th>%s</th><td>%s</td></tr>', esc_html($label), $v);
		}
		printf('<tr><th>Message</th><td><div class="tbn-enq__msg">%s</div></td></tr>', nl2br(esc_html($post->post_content)));
		printf('<tr><th>Privacy consent</th><td>%s</td></tr>', esc_html(tbn_enq($id, 'privacy') ?: '—'));
		printf('<tr><th>Sent from</th><td>%s</td></tr>', esc_html(tbn_enq($id, 'page') ?: '—'));
		echo '</tbody></table>';
		$mail = tbn_enq($id, 'email');
		echo '<p>';
		if ($mail) {
			echo '<a class="button button-primary" href="mailto:' . esc_attr($mail) . '?subject=' . rawurlencode('Re: ' . (tbn_enq($id, 'topic') ?: get_bloginfo('name'))) . '">Reply by e-mail</a> ';
		}
		echo '<a class="button" href="' . esc_url(admin_url('edit.php?post_type=enquiry')) . '">Back to all enquiries</a> ';
		echo '<a class="button-link-delete" style="margin-left:1em" href="' . esc_url(get_delete_post_link($id)) . '">Move to bin</a>';
		echo '</p>';
	}, 'enquiry', 'normal', 'high');
});

// CSV export of all enquiries (for Excel: UTF-8 with BOM, semicolons).
add_action('manage_posts_extra_tablenav', function ($which) {
	if ($which === 'top' && get_current_screen()?->post_type === 'enquiry') {
		$url = wp_nonce_url(admin_url('admin-post.php?action=tbn_enquiries_csv'), 'tbn_csv');
		echo '<div class="alignleft actions"><a class="button" href="' . esc_url($url) . '">Download all as CSV (Excel)</a></div>';
	}
});

add_action('admin_post_tbn_enquiries_csv', function () {
	if (!current_user_can('edit_posts') || !check_admin_referer('tbn_csv')) {
		wp_die('Not allowed.');
	}
	$rows = get_posts(['post_type' => 'enquiry', 'numberposts' => -1, 'post_status' => 'publish', 'orderby' => 'date', 'order' => 'DESC']);
	nocache_headers();
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename="enquiries-' . wp_date('Y-m-d') . '.csv"');
	$out = fopen('php://output', 'w');
	fwrite($out, "\xEF\xBB\xBF");
	fputcsv($out, array_merge(['Received'], array_values(TBN_ENQ_FIELDS), ['Message', 'Privacy consent']), ';');
	foreach ($rows as $p) {
		$line = [get_the_date('Y-m-d H:i', $p)];
		foreach (array_keys(TBN_ENQ_FIELDS) as $k) {
			$line[] = tbn_enq($p->ID, $k);
		}
		$line[] = $p->post_content;
		$line[] = tbn_enq($p->ID, 'privacy');
		fputcsv($out, $line, ';');
	}
	fclose($out);
	exit;
});

add_action('admin_head', function () {
	if (get_current_screen()?->post_type !== 'enquiry') {
		return;
	}
	echo '<style>
.tbn-new{display:inline-block;padding:0 6px;background:#25817A;color:#fff;font-size:11px;line-height:18px;text-transform:uppercase}
.column-tbn_from{width:22%}.column-tbn_topic,.column-tbn_org{width:14%}.column-tbn_news{width:6%}
.tbn-enq th{width:180px;padding:10px 10px 10px 0}.tbn-enq td{padding:10px 0}.tbn-enq__msg{max-width:720px;font-size:15px;line-height:1.6}
.post-type-enquiry .page-title-action,.post-type-enquiry #titlediv{display:none}
</style>';
});

/* ---------- Personal data: Tools → Export / Erase personal data finds enquiries by e-mail ---------- */

function tbn_enquiries_by_email(string $email): array {
	return get_posts(['post_type' => 'enquiry', 'numberposts' => -1, 'post_status' => 'any', 'meta_key' => '_tbn_email', 'meta_value' => $email]);
}

add_filter('wp_privacy_personal_data_exporters', function ($exporters) {
	$exporters['tbn-enquiries'] = ['exporter_friendly_name' => 'Contact form enquiries', 'callback' => function ($email) {
		$items = [];
		foreach (tbn_enquiries_by_email($email) as $p) {
			$data = [['name' => 'Received', 'value' => get_the_date('Y-m-d H:i', $p)], ['name' => 'Message', 'value' => $p->post_content]];
			foreach (TBN_ENQ_FIELDS as $k => $label) {
				$data[] = ['name' => $label, 'value' => tbn_enq($p->ID, $k)];
			}
			$items[] = ['group_id' => 'tbn-enquiries', 'group_label' => 'Contact form enquiries', 'item_id' => 'enquiry-' . $p->ID, 'data' => $data];
		}
		return ['data' => $items, 'done' => true];
	}];
	return $exporters;
});

add_filter('wp_privacy_personal_data_erasers', function ($erasers) {
	$erasers['tbn-enquiries'] = ['eraser_friendly_name' => 'Contact form enquiries', 'callback' => function ($email) {
		$n = 0;
		foreach (tbn_enquiries_by_email($email) as $p) {
			wp_delete_post($p->ID, true);
			$n++;
		}
		return ['items_removed' => $n, 'items_retained' => false, 'messages' => [], 'done' => true];
	}];
	return $erasers;
});
