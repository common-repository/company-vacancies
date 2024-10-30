<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://vk.com/id554858695
 * @since      1.0.5
 *
 * @package    Wvcl
 * @subpackage Wvcl/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.5
 * @package    Wvcl
 * @subpackage Wvcl/includes
 * @author     Виктор Шугуров <oren_rebel@mail.ru>
 */
class Wvcl_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.5
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wvcl',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
