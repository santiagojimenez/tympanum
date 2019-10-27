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
$tympanum_podcast_vars = new Tympanum_Podcast_Vars($post->ID);
$tympanum_podcast_vars = $tympanum_podcast_vars->get_vars();
?>
<div class="single-podcast">

    <div class="single-podcast_data">
        <div class="single-podcast_logo">
            <img src="<?php echo $tympanum_podcast_vars['podcast_logo_src'] ?>" alt="">
        </div>
        <h1 class="single-podcast_title"><?php echo $tympanum_podcast_vars['podcast_title']; ?></h1>
        <div class="single-podcast_description">
            <?php echo $tympanum_podcast_vars['podcast_description']; ?>
        </div>
    </div>

    <div class="single-podcast_external-data">
        <?php if ($tympanum_podcast_vars['podcast_twitter']) : ?>
            <div class="single-podcast_external-data_item">
                <span><?php echo __('Twitter', 'tympanum') ?></span>
                <?php echo $tympanum_podcast_vars['podcast_twitter']; ?>
            </div>
        <?php endif; ?>
        <?php if ($tympanum_podcast_vars['podcast_email']) : ?>
            <div class="single-podcast_external-data_item">
                <span><?php echo __('Email', 'tympanum') ?></span>
                <?php echo $tympanum_podcast_vars['podcast_email']; ?>
            </div>
        <?php endif; ?>
        <?php if ($tympanum_podcast_vars['podcast_ext_web']) : ?>
            <div class="single-podcast_external-data_item">
                <span><?php echo __('Sitio web', 'tympanum') ?></span>
                <?php echo $tympanum_podcast_vars['podcast_ext_web']; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'posts_per_page' => 12,
    'paged' => $paged,
    'post_type' => 'episode',
    'tax_query' => array(
        array(
            'taxonomy' => 'podcast',
            'field'    => 'term-id',
            'terms'    => $tympanum_podcast_vars['podcast_id'],
        ),
    ),
);
$the_query = new WP_Query($args);
if ($the_query->have_posts()) : ?>
    <section class="loop-episodes">
        <div class="loop-episodes_grid">
            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <?php get_template_part('inc/episodes-loop'); ?>
            <?php endwhile; ?>
        </div>
        <?php tympanum_navigation() ?>
    </section>
<?php endif;
wp_reset_postdata(); ?>


<?php get_footer(); ?>