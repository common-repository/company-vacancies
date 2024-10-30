<?php

/**
 * The settings of the plugin.
 *
 * @link       https://vk.com/id554858695
 * @since      1.0.5
 *
 * @package    wvcl_Plugin
 * @subpackage wvcl_Plugin/admin
 */

/**
 * Class WordPress_Plugin_Template_Save_Settings
 *
 */
class wvcl_Admin_Save_Settings {

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
	 * The variables of this plugin.
	 *
	 * @since    1.0.5
	 * @access   public
	 * @var      int   
	 */
	public $pages;
	public $found;

	/**
	 * The variables of this plugin.
	 *
	 * @since    1.0.5
	 * @access   public
	 * @var      array    
	 */
	public $options = array();
	public $result = array();

	public $url = 'https://application-interface.com/wvcl/';

	public $recruitment;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.5
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to demonstration
	 * validation and sanitization.
	 *
	 * This function is registered with the 'after_db_upgrade' hook.
	 */
	public function initialize_save() {
		
		// head_hunter
		$this->recruitment = 'head_hunter';
		
		$this->options = array_diff(get_option('wvcl_head_hunter'), array(''));
		$this->wvcl_public_page();
		
		$this->result = array();

		for($i = 0; $i < $this->pages; $i++){
			$this->page = $i;
			$this->wvcl_public_list();
		}
		
		$this->save_plugin_options_db();
		
	}

	public function save_plugin_options_db() {

		global $wpdb;

		switch ($this->recruitment) {
			case 'head_hunter':
				$recruitment = esc_sql( 'headhunter' );
				break;
		}

		if(isset($recruitment)) {
			$table_name = esc_sql( $wpdb->prefix . "wvcl" );
			$sql = $wpdb->prepare( "SELECT * FROM $table_name WHERE recruitment = %s", $recruitment );
			$get_results = $wpdb->get_results( $sql );
			
			if(count($get_results) > 0){
				$wpdb->update( $table_name, [ 'recruitment' => sanitize_text_field($recruitment), 'pages' => sanitize_text_field($this->pages), 'found' => sanitize_text_field($this->found), 'result' => serialize($this->result), 'options' => http_build_query($this->options) ], [ 'id' => sanitize_text_field($get_results[0]->id) ] );
			} else {
				
				$wpdb->insert( $table_name, [ 'recruitment' => sanitize_text_field($recruitment), 'pages' => sanitize_text_field($this->pages), 'found' => sanitize_text_field($this->found), 'result' => serialize($this->result), 'options' => http_build_query($this->options) ] );
			}	
		}

	}
	
	public function wvcl_public_page() {
				
		switch ($this->recruitment) {
			case 'head_hunter':
				$recruitment = esc_sql( 'headhunter' );
				break;
		}
		
		if(isset($recruitment)) {
			$headers = array(
				"User-Agent" 	=> "WVCL Plugin",
				"recruitment" 	=> $recruitment,
				"type" 			=> "vacancies",
				"content-type" 	=> "application/x-www-form-urlencoded"
			);
			
			$args = array(
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers' => $headers,
				'body'    => array( 'query' => http_build_query($this->options) ),
				'cookies' => array()
			);
	
			$response = wp_remote_post( $this->url, $args );
	
			if ( !is_wp_error( $response ) ) {
				$data = json_decode($response['body']);
				if(isset($data->items)){
					if(is_array($data->items)){
						
						
						$this->pages = htmlspecialchars($data->pages);
						$this->found = htmlspecialchars($data->found);
					}
				}
			}
		}

	}

	public function wvcl_public_list() {

		switch ($this->recruitment) {
			case 'head_hunter':
				$recruitment = esc_sql( 'headhunter' );
				break;
		}

		$headers = array(
			"User-Agent" 	=> "WVCL Plugin",
			"recruitment" 	=> $recruitment,
			"type" 			=> "vacancies",
			"content-type" 	=> "application/x-www-form-urlencoded"
		);
		
		$args = array(
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers' => $headers,
			'body'    => array( 'query' => http_build_query($this->options) . "&page=".$this->page ),
			'cookies' => array()
		);

		$response = wp_remote_post( $this->url, $args );

		if ( !is_wp_error( $response ) ) {
			$data = json_decode($response['body']);
			if(is_array($data->items)){
				$this->result = array_merge($this->result, $data->items);	
			}
		}
			
	}

}