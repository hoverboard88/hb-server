<?php
/**
 * SEO-Related Tweaks
 *
 * @package hb_server
 */

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

/**
 * Remove Yoast SEO Columns
 *
 * Credit: Andrew Norcross http://andrewnorcross.com/
 * Source: https://gist.github.com/amboutwe/18558a7e681e36c6bfe6e4fb647265ce
 *
 * If you have custom post types, you can add additional lines in this format
 * add_filter( 'manage_edit-{$post_type}_columns', 'yoast_seo_admin_remove_columns', 10, 1 );
 * replacing {$post_type} with the name of the custom post type.
 *
 * @param Array $columns Array of SEO Columns.
 *
 * @return  Array array of columns.
 */
function yoast_seo_admin_remove_columns( $columns ) {
	unset( $columns['wpseo-score-readability'] );
	unset( $columns['wpseo-title'] );
	unset( $columns['wpseo-metadesc'] );
	unset( $columns['wpseo-focuskw'] );
	unset( $columns['wpseo-links'] );
	unset( $columns['wpseo-linked'] );
	return $columns;
}
add_filter( 'manage_edit-post_columns', 'yoast_seo_admin_remove_columns', 10, 1 );
add_filter( 'manage_edit-tribe_events_columns', 'yoast_seo_admin_remove_columns', 10, 1 );
add_filter( 'manage_edit-page_columns', 'yoast_seo_admin_remove_columns', 10, 1 );
add_filter( 'manage_edit-staff_columns', 'yoast_seo_admin_remove_columns', 10, 1 );
