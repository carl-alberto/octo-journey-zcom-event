<?php
/**
 * Contains class for the settings.
 *
 * @package Event Organizer Tools \ Settings
 * @author Carl Alberto
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class used for the plugin setting.
 */
class Event_Organizer_Tools_Settings {

	/**
	 * The single instance of Event_Organizer_Tools_Settings.
	 *
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The main plugin object.
	 *
	 * @var 	object
	 * @access  public
	 * @since 	1.0.0
	 */
	public $parent = null;

	/**
	 * Prefix for plugin settings.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $base = '';

	/**
	 * Available settings for plugin.
	 *
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = array();

	/**
	 * Available settings for plugin.
	 *
	 * @param object $parent contains the parent object.
	 */
	public function __construct( $parent ) {
		$this->parent = $parent;

		// Change this to make your plugin settings unique.
		$this->base = $parent->base;

		// Initialise settings.
		add_action( 'init', array( $this, 'init_settings' ), 11 );

		// Register plugin settings.
		add_action( 'admin_init' , array( $this, 'register_settings' ) );

		// Add settings page to menu.
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

		// Add settings link to plugins page.
		add_filter( 'plugin_action_links_' . plugin_basename( $this->parent->file ) , array( $this, 'add_settings_link' ) );
	}

	/**
	 * Initialise settings.
	 *
	 * @return void
	 */
	public function init_settings() {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Add settings page to admin menu.
	 *
	 * @return void
	 */
	public function add_menu_item() {
		$page = add_options_page( __( 'Event Organizer Tools Settings', 'event-organizer-tools' ) , __( 'Event Organizer Tools Settings', 'event-organizer-tools' ) , 'manage_options' , $this->parent->_token . '_settings' ,  array( $this, 'settings_page' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
	}

	/**
	 * Load settings JS & CSS.
	 *
	 * @return void
	 */
	public function settings_assets() {

		// We're including the farbtastic script & styles here because they're needed for the colour picker
		// If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below.
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_script( 'farbtastic' );

		// We're including the WP media scripts here because they're needed for the image upload field.
		// If you're not including an image upload then you can leave this function call out.
		wp_enqueue_media();

		wp_register_script( $this->parent->_token . '-settings-js', $this->parent->assets_url . 'js/settings' . $this->parent->script_suffix . '.js', array( 'farbtastic', 'jquery' ), '1.0.0' );
		wp_enqueue_script( $this->parent->_token . '-settings-js' );
	}

	/**
	 * Add settings link to plugin list table.
	 *
	 * @param  array $links Existing links.
	 * @return array 		Modified links
	 */
	public function add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=' . $this->parent->_token . '_settings">' . __( 'Settings', 'event-organizer-tools' ) . '</a>';
		array_push( $links, $settings_link );
		return $links;
	}

	/**
	 * Build settings fields.
	 *
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields() {

		$settings['standard'] = array(
			'title'					=> __( 'Standard', 'event-organizer-tools' ),
			'description'			=> __( 'These are fairly standard form input fields.', 'event-organizer-tools' ),
			'fields'				=> array(
				array(
					'id' 			=> 'cb_reset',
					'label'			=> __( 'Reset All when deactivated', 'event-organizer-tools' ),
					'description'	=> __( 'Reset All when deactivated', 'event-organizer-tools' ),
					'type'			=> 'checkbox',
					'default'		=> '',
				),
				array(
					'id' 			=> 'text_field',
					'label'			=> __( 'Some Text' , 'event-organizer-tools' ),
					'description'	=> __( 'This is a standard text field.', 'event-organizer-tools' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'Placeholder text', 'event-organizer-tools' ),
				),
				array(
					'id' 			=> 'password_field',
					'label'			=> __( 'A Password' , 'event-organizer-tools' ),
					'description'	=> __( 'This is a standard password field.', 'event-organizer-tools' ),
					'type'			=> 'password',
					'default'		=> '',
					'placeholder'	=> __( 'Placeholder text', 'event-organizer-tools' ),
				),
				array(
					'id' 			=> 'secret_text_field',
					'label'			=> __( 'Some Secret Text' , 'event-organizer-tools' ),
					'description'	=> __( 'This is a secret text field - any data saved here will not be displayed after the page has reloaded, but it will be saved.', 'event-organizer-tools' ),
					'type'			=> 'text_secret',
					'default'		=> '',
					'placeholder'	=> __( 'Placeholder text', 'event-organizer-tools' ),
				),
				array(
					'id' 			=> 'text_block',
					'label'			=> __( 'A Text Block' , 'event-organizer-tools' ),
					'description'	=> __( 'This is a standard text area.', 'event-organizer-tools' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> __( 'Placeholder text for this textarea', 'event-organizer-tools' ),
				),
				array(
					'id' 			=> 'single_checkbox',
					'label'			=> __( 'An Option', 'event-organizer-tools' ),
					'description'	=> __( 'A standard checkbox - if you save this option as checked then it will store the option as \'on\', otherwise it will be an empty string.', 'event-organizer-tools' ),
					'type'			=> 'checkbox',
					'default'		=> '',
				),
				array(
					'id' 			=> 'select_box',
					'label'			=> __( 'A Select Box', 'event-organizer-tools' ),
					'description'	=> __( 'A standard select box.', 'event-organizer-tools' ),
					'type'			=> 'select',
					'options'		=> array( 'drupal' => 'Drupal', 'joomla' => 'Joomla', 'wordpress' => 'WordPress' ),
					'default'		=> 'wordpress',
				),
				array(
					'id' 			=> 'radio_buttons',
					'label'			=> __( 'Some Options', 'event-organizer-tools' ),
					'description'	=> __( 'A standard set of radio buttons.', 'event-organizer-tools' ),
					'type'			=> 'radio',
					'options'		=> array( 'superman' => 'Superman', 'batman' => 'Batman', 'ironman' => 'Iron Man' ),
					'default'		=> 'batman',
				),
				array(
					'id' 			=> 'multiple_checkboxes',
					'label'			=> __( 'Some Items', 'event-organizer-tools' ),
					'description'	=> __( 'You can select multiple items and they will be stored as an array.', 'event-organizer-tools' ),
					'type'			=> 'checkbox_multi',
					'options'		=> array( 'square' => 'Square', 'circle' => 'Circle', 'rectangle' => 'Rectangle', 'triangle' => 'Triangle' ),
					'default'		=> array( 'circle', 'triangle' ),
				),
			),
		);

		$settings['extra'] = array(
			'title'					=> __( 'Extra', 'event-organizer-tools' ),
			'description'			=> __( 'These are some extra input fields that maybe aren\'t as common as the others.', 'event-organizer-tools' ),
			'fields'				=> array(
				array(
					'id' 			=> 'number_field',
					'label'			=> __( 'A Number' , 'event-organizer-tools' ),
					'description'	=> __( 'This is a standard number field - if this field contains anything other than numbers then the form will not be submitted.', 'event-organizer-tools' ),
					'type'			=> 'number',
					'default'		=> '',
					'placeholder'	=> __( '42', 'event-organizer-tools' ),
				),
				array(
					'id' 			=> 'colour_picker',
					'label'			=> __( 'Pick a colour', 'event-organizer-tools' ),
					'description'	=> __( 'This uses WordPress\' built-in colour picker - the option is stored as the colour\'s hex code.', 'event-organizer-tools' ),
					'type'			=> 'color',
					'default'		=> '#21759B',
				),
				array(
					'id' 			=> 'an_image',
					'label'			=> __( 'An Image' , 'event-organizer-tools' ),
					'description'	=> __( 'This will upload an image to your media library and store the attachment ID in the option field. Once you have uploaded an imge the thumbnail will display above these buttons.', 'event-organizer-tools' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> '',
				),
				array(
					'id' 			=> 'multi_select_box',
					'label'			=> __( 'A Multi-Select Box', 'event-organizer-tools' ),
					'description'	=> __( 'A standard multi-select box - the saved data is stored as an array.', 'event-organizer-tools' ),
					'type'			=> 'select_multi',
					'options'		=> array( 'linux' => 'Linux', 'mac' => 'Mac', 'windows' => 'Windows' ),
					'default'		=> array( 'linux' ),
				),
			),
		);

		$settings = apply_filters( $this->parent->_token . '_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Register plugin settings.
	 *
	 * @return void
	 */
	public function register_settings() {
		if ( is_array( $this->settings ) ) {

			// Check posted/selected tab.
			// TODO: Do a more proper input validation.
			$current_section = '';
			if ( isset( $_POST['tab'] ) && $_POST['tab'] ) { // @codingStandardsIgnoreLine
				$current_section = $_POST['tab'];
			} else {
				if ( isset( $_GET['tab'] ) && $_GET['tab'] ) { // @codingStandardsIgnoreLine
					$current_section = $_GET['tab'];
				}
			}

			foreach ( $this->settings as $section => $data ) {

				if ( $current_section && $current_section !== $section ) {
					continue;
				}
				// Add section to page.
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), $this->parent->_token . '_settings' );

				foreach ( $data['fields'] as $field ) {

					// Validation callback for field.
					$validation = '';
					if ( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field.
					$option_name = $this->base . $field['id'];
					register_setting( $this->parent->_token . '_settings', $option_name, $validation );

					// Add field to page.
					add_settings_field( $field['id'], $field['label'], array( $this->parent->admin, 'display_field' ), $this->parent->_token . '_settings', $section, array( 'field' => $field, 'prefix' => $this->base ) );
				}

				if ( ! $current_section ) {
					break;
				}
			}
		}
	}

	/**
	 * Displays the description in the plugins  settings.
	 *
	 * @access public
	 * @param array $section Contains the ID and the description.
	 */
	public function settings_section( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html; // @codingStandardsIgnoreLine
	}

	/**
	 * Load settings page content.
	 *
	 * @return void
	 */
	public function settings_page() {

		// Build page HTML.
		$html = '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
		$html .= '<h2>' . __( 'Event Organizer Tools Settings' , 'event-organizer-tools' ) . '</h2>' . "\n";

		$tab = '';
		if ( isset( $_GET['tab'] ) && $_GET['tab'] ) { // @codingStandardsIgnoreLine
			$tab .= $_GET['tab'];
		}

		// Show page tabs.
		if ( is_array( $this->settings ) && 1 < count( $this->settings ) ) {
			$html .= '<h2 class="nav-tab-wrapper">' . "\n";
			$c = 0;
			foreach ( $this->settings as $section => $data ) {
				// Set tab class.
				$class = 'nav-tab';
				// @codingStandardsIgnoreLine
				if ( ! isset( $_GET['tab'] ) ) {
					if ( 0 === $c ) {
						$class .= ' nav-tab-active';
					}
				} else {
					// @codingStandardsIgnoreLine
					if ( isset( $_GET['tab'] ) && $section == $_GET['tab'] ) {
						$class .= ' nav-tab-active';
					}
				}

				// Set tab link.
				$tab_link = add_query_arg( array( 'tab' => $section ) );
				// @codingStandardsIgnoreLine
				if ( isset( $_GET['settings-updated'] ) ) {
					$tab_link = remove_query_arg( 'settings-updated', $tab_link );
				}

				// Output tab.
				$html .= '<a href="' . $tab_link . '" class="' . esc_attr( $class ) . '">' . esc_html( $data['title'] ) . '</a>' . "\n";

				++$c;
			}

			$html .= '</h2>' . "\n";
		}

		$html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";
				// Get settings fields.
				ob_start();
				settings_fields( $this->parent->_token . '_settings' );
				do_settings_sections( $this->parent->_token . '_settings' );
				$html .= ob_get_clean();
				$html .= '<p class="submit">' . "\n";
					$html .= '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '" />' . "\n";
					$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings' , 'event-organizer-tools' ) ) . '" />' . "\n";
				$html .= '</p>' . "\n";
			$html .= '</form>' . "\n";
		$html .= '</div>' . "\n";
		// @codingStandardsIgnoreLine
		echo $html;
	}

	/**
	 * Main Event_Organizer_Tools_Settings Instance.
	 *
	 * Ensures only one instance of Event_Organizer_Tools_Settings is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Event_Organizer_Tools()
	 * @param object $parent Contains the parent instance.
	 * @return Main Event_Organizer_Tools_Settings instance
	 */
	public static function instance( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html_e( 'Cheatin&#8217; huh?', 'event-organizer-tools' ), esc_html( $this->parent->_version ) );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html_e( 'Cheatin&#8217; huh?', 'event-organizer-tools' ), esc_html( $this->parent->_version ) );
	} // End __wakeup()

}
