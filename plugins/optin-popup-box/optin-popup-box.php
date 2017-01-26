<?php
/**
 * Plugin Name: Optin Popup Box
 * Version: 1.0.0
 * Plugin URI: https://carl.alber2.com/
 * Description: This is your starter template for your next WordPress plugin.
 * Author: Carl Alberto
 * Author URI: https://carl.alber2.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: optin-popup-box
 * Domain Path: /languages/
 *
 * @package Optin Popup Box
 * @author Carl Alberto
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load plugin class files.
require_once( 'includes/class-optin-popup-box.php' );
require_once( 'includes/class-optin-popup-box-settings.php' );

// Load plugin libraries.
require_once( 'includes/lib/class-optin-popup-box-admin-api.php' );
require_once( 'includes/lib/class-optin-popup-box-post-type.php' );
require_once( 'includes/lib/class-optin-popup-box-taxonomy.php' );

// Load custom functionalities.
require_once( 'includes/class-optin-popup-box-main.php' );

/**
 * Returns the main instance of Optin_Popup_Box to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Optin_Popup_Box
 */
function optin_popup_box() {
	// Plugin main variables.
	$latest_plugin_version = '1.0.0';
	$settings_prefix = 'plg1_';

	$pluginoptions = array(
		'settings_prefix' => $settings_prefix,
	);

	$instance = Optin_Popup_Box::instance( __FILE__,
		$latest_plugin_version,
		$pluginoptions
	);

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Optin_Popup_Box_Settings::instance( $instance );
	}

	return $instance;
}

optin_popup_box();
