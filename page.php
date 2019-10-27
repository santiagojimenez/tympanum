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
<div class="single-post-page">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php get_template_part('inc/single-loop'); ?>
		<?php endwhile;
		else : ?>
		<h1><?php echo __('Lo lamento, nada he hallado.', 'tympanum'); ?></h1>
	<?php endif; ?>
</div>
<?php get_footer(); ?>