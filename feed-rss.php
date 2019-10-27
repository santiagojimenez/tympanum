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
<?php
header('Content-Type: ' . feed_content_type('rss2') . '; charset=' . get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?' . '>';
$tympanum_episode_vars = new Tympanum_Episode_Vars($post->ID);
$tympanum_episode_vars = $tympanum_episode_vars->get_vars();
$custom_logo_id = get_theme_mod('custom_logo');
if (has_custom_logo()) {
    $custom_logo_src = wp_get_attachment_image_src($custom_logo_id, 'full')[0];
} else {
    $custom_logo_src = get_template_directory_uri() . '/screenshot.png';
}
?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" <?php do_action('rss2_ns'); ?>>
    <channel>
        <title><?php the_title_rss(); ?></title>
        <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
        <link><?php bloginfo_rss('url') ?></link>
        <description><?php bloginfo_rss('description') ?></description>
        <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
        <language>es-ES</language>
        <sy:updatePeriod><?php echo apply_filters('rss_update_period', 'hourly'); ?></sy:updatePeriod>
        <sy:updateFrequency><?php echo apply_filters('rss_update_frequency', '1'); ?></sy:updateFrequency>
        <?php if (have_posts()) : ?>
            <image>
                <url><?php echo $custom_logo_src; ?></url>
                <title><?php the_title_rss(); ?></title>
                <link><?php bloginfo_rss('url') ?></link>
                <width>1200</width>
                <height>900</height>
            </image>
            <?php while (have_posts()) : the_post() ?>
                <item>
                    <title><?php the_title_rss(); ?></title>
                    <link><?php the_permalink_rss(); ?></link>
                    <pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
                    <dc:creator><?php echo wp_get_post_terms($post->ID, 'podcast')[0]->name; ?></dc:creator>
                    <guid isPermaLink="false"><?php the_guid(); ?></guid>
                    <description>
                        <![CDATA[<?php the_excerpt_rss() ?>]]>
                    </description>
                    <content:encoded>
                        <![CDATA[<?php the_content_feed() ?>]]>
                    </content:encoded>
                    <enclosure url="<?php echo $tympanum_episode_vars['episode_audio_src'] ?>" type="audio/mpeg" />
                    <itunes:author><?php echo wp_get_post_terms($post->ID, 'podcast')[0]->name; ?></itunes:author>
                    <itunes:image><?php echo $tympanum_episode_vars['podcast_logo_src'] ?></itunes:image>
                    <?php do_action('rss2_item'); ?>
                </item>
            <?php endwhile; ?>
        <?php endif; ?>
    </channel>
</rss>