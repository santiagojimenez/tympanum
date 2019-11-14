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

<?php
$args = array(
	'post_type' => 'episode',
	'posts_per_page' => 1
);
$loop = new WP_Query($args);
if ($loop->have_posts()) : ?>
	<section class="highlight-episode">
		<?php while ($loop->have_posts()) : $loop->the_post() ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<a href="<?php the_permalink(); ?>" class="highlight-episode_image">
					<?php if (has_post_thumbnail()) : ?>
						<img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'tympanum-m') ?>" class="wp-post-image" srcset="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'tympanum-m') ?> 360w, <?php echo get_the_post_thumbnail_url(get_the_ID(), 'tympanum-xl') ?> 1400w" sizes="(max-width: 768px) 360px, 100vw" />
					<?php endif; ?>
				</a>
				<div class="highlight-episode_data">
					<?php if (wp_get_post_terms($post->ID, 'podcast')) : ?>
						<a href="<?php echo get_term_link(wp_get_post_terms($post->ID, 'podcast')[0]->term_id, 'podcast'); ?>" class="highlight-episode_data_podcast"><?php echo wp_get_post_terms($post->ID, 'podcast')[0]->name; ?></a>
					<?php endif; ?>
					<a href="<?php the_permalink(); ?>" class="highlight-episode_data_title">
						<h3><?php the_title(); ?></h3>
					</a>
					<p class="highlight-episode_data_date"><?php echo get_the_date(); ?></p>
				</div>
			</article>
		<?php endwhile;
			wp_reset_postdata(); ?>
	</section>
<?php endif;  ?>

<?php
$args = array(
	'post_type' => 'episode',
	'offset' => -1,
);
$loop = new WP_Query($args);
if ($loop->have_posts()) : ?>
	<section class="loop-episodes">
		<div class="loop-episodes_grid">
			<?php while ($loop->have_posts()) : $loop->the_post() ?>
				<?php get_template_part('inc/episodes-loop'); ?>
			<?php endwhile;
				wp_reset_postdata(); ?>
		</div>
	</section>
<?php endif; ?>

<?php
$taxonomy = 'podcast';
$args = array(
	'taxonomy'               => $taxonomy,
	'orderby'                => 'name',
	'order'                  => 'ASC',
	'hide_empty'             => true
);
$loop = new WP_Term_Query($args);
if (count($loop->get_terms()) > 1) : ?>
	<section class="loop-podcasts">
		<h2 class="loop-podcast_title"><?php echo __('Podcasts', 'tympanum') ?></h2>
		<div class="loop-podcasts_grid">
			<?php foreach ($loop->get_terms() as $term_single) : ?>
				<?php
						$podcast_img_id = get_term_meta($term_single->term_id, 'tympanum-podcast-logo', true);
						$podcast_logo = wp_get_attachment_image_src($podcast_img_id, 'tympanum-s')[0];
						?>
				<div class="loop-podcasts_podcast">
					<?php if ($podcast_img_id) : ?>
						<a href="<?php echo get_term_link($term_single, $taxonomy); ?>" class="loop-podcasts_podcast_img">
							<img src="<?php echo $podcast_logo; ?>" alt="">
						</a>
					<?php endif; ?>
					<a href="<?php echo get_term_link($term_single, $taxonomy); ?>" class="loop-podcasts_podcast_name">
						<?php echo $term_single->name; ?>
					</a>
				</div>
			<?php endforeach;
				wp_reset_postdata(); ?>
		</div>
	</section>
<?php endif; ?>

<?php
$args = array(
	'post_type' => 'post',
	'posts_per_page' => 1
);
$loop = new WP_Query($args);
if ($loop->have_posts()) : ?>
	<section class="highlight-post">
		<article>
			<h3 class="highlight-post_title">
				<a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<p class="highlight-post_data">
				<?php echo get_the_date(); ?> | <?php the_category(', '); ?>
			</p>
			<div class="highlight-post_excerpt">
				<?php the_excerpt(); ?>
			</div>
		</article>
	</section>
<?php endif;
wp_reset_postdata(); ?>

<?php
$args = array(
	'post_type' => 'post',
	'posts_per_page' => 10,
	'offset' => -1
);
$loop = new WP_Query($args);
if ($loop->have_posts()) : ?>
	<section class="loop-archive">
		<div class="loop-archive_container">
			<div class="loop-archive_grid">
				<?php while ($loop->have_posts()) : $loop->the_post() ?>
					<?php get_template_part('inc/archive-loop') ?>
				<?php endwhile;
					wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_footer(); ?>