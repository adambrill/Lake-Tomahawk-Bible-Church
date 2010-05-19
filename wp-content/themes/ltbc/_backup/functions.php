<?php
/**
 * @package WordPress
 * @subpackage LTBC
 */

function custom_attachment_fields_to_edit($form_fields, $post) {
	if ($post->post_mime_type === 'audio/mpeg') {
		$date = explode(' ', $post->post_date);
		$form_fields['post_date'] = array(
			'label' => __('Date'),
			'value' => $date[0]
		);
	}
	return $form_fields;
}
add_action('attachment_fields_to_edit', 'custom_attachment_fields_to_edit', 1, 2);

function custom_attachment_fields_to_save($form_fields, $post) {
	if (isset($post['post_date'])) {
		$form_fields['post_date'] = $post['post_date'];
	}
	return $form_fields;
}
add_action('attachment_fields_to_save', 'custom_attachment_fields_to_save', 1, 2);

//include("widgets/messages.php");

?>