<?php
/**
 * Site Health tweaks.
 *
 * @package hb_server
 */

/**
 * Hide the Site Health "Opcode cache is not enabled" warning on the Hoverboard servers.
 *
 * WordPress checks OPcache by calling opcache_get_status(). The servers disable that function, so the
 * check always fails and reports OPcache as off even though it's on. The test only runs where the
 * function is available, so it still works anywhere it can give a real answer.
 *
 * @param array $tests Site Health tests.
 *
 * @return array
 */
function hb_server_remove_opcode_cache_test( $tests ) {
	if ( ! function_exists( 'opcache_get_status' ) ) {
		unset( $tests['direct']['opcode_cache'] );
	}

	return $tests;
}
add_filter( 'site_status_tests', 'hb_server_remove_opcode_cache_test' );
