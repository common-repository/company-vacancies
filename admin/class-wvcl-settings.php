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
 * Class WordPress_Plugin_Template_Settings
 *
 */
class wvcl_Admin_Settings {

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

	public $tab;
	public $active_tab;

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
	 * This function introduces the theme options into the 'Appearance' menu and into a top-level
	 * 'WPPB Demo' menu.
	 */
	public function setup_plugin_options_menu() {

		//Add the menu to the Plugins set of menu items
		add_menu_page(
			__( 'Job list settings', 'company-vacancies' ),		// The title to be displayed in the browser window for this page.
			__( 'Jobs', 'company-vacancies' ),					// The text to be displayed for this menu item
			'manage_options',									// Which type of users can see this menu item
			'wvcl_options',										// The unique ID - that is, the slug - for this menu item
			array( $this, 'render_settings_page_content'),		// The name of the function to call when rendering this menu's page
			'dashicons-groups'									// The icon dashicons this menu's page
		);

	}

	/**
	 * Provides default values for the Input Options.
	 *
	 * @return array
	 */
	public function default_input_options() {

		$defaults = array(
			'input_example'		=>	'default input example',
			'textarea_example'	=>	'',
			'checkbox_example'	=>	'',
			'radio_example'		=>	'2',
			'time_options'		=>	'default'
		);

		return $defaults;

	}

	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	public function render_settings_page_content() {
		add_thickbox();
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wvcl-wrap wrap">

			<h2><?php esc_html_e( 'Job list settings', 'company-vacancies' ); ?></h2>
			<?php settings_errors(); ?>

			<?php 
				switch ($this->tab) {
					case 'head_hunter':
						$this->active_tab = 'head_hunter';
						break;
					default:
						$this->active_tab = 'head_hunter';
						break;
				}
			?>

			<form method="post" action="options.php">
				<?php
					switch ($this->active_tab) {
						case 'head_hunter':
							settings_fields( 'wvcl_head_hunter' );
							do_settings_sections( 'wvcl_head_hunter' );
							submit_button();
							break;
						default:
							settings_fields( 'wvcl_head_hunter' );
							do_settings_sections( 'wvcl_head_hunter' );
							submit_button();
							break;
					}
				?>
			</form>

		</div><!-- /.wrap -->
	<?php
	}

