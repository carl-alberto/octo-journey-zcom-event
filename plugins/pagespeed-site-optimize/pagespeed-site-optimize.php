<?php
/**
 * Plugin Name: Pagespeed Site Optimize
 * Version: 1.0.0
 * Plugin URI: https://carl.alber2.com/
 * Description: This is your starter template for your next WordPress plugin.
 * Author: Carl Alberto
 * Author URI: https://carl.alber2.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: pagespeed-site-optimize
 * Domain Path: /languages/
 *
 * @package Pagespeed Site Optimize
 * @author Carl Alberto
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load plugin class files.
require_once( 'includes/class-pagespeed-site-optimize.php' );
require_once( 'includes/class-pagespeed-site-optimize-settings.php' );

// Load plugin libraries.
require_once( 'includes/lib/class-pagespeed-site-optimize-admin-api.php' );
require_once( 'includes/lib/class-pagespeed-site-optimize-post-type.php' );
require_once( 'includes/lib/class-pagespeed-site-optimize-taxonomy.php' );

// Load custom functionalities.
require_once( 'includes/class-pagespeed-site-optimize-main.php' );

/**
 * Returns the main instance of Pagespeed_Site_Optimize to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Pagespeed_Site_Optimize
 */
function pagespeed_site_optimize() {
	// Plugin main variables.
	$latest_plugin_version = '1.0.0';
	$settings_prefix = 'plg1_';

	$pluginoptions = array(
		'settings_prefix' => $settings_prefix,
	);

	$instance = Pagespeed_Site_Optimize::instance( __FILE__,
		$latest_plugin_version,
		$pluginoptions
	);

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Pagespeed_Site_Optimize_Settings::instance( $instance );
	}

	return $instance;
}

pagespeed_site_optimize();
