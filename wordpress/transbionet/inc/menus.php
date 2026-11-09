<?php
// Menus are edited in Appearance → Menus. The theme renders them itself to keep the prototype markup.
defined('ABSPATH') || exit;

function tbn_menu_items(string $location): array {
	$locations = get_nav_menu_locations();
	if (empty($locations[$location])) {
		return [];
	}
	$items = wp_get_nav_menu_items($locations[$location]) ?: [];
	return array_values(array_filter($items, fn ($i) => $i->post_status === 'publish'));
}

function tbn_path(string $url): string {
	return trailingslashit((string) wp_parse_url($url, PHP_URL_PATH));
}

function tbn_is_current(string $url): bool {
	if (!str_starts_with($url, home_url())) {
		return false;
	}
	$here = tbn_path((string) ($_SERVER['REQUEST_URI'] ?? '/'));
	$path = tbn_path($url);
	// The home page is current only on itself; other items also on their sub-pages (/news/ on /news/<slug>/).
	return $path === '/' ? $here === '/' : str_starts_with($here, $path);
}

// Main menu with drop-downs. The "Partners" item (address /partners/) gets the list of partners
// automatically, so a new partner shows up in the menu without editing it.
function tbn_primary_menu(): void {
	$items = tbn_menu_items('primary');
	$tree = [];
	foreach ($items as $i) {
		if (!$i->menu_item_parent) {
			$tree[$i->ID] = ['item' => $i, 'children' => []];
		}
	}
	foreach ($items as $i) {
		if ($i->menu_item_parent && isset($tree[$i->menu_item_parent])) {
			$tree[$i->menu_item_parent]['children'][] = ['title' => $i->title, 'url' => $i->url, 'target' => $i->target];
		}
	}
	foreach ($tree as &$node) {
		if (!$node['children'] && tbn_path($node['item']->url) === '/partners/') {
			$node['children'][] = ['title' => 'All partners', 'url' => $node['item']->url, 'target' => ''];
			foreach (tbn_partners() as $p) {
				$node['children'][] = ['title' => get_the_title($p), 'url' => get_permalink($p), 'target' => ''];
			}
		}
	}
	unset($node);

	echo '<ul class="nav__list">';
	foreach ($tree as $node) {
		$i = $node['item'];
		$has = (bool) $node['children'];
		$current = tbn_is_current($i->url);
		printf(
			'<li class="nav__item%s"><a class="nav__link%s" href="%s"%s%s>%s%s</a>',
			$has ? ' nav__item--parent' : '',
			$current ? ' active' : '',
			esc_url($i->url),
			$current ? ' aria-current="page"' : '',
			$i->target ? ' target="_blank" rel="noopener noreferrer"' : '',
			esc_html($i->title),
			$has ? tbn_icon('chevron', 16) : ''
		);
		if ($has) {
			echo '<ul class="nav__sub">';
			foreach ($node['children'] as $c) {
				printf('<li><a class="nav__sublink" href="%s"%s>%s</a></li>', esc_url($c['url']), $c['target'] ? ' target="_blank" rel="noopener noreferrer"' : '', esc_html($c['title']));
			}
			echo '</ul>';
		}
		echo '</li>';
	}
	echo '</ul>';
}

// Flat list of links (footer menus).
function tbn_flat_menu(string $location): void {
	foreach (tbn_menu_items($location) as $i) {
		if ($i->menu_item_parent) {
			continue;
		}
		$external = $i->target || !str_starts_with($i->url, home_url());
		printf('<li><a href="%s"%s>%s</a></li>', esc_url($i->url), $external ? ' target="_blank" rel="noopener noreferrer"' : '', esc_html($i->title));
	}
}
