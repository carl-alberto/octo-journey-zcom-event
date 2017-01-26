<?php
/**
 * Plugin Name: Simple Event Organizer
 * Version: 1.0.0
 * Plugin URI: https://carl.alber2.com/
 * Description: This is your starter template for your next WordPress plugin.
 * Author: Carl Alberto
 * Author URI: https://carl.alber2.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: simple-event-organizer
 * Domain Path: /languages/
 *
 * @package Simple Event Organizer
 * @author Carl Alberto
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load plugin class files.
require_once( 'includes/class-simple-event-organizer.php' );
require_once( 'includes/class-simple-event-organizer-settings.php' );

// Load plugin libraries.
require_once( 'includes/lib/class-simple-event-organizer-admin-api.php' );
require_once( 'includes/lib/class-simple-event-organizer-post-type.php' );
require_once( 'includes/lib/class-simple-event-organizer-taxonomy.php' );

// Load custom functionalities.
require_once( 'includes/class-simple-event-organizer-main.php' );

/**
 * Returns the main instance of Simple_Event_Organizer to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Simple_Event_Organizer
 */
function simple_event_organizer() {
	// Plugin main variables.
	$latest_plugin_version = '1.0.0';
	$settings_prefix = 'plg1_';

	$pluginoptions = array(
		'settings_prefix' => $settings_prefix,
	);

	$instance = Simple_Event_Organizer::instance( __FILE__,
		$latest_plugin_version,
		$pluginoptions
	);

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Simple_Event_Organizer_Settings::instance( $instance );
	}

	return $instance;
}

simple_event_organizer();
