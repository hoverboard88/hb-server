<?php
/**
 * Set Environment Variables
 *
 * @package hb_server
 */

$server_vars = isset( $_SERVER ) ? $_SERVER : false;

// Set proper env var for env type.
if ( getenv( 'LANDO' ) ) {
	if ( ! defined( 'WP_ENVIRONMENT_TYPE' ) ) {
		define( 'WP_ENVIRONMENT_TYPE', 'local' );
	}

	if ( ! defined( 'WP_DEVELOPMENT_MODE' ) ) {
		define( 'WP_DEVELOPMENT_MODE', 'all' );
	}

	define( 'JETPACK_DEV_DEBUG', true );

	if ( ! defined( 'WP_DEBUG' ) ) {
		define( 'WP_DEBUG', true );
	}

	if ( ! defined( 'WP_DEBUG_LOG' ) ) {
		define( 'WP_DEBUG_LOG', true );
	}

	if ( ! defined( 'WP_DEBUG_DISPLAY' ) ) {
		define( 'WP_DEBUG_DISPLAY', true );
	}
} elseif ( strstr( $server_vars['HOME'], 'hbserver.dev' ) ) {
	define( 'WP_ENVIRONMENT_TYPE', 'development' );

	if ( ! defined( 'WP_DEBUG' ) ) {
		define( 'WP_DEBUG', true );
	}

	if ( ! defined( 'WP_DEBUG_LOG' ) ) {
		define( 'WP_DEBUG_LOG', true );
	}

	if ( ! defined( 'WP_DEBUG_DISPLAY' ) ) {
		define( 'WP_DEBUG_DISPLAY', true );
	}
} elseif ( array_key_exists( 'SPINUPWP_SITE', $server_vars ) ) {
	define( 'WP_ENVIRONMENT_TYPE', 'production' );

	if ( ! defined( 'WP_DEBUG' ) ) {
		define( 'WP_DEBUG', false );
	}
}
