<?php
/**
 * Theme licensing for Easy Digital Downloads.
 *
 * @package Kulkuri
 */

/**
 * Creates the updater class.
 *
 * since 1.0.0
 */
function kulkuri_updater() {

	/* If there is no valid license key status, don't let updates. */
	if( get_option( 'kulkuri_license_key_status' ) != 'valid' ) {
		return;
	}

	/* Load our custom theme updater. */
	if ( !class_exists( 'EDD_SL_Theme_Updater' ) ) {
		include( dirname( __FILE__ ) . '/theme-updater-class.php' );
	}

	new EDD_SL_Theme_Updater( array(
		'remote_api_url' => kulkuri_updater_settings( 'remote_api_url' ),
		'version'        => kulkuri_updater_settings( 'version' ),
		'license'        => trim( get_option( 'kulkuri_license_key' ) ),
		'item_name'      => kulkuri_updater_settings( 'theme_name' ),
		'author'         => kulkuri_updater_settings( 'author' )
		)
	);
}
add_action( 'admin_init', 'kulkuri_updater' );

/**
 * Adds a menu item for the theme license under the appearance menu.
 *
 * since 1.0.0
 */
function kulkuri_license_menu() {
	add_theme_page(
		__( 'Theme License', 'kulkuri' ),
		__( 'Theme License', 'kulkuri' ),
		'manage_options', 'kulkuri-license',
		'kulkuri_license_page'
	);
}
add_action( 'admin_menu', 'kulkuri_license_menu' );

/**
 * Outputs the markup used on the theme license page.
 *
 * since 1.0.0
 */
function kulkuri_license_page() {

	$license = trim( get_option( 'kulkuri_license_key' ) );
	$status = get_option( 'kulkuri_license_key_status', false );

	// Checks license status to display under license key
	if ( ! $license ) {
		$message = __( 'Enter your theme license key.', 'kulkuri' );
	} else {
		delete_transient( 'kulkuri_license_message' );
		if ( ! get_transient( 'kulkuri_license_message', false ) ) {
			set_transient( 'kulkuri_license_message', kulkuri_check_license(), ( 60 * 60 * 24 ) );
		}
		$message = get_transient( 'kulkuri_license_message' );
	}
	?>
	<div class="wrap">
		<h2><?php _e( 'Theme License Options', 'kulkuri' ); ?></h2>
		<form method="post" action="options.php">

			<?php settings_fields( 'kulkuri_license' ); ?>

			<table class="form-table">
				<tbody>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e( 'License Key', 'kulkuri' ); ?>
						</th>
						<td>
							<input id="kulkuri_license_key" name="kulkuri_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<p class="description">
								<?php echo $message; ?>
							</p>
						</td>
					</tr>

					<?php if ( $license ) { ?>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e( 'License Action', 'kulkuri' ); ?>
						</th>
						<td>
							<?php
							wp_nonce_field( 'kulkuri_nonce', 'kulkuri_nonce' );
							if ( 'valid' == $status ) { ?>
								<input type="submit" class="button-secondary" name="kulkuri_license_deactivate" value="<?php esc_attr_e( 'Deactivate License', 'kulkuri' ); ?>"/>
							<?php } else { ?>
								<input type="submit" class="button-secondary" name="kulkuri_license_activate" value="<?php esc_attr_e( 'Activate License', 'kulkuri' ); ?>"/>
							<?php }
							?>
						</td>
					</tr>
					<?php } ?>

				</tbody>
			</table>
			<?php submit_button(); ?>
		</form>
	<?php
}

/**
 * Registers the option used to store the license key in the options table.
 *
 * since 1.0.0
 */
function kulkuri_register_option() {
	register_setting( 'kulkuri_license', 'kulkuri_license_key', 'kulkuri_sanitize_license' );
}
add_action( 'admin_init', 'kulkuri_register_option' );

/**
 * Sanitizes the license key.
 *
 * since 1.0.0
 *
 * @param string $new License key that was submitted.
 * @return string $new Sanitized license key.
 */
function kulkuri_sanitize_license( $new ) {

	$old = get_option( 'kulkuri_license_key' );

	if ( $old && $old != $new ) {
		// New license has been entered, so must reactivate
		delete_option( 'kulkuri_license_key_status' );
		delete_transient( 'kulkuri_license_message' );
	}

	return $new;
}

/**
 * Activates the license key.
 *
 * @since 1.0.0
 */
