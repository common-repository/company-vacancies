<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://vk.com/id554858695
 * @since      1.0.5
 *
 * @package    Wvcl
 * @subpackage Wvcl/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wvcl
 * @subpackage Wvcl/public
 * @author     Виктор Шугуров <oren_rebel@mail.ru>
 */
class Wvcl_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.5
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.5
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.5
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		
		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode( 'vacancy', array( $this, 'wvcl_public_init') );

	}

	public function wvcl_public_init($atts) {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		$atts = shortcode_atts( array(
			'recruitment' => ''
		), $atts, 'recruitment' );

		$db_result = $this->wvcl_public_db(esc_html($atts['recruitment']));
		$out = '<div class="vacancy-container">';
				
		if(count($db_result) > 0) {
			$result = unserialize($db_result[0]->result);
			if(is_array($result) && count($result) > 0) {
				$out .= '<div class="vacancy-container--found">'.__( 'Vacancies', 'company-vacancies' ).': '.esc_html($db_result[0]->found).'</div>
						<div class="vacancy-items">';
							foreach($result as $key => $args){
								$out .= '<div class="vacancy-item">
											<div class="vacancy-name"><a href="' . esc_html($args->alternate_url) . '" title="' . esc_html($args->name) . '" rel="nofollow" target="_blank">' . esc_html($args->name) . '</a></div>
											<div class="vacancy-salary">' . (!empty($args->salary->from) ? __( 'from', 'company-vacancies' ).' ' . esc_html($args->salary->from) : '') . ' ' . (isset($args->salary->to) ? (!empty(esc_html($args->salary->to)) ? __( 'before', 'company-vacancies' ).' ' . esc_html($args->salary->to) : '') : '') . ' ' . (isset($args->salary->currency) ? $this->wvcl_public_currency(esc_html($args->salary->currency)) : '') . '</div>
											<div class="vacancy-area-name">' . esc_html($args->area?->name) . '</div>
											<div class="vacancy-schedule-name">' . esc_html($args->schedule?->name) . '</div>
											<div class="vacancy-snippet-requirement">' . esc_html($args->snippet?->requirement) . '</div>
											<div class="vacancy-snippet-responsibility">' . esc_html($args->snippet?->responsibility) . '</div>
											<div class="vacancy-respond"><a href="' . esc_html($args->alternate_url) . '" title="' . esc_html($args->name) . '" rel="nofollow" target="_blank">'.__( 'Respond', 'company-vacancies' ).'</a></div>
										</div>
									';
							}
					$out .= '</div>';
			} else {
				$out .= '<div class="vacancy-item--noresult">'.__( 'No vacancies found. Try other search options or remove filters', 'company-vacancies' ).'</div>';
			}
		} else {
			$out .= '<div class="vacancy-item--noresult">'.__( 'No vacancies found. Try other search options or remove filters', 'company-vacancies' ).'</div>';
		}
		$out .= '</div>';
		return $out;
	}

	public function wvcl_public_db ($recruitment) {
		global $wpdb;
		
		$cache_key = $recruitment;
		$recruitment = esc_sql( $recruitment );
		$cache = wp_cache_get( $cache_key );
	
		if( false !== $cache )
			return $cache;
			
		$table_name = esc_sql( $wpdb->prefix . "wvcl" );
		$sql = $wpdb->prepare( "SELECT * FROM $table_name WHERE recruitment = %s", $recruitment );
		$value = $wpdb->get_results( $sql );
		wp_cache_set( $cache_key, $value );
	
		return $value;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.5
	 */
	public function wvcl_public_currency($currency) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wvcl_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wvcl_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		switch ($currency) {
			case 'RUR':
				return "₽";
				break;
			case 'USD':
				return "$";
				break;
			case 'EUR':
				return "€";
				break;
			default:
				return esc_html($currency);
		}		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.5
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wvcl_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wvcl_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wvcl-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.5
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wvcl_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wvcl_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wvcl-public.js', array( 'jquery' ), $this->version, false );

	}

}
