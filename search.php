<?php

/**
 * @category   WP Template: Podcasting
 * @package    Tympanum
 * @author     Santiago Jimenez <sj@sjim.dev>
 * @license    GNU General Public License v3
 * @version    0.2.0
 * @link       https://tympanum.dev
 */
get_header();
global $wp_query; ?>
<section class="search-page loop-archive">
	<div class="loop-archive_container">
		<h1 class="loop-archive_title">
			<?php if (get_search_query() != '') : ?>
				<?php
					$num_posts = $wp_query->found_posts;
					$string = __('He encontrado %d coincidencias con la búsqueda', 'tympanum');
					echo sprintf($string, $num_posts);
					echo ': ';
					the_search_query(); ?>
			<?php else : ?>
				<?php echo __('No has introducido ningún criterio de búsqueda. Aquí tienes todas nuestras entradas', 'tympanum'); ?>.
			<?php endif; ?>
		</h1>
		<?php if (have_posts()) : ?>
			<div class="loop-archive_grid">
				<?php while (have_posts()) : the_post(); ?>
					<?php get_template_part('inc/archive-loop'); ?>
				<?php endwhile; ?>
			</div>
			<?php tympanum_navigation(); ?>
		<?php else : ?>
			<h2 class="loop-archive_subtitle">
				<?php echo __('No existen entradas', 'tympanum'); ?>.
			</h2>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>