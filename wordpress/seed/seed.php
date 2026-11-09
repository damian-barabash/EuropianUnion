<?php
/**
 * First content of transbionet.eu, moved from the React prototype (src/data).
 * Run on the server: wp eval-file ~/tbn-seed/seed.php  (images in ~/tbn-seed/img).
 * Safe to run again: pages, partners, terms and media are found by slug / file name and updated.
 * Pages the client hid for now (Open Calls, Events, Digital Platform) are created as drafts.
 */

if (!function_exists('update_field')) {
	WP_CLI::error('ACF / Secure Custom Fields is not active.');
}

require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

define('SEED_IMG', getenv('HOME') . '/tbn-seed/img/');

/* ---------- helpers ---------- */

function seed_media(string $file, string $alt = ''): int {
	$name = pathinfo($file, PATHINFO_FILENAME);
	$found = get_posts(['post_type' => 'attachment', 'name' => sanitize_title($name), 'numberposts' => 1, 'post_status' => 'inherit']);
	if ($found) {
		return $found[0]->ID;
	}
	$tmp = wp_tempnam($file);
	copy(SEED_IMG . $file, $tmp);
	$id = media_handle_sideload(['name' => basename($file), 'tmp_name' => $tmp], 0, $alt ?: $name);
	if (is_wp_error($id)) {
		WP_CLI::error("$file: " . $id->get_error_message());
	}
	if ($alt) {
		update_post_meta($id, '_wp_attachment_image_alt', $alt);
	}
	WP_CLI::log("media  $file → $id");
	return $id;
}

function seed_post(string $type, string $slug, array $data, array $fields = []): int {
	$found = get_posts(['post_type' => $type, 'name' => $slug, 'numberposts' => 1, 'post_status' => 'any']);
	$data += ['post_type' => $type, 'post_name' => $slug, 'post_status' => 'publish'];
	if ($found) {
		$data['ID'] = $found[0]->ID;
		$id = wp_update_post($data, true);
	} else {
		$id = wp_insert_post($data, true);
	}
	if (is_wp_error($id)) {
		WP_CLI::error("$type $slug: " . $id->get_error_message());
	}
	foreach ($fields as $k => $v) {
		update_field($k, $v, $id);
	}
	WP_CLI::log("$type  $slug → $id ({$data['post_status']})");
	return $id;
}

function seed_page(string $slug, string $title, array $header, array $sections, string $status = 'publish', int $order = 0): int {
	return seed_post('page', $slug, ['post_title' => $title, 'post_status' => $status, 'menu_order' => $order], $header + ['sections' => $sections]);
}

function seed_term(string $tax, string $name, string $slug): int {
	$t = get_term_by('slug', $slug, $tax);
	if ($t) {
		return $t->term_id;
	}
	$r = wp_insert_term($name, $tax, ['slug' => $slug]);
	return is_wp_error($r) ? 0 : $r['term_id'];
}

function link_to(string $url, string $title, bool $blank = false): array {
	return ['url' => $url, 'title' => $title, 'target' => $blank ? '_blank' : ''];
}

$home = home_url('/');

/* ---------- terms ---------- */

$uncat = get_term_by('slug', 'uncategorized', 'category');
if ($uncat) {
	wp_update_term($uncat->term_id, 'category', ['name' => 'News', 'slug' => 'news-item']);
}
seed_term('category', 'News', 'news-item');
seed_term('category', 'Press release', 'press-release');
seed_term('category', 'Article', 'article');
foreach (['Document' => 'document', 'Deliverable' => 'deliverable', 'Promo material' => 'promo-material', 'Video' => 'video'] as $n => $s) {
	seed_term('resource_type', $n, $s);
}

/* ---------- media ---------- */