function kulkuri_activate_license() {

	$license = trim( get_option( 'kulkuri_license_key' ) );

	// Data to send in our API request.
	$api_params = array(
		'edd_action' => 'activate_license',
		'license'    => $license,
		'item_name'  => urlencode( kulkuri_updater_settings( 'theme_name' ) )
	);

	// Call the custom API.
	$response = wp_remote_get( add_query_arg( $api_params, kulkuri_updater_settings( 'remote_api_url' ) ), array( 'timeout' => 15, 'sslverify' => false ) );

	// Make sure the response came back okay.
	if ( is_wp_error( $response ) ) {
		return false;
	}

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	// $license_data->license will be either "active" or "inactive"
	update_option( 'kulkuri_license_key_status', $license_data->license );
	delete_transient( 'kulkuri_license_message' );

}
add_action( 'update_option_kulkuri_license_key', 'kulkuri_activate_license', 10, 2 );

/**
 * Deactivates the license key.
 *
 * @since 1.0.0
 */
function kulkuri_deactivate_license() {

	// Retrieve the license from the database.
	$license = trim( get_option( 'kulkuri_license_key' ) );

	// Data to send in our API request.
	$api_params = array(
		'edd_action' => 'deactivate_license',
		'license'    => $license,
		'item_name'  => urlencode( kulkuri_updater_settings( 'theme_name' ) )
	);

	// Call the custom API.
	$response = wp_remote_get( add_query_arg( $api_params, kulkuri_updater_settings( 'remote_api_url' ) ), array( 'timeout' => 15, 'sslverify' => false ) );

	// Make sure the response came back okay
	if ( is_wp_error( $response ) ) {
		return false;
	}

	// decode the license data
	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	// $license_data->license will be either "deactivated" or "failed"
	if ( $license_data->license == 'deactivated' ) {
		delete_option( 'kulkuri_license_key_status' );
		delete_transient( 'kulkuri_license_message' );
	}

}

/**
 * Checks if a license action was submitted.
 *
 * @since 1.0.0
 */
function kulkuri_license_action() {

	if ( isset( $_POST['kulkuri_license_activate'] ) ) {
		if ( check_admin_referer( 'kulkuri_nonce', 'kulkuri_nonce' ) ) {
			kulkuri_activate_license();
		}
	}

	if ( isset( $_POST['kulkuri_license_deactivate'] ) ) {
		if ( check_admin_referer( 'kulkuri_nonce', 'kulkuri_nonce' ) ) {
			kulkuri_deactivate_license();
		}
	}

}
add_action( 'admin_init', 'kulkuri_license_action' );

/**
 * Checks if license is valid and gets expire date.
 *
 * @since 1.0.0
 *
 * @return string $message License status message.
 */
function kulkuri_check_license() {

	$license = trim( get_option( 'kulkuri_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license'    => $license,
		'item_name'  => urlencode( kulkuri_updater_settings( 'theme_name' ) )
	);

	$response = wp_remote_get( add_query_arg( $api_params, kulkuri_updater_settings( 'remote_api_url' ) ), array( 'timeout' => 15, 'sslverify' => false ) );

	if ( is_wp_error( $response ) ) {
		return false;
	}

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );
	
	/* If response doesn't include license data, return. */
	if ( !isset( $license_data->license ) ) {
		$message = __( 'License status is unknown.', 'kulkuri' );
		return $message;
	}

	/* Get expire date. */
	$expires = false;
	if ( $license_data->expires ) {
		$expires = date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires ) );
	}
	
	/* Get site counts. */
	$site_count = $license_data->site_count;
	$license_limit = $license_data->license_limit;
	
	/* If unlimited use infinity sign. */
	if( 0 == $license_limit ) {
		$license_limit = __( '&#8734;', 'kulkuri' );
	}

	if ( $license_data->license == 'valid' ) {
		$message = __( 'License key is active', 'kulkuri' ) . ' ';
		if ( $expires ) {
			$message .= sprintf( __( 'and expires %s.', 'kulkuri' ), $expires ) . ' ';
		}
		if ( $site_count && $license_limit ) {
			$message .= sprintf( _n( 'You have %1$s / %2$s site activated.', 'You have %1$s / %2$s sites activated.', $site_count, 'kulkuri' ), $site_count, $license_limit );
		}
	} else if ( $license_data->license == 'expired' ) {
		$message = __( 'License key has expired.', 'kulkuri' ) . ' ';
		if ( $expires ) {
			$message .= sprintf( __( 'Expired %s.', 'kulkuri' ), $expires );
		}
	} else if ( $license_data->license == 'invalid' ) {
		$message = __( 'License keys do not match.', 'kulkuri' );
	} else if ( $license_data->license == 'inactive' ) {
		$message = __( 'License is inactive.', 'kulkuri' );
	} else if ( $license_data->license == 'disabled' ) {
		$message = __( 'License key is disabled.', 'kulkuri' );
	} else if ( $license_data->license == 'site_inactive' ) {
		$message = __( 'Site is inactive.', 'kulkuri' );
	} else {
		$message = __( 'License status is unknown.', 'kulkuri' );
	}

	return $message;
}