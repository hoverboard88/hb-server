<?php
/**
 * Dashboard
 *
 * @package hb_server
 */

/**
 * Remove Dashboard Widgets
 *
 * Ref: http://adamscottcreative.com/add-your-own-news-feed-to-wordpress-dashboard/
 */
function tmm_dashboard_widgets() {
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'searchwp_statistics', 'dashboard', 'normal' );
	remove_meta_box( 'wp_mail_smtp_reports_widget_lite', 'dashboard', 'normal' );
	remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'normal' );
	remove_meta_box( 'llar_stats_widget', 'dashboard', 'normal' );
	remove_meta_box( 'welcome-panel', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'ga_dashboard_widget', 'dashboard', 'normal' );
	remove_meta_box( 'wpseo-wincher-dashboard-overview', 'dashboard', 'normal' );
	remove_meta_box( 'jetpack_summary_widget', 'dashboard', 'normal' );
	remove_meta_box( 'tribe_dashboard_widget', 'dashboard', 'normal' );

	add_meta_box( 'hb_support_dashboard_widget', 'Need Help?', 'hb_support_widget', 'dashboard', 'side', 'high' );
}
add_action( 'wp_dashboard_setup', 'tmm_dashboard_widgets', 999 );

/**
 * Hoverboard Support Widget
 */
function hb_support_widget() {
	?>
		<div class="hb-contact-widget">
			<img class="hb-contact-width__logo" src="<?php echo esc_url( HB_SERVER_URL . '/assets/logo-square.png' ); ?>" />

			<div class="hb-contact-widget__text">
				<h3 class="hb-contact-widget__heading">
					Hello, it's Hoverboard! 😀
				</h3>

				<p>Email us at <a href="mailto:hi@hoverboardstudios.com">hi@hoverboardstudios.com</a> if you are having issues with your site.</p>
			</div>
		</div>
	<?php
}