$img = [
	'hero' => seed_media('hero-main.webp', 'Three researchers in a laboratory discussing a molecular model on a screen'),
	'support' => seed_media('edge-support.webp', 'Three researchers discussing a sample at a laboratory microscope'),
	'platform' => seed_media('edge-platform.webp', 'A researcher at a microscope next to a screen with DNA analysis software'),
	'bench' => seed_media('lab-team-bench.webp', 'Researchers working together at a laboratory bench'),
	'computers' => seed_media('lab-computers.webp', 'Two researchers working at computers in a laboratory'),
	'news_logo' => seed_media('news-transbionet-logo.webp', 'TransBioNet logo'),
];

/* ---------- partners ---------- */

$partners = [
	['accelbio', 'AccelBio', 'Associação AccelBio', 'Portugal', 'Collaborative laboratory', 'Coordinator',
		'Coordinates TransBioNet and leads the assessment toolkit, training academy and selection of open call projects.',
		'accelbio.webp', 1, 'https://accelbio.pt/', 'https://www.linkedin.com/company/colab-accelbio/', [
			'AccelBio is a private non-profit association recognized as a Collaborative Laboratory (CoLAB) by the Portuguese Foundation for Science and Technology.',
			'Based at Biocant Park, in Cantanhede, Portugal, it capitalizes on innovative research from academia and startups, identifying biological targets and platforms with potential to generate new drug candidates. AccelBio provides industry-standard drug discovery capabilities, from target validation to pre-clinical proof of concept, de-risking assets until they are ready for out-licensing or new spin-off companies. AccelBio plays a major role in strengthening Portugal’s biomedical innovation ecosystem, bringing local and international partners together.',
		]],
	['biocant-park', 'Biocant Park', 'Biocant Park, S.A.', 'Portugal', 'Biotechnology park', 'Partner',
		'Leads the European Infrastructure Atlas, mapping specialist research facilities and services for drug discovery.',
		'biocant-park.webp', 1.05, 'https://www.biocant.pt/', 'https://www.linkedin.com/company/biocant-park/', [
			'Biocant Park will lead the implementation of the European Infrastructure Atlas, which will map specialized research facilities and services supporting drug discovery. It will also co-lead communication and dissemination activities, engaging both key stakeholders and the wider public. In addition, Biocant Park will contribute to the development of the Valorisation Toolkit, co-design and deliver modules for the Digital Training Academy, and support the implementation of open calls.',
		]],
	['danish-life-science-cluster', 'Danish Life Science Cluster', 'Foreningen Danish Life Science Cluster', 'Denmark', 'Life sciences cluster', 'Partner',
		'Co-leads policy and ecosystem mapping and stakeholder consultations, connecting the project with Danish expertise and research services.',
		'', 1, '', '', []],
	['eatris', 'EATRIS', 'EATRIS ERIC', 'Netherlands', 'European research infrastructure', 'Partner',
		'Leads the Digital Platform and Community of Practice, bringing together assessment tools, infrastructure information and learning resources.',
		'eatris.webp', 0.8, 'https://eatris.eu', 'https://www.linkedin.com/company/eatris-eric', [
			'EATRIS is the European infrastructure for translational medicine. We bring together resources and services for research communities to translate scientific discoveries into benefits for patients.',
			'We are a non-profit organisation that provides access to a vast array of expertise and facilities from over 175 top-tier academic centres across Europe. We focus on improving and optimising preclinical and early clinical development of drugs, vaccines and diagnostics, and overcome barriers to health innovation.',
			'Our research infrastructure offers a broad range of research services for both academia and industry across various research fields. In addition, we work with public funding agencies, charities and policy makers with tailored actions to help improve the translational research and innovation ecosystem.',
		]],
	['hlsc', 'Health & Life Sciences Cluster (HLSC)', 'Biotehnologichen i Zdraven Klaster', 'Bulgaria', 'Life sciences cluster', 'Partner',
		'Co-leads policy and ecosystem mapping and stakeholder consultations, contributing to training and shared tools.',
		'hlsc.webp', 1.3, 'https://www.biocluster.bg/', 'https://www.linkedin.com/company/lifesciencesbulgaria/', [
			'HLSC (Health & Life Sciences Cluster, Bulgaria) is Bulgaria’s national life-sciences cluster, bringing together universities, research centres, hospitals, startups, technology-transfer organisations, SMEs and established companies across biotechnology, health, personalised medicine and digital health. HLSC connects science, industry and policy, helping innovators access funding, develop cross-border partnerships, validate solutions and engage with European and international networks.',
			'The cluster has practical experience in building inclusive innovation ecosystems through European projects including TransBioNet, OHAMR, C3BG, INNAXE, PRECISEU, VELES, ENACT and BIO-RED. Its work spans biotechnology, health-data ecosystems, personalised medicine, capacity building, technology transfer and the strengthening of innovation in Widening countries.',
			'Within TransBioNet, HLSC co-leads inclusive policy analysis and contributes to ensuring that Widening-country ecosystems are represented in project activities and recommendations. It also supports training, open calls, stakeholder engagement, communication and dissemination. Through its established links with public authorities, academia, healthcare providers and industry, HLSC serves as a first point of contact for organisations in Bulgaria and South-East Europe seeking collaboration, specialised support and pathways to transform research into market-ready biomedical innovation.',
		]],
	['innostars', 'InnoStars', 'InnoStars e.V.', 'Germany', 'Life sciences cluster', 'Partner',
		'Leads communication, dissemination, open calls launch and administration, and the development and adoption of the TransBioNet Charter.',
		'innostars.webp', 1, 'https://www.innostars.org', 'https://www.linkedin.com/company/innostars/', [
			'InnoStars brings together a diverse ecosystem of partners and innovators across Europe, focusing on regions with moderate innovation capacity. Through its network of partner institutions and various innovation programmes supporting start-ups and other ecosystem payers, it has helped drive the development and launch of products, services, and job opportunities across the healthcare value chain. Its mission is to strengthen regional innovation ecosystems, promote entrepreneurship and collaboration, and bridge gaps in healthcare innovation, ultimately enabling people to live longer, healthier lives.',
		]],
	['lithuaniabio', 'LithuaniaBIO', 'Asociacija LithuaniaBIO', 'Lithuania', 'Life sciences and biotechnology association', 'Partner',
		'Leads cross-border secondments and knowledge exchange, connecting Lithuanian innovators and research services with the European network.',
		'lithuaniabio.webp', 1, '', '', []],
];