	/**
	 * This function provides a simple description for the Input Examples page.
	 *
	 * It's called from the 'wvcl_theme_initialize_render_form_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function head_hunter_callback() {
		$options = get_option('wvcl_head_hunter');
		echo '
			<p>'.__( 'Copy this shortcode and paste it into your posts, pages, or text widget content:', 'company-vacancies' ).'</p>
			<div class="shortcode">
				<div>[vacancy recruitment="headhunter"]</div>
				<div>
					<span class="dashicons-before dashicons-admin-page" aria-hidden="true"></span>
				</div>
			</div>
			<p>'.__( 'Attention: unknown parameters and parameters with an error in the name are ignored', 'company-vacancies' ).'</p>
		';
	} // end general_options_callback

	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to demonstration
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_render_form() {

		if( false == get_option( 'wvcl_description' ) ) {
			$default_array = $this->default_input_options();
			update_option( 'wvcl_description', $default_array );
		} // end if

		add_settings_section(
			'description_section',
			__( '', 'company-vacancies' ),
			array( $this, 'description_callback'),
			'wvcl_description'
		);

		register_setting(
			'wvcl_description',
			'description_section',
			array( $this, 'validate_description')
		);

		if( false == get_option( 'wvcl_head_hunter' ) ) {
			$default_array = $this->default_input_options();
			update_option( 'wvcl_head_hunter', $default_array );
		} // end if

		add_settings_section(
			'head_hunter_section',
			__( '', 'company-vacancies' ),
			array( $this, 'head_hunter_callback'),
			'wvcl_head_hunter'
		);

		add_settings_field(
			'Text field',
			__( 'Text field', 'company-vacancies' ),
			array( $this, 'text_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Search area',
			__( 'Search area', 'company-vacancies' ),
			array( $this, 'search_field_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Work experience',
			__( 'Work experience', 'company-vacancies' ),
			array( $this, 'experience_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Employment type',
			__( 'Employment type', 'company-vacancies' ),
			array( $this, 'employment_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Schedule',
			__( 'Schedule', 'company-vacancies' ),
			array( $this, 'schedule_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Region',
			__( 'Region', 'company-vacancies' ),
			array( $this, 'area_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Line or metro station',
			__( 'Line or metro station', 'company-vacancies' ),
			array( $this, 'metro_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Profession or specialization',
			__( 'Profession or specialization', 'company-vacancies' ),
			array( $this, 'specialization_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Industry of the company that posted the job',
			__( 'Industry of the company that posted the job', 'company-vacancies' ),
			array( $this, 'industry_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Company ID',
			__( 'Company ID', 'company-vacancies' ),
			array( $this, 'employer_id_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Currency code',
			__( 'Currency code', 'company-vacancies' ),
			array( $this, 'currency_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Salary',
			__( 'Salary', 'company-vacancies' ),
			array( $this, 'salary_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Filter by job tags',
			__( 'Filter by job tags', 'company-vacancies' ),
			array( $this, 'label_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Show jobs with salary only',
			__( 'Show jobs with salary only', 'company-vacancies' ),
			array( $this, 'only_with_salary_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Number of days within which you need to find vacancies',
			__( 'Number of days within which you need to find vacancies', 'company-vacancies' ),
			array( $this, 'period_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'The date that lowers the date range for the publication of vacancies',
			__( 'The date that lowers the date range for the publication of vacancies', 'company-vacancies' ),
			array( $this, 'date_from_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'The date that limits the date range of the publication of vacancies from above',
			__( 'The date that limits the date range of the publication of vacancies from above', 'company-vacancies' ),
			array( $this, 'date_to_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Whether to return clusters for a given search',
			__( 'Whether to return clusters for a given search', 'company-vacancies' ),
			array( $this, 'clusters_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Whether to return a description of the search parameters used',
			__( 'Whether to return a description of the search parameters used', 'company-vacancies' ),
			array( $this, 'describe_arguments_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Disable automatic job conversion',
			__( 'Disable automatic job conversion', 'company-vacancies' ),
			array( $this, 'no_magic_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Professional role',
			__( 'Professional role', 'company-vacancies' ),
			array( $this, 'professional_role_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		register_setting(
			'wvcl_head_hunter',
			'wvcl_head_hunter',
			array( $this, 'validate_field')
		);
	}

	public function text_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
		<input type="text" id="text" name="wvcl_head_hunter[text]" value="' . esc_attr($options['text']) . '" />
		<div class="description" id="tagline-text">
			<p>'.__( 'The query language is available, as on the main site:', 'company-vacancies' ).' <a href="https://hh.ru/article/1175" rel="nofollow" target="_blank">https://hh.ru/article/1175</a>. '.__( 'Specially for this field there is', 'company-vacancies' ).' <a href="https://github.com/hhru/api/blob/master/docs/suggests.md#vacancy-search-keyword" rel="nofollow" target="_blank">'.__( 'autocomplete', 'company-vacancies' ).'</a>.</p>
		</div>';

	} // end text_head_hunter

	public function search_field_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
		<input type="text" id="search_field" name="wvcl_head_hunter[search_field]" value="' . esc_attr($options['search_field']) . '" />
		<div class="description" id="tagline-search_field">
			<p>'.__( 'Reference with possible values: <code>Job Search Area</code> in', 'company-vacancies' ).' <a href="https://application-interface.com/wvcl/dictionaries/?TB_iframe&width=1140&height=600" class="thickbox" rel="nofollow" target="_blank">/dictionaries</a>.</p>
			<p>'.__( 'By default, all fields are used.', 'company-vacancies' ).'</p>
			<p>'.__( 'Multiple values may be specified.', 'company-vacancies' ).'</p>
		</div>';

	} // end search_field_head_hunter

	public function experience_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
		<input type="text" id="experience" name="wvcl_head_hunter[experience]" value="' . esc_attr($options['experience']) . '" />
		<div class="description" id="tagline-experience">
			<p>'.__( 'It is necessary to transfer the <code>id</code> from the <code>Work Experience</code> directory to', 'company-vacancies' ).' <a href="https://application-interface.com/wvcl/dictionaries/?TB_iframe&width=1140&height=600" class="thickbox" rel="nofollow" target="_blank">/dictionaries</a>.</p>
		</div>';

	} // end experience_head_hunter

	public function employment_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="employment" name="wvcl_head_hunter[employment]" value="' . esc_attr($options['employment']) . '" />
			<div class="description" id="tagline-schedule">
				<p>'.__( 'It is necessary to pass <code>id</code> from the <code>Employment type</code> directory to', 'company-vacancies' ).' <a href="https://application-interface.com/wvcl/dictionaries/?TB_iframe&width=1140&height=600" class="thickbox" rel="nofollow" target="_blank">/dictionaries</a>.</p>
				<p>'.__( 'Multiple values may be specified.', 'company-vacancies' ).'</p>
			</div>';

	} // end employment_head_hunter

	public function schedule_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="schedule" name="wvcl_head_hunter[schedule]" value="' . esc_attr($options['schedule']) . '" />
			<div class="description" id="tagline-schedule">
				<p>'.__( 'It is necessary to transfer the <code>id</code> from the <code>Work Schedule</code> directory to', 'company-vacancies' ).' <a href="https://application-interface.com/wvcl/dictionaries/?TB_iframe&width=1140&height=600" class="thickbox" rel="nofollow" target="_blank">/dictionaries</a>.</p>
				<p>'.__( 'Multiple values may be specified.', 'company-vacancies' ).'</p>
			</div>';

	} // end schedule_head_hunter

	public function area_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="area" name="wvcl_head_hunter[area]" value="' . esc_attr($options['area']) . '" />
			<div class="description" id="tagline-area">
				<p>'.__( 'It is necessary to pass <code>id</code> from the directory', 'company-vacancies' ).' <a href="https://application-interface.com/wvcl/areas/?TB_iframe&width=1140&height=600" class="thickbox" rel="nofollow" target="_blank">/areas</a>.</p>
				<p>'.__( 'Multiple values may be specified.', 'company-vacancies' ).'</p>
			</div>';

	} // end area_head_hunter

	public function metro_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="metro" name="wvcl_head_hunter[metro]" value="' . esc_attr($options['metro']) . '" />
			<div class="description" id="tagline-metro">
				<p>'.__( 'It is necessary to pass <code>id</code> from the directory', 'company-vacancies' ).' <a href="https://application-interface.com/wvcl/metro/?TB_iframe&width=1140&height=600" class="thickbox" rel="nofollow" target="_blank">/metro</a>.</p>
				<p>'.__( 'Multiple values may be specified.', 'company-vacancies' ).'</p>
			</div>';

	} // end metro_head_hunter
	
	public function professional_role_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="professional_role" name="wvcl_head_hunter[professional_role]" value="' . esc_attr($options['professional_role']) . '" />
			<div class="description" id="tagline-professional_role">
				<p>'.__( 'It is necessary to pass <code>id</code> from the directory', 'company-vacancies' ).' <a href="https://application-interface.com/wvcl/professional_roles/?TB_iframe&width=1140&height=600" class="thickbox" rel="nofollow" target="_blank">/professional_roles</a>.</p>
				<p>'.__( 'Multiple values may be specified.', 'company-vacancies' ).'</p>
				<p>'.__( 'Replacement for specializations (<code>Professional area or specialization</code> parameter).', 'company-vacancies' ).'</p>
			</div>';

	} // end professional_role_head_hunter	

	public function industry_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="industry" name="wvcl_head_hunter[industry]" value="' . esc_attr($options['industry']) . '" />
			<div class="description" id="tagline-industry">
				<p>'.__( 'It is necessary to pass <code>id</code> from the directory', 'company-vacancies' ).' <a href="https://application-interface.com/wvcl/industries/?TB_iframe&width=1140&height=600" class="thickbox" rel="nofollow" target="_blank">/industries</a>.</p>
				<p>'.__( 'Multiple values may be specified.', 'company-vacancies' ).'</p>
			</div>';
			
	} // end industry_head_hunter
	
	public function employer_id_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="employer_id" name="wvcl_head_hunter[employer_id]" value="' . esc_attr($options['employer_id']) . '" />
			<div class="description" id="tagline-employer_id">
				<p>'.__( 'Identifier', 'company-vacancies' ).' <a href="https://github.com/hhru/api/blob/master/docs/employers.md" rel="nofollow" target="_blank">'.__( 'companies', 'company-vacancies' ).'</a></p>
				<p>'.__( 'The company ID can also be viewed in the address bar, for example https://hh.ru/employer/<code>1455</code>', 'company-vacancies' ).'</p>
				<p>'.__( 'Multiple values may be specified.', 'company-vacancies' ).'</p>
			</div>';

	} // end employer_id_head_hunter

	public function currency_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="currency" name="wvcl_head_hunter[currency]" value="' . esc_attr($options['currency']) . '" />
			<div class="description" id="tagline-currency">
				<p>'.__( 'Reference book with possible values: <code>Currency code</code> (key <code>code</code>) in', 'company-vacancies' ).' <a href="https://application-interface.com/wvcl/dictionaries/?TB_iframe&width=1140&height=600" class="thickbox" rel="nofollow" target="_blank">/dictionaries</a>.</p>
				<p>'.__( 'It makes sense to specify only together with the <code>Salary amount</code> parameter.', 'company-vacancies' ).'</p>
			</div>';

	} // end currency_head_hunter
	
	public function salary_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="salary" name="wvcl_head_hunter[salary]" value="' . esc_attr($options['salary']) . '" />
			<div class="description" id="tagline-salary">
				<p>'.__( 'If this field is specified, but <code>Currency code</code> is not specified, then the <code>RUB</code> value of <code>Currency code</code> is used.', 'company-vacancies' ).'</p>
				<p>'.__( 'When specifying a value, vacancies will be found in which the salary range is close to that specified in the request.', 'company-vacancies' ).'</p>
				<p>'.__( 'In this case, the values are recalculated at the current exchange rates of the Central Bank of the Russian Federation.', 'company-vacancies' ).'</p>
				<p>'.__( 'For example, if you specify <code>Salary = 100 and Currency code = EUR</code>, vacancies will be found where the salary bracket is indicated in rubles and, after conversion to Euro, is close to 100 EUR.', 'company-vacancies' ).'</p>
				<p>'.__( 'By default, vacancies will also be found in which the salary fork is not specified. To filter such vacancies, use <code>Show vacancies with salary only = yes</code>.', 'company-vacancies' ).'</p>
			</div>';

	} // end salary_head_hunter

	public function label_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="label" name="wvcl_head_hunter[label]" value="' . esc_attr($options['label']) . '" />
			<div class="description" id="tagline-label">
				<p>'.__( 'It is necessary to transfer the <code>id</code> from the <code>Vacancy Tags</code> directory to', 'company-vacancies' ).' <a href="https://application-interface.com/wvcl/dictionaries/?TB_iframe&width=1140&height=600" class="thickbox" rel="nofollow" target="_blank">/dictionaries</a>.</p>
				<p>'.__( 'Multiple values may be specified.', 'company-vacancies' ).'</p>
			</div>';
			
	} // end label_head_hunter

	public function only_with_salary_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<select id="only_with_salary" name="wvcl_head_hunter[only_with_salary]">
				<option value="false" ' . selected( esc_attr($options['only_with_salary']), 'false', false) . '>'. __( 'No', 'company-vacancies' ) . '</option>
				<option value="true"' . selected( esc_attr($options['only_with_salary']), 'true', false) . '>' . __( 'Yes', 'company-vacancies' ) . '</option>
			</select>
			<div class="description" id="tagline-only_with_salary">
				<p>'.__( 'Possible values: <code>Yes</code> or <code>No</code>.', 'company-vacancies' ).'</p>
				<p>'.__( 'By default, <code>No</code> is used.', 'company-vacancies' ).'</p>
			</div>';

	} // end only_with_salary_head_hunter

	public function period_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="period" name="wvcl_head_hunter[period]" value="' . esc_attr($options['period']) . '" />
			<div class="description" id="tagline-period">
				<p>'.__( 'Maximum value:', 'company-vacancies' ).' <code>30</code>.</p>
			</div>';
			
	} // end period_head_hunter

	public function date_from_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="date_from" name="wvcl_head_hunter[date_from]" value="' . esc_attr($options['date_from']) . '" placeholder="___-__-__" />
			<div class="description" id="tagline-date_from">
				<p>'.__( 'Cannot be passed along with the <code>Number of days within which vacancies are to be found</code> parameter.', 'company-vacancies' ).'</p>
				<p>'.__( 'The value is specified in the format', 'company-vacancies' ).' <a href="https://github.com/hhru/api/blob/master/docs/general.md#date-format" rel="nofollow" target="_blank">ISO 8601</a> - <code>YYYY-MM-DD</code> '.__( 'or to the nearest second', 'company-vacancies' ).' <code>YYYY-MM-DDThh:mm:ss±hhmm</code>.</p>
				<p>'.__( 'The specified value will be rounded up to the nearest 5 minutes.', 'company-vacancies' ).'</p>
			</div>';

	} // end date_from_head_hunter

	public function date_to_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="date_to" name="wvcl_head_hunter[date_to]" value="' . esc_attr($options['date_to']) . '" placeholder="___-__-__" />
			<div class="description" id="tagline-date_to">
				<p>'.__( 'It must be passed only in pair with the <code>Date parameter, which limits the range of vacancies publication dates from below</code>.', 'company-vacancies' ).'</p>
				<p>'.__( 'Cannot be passed along with the <code>Number of days within which vacancies are to be found</code> parameter.', 'company-vacancies' ).'</p>
				<p>'.__( 'The value is specified in the format', 'company-vacancies' ).' <a href="https://github.com/hhru/api/blob/master/docs/general.md#date-format" rel="nofollow" target="_blank">ISO 8601</a> - <code>YYYY-MM-DD</code> '.__( 'or to the nearest second', 'company-vacancies' ).' <code>YYYY-MM-DDThh:mm:ss±hhmm</code>.</p>
				<p>'.__( 'The specified value will be rounded up to the nearest 5 minutes.', 'company-vacancies' ).'</p>
			</div>';
			
	} // end date_to_head_hunter

	public function order_by_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="order_by" name="wvcl_head_hunter[order_by]" value="' . esc_attr($options['order_by']) . '" />
			<div class="description" id="tagline-order_by">
				<p>'.__( 'Reference with possible values: <code>vacancy_search_order</code> in', 'company-vacancies' ).' <a href="https://application-interface.com/wvcl/dictionaries/?TB_iframe&width=1140&height=600" class="thickbox" rel="nofollow" target="_blank">/dictionaries</a>.</p>
				<p>'.__( 'If sorting by distance from the geo-point <code>distance</code> is selected, you must also specify its coordinates', 'company-vacancies' ).' <code>sort_point_lat</code>,<code>sort_point_lng</code>.</p>
			</div>';
			
	} // end order_by_head_hunter

	public function clusters_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<select id="clusters" name="wvcl_head_hunter[clusters]">
				<option value="false" ' . selected( esc_attr($options['clusters']), 'false', false) . '>'. __( 'No', 'company-vacancies' ) . '</option>
				<option value="true"' . selected( esc_attr($options['clusters']), 'true', false) . '>' . __( 'Yes', 'company-vacancies' ) . '</option>
			</select>
			<div class="description" id="tagline-clusters">
				<p><a href="https://github.com/hhru/api/blob/master/docs/clusters.md" rel="nofollow" target="_blank">'.__( 'Clusters for a given search', 'company-vacancies' ).'</a>, '.__( 'default: <code>No</code>.', 'company-vacancies' ).'</p>
			</div>';
			
	} // end clusters_head_hunter

	public function describe_arguments_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<select id="describe_arguments" name="wvcl_head_hunter[describe_arguments]">
				<option value="false" ' . selected( esc_attr($options['describe_arguments']), 'false', false) . '>'. __( 'No', 'company-vacancies' ) . '</option>
				<option value="true"' . selected( esc_attr($options['describe_arguments']), 'true', false) . '>' . __( 'Yes', 'company-vacancies' ) . '</option>
			</select>
			<div class="description" id="tagline-describe_arguments">
				<p><a href="https://github.com/hhru/api/blob/master/docs/vacancies_search_arguments.md" rel="nofollow" target="_blank">'.__( 'Description of search parameters used', 'company-vacancies' ).'</a>, '.__( 'default: <code>No</code>.', 'company-vacancies' ).'</p>
			</div>';
			
	} // end describe_arguments_head_hunter

	public function no_magic_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<select id="no_magic" name="wvcl_head_hunter[no_magic]">
				<option value="false" ' . selected( esc_attr($options['no_magic']), 'false', false) . '>'. __( 'No', 'company-vacancies' ) . '</option>
				<option value="true"' . selected( esc_attr($options['no_magic']), 'true', false) . '>' . __( 'Yes', 'company-vacancies' ) . '</option>
			</select>
			<div class="description" id="tagline-no_magic">
				<p>'.__( 'If the value is <code>Yes</code>, disable automatic conversion of vacancies.', 'company-vacancies' ).'</p>
				<p>'.__( 'The default is <code>No</code>. When automatic conversion is enabled, an attempt will be made to change the user`s text query to a set of parameters.', 'company-vacancies' ).'</p> 
				<p>'.__( 'For example, the query <code>Text field = Moscow accountant 100500</code> will be converted to <code>Text field = accountant and Show vacancies with salary only = Yes and Region = Moscow and Salary amount = 100500</code>.', 'company-vacancies' ).'</p>
			</div>';
			
	} // end no_magic_head_hunter

	public function validate_field( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

			} // end if

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_field', $output, $input );

	} // end validate_field

}