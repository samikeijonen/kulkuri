<?php
/**
 * Theme licensing for Easy Digital Downloads.
 *
 * @package Kulkuri
 */
 
// Includes the files needed for the theme updater
include( dirname( __FILE__ ) . '/theme-updater-admin.php' );

// Loads the theme updater admin class
$updater = new Kulkuri_Theme_Updater_Admin;

// Defines variables to be used by the theme updater
$updater->init(
	array(
		'remote_api_url' => 'http://localhost/foxnet-themes-shop', // URL of site running EDD
		'theme_slug'     => 'Kulkuri',                             // The name of this theme
		'version'        => KULKURI_VERSION,                       // The current version of this theme
		'author'         => 'Sami Keijonen'                        // The author of this theme
	)
);


function kulkuri_updater_settings( $setting ) {

	/* URL of site running EDD. */
	$data['remote_api_url'] = 'http://localhost/foxnet-themes-shop';

	/* The name of this theme. */
	$data['theme_name'] = 'Kulkuri';

	/* The current theme version we are running. */
	$data['version'] = KULKURI_VERSION; // From functions.php file.

	/* The author's name. */
	$data['author'] = 'Sami Keijonen';

	if ( isset( $data[$setting] ) ) {
		return $data[$setting];
	}

	return false;
}