foreach ($partners as [$slug, $name, $legal, $country, $type, $role, $role_text, $logo, $scale, $web, $li, $desc]) {
	seed_post('partner', $slug, ['post_title' => $name], [
		'partner_logo' => $logo ? seed_media('partners/' . $logo, $name . ' logo') : '',
		'partner_logo_scale' => $scale,
		'partner_role' => $role,
		'partner_country' => $country,
		'partner_type' => $type,
		'partner_legal' => $legal,
		'partner_website' => $web,
		'partner_linkedin' => $li,
		'partner_role_text' => $role_text,
		'partner_description' => $desc ? '<p>' . implode("</p>\n<p>", array_map('esc_html', $desc)) . '</p>' : '',
	]);
}

/* ---------- news ---------- */

$news_id = seed_post('post', 'transbionet-launched', [
	'post_title' => 'TransBioNet launched to bring biomedical research closer to investment',
	'post_date' => '2026-10-22 10:00:00',
	'post_excerpt' => 'A new Horizon Europe project brings together seven partners from six countries to build the first pan-European network of knowledge valorisation intermediaries for drug discovery.',
	'post_content' => "<!-- wp:paragraph -->\n<p>TransBioNet, a new initiative funded by the European Union’s Horizon Europe programme, has been launched to help promising biomedical research across Europe progress towards investment readiness. The nearly €2 million project brings together seven partners from six countries to establish the first pan-European network of knowledge valorisation intermediaries fully dedicated to drug discovery and biomedical innovation.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Coordinated by Associação AccelBio in Portugal, the project will address the translation gap through shared assessment tools, training, cross-border collaboration and two Open Calls supporting early-stage drug discovery projects.</p>\n<!-- /wp:paragraph -->",
	'post_category' => [get_term_by('slug', 'news-item', 'category')->term_id],
]);
set_post_thumbnail($news_id, $img['news_logo']);

