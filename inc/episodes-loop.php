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
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if (has_post_thumbnail()) : ?>
		<div class="loop-episodes_episode_img">
			<a href="<?php the_permalink(); ?>">
				<img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'tympanum-m') ?>" class="wp-post-image" srcset="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'tympanum-s') ?> 165w, <?php echo get_the_post_thumbnail_url(get_the_ID(), 'tympanum-m') ?> 360w" sizes="(max-width: 768px) 157.5px, 281.25px" />
			</a>
		</div>
	<?php endif; ?>
	<div class="loop-episodes_episode_data">
		<?php if (!is_archive('podcast') && wp_get_post_terms($post->ID, 'podcast')[0]->term_id) : ?>
			<a href="<?php echo get_term_link(wp_get_post_terms($post->ID, 'podcast')[0]->term_id, 'podcast'); ?>" class="loop-episodes_episode_podcast"><?php echo wp_get_post_terms($post->ID, 'podcast')[0]->name; ?></a>
		<?php endif; ?>
		<a href="<?php the_permalink(); ?>" class="loop-episodes_episode_title">
			<h3><?php the_title(); ?></h3>
		</a>
		<p class="loop-episodes_episode_date"><?php echo get_the_date(); ?></p>
	</div>
</article>