<?php

/**
 * @category   WP Template: Podcasting
 * @package    Tympanum
 * @author     Santiago Jimenez <sj@sjim.dev>
 * @license    GNU General Public License v3
 * @version    0.2.0
 * @link       https://tympanum.dev
 */
get_header(); ?>
<section class="archive-page loop-archive">
	<div class="loop-archive_container">
		<h1 class="loop-archive_title">
			<?php echo single_cat_title('', false); ?>
		</h1>
		<?php if (have_posts()) : ?>
			<div class="loop-archive_grid">
				<?php while (have_posts()) : the_post(); ?>
					<?php get_template_part('inc/archive-loop'); ?>
				<?php endwhile; ?>
				<?php tympanum_navigation(); ?>
			</div>
		<?php else : ?>
			<h2 class="loop-archive_subtitle">
				<?php echo __('Lo siento, no existen entradas.', 'tympanum'); ?>
			</h2>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>