/* ---------- pages ---------- */

$pillars = [
	['title' => 'Project assessment', 'text' => 'Shared tools to support more standardised evaluations of early-stage drug discovery projects.'],
	['title' => 'Research infrastructure', 'text' => 'An atlas mapping research infrastructures and services relevant to biomedical translation across Europe.'],
	['title' => 'Skills and collaboration', 'text' => 'Training, peer learning and cross-border secondments to strengthen skills and knowledge exchange among intermediaries.'],
	['title' => 'Open calls', 'text' => 'Mentoring and bootcamps for selected projects, with validation funding planned for the highest-ranked.'],
];
$cta = ['acf_fc_layout' => 'cta', 'title' => 'Have a question about the project?', 'text' => 'Write to us about the project, future open calls or opportunities to collaborate.', 'button' => link_to($home . 'contact/', 'Contact us')];

$front = seed_page('home', 'Home', ['header_hide' => 1], [
	['acf_fc_layout' => 'hero', 'title' => 'Bringing biomedical discoveries closer to investment',
		'text' => 'TransBioNet connects researchers, start-ups and innovation support organisations across Europe to help promising drug discovery projects move towards investment readiness. Through shared assessment tools, training and access to specialist expertise and research infrastructure, we help teams identify their next steps and prepare for further development.',
		'button' => link_to($home . 'about/', 'Discover more'), 'image' => $img['hero']],
	['acf_fc_layout' => 'facts', 'items' => [
		['value' => '€1.96M', 'label' => 'Total project budget'],
		['value' => '7', 'label' => 'Partners in the consortium'],
		['value' => '6', 'label' => 'Countries involved'],
		['value' => '36', 'label' => 'Months of the project'],
	]],
	['acf_fc_layout' => 'bleed', 'image' => $img['support'], 'title' => 'Support for early-stage drug discovery',
		'text' => '<p>Promising research needs a clear development pathway. TransBioNet helps research teams and innovation support organisations identify what a project needs to progress, access relevant expertise and prepare for further development and investment.</p>',
		'button' => link_to($home . 'about/', 'More about the project')],
	['acf_fc_layout' => 'columns', 'bg' => 'orbs', 'title' => 'How we support innovation', 'items' => $pillars],
	['acf_fc_layout' => 'bleed', 'hide' => 1, 'image_right' => 1, 'image' => $img['platform'], 'title' => 'Digital Platform',
		'text' => '<p>Text about the Digital Platform from the project team.</p>', 'button' => link_to($home . 'digital-platform/', 'Explore the platform')],
	['acf_fc_layout' => 'calls', 'hide' => 1, 'bg' => 'grey', 'show' => 'all', 'title' => 'Open Calls', 'text' => 'Funding opportunities for organisations that want to work with the project.', 'button' => link_to($home . 'open-calls/', 'All Open Calls'), 'empty' => 'The first call will be announced here.'],
	['acf_fc_layout' => 'news', 'bg' => 'orbs', 'title' => 'News', 'count' => 3, 'button' => link_to($home . 'news/', 'Read all news')],
	['acf_fc_layout' => 'events', 'hide' => 1, 'show' => 'upcoming', 'dark' => 1, 'limit' => 3, 'title' => 'Upcoming events', 'text' => 'Info days, workshops and conferences organised by the project or with its participation.', 'button' => link_to($home . 'events/', 'All events')],
	['acf_fc_layout' => 'partner_logos', 'bg' => 'orbs', 'title' => 'Partners', 'text' => '{partners} organisations from {countries} countries work together in the consortium.', 'all_label' => 'Meet the consortium'],
	['acf_fc_layout' => 'talk', 'title' => 'Let’s talk about TransBioNet', 'text' => 'Have a question about the project, future open calls or opportunities to collaborate? Get in touch with our team using the form.'],
], 'publish', 0);

