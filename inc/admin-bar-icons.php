<?php
/**
 * Admin Bar Icons to show/hide.
 *
 * @package hb_server
 */

/**
 * Output the CSS to hide Bar Icons in the wp_head
 */
function hb_admin_bar_icons() {
	$user_id       = get_current_user_id();
	$bar_icons     = hb_get_bar_icons( $user_id );
	$css_selectors = array();

	foreach ( $bar_icons as $bar_icon ) :
		// If the user wants to show this icon, skip.
		if ( $bar_icon['value'] ) {
			continue;
		}

		$id = str_replace( '_', '-', $bar_icon['key'] );

		array_push( $css_selectors, '#wp-admin-bar-' . $id );
	endforeach;

	$css_selector_string = implode( ', ', $css_selectors );

	echo '<style>' . esc_attr( $css_selector_string ) . '{ display: none; }</style>';
}

add_action( 'wp_head', 'hb_admin_bar_icons' );
add_action( 'admin_head', 'hb_admin_bar_icons' );


/**
 * Get all of the bar icon options.
 *
 * @param   Int $user_id  The Current user you want to get their value for the icon.
 *
 * @return  Array Bar Icons with current user's value
 */
function hb_get_bar_icons( $user_id = false ) {
	return array(
		array(
			'key'   => 'gform_forms',
			'name'  => 'Gravity Forms',
			'value' => $user_id ? get_user_meta( $user_id, 'hb_admin_bar_gform_forms', true ) : false,
		),
		array(
			'key'   => 'wp_mail_smtp_menu',
			'name'  => 'WP Mail SMTP',
			'value' => $user_id ? get_user_meta( $user_id, 'hb_admin_bar_wp_mail_smtp_menu', true ) : false,
		),
		array(
			'key'   => 'comments',
			'name'  => 'Comments',
			'value' => $user_id ? get_user_meta( $user_id, 'hb_admin_bar_comments', true ) : false,
		),
		array(
			'key'   => 'wpseo_menu',
			'name'  => 'Yoast SEO',
			'value' => $user_id ? get_user_meta( $user_id, 'hb_admin_bar_wpseo_menu', true ) : false,
		),
		array(
			'key'   => 'llar_root',
			'name'  => 'Limit Login Attempts Reloaded',
			'value' => $user_id ? get_user_meta( $user_id, 'hb_admin_bar_llar_root', true ) : false,
		),
		array(
			'key'   => 'searchwp',
			'name'  => 'SearchWP',
			'value' => $user_id ? get_user_meta( $user_id, 'hb_admin_bar_searchwp', true ) : false,
		),
		array(
			'key'   => 'duplicate_post',
			'name'  => 'Duplicate Post',
			'value' => $user_id ? get_user_meta( $user_id, 'hb_admin_bar_duplicate_post', true ) : false,
		),
		array(
			'key'   => 'tribe_events',
			'name'  => 'The Events Calendar',
			'value' => $user_id ? get_user_meta( $user_id, 'hb_admin_bar_tribe_events', true ) : false,
		),
	);
}

/**
 * Admin for hiding and showing Admin bar icon/fields.
 *
 * @param Object $user Current user info.
 */
function hb_admin_bar_fields( $user ) {
	$bar_icons = hb_get_bar_icons( $user->ID );
	?>

	<h3 id="hb-admin-bar-icons">
		<?php echo esc_html__( 'Admin Bar Icons' ); ?>
	</h3>

	<p>
		<?php echo esc_html__( 'There are a lot of plugins that needlessly put their icon in the admin bar and clutter it up. Here you can show or hide these.' ); ?>
	</p>

	<table class="form-table">
		<tr>
			<th valign="top">
				<?php echo esc_html__( 'Show in Admin Bar' ); ?>
			</th>

			<td>
				<?php foreach ( $bar_icons as $bar_icon ) : ?>
					<label for="<?php echo esc_attr( $bar_icon['key'] ); ?>">
						<input tabindex="101" type="checkbox" name="<?php echo esc_attr( $bar_icon['key'] ); ?>" <?php echo '1' === $bar_icon['value'] ? 'checked="checked"' : ''; ?> />

						<?php echo esc_attr( $bar_icon['name'] ); ?>
					</label><br />
				<?php endforeach; ?>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Save the Admin Bar options to the DB.
 *
 * @param   Int $user_id  The current user's ID.
 */
function save_hb_admin_bar_fields( $user_id ) {
	$bar_icons = hb_get_bar_icons();

	if ( current_user_can( 'edit_user', $user_id ) ) {
		foreach ( $bar_icons as $bar_icon ) :
			// TODO: Nonce.
			update_user_meta( $user_id, 'hb_admin_bar_' . $bar_icon['key'], isset( $_POST[ $bar_icon['key'] ] ) ? 1 : 0 ); // phpcs:ignore
		endforeach;
	}
}

add_action( 'show_user_profile', 'hb_admin_bar_fields' );
add_action( 'edit_user_profile', 'hb_admin_bar_fields' );
add_action( 'personal_options_update', 'save_hb_admin_bar_fields' );
add_action( 'edit_user_profile_update', 'save_hb_admin_bar_fields' );
