<?php

/**
 * @category   WP Template: Podcasting
 * @package    Tympanum
 * @author     Santiago Jimenez <sj@sjim.dev>
 * @license    GNU General Public License v3
 * @version    0.2.0
 * @link       https://tympanum.dev
 */
function tympanum_podcast_editform_termmeta($term)
{
	$twitter_id = get_term_meta($term->term_id, 'tympanum-twitter-url', true);
	$email_contact = get_term_meta($term->term_id, 'tympanum-email-contact', true);
	$web_page = get_term_meta($term->term_id, 'tympanum-external-web-page', true);

	wp_nonce_field('podcast_termmeta', 'podcast_termmeta_nonce'); ?>

	<tr class="form-field tympanum-twitter-url-wrap">
		<th scope="row"><label for="tympanum-twitter-url"><?php echo __('Usuario de Twitter', 'tympanum'); ?></label></th>
		<td>
			<input type="text" id="tympanum-twitter-url" name="tympanum-twitter-url" value="<?php echo sanitize_text_field($twitter_id); ?>" />
		</td>
	</tr>
	<tr class="form-field tympanum-email-contact-wrap">
		<th scope="row"><label for="tympanum-email-contact"><?php echo __('Email', 'tympanum'); ?></label></th>
		<td>
			<input type="text" id="tympanum-email-contact" name="tympanum-email-contact" value="<?php echo sanitize_text_field($email_contact); ?>" />
		</td>
	</tr>
	<tr class="form-field tympanum-external-web-page-wrap">
		<th scope="row"><label for="tympanum-external-web-page"><?php echo __('Sitio web', 'tympanum'); ?></label></th>
		<td>
			<input type="text" id="tympanum-external-web-page" name="tympanum-external-web-page" value="<?php echo sanitize_text_field($web_page); ?>" />
		</td>
	</tr>
	<tr class="form-field tympanum-podcast-logo-wrap">
		<th scope="row"><label for="tympanum-podcast-logo"><?php echo __('Imagen de portada', 'tympanum'); ?></label></th>
		<td>
			<!-- Your image container, which can be manipulated with js -->
			<?php
				// Get WordPress' media upload URL
				$upload_link = esc_url(get_upload_iframe_src('image', $post->ID));
				// See if there's a media id already saved as post meta
				$podcast_img_id = get_post_meta($post->ID, '_podcast_img_id', true);
				// For convenience, see if the array is valid
				$podcast_have_img = get_term_meta($term->term_id, 'tympanum-podcast-logo', true);
				// Get the image src
				$podcast_logo = wp_get_attachment_image_src($podcast_img_id, 'full');
				?>

			<div class="custom-img-container">
				<?php if ($podcast_have_img) : ?>
					<img src="<?php echo wp_get_attachment_image_src($podcast_have_img, 'medium')[0]; ?>" alt="" style="max-width:100%;" />
				<?php endif; ?>
			</div>

			<!-- Your add & remove image links -->
			<div class="hide-if-no-js">
				<a class="button upload-custom-img <?php if ($podcast_have_img) echo 'hidden' ?>" href="<?php echo $upload_link ?>">
					<?php echo __('Selecciona una imagen de portada', 'tympanum'); ?>
				</a>
				<a class="delete delete-custom-img <?php if (!$podcast_have_img) echo 'hidden' ?>" href="#">
					<?php echo __('Eliminar imagen', 'tympanum'); ?>
				</a>
			</div>

			<!-- A hidden input to set and post the chosen image id -->
			<input class="custom-img-id" type="hidden" name="tympanum-podcast-logo" id="tympanum-podcast-logo" value="<?php echo $podcast_have_img; ?>" />

			<script type="text/javascript">
				jQuery(function($) {

					// Set all variables to be used in scope
					var frame,
						metaBox = $('#meta-box-id.postbox'), // Your meta box id here
						addImgLink = $('.upload-custom-img'),
						delImgLink = $('.delete-custom-img'),
						imgContainer = $('.custom-img-container'),
						imgIdInput = $('.custom-img-id');

					// ADD IMAGE LINK
					addImgLink.on('click', function(event) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if (frame) {
							frame.open();
							return;
						}

						// Create a new media frame
						frame = wp.media({
							title: <?php echo __('Selecciona una imagen de portada'); ?>,
							button: {
								text: <?php echo __('Usar esta imagen'); ?>
							},
							library: {
								type: ['image']
							},
							multiple: false // Set to true to allow multiple files to be selected
						});


						// When an image is selected in the media frame...
						frame.on('select', function() {

							// Get media attachment details from the frame state
							var attachment = frame.state().get('selection').first().toJSON();

							// Send the attachment URL to our custom image input field.
							imgContainer.append('<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>');

							// Send the attachment id to our hidden input
							imgIdInput.val(attachment.id);

							// Hide the add image link
							addImgLink.addClass('hidden');

							// Unhide the remove image link
							delImgLink.removeClass('hidden');
						});

						// Finally, open the modal on click
						frame.open();
					});


					// DELETE IMAGE LINK
					delImgLink.on('click', function(event) {

						event.preventDefault();

						// Clear out the preview image
						imgContainer.html('');

						// Un-hide the add image link
						addImgLink.removeClass('hidden');

						// Hide the delete image link
						delImgLink.addClass('hidden');

						// Delete the image id from the hidden input
						imgIdInput.val('');

					});

				});
			</script>

			<?php wp_enqueue_media() ?>

		</td>
	</tr>


<?php
}
add_action('podcast_edit_form_fields', 'tympanum_podcast_editform_termmeta');


function tympanum_edit_podcast_fields_save_data($term_id)
{
	if (!isset($_POST['podcast_termmeta_nonce'])) {
		return $term_id;
	}
	$nonce = $_POST['podcast_termmeta_nonce'];

	if (!wp_verify_nonce($nonce, 'podcast_termmeta')) {
		return $term_id;
	}

	$old_twitter_id = get_term_meta($term_id, 'tympanum-twitter-url', true);
	$old_email_contact = get_term_meta($term_id, 'tympanum-email-contact', true);
	$old_web_page = get_term_meta($term_id, 'tympanum-external-web-page', true);
	$old_podcast_logo = get_term_meta($term_id, 'tympanum-podcast-logo', true);

	$twitter_id = sanitize_text_field($_POST['tympanum-twitter-url']);
	$email_contact = sanitize_text_field($_POST['tympanum-email-contact']);
	$web_page = sanitize_text_field($_POST['tympanum-external-web-page']);
	$podcast_logo = sanitize_text_field($_POST['tympanum-podcast-logo']);

	update_term_meta($term_id, 'tympanum-twitter-url', $twitter_id, $old_twitter_id);
	update_term_meta($term_id, 'tympanum-email-contact', $email_contact, $old_email_contact);
	update_term_meta($term_id, 'tympanum-external-web-page', $web_page, $old_web_page);
	update_term_meta($term_id, 'tympanum-podcast-logo', $podcast_logo, $old_podcast_logo);
}
add_action('edit_podcast', 'tympanum_edit_podcast_fields_save_data');
