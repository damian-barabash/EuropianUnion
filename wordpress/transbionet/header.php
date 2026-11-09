<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main">Skip to content</a>
<?php
$tbn_announce = tbn_option('announce_show') ? tbn_option('announce_text') : '';
if ($tbn_announce) :
	$tbn_link = tbn_option('announce_link');
	?>
	<div class="announce">
		<div class="container announce__in">
			<span><?php echo esc_html($tbn_announce); ?></span>
			<?php if (!empty($tbn_link['url'])) : ?><a href="<?php echo esc_url($tbn_link['url']); ?>"><?php echo esc_html($tbn_link['title'] ?: 'Read more'); ?></a><?php endif; ?>
		</div>
	</div>
<?php endif; ?>
<header class="header">
	<div class="container header__in">
		<div class="header__brand">
			<a href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name') . ' — home'); ?>"><?php echo tbn_logo(); ?></a>
			<span class="header__sep" aria-hidden="true"></span>
			<?php echo tbn_eu_emblem(); ?>
		</div>
		<button class="header__burger" type="button" aria-expanded="false" aria-controls="main-nav">
			<span class="header__burger-open"><?php echo tbn_icon('menu', 24); ?></span>
			<span class="header__burger-close"><?php echo tbn_icon('close', 24); ?></span>
			<span class="sr-only">Menu</span>
		</button>
		<nav id="main-nav" class="nav" aria-label="Main">
			<?php tbn_primary_menu(); ?>
		</nav>
	</div>
</header>
<main id="main">