seed_page('about', 'About the project', ['header_lead' => 'TransBioNet, a new initiative funded by the European Union’s Horizon Europe programme, has been launched to help promising biomedical research across Europe progress towards investment readiness. The nearly €2 million project brings together seven partners from six countries to establish the first pan-European network of knowledge valorisation intermediaries fully dedicated to drug discovery and biomedical innovation.'], [
	['acf_fc_layout' => 'media', 'image' => $img['bench'], 'title' => 'From biomedical research to investment readiness', 'text' =>
		'<p>In drug discovery, the gap between laboratory discoveries and marketable therapies is particularly difficult to overcome. According to the European Federation of Pharmaceutical Industries and Associations (EFPIA), bringing a new medicine to market takes on average more than 10 years, with research and development costs often exceeding €3 billion and success rates as low as just one to two compounds for every 10,000 tested. Amid growing competition, Europe’s share of global commercial drug trials fell by 10 percentage points between 2013 and 2023.</p>'
		. '<p>TransBioNet aims to establish the first pan-European network of knowledge valorisation intermediaries fully dedicated to drug discovery and biomedical innovation.</p>'
		. '<p>Coordinated by Associação AccelBio in Portugal, the project will address this translation gap through shared assessment tools, training, cross-border collaboration and two Open Calls supporting early-stage drug discovery projects.</p>'],
	['acf_fc_layout' => 'columns', 'bg' => 'grey', 'title' => 'How we support innovation', 'items' => $pillars],
	$cta,
], 'publish', 1);

seed_page('open-calls', 'Open Calls', ['header_lead' => 'Funding opportunities published by the project. Each call has its own rules, deadline and documents.'], [
	['acf_fc_layout' => 'calls', 'show' => 'current', 'title' => 'Current and upcoming calls', 'empty' => 'The first call will be announced here.'],
	['acf_fc_layout' => 'events', 'show' => 'webinars', 'dark' => 1, 'title' => 'Webinars and info sessions', 'text' => 'Online meetings that explain the rules of the calls and answer applicants’ questions.'],
	['acf_fc_layout' => 'steps', 'bg' => 'grey', 'title' => 'How applying works', 'text' => 'The same four steps apply to every call.', 'items' => [
		['title' => 'Read the call text', 'text' => 'Download the call text and the guide for applicants. Check the eligibility criteria.'],
		['title' => 'Prepare your proposal', 'text' => 'Fill in the proposal template and the budget table.'],
		['title' => 'Apply in the external system', 'text' => 'Submit the proposal and annexes through the application system before the deadline.'],
		['title' => 'Evaluation and results', 'text' => 'Independent experts evaluate the proposals. Applicants are informed by e-mail.'],
	]],
	['acf_fc_layout' => 'calls', 'show' => 'closed', 'title' => 'Closed calls', 'text' => 'Results and documents of finished calls stay available here.', 'hide' => 1],
], 'draft', 2);

seed_page('partners', 'Partners', ['header_lead' => '7 organisations from 6 countries form the project consortium.'], [
	['acf_fc_layout' => 'partner_cards'],
], 'publish', 3);

$news_page = seed_page('news', 'News', ['header_lead' => 'Updates from the project and its partners.'], [], 'publish', 4);

seed_page('events', 'Events', ['header_lead' => 'Info days, workshops and conferences organised by the project or with its participation.'], [
	['acf_fc_layout' => 'events', 'show' => 'upcoming', 'title' => 'Upcoming events', 'empty' => 'No upcoming events right now. New dates will appear here.'],
	['acf_fc_layout' => 'events', 'show' => 'past', 'title' => 'Past events'],
], 'draft', 5);

