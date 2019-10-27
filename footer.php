<?php

/**
 * @category   WP Template: Podcasting
 * @package    Tympanum
 * @author     Santiago Jimenez <sj@sjim.dev>
 * @license    GNU General Public License v3
 * @version    0.2.0
 * @link       https://tympanum.dev
 */ ?>
</main>
<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="site-footer_grid">
		<div class="site-footer_menu">
			<?php wp_nav_menu(array('theme_location' => 'tympanum_footer_menu', 'depth' => 1)); ?>
		</div>
		<div class="site-footer_brand">
			<p class="site-footer_site"><?php echo bloginfo('name') ?></p>
			<p class="site-footer_tech"><?php echo __('Basado en Tympanum', 'tympanum'); ?></p>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>

</html>