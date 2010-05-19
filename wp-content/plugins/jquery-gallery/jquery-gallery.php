<?php
/*
Plugin Name: jQuery Gallery
Plugin URI: http://adambrill.com
Description: jQuery Galleries are easy
Author: Adam Brill
Author URI: http://adambrill.com/
Version: 1.0
*/

function jQuery_gallery($null, $attr) {
	global $post;
	$attachments = get_children(array(
		'post_parent' => $post->ID,
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => 'ASC',
		'orderby' => 'menu_order ID'
	));
	$lis = array();
	foreach($attachments as $key => $attachment) {
		array_push($lis, '<li>' . wp_get_attachment_link($key, 'thumbnail', false, false) . '</li>');
	}
	$output = '
	<div id="gallery" class="ad-gallery">
		<div class="ad-image-wrapper"></div>
		<div class="ad-controls"></div>
		<div class="ad-nav">
			<div class="ad-thumbs">
				<ul class="ad-thumb-list">
					' . implode('', $lis) . '
				</ul>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	$("div.ad-gallery").adGallery({
		loader_image: "/i/loader.gif",
		slideshow:{enable:false},
		callbacks: {
			init: function() {
				this.preloadAll();
			}
		}
	});
	</script>
	';
	return $output;
}

add_filter('post_gallery', 'jQuery_gallery', 10, 2);

?>