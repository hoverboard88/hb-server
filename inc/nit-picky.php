<?php
/**
 * Nit Picky tweaks.
 *
 * @package hb_server
 */

// Disable WordPress Administration Email verification Screen.
add_filter( 'admin_email_check_interval', '__return_false' );
