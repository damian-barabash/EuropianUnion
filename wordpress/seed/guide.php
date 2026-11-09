<?php
/**
 * Private page "How to edit the site" — the written guide for the project team.
 * Run: wp eval-file ~/tbn-seed/guide.php
 */

$html = <<<'HTML'
<p>This guide is for the TransBioNet team. You only need a web browser: log in at <strong>transbionet.eu/wp-admin</strong>. This page is private — visitors never see it.</p>

<h2>1. Where things are</h2>
<table>
<tr><th>Menu on the left</th><th>What it is for</th></tr>
<tr><td><strong>Enquiries</strong></td><td>Messages sent through the contact form. The number shows how many are new.</td></tr>
<tr><td><strong>Site settings</strong></td><td>E-mail, social media, EU emblem wording and disclaimer, bar above the header, contact form topics, Open Call steps, cookies and Google Tag Manager.</td></tr>
<tr><td><strong>News</strong></td><td>News, press releases and articles.</td></tr>
<tr><td><strong>Events</strong></td><td>Info days, workshops, conferences.</td></tr>
<tr><td><strong>Open Calls</strong></td><td>Funding calls with dates, budget and documents.</td></tr>
<tr><td><strong>Partners</strong></td><td>Consortium members: logo, country, description, links.</td></tr>
<tr><td><strong>Resources</strong></td><td>Documents, deliverables, promotional materials and videos.</td></tr>
<tr><td><strong>Pages</strong></td><td>Home, About, Contact and all other pages, built from sections.</td></tr>
<tr><td><strong>Appearance → Menus</strong></td><td>Links in the header and the footer.</td></tr>
</table>

<h2>2. Adding news</h2>
<ol>
<li><strong>News → Add news.</strong> Type the title.</li>
<li>Write the text. Press <strong>+</strong> to add a heading, list, image, file, table or YouTube video (paste the YouTube link on an empty line).</li>
<li>On the right: choose the <strong>category</strong> (News, Press release or Article), set the <strong>image</strong> (at least 1920 × 1280 px, 3:2; keep important things in the middle) and write the <strong>excerpt</strong> — two sentences shown on the card and under the title.</li>
<li>Press <strong>Publish</strong>. The news appears on the News page and the three newest on the home page.</li>
</ol>

<h2>3. Adding a partner</h2>
<ol>
<li><strong>Partners → Add partner.</strong> The title is the name visitors see; partners are sorted by it.</li>
<li>Upload the <strong>logo</strong> (PNG or WebP with transparent background, cropped to the edges). If it looks too large or small next to the others, change <strong>Logo size</strong> (e.g. 0.8 or 1.3).</li>
<li>Fill in country, type, legal name, website, LinkedIn, role and description. Press <strong>Publish</strong>.</li>
</ol>
<p>The partner appears automatically on the Partners page, in the Partners drop-down menu and among the logos on the home page.</p>

<h2>4. Adding a document or video</h2>
<ol>
<li><strong>Resources → Add resource.</strong> Type the title.</li>
<li>Choose <strong>Uploaded file</strong>, <strong>Video</strong> (YouTube or Vimeo link) or <strong>Link to another site</strong>.</li>
<li>On the right tick the <strong>type</strong>: Document, Deliverable, Promo material or Video. Press <strong>Publish</strong>.</li>
</ol>
<p>Documents are listed on the Resources page with a filter by type; videos in the Videos section. File size and format are shown automatically. To show a document on an Open Call, pick it in the call's "Documents of this call" field.</p>

<h2>5. Events and Open Calls</h2>
<p><strong>Events → Add event:</strong> title, text, image, and on the right date, time, place, format and registration link. Past events move to "Past events" by themselves. Tick "Info session about Open Calls" to also list it on the Open Calls page.</p>
<p><strong>Open Calls → Add Open Call:</strong> title, excerpt (short summary), text, and on the right the dates, budget, funding per project and application system link. The status (Opens soon / Open / Closed), the days left and the progress bar follow the dates automatically. The "Apply" button appears only while the call is open and the link is filled in. Below the text: documents and questions with answers.</p>
<p>The Open Calls, Events and Digital Platform pages are drafts for now. To show them: Pages → open the page → <strong>Publish</strong>, then add it to the menu (Appearance → Menus) and un-hide the matching section on the home page.</p>

<h2>6. Editing pages and sections</h2>
<p>Every page is built from <strong>sections</strong>, from top to bottom: Hero, Numbers, Photo to the edge + text, Columns, Text, Latest news, Open Calls list, Events list, Partner logos, Documents, Videos, Steps, Timeline, Questions and answers, People, Call to action band, Contact form, and more.</p>
<ul>
<li><strong>Change text or a photo:</strong> open the page, click the section, edit, press <strong>Update</strong>.</li>
<li><strong>Add a section:</strong> "Add section" at the bottom (or the + on a section to add one above it).</li>
<li><strong>Reorder:</strong> drag the section by its number.</li>
<li><strong>Hide without deleting:</strong> switch on "Hide this section".</li>
<li><strong>Page header:</strong> the title and the lead under it are at the top of the page form.</li>
</ul>
<p>Photo sizes: hero and photos to the edge at least 2560 × 1600 px; photos next to text at least 1400 × 1000 px. WordPress makes smaller versions for phones itself.</p>

<h2>7. Enquiries from the contact form</h2>
<p>Messages are not e-mailed — they wait in <strong>Enquiries</strong>. New ones are marked "New". Open one to read it (it is then marked as read), use <strong>Reply by e-mail</strong> to answer from your mail program, and <strong>Download all as CSV</strong> to get a table for Excel. People who ticked "news and updates" have "Yes" in the News column.</p>
<p>Personal data: delete enquiries you no longer need. If someone asks for their data to be removed, use <strong>Tools → Erase Personal Data</strong> with their e-mail — their enquiries are deleted.</p>

<h2>8. Menus, footer, cookie banner</h2>
<ul>
<li><strong>Appearance → Menus:</strong> "Main menu" (header), "Footer menu" and "Legal links". The Partners drop-down fills itself.</li>
<li><strong>Site settings:</strong> project e-mail and social links (a profile without an address is shown as plain text), EU disclaimer, the bar above the header (e.g. "Open Call 1 is open until…"), contact form topics, cookie banner text, Google Tag Manager ID.</li>
<li>Google Analytics 4 runs through Google Tag Manager and starts only after a visitor clicks "Accept all".</li>
</ul>

<h2>9. Good habits</h2>
<ul>
<li>Give every image a short <strong>alternative text</strong> (Media → click the image → "Alternative text") — needed for accessibility.</li>
<li>Upload PDFs that are readable on screen; send a link to the source document if a PDF is scanned.</li>
<li>Do not install plugins or change the theme — ask the website administrator first.</li>
<li>Logos of the EU emblem and the disclaimer must stay in the header and footer (Horizon Europe rules).</li>
</ul>
HTML;

$found = get_page_by_path('how-to-edit-the-site', OBJECT, 'page');
$data = ['post_type' => 'page', 'post_name' => 'how-to-edit-the-site', 'post_title' => 'How to edit the site', 'post_status' => 'private', 'menu_order' => 99];
if ($found) {
	$data['ID'] = $found->ID;
}
$id = $found ? wp_update_post($data) : wp_insert_post($data);
update_field('header_lead', 'A short guide for the project team: news, partners, documents, pages, enquiries.', $id);
update_field('sections', [['acf_fc_layout' => 'text', 'content' => $html]], $id);
WP_CLI::success("Guide page $id");
