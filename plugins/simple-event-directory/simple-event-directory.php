<?php
/**
 * Plugin Name: Simple Event Directory
 * Version: 1.0.0
 * Plugin URI: https://carl.alber2.com/
 * Description: This is your starter template for your next WordPress plugin.
 * Author: Carl Alberto
 * Author URI: https://carl.alber2.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: simple-event-directory
 * Domain Path: /languages/
 *
 * @package Simple Event Directory
 * @author Carl Alberto
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load plugin class files.
require_once( 'includes/class-simple-event-directory.php' );
require_once( 'includes/class-simple-event-directory-settings.php' );

// Load plugin libraries.
require_once( 'includes/lib/class-simple-event-directory-admin-api.php' );
require_once( 'includes/lib/class-simple-event-directory-post-type.php' );
require_once( 'includes/lib/class-simple-event-directory-taxonomy.php' );

// Load custom functionalities.
require_once( 'includes/class-simple-event-directory-main.php' );

/**
 * Returns the main instance of Simple_Event_Directory to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Simple_Event_Directory
 */
function simple_event_directory() {
	// Plugin main variables.
	$latest_plugin_version = '1.0.0';
	$settings_prefix = 'plg1_';

	$pluginoptions = array(
		'settings_prefix' => $settings_prefix,
	);

	$instance = Simple_Event_Directory::instance( __FILE__,
		$latest_plugin_version,
		$pluginoptions
	);

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Simple_Event_Directory_Settings::instance( $instance );
	}

	return $instance;
}

simple_event_directory();
