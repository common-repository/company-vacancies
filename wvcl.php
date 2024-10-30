<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://vk.com/id554858695
 * @since             1.0.5
 * @package           Wvcl
 *
 * @wordpress-plugin
 * Plugin Name:       Company vacancies
 * Plugin URI:        https://ru.wordpress.org/plugins/company-vacancies/
 * Description:       The plugin is designed to display a list of vacancies on the site.
 * Version:           1.0.5
 * Author:            Виктор Шугуров
 * Author URI:        https://vk.com/id554858695
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       company-vacancies
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.5 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WVCL_VERSION', '1.0.5' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wvcl-activator.php
 */
function activate_wvcl() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wvcl-activator.php';
	Wvcl_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wvcl-deactivator.php
 */
function deactivate_wvcl() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wvcl-deactivator.php';
	Wvcl_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wvcl' );
register_deactivation_hook( __FILE__, 'deactivate_wvcl' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wvcl.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.5
 */
function run_wvcl() {

	$plugin = new Wvcl();
	$plugin->run();

}
run_wvcl();
