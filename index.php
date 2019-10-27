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
<div class="cnt">
	<?php if (have_posts()) : ?>
		<div class="row">
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('inc/episodes-loop'); ?>
			<?php endwhile; ?>
		</div>
		<div class="row">
			<div class="col">
				<?php the_posts_pagination(array(
						'mid_size' => 2,
						'prev_text' => __('Anterior', 'tympanum'),
						'next_text' => __('Siguiente', 'tympanum'),
					)); ?>
			</div>
		</div>
	<?php endif; ?>
</div>
<?php get_footer(); ?>