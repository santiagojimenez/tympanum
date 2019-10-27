<?php

/**
 * @category   WP Template: Podcasting
 * @package    Tympanum
 * @author     Santiago Jimenez <sj@sjim.dev>
 * @license    GNU General Public License v3
 * @version    0.2.0
 * @link       https://tympanum.dev
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('loop-archive_item', null); ?>>
	<h2 class="loop-archive_item_title">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h2>
	<p class="loop-archive_item_data">
		<?php if (get_post_type() == 'episode') : ?>
			<span class="loop-archive_item_data_tag"><?php echo __('Podcast', 'tympanum') ?></span> | <?php echo get_the_date(); ?> | <?php the_terms($post->ID, 'podcast', '<span class="podcast">', '', '</span>') ?>
		<?php else : ?>
			<?php echo get_the_date(); ?> | <?php the_category(', '); ?>
		<?php endif; ?>
	</p>
	<div class="loop-archive_item_data_excerpt">
		<?php the_excerpt(); ?>
	</div>
</article>