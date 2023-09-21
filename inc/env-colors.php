<?php
/**
 * Env Colors
 *
 * @package hb_server
 */

/**
 * Make the whole admin bar the env color.
 */
function hb_env_colors() {
	// check is user is an administrator.
	if ( ! current_user_can( 'manage_options' ) ) :
		return;
	endif;

	if ( wp_get_environment_type() === 'development' ) {
		$color = '#3b9843';
	} elseif ( wp_get_environment_type() === 'staging' ) {
		$color = '#d79d00';
	} elseif ( wp_get_environment_type() === 'production' ) {
		$color = '#1d2327';
	} else {
		$color = '#0087b1';
	}
	?>

	<style>
		#wpadminbar {
			background-color: <?php echo esc_attr( $color ); ?>;
		}

		.edit-post-fullscreen-mode-close.components-button {
			background-color: <?php echo esc_attr( $color ); ?>;
		}

		.edit-post-fullscreen-mode-close.components-button:before {
			box-shadow: inset 0 0 0 var(--wp-admin-border-width-focus) <?php echo esc_attr( $color ); ?>;
		}

		.edit-post-fullscreen-mode-close.components-button:hover:before {
			box-shadow: inset 0 0 0 var(--wp-admin-border-width-focus) <?php echo esc_attr( $color ); ?>;
		}
	</style>

	<meta name="theme-color" content="<?php echo esc_attr( $color ); ?>" />
	<?php
}
add_action( 'wp_head', 'hb_env_colors' );
add_action( 'admin_head', 'hb_env_colors' );

/**
 * Adding emoji to title tag.
 *
 * @param   String $title Title tag.
 *
 * @return  String Returned title tag.
 */
function hb_color_title_tag( $title ) {
	// check is user is an administrator.
	if ( ! current_user_can( 'manage_options' ) ) :
		return $title;
	endif;

	if ( wp_get_environment_type() === 'development' ) {
		return '🟢 ' . $title;
	} elseif ( wp_get_environment_type() === 'staging' ) {
		return '🟡 ' . $title;
	} elseif ( wp_get_environment_type() === 'production' ) {
		return $title;
	} else {
		return '🔵 ' . $title;
	}
}
add_filter( 'wpseo_title', 'hb_color_title_tag' );
add_filter( 'document_title', 'hb_color_title_tag' );
add_filter( 'admin_title', 'hb_color_title_tag' );
