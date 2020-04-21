<?php

/**
 * @category   WP Template: Podcasting
 * @package    Tympanum
 * @author     Santiago Jimenez <sj@sjim.dev>
 * @license    GNU General Public License v3
 * @version    0.2.0
 * @link       https://tympanum.dev
 */


class Tympanum_Episode_Vars
{
	private $episode_id;
	private $episode_audio_attachment;
	private $podcast_id;
	private $podcast_logo_id;

	function __construct($post_id)
	{
		$post = get_post($post_id);
		if ($post) {
			$this->episode_id = $post->ID;
			$this->episode_audio_attachment = get_post_meta($post->ID, 'tympanum_audio_attachment', true);
			$this->podcast_id = wp_get_post_terms($post->ID, 'podcast')[0]->term_id;
			$this->podcast_logo_id = get_term_meta($this->podcast_id, 'tympanum-podcast-logo', true);
		}
	}

	function get_episode_id()
	{
		return $this->episode_id;
	}
	function get_episode_date()
	{
		return get_the_date('', $this->episode_id);
	}
	function get_episode_thumb_full_src()
	{
		return get_the_post_thumbnail_url($this->episode_id, 'full');
	}
	function get_episode_audio_attachment()
	{
		if (ctype_digit($this->episode_audio_attachment)) {
			$int = intval($this->episode_audio_attachment);
			return $int;
		} else {
			return $this->episode_audio_attachment;
		}
	}
	function get_episode_audio_src()
	{
		if (is_int($this->get_episode_audio_attachment())) {
			return wp_get_attachment_url($this->get_episode_audio_attachment());
		} else {
			return $this->get_episode_audio_attachment();
		}
	}
	function get_episode_background()
	{
		if ($this->episode_audio_attachment) {
			return 'style="background-image: url(' . $this->get_episode_thumb_full_src() . ');"';
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
		return wp_get_post_terms($this->episode_id, 'podcast')[0]->name;
	}
	function get_podcast_logo_id()
	{
		return $this->podcast_logo_id;
	}
	function get_podcast_logo_src()
	{
		return wp_get_attachment_image_src($this->podcast_logo_id, 'tympanum-s')[0];
	}
	function get_episode_panel_audio_attachment_message()
	{
		if (is_int($this->get_episode_audio_attachment())) {
			return 'Estás enlazando un audio de <u>tu galería de medios</u>.';
		} else {
			return 'Estás enlazando un audio en un <u>servidor externo</u>.';
		}
	}

	function get_vars()
	{
		$vars = array(
			'episode_id' => $this->get_episode_id(),
			'episode_date_published' => $this->get_episode_date(),
			'episode_thumb_full_src' => $this->get_episode_thumb_full_src(),
			'episode_background' => $this->get_episode_background(),
			'episode_audio_attachment' => $this->get_episode_audio_attachment(),
			'episode_audio_src' => $this->get_episode_audio_src(),
			'podcast_id' => $this->get_podcast_id(),
			'podcast_url' => $this->get_podcast_url(),
			'podcast_title' => $this->get_podcast_title(),
			'podcast_logo_id' => $this->get_podcast_logo_id(),
			'podcast_logo_src' => $this->get_podcast_logo_src(),
			'episode_panel_audio_attachment_message' => $this->get_episode_panel_audio_attachment_message()
		);
		return $vars;
	}
}
//------------------
// FINAL - VARIABLES EPISODIO
//------------------




//Article UTM Link
add_action('load-post.php', 'utm_post_meta_boxes_setup');
add_action('load-post-new.php', 'utm_post_meta_boxes_setup');

function utm_post_meta_boxes_setup()
{
	add_action('add_meta_boxes', 'utm_add_post_meta_boxes');
	add_action('save_post', 'save_meta_box_podcast', 10, 2);
}


function utm_add_post_meta_boxes()
{
	add_meta_box(
		'utm-post-class',
		'Audio del episodio',
		'utm_post_class_meta_box',
		'episode',
		'side',
		'default',
		null
	);
}

function utm_post_class_meta_box($post)
{
	wp_enqueue_media();
	global $post;

	$tympanum_episode_vars = new Tympanum_Episode_Vars($post->ID);
	$tympanum_episode_vars = $tympanum_episode_vars->get_vars();

	$upload_link = esc_url(get_upload_iframe_src('media', $post->ID));
	wp_nonce_field('episode_meta', 'episode_meta_nonce');
	add_thickbox();
	?>
	<input id="tympanum_audio_attachment" name="tympanum_audio_attachment" type="hidden" value="<?php echo $tympanum_episode_vars["episode_audio_src"]; ?>">
	<div>
		<div id="tympanum_audio_preview" class="tympanum_audio_preview">
			<div id="tympanum_audio_intro" <?php if ($tympanum_episode_vars["episode_audio_src"]) echo 'style="display: none;"' ?>>
				<p><?php echo __('Sube un fichero de audio a la biblioteca o pega una URL a un fichero de audio en un servidor externo', 'tympanum'); ?>.</p>
			</div>
			<div id="audio_player" <?php if (!$tympanum_episode_vars["episode_audio_src"]) echo 'style="display: none;"' ?>>
				<audio src="<?php echo $tympanum_episode_vars['episode_audio_src'] ?>" controls>
			</div>
			<h5 id="tympanum_audio_prev" <?php if (!$tympanum_episode_vars["episode_audio_src"]) echo 'style="display: none;"' ?>><?php echo $tympanum_episode_vars["episode_panel_audio_attachment_message"] ?></h5>
		</div>
		<div id="tympanum_audio_inputs" class="tympanum_audio_inputs">
			<p>
				<label class="components-base-control__label" for="utm-post-class"><strong><?php echo __('Audio interno: sube tu fichero de audio', 'tympanum'); ?></strong></label>
			</p>
			<p>
				<a id="audio_upload_iframe_button" class="button" href="<?php echo $upload_link ?>">
					<?php _e('Seleccionar audio', 'tympanum') ?>
				</a>
			</p>
			<hr />
			<p />
			<form class="external-audio-modal-content">
				<p>
					<label for="audio_external_submit"><strong><?php echo __('Audio externo: pega aquí la URL de tu audio', 'tympanum'); ?></strong></label>
				</p>
				<p>
					<input id="audio_external_input" value="" type="url"><input id="audio_external_submit" class="button components-button is-primary" type="submit" value="Validar">
				</p>
				<p id="audio_external_notifications"><?php echo __('Pega una URL directa a un fichero de audio MP3 o OGG', 'tympanum'); ?>.</p>
			</form>
		</div>
	</div>

	<style media="screen">
		.tympanum_audio_preview {}

		.tympanum_audio_inputs {}

		.external-audio-modal-content {
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
		}
	</style>

	<script type="text/javascript">
		jQuery(function($) {

			// External audio
			$(document).ready(function() {
				$("#audio_external_submit").click(function() {
					var value = $('#audio_external_input').val();
					var arr = value.split("?");
					value = arr[0];
					var audio_extension = value.slice(-4);
					if (audio_extension === '.mp3' || audio_extension === '.ogg') {
						$('#audio_external_notifications').html(<?php echo __('El audio es válido, lo has introducido correctamente', 'tympanum'); ?>.);
						$('#audio_external_notifications').css({
							'background-color': '#eff9f1',
							'padding': '15px 15px 15px 25px',
							'border-left': '3px solid #4ab866',
							'color': '#000',
							'font-size': '13px'
						});
						$('#audio_external').val(value);
						$('.external-audio-modal-wrap').hide();
						$('#tympanum_audio_attachment').val(value);
						$('#tympanum_audio_prev').html(<?php echo __('Estás usando un audio en un servidor <u>externo</u>', 'tympanum'); ?>.);
						$('#audio_external_input').val('');
						$('#audio_player').html('<audio src="' + value + '" controls />');
						$('#tympanum_audio_intro').hide();
						$('#audio_player').show();
						$('#tympanum_audio_prev').show();
					} else {
						$('#audio_external_notifications').html(<?php echo __('El audio no es válido, vuelve a intentarlo. Pega una URL directa a un fichero de audio MP3 o OGG', 'tympanum'); ?>.);
						$('#audio_external_notifications').css({
							'background-color': '#FBEAEA',
							'padding': '15px 15px 15px 25px',
							'border-left': '3px solid #DC3232',
							'color': '#000',
							'font-size': '13px'
						});
					}
					return false;
				});
			});

			// Internal audio
			// Set all variables to be used in scope
			var frame;
			var addImgLink = $('#audio_upload_iframe_button');
			var tympanum_audio_attachment = $('#tympanum_audio_attachment');
			var tympanum_audio_prev = $('#tympanum_audio_prev');
			var audio_id = $('#audio_id');
			var audio_external = $('#audio_external');
			var audio_player = $('#audio_player');


			frame = wp.media({
				title: <?php echo __('Sube un audio o elige uno de la biblioteca', 'tympanum'); ?>,
				button: {
					text: <?php echo __('Usar este audio', 'tympanum'); ?>
				},
				library: {
					type: ['audio']
				},
				multiple: false // Set to true to allow multiple files to be selected
			});
			//console.log(wp)
			// When an audio is selected in the media frame...
			frame.on('select', function() {

				// Get media attachment details from the frame state
				var attachment = frame.state().get('selection').first().toJSON();

				// Check type file is audio
				if (attachment.type != 'audio') {
					alert('This file not is file audio');
					return false;
				}

				// Send the attachment ID to our hidden input
				tympanum_audio_attachment.val(attachment.id);

				// Send URL to audio player
				audio_player.val('src', attachment.url);
				audio_player.html('<audio src="' + attachment.url + '" controls />');


				// Send URL to prev (This val not saving in database)
				tympanum_audio_prev.html(<?php echo __('Estás usando un audio en un servidor <u>interno</u>', 'tympanum'); ?>.);

				// Function to converse bps in kbps before send to bitrate container
				function bitrateToKbps() {
					var bitrate = attachment.meta.bitrate;
					bitrate = bitrate.toString();
					bitrate = bitrate.substring(0, bitrate.length - 3); // "12345.0"
					return bitrate;
				}

				$('#tympanum_audio_intro').hide();
				$('#audio_player').show();
				$('#tympanum_audio_prev').show();

			});
			// ADD IMAGE LINK
			$(addImgLink).click(function(event) {
				event.preventDefault();
				// Finally, open the modal on click
				frame.open();
			});

		});
	</script>

<?php }
function save_meta_box_podcast($post_id)
{
	// Bail if we're doing an auto save  
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

	// if our nonce isn't there, or we can't verify it, bail 
	if (!isset($_POST['episode_meta_nonce']) || !wp_verify_nonce($_POST['episode_meta_nonce'], 'episode_meta')) return;

	// if our current user can't edit this post, bail  
	if (!current_user_can('edit_post')) return;

	// Escape if isnt ID
	if (ctype_digit($_POST['tympanum_audio_attachment'])) {
		$tympanum_audio_attachment = $_POST['tympanum_audio_attachment'];
	} else {
		$tympanum_audio_attachment = esc_url($_POST['tympanum_audio_attachment']);
	}

	// Make sure your data is set before trying to save it  
	if (isset($_POST['tympanum_audio_attachment']))
		update_post_meta($post_id, 'tympanum_audio_attachment', $tympanum_audio_attachment);
}
add_action('save_post', 'save_meta_box_podcast');
