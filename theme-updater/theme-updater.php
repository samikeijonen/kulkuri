<?php
/**
 * Theme licensing for Easy Digital Downloads.
 *
 * @package Kulkuri
 */

/**
 * When using in your own project:
 *
 * 1. Find/replace "kulkuri" with your theme kulkuri
 * 2. Find/replace "kulkuri" with your theme kulkuri
 * 3. Update the variables in kulkuri_theme_info()
 * 4. Delete this doc block
 */

/**
 * Returns settings required by the theme updater.
 *
 * since 1.0.0
 *
 * @param string $setting
 * @returns string $setting data
 */
function kulkuri_updater_settings( $setting ) {

	/* URL of site running EDD. */
	$data['remote_api_url'] = 'http://localhost/foxnet-themes-shop';

	/* The name of this theme. */
	$data['theme_name'] = 'Kulkuri';

	/* The current theme version we are running. */
	$data['version'] = '1.0';

	/* The author's name. */
	$data['author'] = 'Sami Keijonen';

	if ( isset( $data[$setting] ) ) {
		return $data[$setting];
	}

	return false;
}

/**
 * Includes functions to create the admin page.
 *
 * since 1.0.0
 */
include( dirname( __FILE__ ) . '/theme-updater-functions.php' );
