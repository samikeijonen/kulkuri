<?php
/**
 * Theme licensing for Easy Digital Downloads.
 *
 * @package Kulkuri
 */
 
// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	array(
		'remote_api_url' => 'http://localhost/foxnet-themes-shop', // Site where EDD is hosted
		'item_name'      => 'Kulkuri',                             // Name of theme
		'theme_slug'     => 'kulkuri',                             // Theme slug
		'version'        => KULKURI_VERSION,                       // The current version of this theme
		'author'         => 'Sami Keijonen'                        // The author of this theme
	)

);
