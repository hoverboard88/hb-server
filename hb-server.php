<?php
/**
 * Plugin Name: Hoverboard Server
 * Description: Adds functionality for sites to run on Hoverboard server.
 * Version: 0.1
 * Author: Hoverboard
 * Author URI: https://hoverboardstudios.com
 *
 * @package hb_server
 */

add_filter( 'auto_core_update_send_email', '__return_false' );
define( 'FORCE_SSL_ADMIN', true );

/**
 * Remove version number
 *
 * @return  string empty string
 */
function hb_version_remove_version() {
	return '';
}
add_filter( 'the_generator', 'hb_version_remove_version' );

$server_vars = isset( $_SERVER ) ? $_SERVER : false;

// Set proper env var for env type.
if ( getenv( 'LANDO' ) ) {
	define( 'WP_ENVIRONMENT_TYPE', 'local' );
	define( 'WP_DEBUG', true );
	define( 'WP_DEBUG_LOG', true );
	define( 'WP_DEBUG_DISPLAY', true );
} elseif ( strstr( $server_vars['HOME'], 'hbserver.dev' ) ) {
	define( 'WP_ENVIRONMENT_TYPE', 'development' );
	define( 'WP_DEBUG', true );
	define( 'WP_DEBUG_LOG', true );
	define( 'WP_DEBUG_DISPLAY', true );
} elseif ( $server_vars['SPINUPWP_SITE'] ) {
	define( 'WP_ENVIRONMENT_TYPE', 'production' );
}

// Spinup servers only.
if ( $server_vars['SPINUPWP_SITE'] ) {
	define( 'DISALLOW_FILE_MODS', true );
	define( 'WP_AUTO_UPDATE_CORE', 'minor' );
	define( 'DISABLE_WP_CRON', true );
}
/**
 * Set Blog Public
 *
 * @return boolean Is blog public.
 */
function hb_set_blog_public() {
	if ( wp_get_environment_type() === 'development' ) {
		return 0;
	} elseif ( wp_get_environment_type() === 'production' ) {
		return 1;
	}
}
add_filter( 'pre_option_blog_public', 'hb_set_blog_public', 0, 999 );

/**
 * Change robots.txt when the site is not set to public.
 *
 * @param  string  $output robots.txt output.
 * @param  boolean $public is public or not.
 *
 * @return  string robots.txt output
 */
function hb_robots_txt( $output, $public ) {
	if ( 0 === $public ) {
		$output = "User-agent: *\nDisallow: /\n\nUser-agent: RavenCrawler\nUser-agent: rogerbot\nUser-agent: dotbot\nUser-agent: SemrushBot\nUser-agent: SemrushBot-SA\nUser-agent: PowerMapper\nUser-agent: Swiftbot\nAllow: /";
	}
	return $output;
}
add_filter( 'robots_txt', 'hb_robots_txt', 99, 2 );
