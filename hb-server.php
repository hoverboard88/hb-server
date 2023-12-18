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

/**
 * Base file that requires everything.
 *
 * @package hb_server
 */

require plugin_dir_path( __FILE__ ) . '/inc/set-env-vars.php';
require plugin_dir_path( __FILE__ ) . '/inc/security.php';
require plugin_dir_path( __FILE__ ) . '/inc/admin-bar-icons.php';
require plugin_dir_path( __FILE__ ) . '/inc/seo.php';
require plugin_dir_path( __FILE__ ) . '/inc/env-colors.php';
require plugin_dir_path( __FILE__ ) . '/inc/nit-picky.php';
