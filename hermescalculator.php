<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wppb.me/
 * @since             1.0.0
 * @package           Hermescalculator
 *
 * @wordpress-plugin
 * Plugin Name:       hermesrawCalculator
 * Plugin URI:        https://themadbrains.com/
 * Description:       Pets feed calculator.
 * Version:           1.0.0
 * Author:            Baljeet (The Mad Brains)
 * Author URI:        https://themadbrains.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hermescalculator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'HERMESCALCULATOR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-hermescalculator-activator.php
 */
function activate_hermescalculator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hermescalculator-activator.php';
	Hermescalculator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-hermescalculator-deactivator.php
 */
function deactivate_hermescalculator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hermescalculator-deactivator.php';
	Hermescalculator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_hermescalculator' );
register_deactivation_hook( __FILE__, 'deactivate_hermescalculator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-hermescalculator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_hermescalculator() {

	$plugin = new Hermescalculator();
	$plugin->run();

}
run_hermescalculator();
