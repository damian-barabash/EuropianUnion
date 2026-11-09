<?php
defined('ABSPATH') || exit;

add_action('after_setup_theme', function () {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('responsive-embeds');
	add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
	add_theme_support('editor-styles');
	add_editor_style('assets/css/editor.css');

	// Block editor: only the project colours, no free colour picker, no custom font sizes.
	add_theme_support('editor-color-palette', [
		['name' => 'Navy', 'slug' => 'navy', 'color' => '#202B57'],
		['name' => 'Blue', 'slug' => 'blue', 'color' => '#2D51AA'],
		['name' => 'Teal', 'slug' => 'teal', 'color' => '#25817A'],
		['name' => 'Ink', 'slug' => 'ink', 'color' => '#141A33'],
	]);
	add_theme_support('disable-custom-colors');
	add_theme_support('disable-custom-font-sizes');
	add_theme_support('disable-custom-gradients');
	remove_theme_support('core-block-patterns');

	register_nav_menus([
		'primary' => 'Main menu (header)',
		'footer'  => 'Footer menu',
		'legal'   => 'Legal links (footer)',
	]);

	// Card 3:2, wide article image 16:9, full-bleed photos.
	add_image_size('tbn-card', 780, 520, true);
	add_image_size('tbn-wide', 1600, 900, true);
	add_image_size('tbn-bleed', 1600, 1000, false);
	add_image_size('tbn-hero', 2560, 1600, false);
});

add_action('wp_enqueue_scripts', function () {
	$css = ['tokens', 'base', 'components', 'sections', 'wp'];
	$deps = [];
	foreach ($css as $name) {
		$path = "/assets/css/{$name}.css";
		wp_enqueue_style("tbn-{$name}", TBN_URI . $path, $deps, filemtime(TBN_DIR . $path));
		$deps = ["tbn-{$name}"];
	}
	wp_enqueue_script('tbn-site', TBN_URI . '/assets/js/site.js', [], filemtime(TBN_DIR . '/assets/js/site.js'), ['strategy' => 'defer', 'in_footer' => true]);

	// Block styles are not used on the front end: the theme styles the content itself.
	wp_dequeue_style('global-styles');
	wp_dequeue_style('classic-theme-styles');
});

// Fonts are served from the theme, nothing is requested from Google.
add_action('wp_head', function () {
	$base = TBN_URI . '/assets/fonts/';
	echo '<link rel="preload" href="' . esc_url($base . 'onest-latin-wght-normal.woff2') . '" as="font" type="font/woff2" crossorigin>' . "\n";
	echo '<link rel="icon" type="image/svg+xml" href="' . esc_url(TBN_URI . '/assets/brand/favicon.svg') . '">' . "\n";
	echo "<style>
@font-face{font-family:'Onest Variable';font-style:normal;font-display:swap;font-weight:100 900;src:url({$base}onest-latin-ext-wght-normal.woff2) format('woff2-variations');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C0,U+2113,U+2C60-2C7F,U+A720-A7FF}
@font-face{font-family:'Onest Variable';font-style:normal;font-display:swap;font-weight:100 900;src:url({$base}onest-latin-wght-normal.woff2) format('woff2-variations');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}
</style>\n";
}, 2);

// Clean-up: no emoji script, no comments anywhere, no generator tag.
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_generator');
add_filter('comments_open', '__return_false', 20);
add_filter('pings_open', '__return_false', 20);
add_filter('comments_array', '__return_empty_array', 10);
add_action('init', function () {
	foreach (get_post_types() as $type) {
		if (post_type_supports($type, 'comments')) {
			remove_post_type_support($type, 'comments');
			remove_post_type_support($type, 'trackbacks');
		}
	}
});

// News live under /news/<slug>/ (permalink structure set on install, see wordpress/seed). Custom post
// types use `with_front => false`, so they keep their own base (/events/, /open-calls/, /partners/).

// "News", "Press release", "Article" are categories; the excerpt is the card text.
add_filter('excerpt_length', fn () => 28);
add_filter('excerpt_more', fn () => '…');

// Body class for pages built from sections.
add_filter('body_class', function ($classes) {
	if (is_page() && function_exists('have_rows') && get_field('sections')) {
		$classes[] = 'has-sections';
	}
	return $classes;
});
