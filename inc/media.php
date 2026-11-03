<?php
/**
 * Media things.
 *
 * @package Hoverboard
 */

/**
 * Downsize huge images.
 *
 * @param Object $upload The upload object.
 *
 * @return Object The upload object.
 */
function hb_resize_large_upload( $upload ) {
	$resizable_mimes = array( 'image/jpeg', 'image/png', 'image/webp' );
	if ( ! in_array( $upload['type'], $resizable_mimes, true ) ) {
		return $upload;
	}

	$max_dimension = 2000;
	$file_path     = $upload['file'];

	$editor = wp_get_image_editor( $file_path );
	if ( is_wp_error( $editor ) ) {
		return $upload;
	}

	$size = $editor->get_size();
	if ( ! $size || ( $size['width'] <= $max_dimension && $size['height'] <= $max_dimension ) ) {
		return $upload;
	}

	$editor->resize( $max_dimension, $max_dimension, false );
	$editor->set_quality( 82 );
	$editor->save( $file_path );

	clearstatcache();

	return $upload;
}
add_filter( 'wp_handle_upload', 'hb_resize_large_upload' );
