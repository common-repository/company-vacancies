<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://vk.com/id554858695
 * @since      1.0.5
 *
 * @package    Wvcl
 * @subpackage Wvcl/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.5
 * @package    Wvcl
 * @subpackage Wvcl/includes
 * @author     Виктор Шугуров <oren_rebel@mail.ru>
 */
class Wvcl_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.5
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook( 'wvcl_cron_vacancy' );
	}

}