seed_page('resources', 'Resources', ['header_lead' => 'Documents, public deliverables, promotional materials and videos produced by the project.'], [
	['acf_fc_layout' => 'resources', 'filter' => 1, 'empty' => 'Project documents, public deliverables, promotional materials and videos will be shared here as they become available. Check back for new resources as the project progresses.'],
	['acf_fc_layout' => 'videos', 'bg' => 'grey', 'title' => 'Videos', 'text' => 'Recordings and short films about the project.'],
], 'publish', 6);

seed_page('digital-platform', 'Digital Platform', ['header_lead' => 'An online space that will connect the organisations, knowledge and opportunities created by the project.', 'header_badge' => 'In development'], [
	['acf_fc_layout' => 'media', 'image' => $img['computers'], 'title' => 'What the platform will be', 'text' => '<p>Text about the Digital Platform from the project team.</p>'],
	['acf_fc_layout' => 'timeline', 'title' => 'Where we are now', 'items' => [
		['period' => 'Done', 'title' => 'Concept and requirements'],
		['period' => 'In progress', 'title' => 'Platform development'],
		['period' => 'Planned', 'title' => 'Pilot with partners', 'planned' => 1],
		['period' => 'Planned', 'title' => 'Public launch', 'planned' => 1],
	]],
], 'draft', 7);

seed_page('contact', 'Contact', [], [
	['acf_fc_layout' => 'contact', 'title' => 'Contact', 'social_title' => 'Follow the project', 'form_title' => 'Send a message'],
], 'publish', 8);

$cookie_text = <<<HTML
<p>This page explains which cookies and similar technologies the TransBioNet website uses and how you can control them.</p>
<h2>Necessary storage</h2>
<p>The website stores your cookie choice in your browser (local storage, key <code>cookie-consent</code>) so that the banner does not appear on every page. It contains no personal data and stays until you clear your browser data.</p>
<h2>Analytics cookies (only with your consent)</h2>
<p>If you click “Accept all”, we load Google Tag Manager and Google Analytics 4 to understand how the website is used (pages visited, approximate location, device type). Google Analytics sets the cookies <code>_ga</code> and <code>_ga_*</code>, kept for up to 2 years. The data is processed by Google Ireland Limited. If you choose “Only necessary”, these tools are not loaded.</p>
<h2>Embedded videos</h2>
<p>Videos from YouTube or Vimeo are loaded only after you click play. From that moment the video provider may set its own cookies.</p>
<h2>Changing your choice</h2>
<p>You can change or withdraw your consent at any time with the “Cookie settings” link in the footer, or by deleting cookies in your browser settings.</p>
<h2>Contact</h2>
<p>Questions about this policy: <a href="mailto:info@transbionet.eu">info@transbionet.eu</a>. More about how personal data is handled: <a href="https://innostars.org/privacy-notice/" target="_blank" rel="noopener">privacy notice</a>.</p>
HTML;
seed_page('cookie-policy', 'Cookie policy', [], [['acf_fc_layout' => 'text', 'content' => $cookie_text]], 'publish', 20);

$a11y = <<<HTML
<p>The TransBioNet project is committed to making its website accessible, in line with the Web Content Accessibility Guidelines (WCAG) 2.1, level AA.</p>
<h2>What we have done</h2>
<ul><li>Text and buttons have sufficient colour contrast.</li><li>All pages can be used with a keyboard; a “Skip to content” link is the first element on every page.</li><li>Images have text alternatives; decorative images are hidden from screen readers.</li><li>Videos load only on request and can be played with the keyboard.</li><li>Animations are switched off when your system asks for reduced motion.</li></ul>
<h2>Known limitations</h2>
<p>Some documents published as PDF files may not be fully accessible. If you need a document in another format, write to us.</p>
<h2>Feedback</h2>
<p>If you find a problem with the accessibility of this website, please contact us at <a href="mailto:info@transbionet.eu">info@transbionet.eu</a>. We will reply as soon as possible.</p>
<p>This statement was prepared on [date].</p>
HTML;
seed_page('accessibility', 'Accessibility statement', [], [['acf_fc_layout' => 'text', 'content' => $a11y]], 'draft', 21);

/* ---------- reading settings ---------- */

