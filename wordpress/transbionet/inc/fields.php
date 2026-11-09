<?php
/**
 * Custom fields, defined in code so they travel with the theme (ACF PRO or Secure Custom Fields).
 * Field keys are generated from names: field_<group>_<name>[_<sub>…]. Changing a name changes the key,
 * so rename only together with a data migration.
 */
defined('ABSPATH') || exit;

// Field shorthand.
function tbn_f(string $name, string $type, string $label, array $extra = []): array {
	return ['name' => $name, 'type' => $type, 'label' => $label] + $extra;
}

// Adds keys to fields, sub fields and flexible layouts.
function tbn_keys(array $fields, string $prefix): array {
	foreach ($fields as &$f) {
		$k = $prefix . '_' . $f['name'];
		$f['key'] = 'field_' . $k;
		if (!empty($f['sub_fields'])) {
			$f['sub_fields'] = tbn_keys($f['sub_fields'], $k);
		}
		if (!empty($f['layouts'])) {
			$layouts = [];
			foreach ($f['layouts'] as $lname => $l) {
				$l['key'] = 'layout_' . $k . '_' . $lname;
				$l['name'] = $lname;
				$l['display'] = $l['display'] ?? 'block';
				$l['sub_fields'] = tbn_keys($l['sub_fields'], $k . '_' . $lname);
				$layouts[$l['key']] = $l;
			}
			$f['layouts'] = $layouts;
		}
	}
	return $fields;
}

function tbn_group(string $key, string $title, array $fields, array $location, array $extra = []): void {
	acf_add_local_field_group([
		'key' => 'group_' . $key,
		'title' => $title,
		'fields' => tbn_keys($fields, $key),
		'location' => $location,
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
	] + $extra);
}

/* ---------- Reusable pieces ---------- */

function tbn_hide_field(): array {
	return tbn_f('hide', 'true_false', 'Hide this section', ['ui' => 1, 'instructions' => 'Keeps the section here but does not show it on the site.', 'wrapper' => ['width' => 30]]);
}

function tbn_bg_field(array $choices = ['white' => 'White', 'grey' => 'Light grey', 'orbs' => 'White with soft colour circles'], string $default = 'white'): array {
	return tbn_f('bg', 'select', 'Background', ['choices' => $choices, 'default_value' => $default, 'wrapper' => ['width' => 35]]);
}

