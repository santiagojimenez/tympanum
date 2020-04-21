<?php

/**
 * @category   WP Template: Podcasting
 * @package    Tympanum
 * @author     Santiago Jimenez <sj@sjim.dev>
 * @license    GNU General Public License v3
 * @version    0.2.0
 * @link       https://tympanum.dev
 */ ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
		<?php if (!is_page()) : ?>
			<div class="entry-info">
				<p>
					<?php echo get_the_date(); ?> | <?php the_category(', '); ?>
				</p>
			</div>
		<?php endif; ?>
	</header>
	<div class="entry-content">
		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __('Páginas', 'tympanum') . ':',
				'after'  => '</div>',
			)
		);
		?>
	</div>
</article>