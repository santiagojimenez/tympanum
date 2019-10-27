// @category   WP Template: Podcasting
// @package    Tympanum
// @author     Santiago Jimenez <sj@sjim.dev>
// @license    GNU General Public License v3
// @version    0.2.0
// @link       https://tympanum.dev

jQuery(document).ready(function () {

	// Open and close de header menu
	jQuery('.site-header_menu-btn').click(function () {
		jQuery('.site-nav').show();
		jQuery('body').css('overflow', 'hidden');
	});

	jQuery('.site-nav_menu').click(function (event) {
		event.stopPropagation();
	});

	jQuery('.site-nav_wrap').click(function (event) {
		jQuery('.site-nav').hide();
		jQuery('body').removeAttr('style');
	});

	jQuery('.site-header_search_btn').click(function () {
		jQuery('.site-header_form').show();
	});

	jQuery('.site-header_form_btn').click(function () {
		jQuery('.site-header_form').hide();
	});


	// Open and close de info box of episode
	jQuery('.single-episode_player_text').click(function () {
		jQuery('.single-episode_data_wrap').toggleClass('opened');
		jQuery(this).toggleClass('active');
	});
});