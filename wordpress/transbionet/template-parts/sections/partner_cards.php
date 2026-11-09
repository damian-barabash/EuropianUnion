<?php $partners = tbn_partners(); if (!$partners) { return; } ?>
<section class="section">
	<div class="container">
		<div class="grid grid--4"><?php foreach ($partners as $p) { tbn_partner_card($p); } ?></div>
	</div>
</section>
