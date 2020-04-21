<?php

/**
 * @category   WP Template: Podcasting
 * @package    Tympanum
 * @author     Santiago Jimenez <sj@sjim.dev>
 * @license    GNU General Public License v3
 * @version    0.2.0
 * @link       https://tympanum.dev
 */

function tympanum_podcast_addform_termmeta()
{
	wp_nonce_field('podcast_termmeta', 'podcast_termmeta_nonce'); ?>

	<div class="">
		<div class="">
			<div class="custom-img-container">

			</div>

			<!-- Your add & remove image links -->
			<div class="hide-if-no-js">
				<a class="button upload-custom-img" href="<?php echo $upload_link ?>"><?php echo __('Selecciona una imagen de portada', 'tympanum'); ?>
				</a>
				<a class="delete delete-custom-img hidden" href="#"><?php echo __('Eliminar imagen', 'tympanum'); ?>
				</a>
			</div>

			<!-- A hidden input to set and post the chosen image id -->
			<input type="hidden" class="custom-img-id" name="tympanum-podcast-logo" id="tympanum-podcast-logo" value="" />

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
							title: 'Selecciona una imagen como portada del podcast',
							button: {
								text: 'Usar esta imagen'
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

		</div>
	</div>
	<div class="form-field tympanum-twitter-url-wrap">
		<label for="tympanum-twitter-url"><?php echo __('Usuario de Twitter', 'tympanum'); ?></label>
		<input type="text" id="tympanum-twitter-url" name="tympanum-twitter-url" value="" />
	</div>
	<div class="form-field tympanum-email-contact-wrap">
		<label for="tympanum-email-contact"><?php echo __('Email', 'tympanum'); ?></label>
		<input type="text" id="tympanum-email-contact" name="tympanum-email-contact" value="" />
	</div>
	<div class="form-field tympanum-external-web-page-wrap">
		<label for="tympanum-external-web-page"><?php echo __('Sitio web', 'tympanum'); ?></label>
		<input type="text" id="tympanum-external-web-page" name="tympanum-external-web-page" value="" />
	</div>

<?php
}
add_action('podcast_add_form_fields', 'tympanum_podcast_addform_termmeta');


function tympanum_add_podcast_fields_save_data($term_id)
{
	$twitter_id = sanitize_text_field($_POST['tympanum-twitter-url']);
	$email_contact = sanitize_text_field($_POST['tympanum-email-contact']);
	$web_page = sanitize_text_field($_POST['tympanum-external-web-page']);
	$podcast_logo = sanitize_text_field($_POST['tympanum-podcast-logo']);

	update_term_meta($term_id, 'tympanum-twitter-url', $twitter_id);
	update_term_meta($term_id, 'tympanum-email-contact', $email_contact);
	update_term_meta($term_id, 'tympanum-external-web-page', $web_page);
	update_term_meta($term_id, 'tympanum-podcast-logo', $podcast_logo);
}
add_action('create_podcast', 'tympanum_add_podcast_fields_save_data');
