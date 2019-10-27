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
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body <?php body_class() ?>>
	<header id="masthead" class="site-header" role="banner">
		<div class="site-header_menu-btn"></div>
		<div class="site-header_brand">
			<?php if (get_custom_logo()) echo get_custom_logo(); ?>
			<a href="<?php echo esc_url(home_url()) ?>" class="site-header_brand_title">
				<?php if (is_home()) {
					echo '<h1>' . bloginfo('name') . '</h1>';
				} else {
					bloginfo('name');
				} ?>
			</a>
		</div>
		<div class="site-header_search">
			<div class="site-header_search_btn"></div>
			<div class="site-header_form">
				<div class="site-header_form_btn"></div>
				<?php get_search_form(); ?>
			</div>
		</div>
	</header>
	<nav class="site-nav">
		<div class="site-nav_wrap">
			<div class="site-nav_container">
				<div class="site-nav_title">
					<a href="<?php echo esc_url(home_url()) ?>">
						<p><?php echo bloginfo('name') ?></p>
					</a>
				</div>
				<div class="site-nav_menu">
					<?php wp_nav_menu(array('theme_location' => 'tympanum_header_menu')); ?>
				</div>
			</div>
		</div>
	</nav>
	<main id="main" class="site-main" role="main">