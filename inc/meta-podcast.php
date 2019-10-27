<?php

/**
 * @category   WP Template: Podcasting
 * @package    Tympanum
 * @author     Santiago Jimenez <sj@sjim.dev>
 * @license    GNU General Public License v3
 * @version    0.2.0
 * @link       https://tympanum.dev
 */
class Tympanum_Podcast_Vars
{
	private $post_id;
	private $podcast_id;

	function __construct($post_id)
	{
		$post = get_post($post_id);
		if ($post) {
			$this->post_id = $post->ID;
			$this->podcast_id = wp_get_post_terms($post->ID, 'podcast')[0]->term_id;
		}
	}

	function get_podcast_id()
	{
		return $this->podcast_id;
	}

	function get_podcast_url()
	{
		return home_url() . '/podcast/' .  wp_get_post_terms($this->episode_id, 'podcast')[0]->slug;
	}

	function get_podcast_title()
	{
		return wp_get_post_terms($this->post_id, 'podcast')[0]->name;
	}

	function get_podcast_description()
	{
		return term_description($this->podcast_id);
	}

	function get_podcast_twitter()
	{
		return get_term_meta($this->podcast_id, 'tympanum-twitter-url', true);
	}

	function get_podcast_email()
	{
		return get_term_meta($this->podcast_id, 'tympanum-email-contact', true);
	}

	function get_podcast_ext_web()
	{
		return get_term_meta($this->podcast_id, 'tympanum-external-web-page', true);
	}

	function get_podcast_logo_id()
	{
		return get_term_meta($this->podcast_id, 'tympanum-podcast-logo', true);
	}

	function get_podcast_logo_src()
	{
		return wp_get_attachment_image_src($this->get_podcast_logo_id(), 'tympanum-s')[0];
	}

	function get_vars()
	{
		$vars = array(
			'podcast_id' => $this->get_podcast_id(),
			'podcast_url' => $this->get_podcast_url(),
			'podcast_title' => $this->get_podcast_title(),
			'podcast_description' => $this->get_podcast_description(),
			'podcast_twitter' => $this->get_podcast_twitter(),
			'podcast_email' => $this->get_podcast_email(),
			'podcast_ext_web' => $this->get_podcast_ext_web(),
			'podcast_logo_id' => $this->get_podcast_logo_id(),
			'podcast_logo_src' => $this->get_podcast_logo_src(),
		);
		return $vars;
	}
}
