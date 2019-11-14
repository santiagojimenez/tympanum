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
$tympanum_episode_vars = new Tympanum_Episode_Vars($post->ID);
$tympanum_episode_vars = $tympanum_episode_vars->get_vars();
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="single-episode_wrap">
		<div class="single-episode_background">
			<img src="<?php echo $tympanum_episode_vars["episode_thumb_full_src"]; ?>" alt="">
		</div>
		<div class="single-episode_data">
			<div class="single-episode_data_wrap">
				<div class="single-episode_data_container">
					<h1><?php echo the_title(); ?></h1>
					<?php if ($tympanum_episode_vars["podcast_id"]) : ?>
						<div class="single-episode_podcast">
							<?php if ($tympanum_episode_vars["podcast_logo_id"]) : ?>
								<a href="<?php echo $tympanum_episode_vars["podcast_url"]; ?>" class="single-episode_img">
									<img src="<?php echo $tympanum_episode_vars["podcast_logo_src"]; ?>" alt="" />
								</a>
							<?php endif; ?>
							<a href="<?php echo $tympanum_episode_vars["podcast_url"]; ?>" class="single-episode_name">
								<?php echo $tympanum_episode_vars["podcast_title"]; ?>
							</a>
						</div>
					<?php endif; ?>
					<?php if (has_post_thumbnail()) : ?>
						<div class="single-episode_thumb">
							<img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'tympanum-l') ?>" class="wp-post-image" width="660" height="660" />
						</div>
					<?php endif ?>
					<div class="single-episode_description">
						<div class="date">
							<?php echo $tympanum_episode_vars["episode_date_published"]; ?>
						</div>
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<?php the_content(); ?>
						<?php endwhile;
						endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php if ($tympanum_episode_vars["episode_audio_src"]) : ?>
			<div class="single-episode_player_wrap">
				<div class="single-episode_player_container">
					<?php
						$attr = array(
							'src'       => $tympanum_episode_vars["episode_audio_src"],
							'loop'      => '',
							'autoplay'  => false,
							'preload'   => 'metadata'
						);
						echo wp_audio_shortcode($attr);
						?>
					<div class="single-episode_player_adds">
						<div class="single-episode_player_labels">
							<?php echo the_title(); ?>
							<?php if ($tympanum_episode_vars["podcast_title"]) : ?>
								- <?php echo $tympanum_episode_vars["podcast_title"]; ?>
							<?php endif; ?>
						</div>
						<div class="single-episode_player_text"></div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php if ($tympanum_episode_vars["episode_audio_src"]) : ?>
	<style media="screen">
		.player-container audio {
			opacity: 0;
		}
	</style>
<?php endif; ?>
<?php get_footer(); ?>