</main>
<footer class="footer">
	<div class="container footer__top">
		<div class="footer__brand">
			<div class="footer__logos">
				<?php echo tbn_logo(true); ?>
				<span class="footer__sep" aria-hidden="true"></span>
				<?php echo tbn_eu_emblem(true); ?>
			</div>
			<?php if ($tbn_disclaimer = tbn_option('disclaimer')) : ?><p><?php echo esc_html($tbn_disclaimer); ?></p><?php endif; ?>
		</div>
		<nav aria-label="Footer">
			<ul class="footer__menu">
				<?php tbn_flat_menu('footer'); ?>
				<?php tbn_flat_menu('legal'); ?>
				<li><button class="footer__cookies" type="button" data-cookie-settings>Cookie settings</button></li>
			</ul>
		</nav>
	</div>
	<div class="container footer__bottom">
		<span>Copyright <?php echo esc_html(wp_date('Y')); ?> | <?php echo esc_html(get_bloginfo('name')); ?></span>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
