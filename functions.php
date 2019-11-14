<?php

/**
 * @category   WP Template: Podcasting
 * @package    Tympanum
 * @author     Santiago Jimenez <sj@sjim.dev>
 * @license    GNU General Public License v3
 * @version    0.2.0
 * @link       https://tympanum.dev
 */


if (!isset($content_width)) {
    $content_width = 1170;
}



add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
add_theme_support('automatic-feed-links');
add_theme_support('post-thumbnails');
add_theme_support('custom-logo');



function tympanum_enqueues()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('tympanum-scripts', get_template_directory_uri() . '/js/tympanum-scripts.js', array(), '0.2.0', false);
    wp_enqueue_style('tympanum-styles-mobile', get_template_directory_uri() . '/css/styles_mobile.css', array(), '0.2.0', 'all');
    wp_enqueue_style('tympanum-styles-desktop', get_template_directory_uri() . '/css/styles_desktop.css', array(), '0.2.0', '(min-width: 768px)');
}

add_action('wp_enqueue_scripts', 'tympanum_enqueues');



function tympanum_menus_init()
{
    register_nav_menus(array(
        'tympanum_header_menu' => 'Menú la cabecera.',
        'tympanum_footer_menu' => 'Menú del pie.',
    ));
}

add_action('init', 'tympanum_menus_init');



function tympanum_thumbnails()
{
    add_image_size('tympanum-s', 165, 165, true);
    add_image_size('tympanum-m', 360, 360, true);
    add_image_size('tympanum-l', 660, 660, true);
    add_image_size('tympanum-xl', 1400, 1000, true);
}

add_action('after_setup_theme', 'tympanum_thumbnails');



function tympanum_wp_title($title, $sep)
{
    if (is_feed()) {
        return $title;
    }

    global $page,
        $paged;
    // Add the blog name
    $title .= get_bloginfo('name', 'display');
    // Add the blog description for the home/front page.
    $site_description = get_bloginfo('description', 'display');

    if ($site_description && (is_home() || is_front_page())) {
        $title .= " $sep $site_description";
    }

    // Add a page number if necessary:
    if (($paged >= 2 || $page >= 2) && !is_404()) {
        $title .= " $sep " . 'Page ' . $paged;
    }

    return $title;
}

add_filter('wp_title', 'tympanum_wp_title', 10, 2);



add_action('init', 'tympanum_cpt_episodes');

function tympanum_cpt_episodes()
{
    register_post_type(
        'episode',
        array(
            'menu_position' => 3,
            'menu_icon' => 'dashicons-microphone',
            'labels' => array(
                'name' => 'Podcast',
                'singular_name' => 'Episodio',
                'add_new' => 'Añadir episodio',
                'add_new_item' => 'Añadir episodio',
                'menu_name' => 'Podcasting',
                'name_admin_bar' => 'Episodio',
                'all_items' => 'Todos los episodios',
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array(
                'title',
                'author',
                'editor',
                'thumbnail',
                'excerpt',
            ),
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'podcasts'),
            'taxonomies' => array('podcast, post_tag')
        )
    );
}



// Add our custom permastructures for custom taxonomy and post
add_action('wp_loaded', 'tympanum_add_clinic_permastructure');

function tympanum_add_clinic_permastructure()
{
    global $wp_rewrite;
    add_permastruct('episode', 'podcast/%podcast%/%episode%', false);
}

// Make sure that all links on the site, include the related texonomy terms
add_filter('post_type_link', 'tympanum_recipe_permalinks', 10, 2);

function tympanum_recipe_permalinks($permalink, $post)
{
    if ($post->post_type !== 'episode') {
        return $permalink;
    }

    $terms = get_the_terms($post->ID, 'podcast');

    if (!$terms) {
        return str_replace('%podcast%/', '', $permalink);
    }

    $post_terms = array();

    foreach ($terms as $term) {
        $post_terms[] = $term->slug;
    }

    return str_replace('%podcast%', implode(',', $post_terms), $permalink);
}



add_action('init', 'tympanum_tax_podcast', 0);

function tympanum_tax_podcast()
{
    $labels = array(
        'name' => __('Podcasts', 'tympanum'),
        'singular_name' => __('Podcast', 'tympanum'),
        'search_items' => __('Buscar podcasts', 'tympanum'),
        'all_items' => __('Todos los podcasts', 'tympanum'),
        'parent_item' => __('Podcast padre', 'tympanum'),
        'parent_item_colon' => __('Podcast padre', 'tympanum'),
        'edit_item' => __('Editar podcast', 'tympanum'),
        'update_item' => __('Actualizar podcast', 'tympanum'),
        'add_new_item' => __('Añadir nuevo podcast', 'tympanum'),
        'new_item_name' => __('Nombre de podcast', 'tympanum'),
        'menu_name' => __('Podcasts', 'tympanum'),
    );
    register_taxonomy(
        'podcast',
        'episode',
        array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'podcast'),
        )
    );
}



function content_outside($text_without_content)
{
    $post_object = get_post($post->ID);

    if ($post_object->post_content == '') {
        echo $text_without_content;
    } else {
        echo wp_trim_words($post_object->post_content, 20, '...');
    }
}



function tympanum_custom_rss()
{
    get_template_part('feed', 'rss');
}

remove_all_actions('do_feed_rss2');
add_action('do_feed_rss2', 'tympanum_custom_rss', 10, 1);

function tympanum_add_podcast_feed($qv)
{
    if (isset($qv['feed']) && !isset($qv['post_type'])) {
        $qv['post_type'] = array('post', 'episode');
    }

    return $qv;
}

add_filter('request', 'tympanum_add_podcast_feed');



if (is_admin()) {
    add_filter('dashboard_recent_posts_query_args', 'tympanum_cpt_in_dashboard');

    function tympanum_cpt_in_dashboard($query)
    {
        $post_types = get_post_types();

        if (is_array($query['post_type'])) {
            $query['post_type'] = $post_types;
        } else {
            $temp = $post_types;
            $query['post_type'] = $temp;
        }

        return $query;
    }
}



if (is_admin()) {
    require get_template_directory() . '/inc/meta-podcast-add.php';
    require get_template_directory() . '/inc/meta-podcast-edit.php';
}

require get_template_directory() . '/inc/meta-podcast.php';
require get_template_directory() . '/inc/meta-episodio.php';



function theme_slug_setup()
{
    add_theme_support('title-tag');
}

add_action('after_setup_theme', 'theme_slug_setup');



function tympanum_navigation()
{
    if (get_previous_posts_link() || get_next_posts_link()) : ?>
        <nav class="pagination">
            <?php global $wp_query;
                    $big = 999999999;
                    echo paginate_links(array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'current' => max(1, get_query_var('paged')),
                        'total' => $wp_query->max_num_pages,
                        'type' => 'list'
                    ));
                    ?>
        </nav>
<?php endif;
}
