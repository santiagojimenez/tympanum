<?php

/**
 * @category   WP Template: Podcasting
 * @package    Tympanum
 * @author     Santiago Jimenez <sj@sjim.dev>
 * @license    GNU General Public License v3
 * @version    0.2.0
 * @link       https://tympanum.dev
 */ ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<input type="search" class="search-form_field" placeholder="<?php echo __('Buscar', 'tympanum'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-form_submit">
		<span class="screen-reader-text"><?php echo __('Buscar', 'tympanum'); ?></span>
	</button>
</form>