function tbn_image_field(string $name = 'image', string $label = 'Image', string $hint = ''): array {
	return tbn_f($name, 'image', $label, ['return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => $hint]);
}

function tbn_link_field(string $name = 'button', string $label = 'Button'): array {
	return tbn_f($name, 'link', $label, ['return_format' => 'array', 'instructions' => 'Text and address of the button. Leave empty for no button.']);
}

/* ---------- Page sections ---------- */

function tbn_section_layouts(): array {
	$basic = ['toolbar' => 'basic', 'media_upload' => 0, 'tabs' => 'visual'];
	return [
		'hero' => ['label' => 'Hero (big title with photo)', 'sub_fields' => [
			tbn_hide_field(),
			tbn_f('title', 'text', 'Title', ['required' => 1]),
			tbn_f('text', 'textarea', 'Text', ['rows' => 4, 'new_lines' => '']),
			tbn_link_field(),
			tbn_image_field('image', 'Photo', 'At least 2560 × 1600 px. Keep the people in the middle of the frame.'),
		]],
		'facts' => ['label' => 'Numbers (key facts)', 'sub_fields' => [
			tbn_hide_field(),
			tbn_f('items', 'repeater', 'Numbers', ['layout' => 'table', 'button_label' => 'Add number', 'max' => 4, 'sub_fields' => [
				tbn_f('value', 'text', 'Number', ['wrapper' => ['width' => 35]]),
				tbn_f('label', 'text', 'Label'),
			]]),
		]],
		'bleed' => ['label' => 'Photo to the edge + text', 'sub_fields' => [
			tbn_hide_field(),
			tbn_f('image_right', 'true_false', 'Photo on the right', ['ui' => 1, 'wrapper' => ['width' => 30]]),
			tbn_image_field('image', 'Photo', 'At least 2560 × 1600 px.'),
			tbn_f('title', 'text', 'Title'),
			tbn_f('text', 'wysiwyg', 'Text', $basic),
			tbn_link_field(),
		]],
		'media' => ['label' => 'Photo + text (inside the page width)', 'sub_fields' => [
			tbn_hide_field(),
			tbn_bg_field(['white' => 'White', 'grey' => 'Light grey']),
			tbn_f('image_right', 'true_false', 'Photo on the right', ['ui' => 1, 'wrapper' => ['width' => 30]]),
			tbn_image_field('image', 'Photo', 'At least 1400 × 1000 px.'),
			tbn_f('title', 'text', 'Title'),
			tbn_f('text', 'wysiwyg', 'Text', $basic),
			tbn_link_field(),
		]],
		'columns' => ['label' => 'Columns with short texts', 'sub_fields' => [
			tbn_hide_field(),
			tbn_bg_field(),
			tbn_f('title', 'text', 'Title'),
			tbn_f('items', 'repeater', 'Columns', ['layout' => 'block', 'button_label' => 'Add column', 'sub_fields' => [
				tbn_f('title', 'text', 'Title'),
				tbn_f('text', 'textarea', 'Text', ['rows' => 3, 'new_lines' => '']),
			]]),
		]],
		'text' => ['label' => 'Text', 'sub_fields' => [
			tbn_hide_field(),
			tbn_bg_field(['white' => 'White', 'grey' => 'Light grey']),
			tbn_f('title', 'text', 'Title'),
			tbn_f('content', 'wysiwyg', 'Text', ['toolbar' => 'full', 'media_upload' => 1, 'instructions' => 'Headings, lists, links, images and files. A YouTube link on its own line becomes a video.']),
		]],
		'notice' => ['label' => 'Notice (framed text)', 'sub_fields' => [
			tbn_hide_field(),
			tbn_f('text', 'textarea', 'Text', ['rows' => 3, 'new_lines' => '']),
		]],
		'news' => ['label' => 'Latest news', 'sub_fields' => [
			tbn_hide_field(),
			tbn_bg_field(),
			tbn_f('title', 'text', 'Title', ['default_value' => 'News']),
			tbn_f('count', 'number', 'How many', ['default_value' => 3, 'min' => 1, 'max' => 12, 'wrapper' => ['width' => 30]]),
			tbn_link_field('button', 'Button under the news'),
		]],
		'calls' => ['label' => 'Open Calls list', 'sub_fields' => [
			tbn_hide_field(),
			tbn_bg_field(),
			tbn_f('show', 'select', 'Which calls', ['choices' => ['current' => 'Open and upcoming', 'closed' => 'Closed', 'all' => 'All'], 'default_value' => 'current', 'wrapper' => ['width' => 35]]),
			tbn_f('title', 'text', 'Title'),
			tbn_f('text', 'text', 'Short text under the title'),
			tbn_link_field('button', 'Button next to the title'),
			tbn_f('empty', 'text', 'Text when there are no calls', ['default_value' => 'There are no calls in this group right now.']),
		]],
		'events' => ['label' => 'Events list', 'sub_fields' => [
			tbn_hide_field(),
			tbn_f('show', 'select', 'Which events', ['choices' => ['upcoming' => 'Upcoming', 'past' => 'Past', 'webinars' => 'Upcoming info sessions about Open Calls'], 'default_value' => 'upcoming', 'wrapper' => ['width' => 35]]),
			tbn_f('dark', 'true_false', 'Dark background', ['ui' => 1, 'wrapper' => ['width' => 35]]),
			tbn_f('limit', 'number', 'How many (empty = all)', ['min' => 1, 'wrapper' => ['width' => 30]]),
			tbn_f('title', 'text', 'Title'),
			tbn_f('text', 'text', 'Short text'),
			tbn_link_field('button', 'Button'),
			tbn_f('empty', 'text', 'Text when there are no events', ['instructions' => 'Leave empty to hide the whole section when there are no events.']),
		]],
		'partner_logos' => ['label' => 'Partner logos', 'sub_fields' => [
			tbn_hide_field(),
			tbn_bg_field(),
			tbn_f('title', 'text', 'Title', ['default_value' => 'Partners']),
			tbn_f('text', 'text', 'Text', ['default_value' => '{partners} organisations from {countries} countries work together in the consortium.', 'instructions' => '{partners} and {countries} are counted automatically.']),
			tbn_f('all_label', 'text', 'Last tile', ['default_value' => 'Meet the consortium']),
		]],
		'partner_cards' => ['label' => 'Partner cards (all partners)', 'sub_fields' => [
			tbn_hide_field(),
		]],
		'resources' => ['label' => 'Documents and files list', 'sub_fields' => [
			tbn_hide_field(),
			tbn_bg_field(['white' => 'White', 'grey' => 'Light grey']),
			tbn_f('title', 'text', 'Title'),
			tbn_f('types', 'taxonomy', 'Only these types', ['taxonomy' => 'resource_type', 'field_type' => 'checkbox', 'return_format' => 'id', 'add_term' => 0, 'save_terms' => 0, 'load_terms' => 0, 'instructions' => 'Leave empty to list all files (videos are shown by the "Videos" section).']),
			tbn_f('filter', 'true_false', 'Show the type filter', ['ui' => 1, 'default_value' => 1]),
			tbn_f('empty', 'text', 'Text when there is nothing yet', ['default_value' => 'Nothing here yet.']),
		]],
		'videos' => ['label' => 'Videos', 'sub_fields' => [
			tbn_hide_field(),
			tbn_bg_field(['white' => 'White', 'grey' => 'Light grey']),
			tbn_f('title', 'text', 'Title'),
			tbn_f('text', 'text', 'Short text'),
			tbn_f('items', 'repeater', 'Videos', ['layout' => 'block', 'button_label' => 'Add video', 'instructions' => 'Leave empty to show all resources of the type "Video".', 'sub_fields' => [
				tbn_f('title', 'text', 'Title', ['wrapper' => ['width' => 40]]),
				tbn_f('url', 'url', 'YouTube or Vimeo address', ['wrapper' => ['width' => 60]]),
				tbn_image_field('cover', 'Cover (optional)', 'Without a cover the YouTube picture is used.'),
			]]),
		]],
		'steps' => ['label' => 'Numbered steps', 'sub_fields' => [
			tbn_hide_field(),
			tbn_bg_field(['white' => 'White', 'grey' => 'Light grey']),
			tbn_f('title', 'text', 'Title'),
			tbn_f('text', 'text', 'Short text'),
			tbn_f('items', 'repeater', 'Steps', ['layout' => 'block', 'button_label' => 'Add step', 'sub_fields' => [
				tbn_f('title', 'text', 'Title'),
				tbn_f('text', 'textarea', 'Text', ['rows' => 2, 'new_lines' => '']),
			]]),
		]],
		'timeline' => ['label' => 'Timeline / stages', 'sub_fields' => [
			tbn_hide_field(),
			tbn_bg_field(['white' => 'White', 'grey' => 'Light grey']),
			tbn_f('title', 'text', 'Title'),
			tbn_f('items', 'repeater', 'Stages', ['layout' => 'table', 'button_label' => 'Add stage', 'sub_fields' => [
				tbn_f('period', 'text', 'Period or state', ['wrapper' => ['width' => 25]]),
				tbn_f('title', 'text', 'Title'),
				tbn_f('text', 'textarea', 'Text', ['rows' => 2, 'new_lines' => '']),
				tbn_f('planned', 'true_false', 'Not started yet', ['ui' => 1, 'wrapper' => ['width' => 15]]),
			]]),
		]],
		'faq' => ['label' => 'Questions and answers', 'sub_fields' => [
			tbn_hide_field(),
			tbn_bg_field(['white' => 'White', 'grey' => 'Light grey']),
			tbn_f('title', 'text', 'Title'),
			tbn_f('items', 'repeater', 'Questions', ['layout' => 'block', 'button_label' => 'Add question', 'sub_fields' => [
				tbn_f('q', 'text', 'Question'),
				tbn_f('a', 'textarea', 'Answer', ['rows' => 3]),
			]]),
		]],
		'people' => ['label' => 'People with quotes', 'sub_fields' => [
			tbn_hide_field(),
			tbn_bg_field(['white' => 'White', 'grey' => 'Light grey']),
			tbn_f('title', 'text', 'Title'),
			tbn_f('items', 'repeater', 'People', ['layout' => 'block', 'button_label' => 'Add person', 'sub_fields' => [
				tbn_image_field('photo', 'Photo', 'Square, at least 600 × 600 px.'),
				tbn_f('name', 'text', 'Name', ['wrapper' => ['width' => 33]]),
				tbn_f('role', 'text', 'Role', ['wrapper' => ['width' => 33]]),
				tbn_f('org', 'text', 'Organisation', ['wrapper' => ['width' => 34]]),
				tbn_f('quote', 'textarea', 'Quote', ['rows' => 3, 'new_lines' => '']),
			]]),
		]],
		'cta' => ['label' => 'Call to action band (navy)', 'sub_fields' => [
			tbn_hide_field(),
			tbn_f('title', 'text', 'Title', ['default_value' => 'Have a question about the project?']),
			tbn_f('text', 'text', 'Text'),
			tbn_link_field('button', 'Main button'),
			tbn_link_field('button2', 'Second button'),
		]],
		'talk' => ['label' => 'Text + contact form', 'sub_fields' => [
			tbn_hide_field(),
			tbn_f('title', 'text', 'Title', ['default_value' => 'Let’s talk about TransBioNet']),
			tbn_f('text', 'textarea', 'Text', ['rows' => 3, 'new_lines' => '']),
		]],
		'contact' => ['label' => 'Contact details + form', 'sub_fields' => [
			tbn_hide_field(),
			tbn_f('title', 'text', 'Title of the details', ['default_value' => 'Contact']),
			tbn_f('social_title', 'text', 'Title of the social links', ['default_value' => 'Follow the project']),
			tbn_f('form_title', 'text', 'Title of the form', ['default_value' => 'Send a message']),
		]],
	];
}

add_action('acf/init', function () {
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	if (function_exists('acf_add_options_page')) {
		acf_add_options_page([
			'page_title' => 'Site settings',
			'menu_title' => 'Site settings',
			'menu_slug' => 'tbn-settings',
			'capability' => 'edit_pages',
			'icon_url' => 'dashicons-admin-generic',
			'position' => 3,
			'redirect' => false,
		]);
	}

	$page = [[['param' => 'post_type', 'operator' => '==', 'value' => 'page']]];

	tbn_group('page_header', 'Page header', [
		tbn_f('header_hide', 'true_false', 'No page header', ['ui' => 1, 'instructions' => 'For pages that start with a "Hero" section (the home page).', 'wrapper' => ['width' => 25]]),
		tbn_f('header_lead', 'textarea', 'Lead under the title', ['rows' => 3, 'new_lines' => '', 'wrapper' => ['width' => 75]]),
		tbn_f('header_badge', 'text', 'Label next to the button (optional)', ['instructions' => 'e.g. "In development"', 'wrapper' => ['width' => 40]]),
		tbn_link_field('header_button', 'Button (optional)'),
	], $page, ['position' => 'acf_after_title', 'menu_order' => 0, 'hide_on_screen' => ['the_content', 'discussion', 'comments', 'author', 'format', 'send-trackbacks']]);

	tbn_group('page_sections', 'Sections', [
		tbn_f('sections', 'flexible_content', '', [
			'button_label' => 'Add section',
			'instructions' => 'The page is built from these sections, top to bottom. Drag to reorder, use "Hide this section" to take one off the site without deleting it.',
			'layouts' => tbn_section_layouts(),
		]),
	], $page, ['position' => 'normal', 'menu_order' => 1]);

	tbn_group('event', 'Event details', [
		tbn_f('event_date', 'date_picker', 'Date', ['required' => 1, 'display_format' => 'j F Y', 'return_format' => 'Ymd', 'first_day' => 1]),
		tbn_f('event_end', 'date_picker', 'End date (for events longer than one day)', ['display_format' => 'j F Y', 'return_format' => 'Ymd', 'first_day' => 1]),
		tbn_f('event_time', 'text', 'Time', ['placeholder' => '10:00–12:00 CET']),
		tbn_f('event_place', 'text', 'Place', ['placeholder' => 'Online / City, venue']),
		tbn_f('event_format', 'select', 'Format', ['choices' => ['On-site' => 'On-site', 'Online' => 'Online', 'Hybrid' => 'Hybrid'], 'default_value' => 'On-site']),
		tbn_f('event_register', 'url', 'Registration link'),
		tbn_f('event_webinar', 'true_false', 'Info session about Open Calls', ['ui' => 1, 'instructions' => 'Also listed on the Open Calls page.']),
	], [[['param' => 'post_type', 'operator' => '==', 'value' => 'event']]], ['position' => 'side']);

	tbn_group('call', 'Open Call details', [
		tbn_f('call_status', 'select', 'Status', ['choices' => ['auto' => 'Automatic, from the dates', 'upcoming' => 'Opens soon', 'open' => 'Open', 'closed' => 'Closed'], 'default_value' => 'auto']),
		tbn_f('call_opens', 'date_picker', 'Opens', ['display_format' => 'j F Y', 'return_format' => 'Ymd', 'first_day' => 1]),
		tbn_f('call_deadline', 'date_picker', 'Deadline', ['display_format' => 'j F Y', 'return_format' => 'Ymd', 'first_day' => 1]),
		tbn_f('call_deadline_time', 'text', 'Deadline time', ['placeholder' => '17:00 CET']),
		tbn_f('call_budget', 'text', 'Total budget', ['placeholder' => '€200,000']),
		tbn_f('call_grant', 'text', 'Funding per project', ['placeholder' => 'up to €20,000 per project']),
		tbn_f('call_apply', 'url', 'Application system link', ['instructions' => 'The "Apply" button appears only when the call is open and this link is filled in.']),
	], [[['param' => 'post_type', 'operator' => '==', 'value' => 'open_call']]], ['position' => 'side']);

	tbn_group('call_more', 'Documents and questions', [
		tbn_f('call_documents', 'relationship', 'Documents of this call', ['post_type' => ['resource'], 'filters' => ['search', 'taxonomy'], 'return_format' => 'object', 'instructions' => 'Pick files from Resources. New files: Resources → Add resource.']),
		tbn_f('call_steps_hide', 'true_false', 'Hide "How to apply" steps', ['ui' => 1, 'instructions' => 'The steps are the same for all calls: Site settings → Open Calls.']),
		tbn_f('call_faq', 'repeater', 'Questions and answers', ['layout' => 'block', 'button_label' => 'Add question', 'sub_fields' => [
			tbn_f('q', 'text', 'Question'),
			tbn_f('a', 'textarea', 'Answer', ['rows' => 3]),
		]]),
	], [[['param' => 'post_type', 'operator' => '==', 'value' => 'open_call']]], ['position' => 'normal']);

	tbn_group('partner', 'Partner', [
		tbn_image_field('partner_logo', 'Logo', 'PNG or WebP with transparent background, cropped to the edges.'),
		tbn_f('partner_logo_scale', 'number', 'Logo size', ['default_value' => 1, 'step' => 0.05, 'min' => 0.5, 'max' => 2, 'instructions' => '1 = normal. Make a very wide logo smaller (0.8) or a small one larger (1.3).', 'wrapper' => ['width' => 25]]),
		tbn_f('partner_role', 'select', 'Role in the consortium', ['choices' => ['Partner' => 'Partner', 'Coordinator' => 'Coordinator'], 'default_value' => 'Partner', 'wrapper' => ['width' => 25]]),
		tbn_f('partner_country', 'text', 'Country', ['wrapper' => ['width' => 25]]),
		tbn_f('partner_type', 'text', 'Type of organisation', ['placeholder' => 'Life sciences cluster', 'wrapper' => ['width' => 25]]),
		tbn_f('partner_legal', 'text', 'Legal name', ['wrapper' => ['width' => 50]]),
		tbn_f('partner_website', 'url', 'Website', ['wrapper' => ['width' => 25]]),
		tbn_f('partner_linkedin', 'url', 'LinkedIn', ['wrapper' => ['width' => 25]]),
		tbn_f('partner_role_text', 'textarea', 'Role in the project', ['rows' => 3, 'new_lines' => '']),
		tbn_f('partner_description', 'wysiwyg', 'About the organisation', ['toolbar' => 'basic', 'media_upload' => 0, 'tabs' => 'visual']),
	], [[['param' => 'post_type', 'operator' => '==', 'value' => 'partner']]], ['position' => 'acf_after_title']);

	tbn_group('resource', 'File or video', [
		tbn_f('resource_kind', 'button_group', 'What is it', ['choices' => ['file' => 'Uploaded file', 'video' => 'Video', 'link' => 'Link to another site'], 'default_value' => 'file']),
		tbn_f('resource_file', 'file', 'File', ['return_format' => 'array', 'conditional_logic' => [[['field' => 'field_resource_resource_kind', 'operator' => '==', 'value' => 'file']]], 'instructions' => 'PDF, DOCX, XLSX, PPTX, ZIP. Size and format are shown automatically.']),
		tbn_f('resource_video', 'url', 'YouTube or Vimeo address', ['conditional_logic' => [[['field' => 'field_resource_resource_kind', 'operator' => '==', 'value' => 'video']]]]),
		tbn_image_field('resource_cover', 'Video cover (optional)'),
		tbn_f('resource_url', 'url', 'Address', ['conditional_logic' => [[['field' => 'field_resource_resource_kind', 'operator' => '==', 'value' => 'link']]]]),
	], [[['param' => 'post_type', 'operator' => '==', 'value' => 'resource']]], ['position' => 'acf_after_title']);

	tbn_group('settings', 'Site settings', [
		tbn_f('tab_general', 'tab', 'Project'),
		tbn_f('eu_label', 'select', 'Wording on the EU emblem', ['choices' => ['Funded by' => 'Funded by the European Union', 'Co-funded by' => 'Co-funded by the European Union'], 'default_value' => 'Funded by', 'instructions' => 'As required by the grant agreement.']),
		tbn_f('disclaimer', 'textarea', 'EU disclaimer (footer)', ['rows' => 4, 'new_lines' => '']),
		tbn_f('email', 'email', 'Project e-mail', ['wrapper' => ['width' => 50]]),
		tbn_f('privacy_url', 'url', 'Privacy notice address', ['wrapper' => ['width' => 50], 'instructions' => 'Used in the contact form consent.']),
		tbn_f('social', 'repeater', 'Social media', ['layout' => 'table', 'button_label' => 'Add profile', 'instructions' => 'A profile without an address is shown as text.', 'sub_fields' => [
			tbn_f('label', 'text', 'Name', ['wrapper' => ['width' => 30]]),
			tbn_f('url', 'url', 'Address'),
		]]),
		tbn_f('tab_announce', 'tab', 'Bar above the header'),
		tbn_f('announce_show', 'true_false', 'Show the bar', ['ui' => 1]),
		tbn_f('announce_text', 'text', 'Text'),
		tbn_link_field('announce_link', 'Link'),
		tbn_f('tab_form', 'tab', 'Contact form'),
		tbn_f('form_topics', 'textarea', 'Topics', ['rows' => 6, 'instructions' => 'One per line.']),
		tbn_f('form_org_types', 'textarea', 'Types of organisation', ['rows' => 9, 'instructions' => 'One per line.']),
		tbn_f('form_done', 'text', 'Message after sending', ['default_value' => 'Thank you. We will reply to the e-mail address you gave us.']),
		tbn_f('tab_calls', 'tab', 'Open Calls'),
		tbn_f('call_steps', 'repeater', '"How to apply" steps (shown on every call)', ['layout' => 'block', 'button_label' => 'Add step', 'sub_fields' => [
			tbn_f('title', 'text', 'Title'),
			tbn_f('text', 'textarea', 'Text', ['rows' => 2, 'new_lines' => '']),
		]]),
		tbn_f('tab_cookies', 'tab', 'Cookies and analytics'),
		tbn_f('gtm_id', 'text', 'Google Tag Manager ID', ['placeholder' => 'GTM-XXXXXXX', 'instructions' => 'Loaded only after the visitor accepts analytics cookies. GA4 is set up inside Tag Manager.']),
		tbn_f('cookie_title', 'text', 'Banner title', ['default_value' => 'We use cookies']),
		tbn_f('cookie_text', 'textarea', 'Banner text', ['rows' => 3, 'new_lines' => '', 'default_value' => 'Necessary cookies keep the site working. With your consent we also use analytics cookies to improve it.']),
	], [[['param' => 'options_page', 'operator' => '==', 'value' => 'tbn-settings']]]);
});