update_option('show_on_front', 'page');
update_option('page_on_front', $front);
update_option('page_for_posts', $news_page);

/* ---------- site settings ---------- */

$opt = [
	'eu_label' => 'Funded by',
	'disclaimer' => 'This project has received funding from the European Union’s Horizon Europe research and innovation programme under grant agreement No. 101291691. Views and opinions expressed are however those of the author(s) only and do not necessarily reflect those of the European Union or European Research Executive Agency (REA). Neither the European Union nor the granting authority can be held responsible for them.',
	'email' => 'info@transbionet.eu',
	'privacy_url' => 'https://innostars.org/privacy-notice/',
	'social' => [['label' => 'LinkedIn', 'url' => ''], ['label' => 'YouTube', 'url' => ''], ['label' => 'X', 'url' => '']],
	'announce_show' => 0,
	'announce_text' => '',
	'form_topics' => "General enquiry\nOpen calls\nCollaboration\nTraining and community\nMedia enquiry",
	'form_org_types' => "Start-up\nSME\nLarge company\nUniversity or research centre\nInnovation support organisation\nResearch infrastructure or service provider\nPublic body\nInvestor\nOther",
	'form_done' => 'Thank you. We will reply to the e-mail address you gave us.',
	'call_steps' => [
		['title' => 'Read the call text', 'text' => 'Download the call text and the guide for applicants. Check the eligibility criteria.'],
		['title' => 'Prepare your proposal', 'text' => 'Fill in the proposal template and the budget table.'],
		['title' => 'Apply in the external system', 'text' => 'Submit the proposal and annexes through the application system before the deadline.'],
		['title' => 'Evaluation and results', 'text' => 'Independent experts evaluate the proposals. Applicants are informed by e-mail.'],
	],
	'gtm_id' => 'GTM-MRXQBPN7',
	'cookie_title' => 'We use cookies',
	'cookie_text' => 'Necessary cookies keep the site working. With your consent we also use analytics cookies to improve it.',
];
foreach ($opt as $k => $v) {
	update_field($k, $v, 'option');
}
WP_CLI::log('settings saved');

/* ---------- menus ---------- */

function seed_menu(string $name, string $location, array $items): void {
	$menu = wp_get_nav_menu_object($name);
	$id = $menu ? $menu->term_id : wp_create_nav_menu($name);
	foreach (wp_get_nav_menu_items($id) ?: [] as $old) {
		wp_delete_post($old->ID, true);
	}
	foreach ($items as $i => $it) {
		$args = ['menu-item-title' => $it[0], 'menu-item-status' => 'publish', 'menu-item-position' => $i + 1];
		if (is_int($it[1])) {
			$args += ['menu-item-object' => 'page', 'menu-item-object-id' => $it[1], 'menu-item-type' => 'post_type'];
		} else {
			$args += ['menu-item-url' => $it[1], 'menu-item-type' => 'custom', 'menu-item-target' => $it[2] ?? ''];
		}
		wp_update_nav_menu_item($id, 0, $args);
	}
	$loc = get_theme_mod('nav_menu_locations', []);
	$loc[$location] = $id;
	set_theme_mod('nav_menu_locations', $loc);
	WP_CLI::log("menu  $name: " . count($items) . ' items');
}

$p = fn ($slug) => get_page_by_path($slug)->ID;
seed_menu('Main menu', 'primary', [['About', $p('about')], ['Partners', $p('partners')], ['News', $p('news')], ['Resources', $p('resources')], ['Contact', $p('contact')]]);
seed_menu('Footer menu', 'footer', [['About the project', $p('about')], ['Partners', $p('partners')], ['News', $p('news')], ['Resources', $p('resources')], ['Contact', $p('contact')]]);
seed_menu('Legal links', 'legal', [['Privacy Notice', 'https://innostars.org/privacy-notice/', '_blank'], ['Cookie policy', $p('cookie-policy')]]);

flush_rewrite_rules();
WP_CLI::success('Seed done.');
