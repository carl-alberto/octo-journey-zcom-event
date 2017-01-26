<?php
/**
 * Plugin Name: Event Organizer Tools
 * Version: 1.0.0
 * Plugin URI: https://carl.alber2.com/
 * Description: This is your starter template for your next WordPress plugin.
 * Author: Carl Alberto
 * Author URI: https://carl.alber2.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: event-organizer-tools
 * Domain Path: /languages/
 *
 * @package Event Organizer Tools
 * @author Carl Alberto
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load plugin class files.
require_once( 'includes/class-event-organizer-tools.php' );
require_once( 'includes/class-event-organizer-tools-settings.php' );

// Load plugin libraries.
require_once( 'includes/lib/class-event-organizer-tools-admin-api.php' );
require_once( 'includes/lib/class-event-organizer-tools-post-type.php' );
require_once( 'includes/lib/class-event-organizer-tools-taxonomy.php' );

// Load custom functionalities.
require_once( 'includes/class-event-organizer-tools-main.php' );

/**
 * Returns the main instance of Event_Organizer_Tools to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Event_Organizer_Tools
 */
function event_organizer_tools() {
	// Plugin main variables.
	$latest_plugin_version = '1.0.0';
	$settings_prefix = 'plg1_';

	$pluginoptions = array(
		'settings_prefix' => $settings_prefix,
	);

	$instance = Event_Organizer_Tools::instance( __FILE__,
		$latest_plugin_version,
		$pluginoptions
	);

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Event_Organizer_Tools_Settings::instance( $instance );
	}

	return $instance;
}

event_organizer_tools();
