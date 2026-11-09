<?php
defined('ABSPATH') || exit;

add_action('init', function () {
	$labels = function (string $one, string $many, string $add) {
		return [
			'name' => $many, 'singular_name' => $one, 'menu_name' => $many, 'all_items' => "All {$many}",
			'add_new' => $add, 'add_new_item' => $add, 'edit_item' => "Edit {$one}", 'new_item' => "New {$one}",
			'view_item' => "View {$one}", 'search_items' => "Search {$many}", 'not_found' => "No {$many} yet",
			'not_found_in_trash' => "No {$many} in the bin", 'featured_image' => 'Image', 'set_featured_image' => 'Set image',
		];
	};

	register_post_type('event', [
		'labels' => $labels('event', 'Events', 'Add event'),
		'public' => true, 'show_in_rest' => true, 'has_archive' => false, 'menu_position' => 6, 'menu_icon' => 'dashicons-calendar-alt',
		'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions'],
		'rewrite' => ['slug' => 'events', 'with_front' => false],
	]);

	register_post_type('open_call', [
		'labels' => $labels('Open Call', 'Open Calls', 'Add Open Call'),
		'public' => true, 'show_in_rest' => true, 'has_archive' => false, 'menu_position' => 7, 'menu_icon' => 'dashicons-megaphone',
		'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions'],
		'rewrite' => ['slug' => 'open-calls', 'with_front' => false],
	]);

	// Partners and resources are short forms: no block editor, only fields (see admin.php).
	register_post_type('partner', [
		'labels' => $labels('partner', 'Partners', 'Add partner'),
		'public' => true, 'show_in_rest' => true, 'has_archive' => false, 'menu_position' => 8, 'menu_icon' => 'dashicons-groups',
		'supports' => ['title', 'revisions'],
		'rewrite' => ['slug' => 'partners', 'with_front' => false],
	]);

	register_post_type('resource', [
		'labels' => $labels('resource', 'Resources', 'Add resource'),
		'description' => 'Documents, deliverables, promotional materials and videos listed on the Resources page.',
		'public' => false, 'publicly_queryable' => false, 'show_ui' => true, 'show_in_rest' => true, 'menu_position' => 9, 'menu_icon' => 'dashicons-media-document',
		'supports' => ['title'],
		'rewrite' => false,
	]);

	register_taxonomy('resource_type', 'resource', [
		'labels' => ['name' => 'Resource types', 'singular_name' => 'Resource type', 'menu_name' => 'Types', 'add_new_item' => 'Add type'],
		'public' => false, 'show_ui' => true, 'show_in_rest' => true, 'hierarchical' => true, 'show_admin_column' => true,
		'meta_box_cb' => 'post_categories_meta_box', 'rewrite' => false,
	]);

	// Built-in posts are the news.
	global $wp_post_types;
	$news = $wp_post_types['post']->labels;
	foreach (['name' => 'News', 'singular_name' => 'News item', 'menu_name' => 'News', 'all_items' => 'All news', 'add_new' => 'Add news', 'add_new_item' => 'Add news', 'edit_item' => 'Edit news'] as $k => $v) {
		$news->$k = $v;
	}
});

// Self-repair: if a plugin rebuilt the address rules without the theme's post types (it happened when plugins
// were activated from the command line), /partners/<name>/ and the like return 404. Rebuild once in that case.
add_action('init', function () {
	$rules = get_option('rewrite_rules');
	if (!is_array($rules)) {
		return;
	}
	foreach (array_keys($rules) as $pattern) {
		if (str_starts_with($pattern, 'partners/')) {
			return;
		}
	}
	flush_rewrite_rules(false);
}, 99);
