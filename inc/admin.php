<?php
/**
 * Admin Tweaks.
 *
 * @package hb_server
 */

/**
 * Add support email to Admin Footer.
 */
function tmm_custom_admin_footer_text() {
	echo 'Questions? Stuck? Email <a href="mailto:hi@hoverboardstudios.com">hi@hoverboardstudios.com</a>';
}
add_filter( 'admin_footer_text', 'tmm_custom_admin_footer_text' );

/**
 * Add Featured Image Column
 *
 * @param Array $cols columns.
 *
 * @return Array columns.
 */
function tcb_add_post_thumbnail_column( $cols ) {
	$cols['tcb_post_thumb'] = __( 'Image' );
	return $cols;
}

/**
 * Get all post types that support featured images.
 */
function get_post_types_with_thumbnail_support() {
	$post_types = get_post_types();

	foreach ( $post_types as $post_type ) {
		if ( post_type_supports( $post_type, 'thumbnail' ) ) {
			add_filter( 'manage_posts_columns', 'tcb_add_post_thumbnail_column', 5 );
			add_filter( 'manage_pages_columns', 'tcb_add_post_thumbnail_column', 5 );
		}
	}
}
add_action( 'init', 'get_post_types_with_thumbnail_support' );

/**
 * Grab featured-thumbnail size post thumbnail and display it.
 *
 * @param Array $col  Columns.
 */
function tcb_display_post_thumbnail_column( $col ) {
	switch ( $col ) {
		case 'tcb_post_thumb':
			if ( function_exists( 'the_post_thumbnail' ) ) {
				the_post_thumbnail( 'thumbnail' );
			} else {
				echo 'Not supported in theme';
			}
			break;
	}
}
add_action( 'manage_posts_custom_column', 'tcb_display_post_thumbnail_column', 5, 2 );
add_action( 'manage_pages_custom_column', 'tcb_display_post_thumbnail_column', 5, 2 );

/**
 * Add custom styles to admin.
 */
function hb_enqueue_admin_styles() {
	wp_enqueue_style( 'hb-admin-style', HB_SERVER_URL . '/assets/admin-style.css', array(), filemtime( HB_SERVER_DIR . '/assets/admin-style.css' ) );
}
add_action( 'admin_enqueue_scripts', 'hb_enqueue_admin_styles' );

/**
 * Increase memory limit for page builders.
 */
function hb_increase_admin_memory_limit() {
	if ( defined( 'WP_MEMORY_LIMIT' ) ) {
		return;
	}

	if ( defined( 'ET_CORE' ) ) {
		ini_set( 'memory_limit', '128M' ); // phpcs:ignore
	}

	if ( defined( 'ELEMENTOR_VERSION' ) ) {
		ini_set( 'memory_limit', '512M' ); // phpcs:ignore
	}
}
add_action( 'admin_init', 'hb_increase_admin_memory_limit' );
