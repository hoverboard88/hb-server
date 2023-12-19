<?php
/**
 * Branding
 *
 * @package hb_server
 */

/**
 * Login Logo
 */
function hb_custom_login_css() {
	?>
	<style>
	.login h1 a {
		background: url(<?php echo esc_url( HB_SERVER_URL . '/assets/logo-square.png' ); ?>) no-repeat top center;
		background-size: contain;
	}
	</style>
	<?php
}
add_action( 'login_head', 'hb_custom_login_css', 99999 );

/**
 * Login Logo URL
 *
 * @param string $url URL.
 *
 * @return string
 */
function hb_loginlogo_url( $url ) {
	return 'https://hoverboardstudios.com';
}
add_filter( 'login_headerurl', 'hb_loginlogo_url' );
