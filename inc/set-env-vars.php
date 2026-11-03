<?php
/**
 * Set Environment Variables
 *
 * WP_DEBUG, WP_DEBUG_LOG, WP_DEBUG_DISPLAY and WP_DEVELOPMENT_MODE can't be set here.
 * WordPress defines them before mu-plugins load, so they belong in wp-config.php.
 *
 * @package hb_server
 */

$server_vars = isset( $_SERVER ) ? $_SERVER : array();
$home_dir    = (string) ( $server_vars['HOME'] ?? getenv( 'HOME' ) );

// Anything that isn't Lando or the dev server is treated as production, including WP-CLI and cron on prod.
if ( getenv( 'LANDO' ) ) {
	$hb_environment = 'local';
} elseif ( strstr( $home_dir, 'hbserver.dev' ) ) {
	$hb_environment = 'development';
} else {
	$hb_environment = 'production';
}

// Bedrock defines this in config/application.php before the plugin loads.
if ( ! defined( 'WP_ENVIRONMENT_TYPE' ) ) {
	define( 'WP_ENVIRONMENT_TYPE', $hb_environment );
}

if ( 'production' === $hb_environment ) {
	// Stop notices and deprecations from filling the log on every request. Warnings and errors still log.
	error_reporting( E_ALL & ~E_NOTICE & ~E_USER_NOTICE & ~E_DEPRECATED & ~E_USER_DEPRECATED ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.prevent_path_disclosure_error_reporting, WordPress.PHP.DiscouragedPHPFunctions.runtime_configuration_error_reporting
	ini_set( 'display_errors', '0' ); // phpcs:ignore WordPress.PHP.IniSet.display_errors_Disallowed
} elseif ( 'development' === $hb_environment && defined( 'WP_CLI' ) && WP_CLI ) {
	// Keep deprecations from burying WP-CLI output (plugin updates, etc.) on dev. Web requests still show them.
	error_reporting( E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.prevent_path_disclosure_error_reporting, WordPress.PHP.DiscouragedPHPFunctions.runtime_configuration_error_reporting
} else {
	// Show everything locally and on dev, even if wp-config.php has WP_DEBUG off.
	error_reporting( E_ALL ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.prevent_path_disclosure_error_reporting, WordPress.PHP.DiscouragedPHPFunctions.runtime_configuration_error_reporting
}
