<?php
/**
 * Foundry_Social_Links_Settings
 *
 * Handles Social Links Settings Page
 *
 * @class    @Foundry_Social_Links_Settings
 * @version  0.0.1
 * @package  Foundry_Social_Links/Core/Foundry_Social_Links_Settings
 * @category Class
 * @author   Performance Foundry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Settings Page
 */
class Foundry_Social_Links_Settings {

	/**
	 * Option key, and option page slug
	 *
	 * @var string
	 */
	private $key = 'foundry_social_links_settings';

	/**
	 * Options page metabox id
	 *
	 * @var string
	 */
	private $metabox_id = 'foundry_social_links_option_metabox';

	/**
	 * Options Page title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 *
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Fields Prefix
	 *
	 * @var string
	 */
	private $prefix = '_foundry_';

	/**
	 * Constructor
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		// Set our title.
		$this->title = __( 'Social Links Settings', 'foundry-social-links' );
	}

	/**
	 * Initiate our hooks
	 *
	 * @since 0.0.1
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
	}

	/**
	 * Register our setting to WP
	 *
	 * @since  0.0.1
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 *
	 * @since 0.0.1
	 */
	public function add_options_page() {
		$this->options_page = add_options_page( $this->title, esc_html__( 'Social Links', 'foundry-social-links' ), 'manage_options', $this->key, array( $this, 'admin_page_display' ) );

		// Include CMB CSS in the head to avoid FOUC.
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
		add_action( 'admin_print_scripts-' . $this->options_page, array( $this, 'load_settings_scripts' ) );
	}

	/**
	 * Enqueue script on settings page
	 *
	 * @return void
	 */
	public function load_settings_scripts() {

		wp_enqueue_script( 'foundry-sl-settings-js', FSL_PLUGIN_URL . 'assets/js/settings.js', array( 'jquery' ), foundry_SL()->version, 'all' );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 *
	 * @since  0.0.1
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo esc_attr( $this->key ); ?>">
			<h2><?php esc_html_e( 'Social Links Settings', 'foundry-social-links' ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
		<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 *
	 * @since  0.0.1
	 */
	public function add_options_page_metabox() {

		// Hook in our save notices.
		add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );

		$settings = new_cmb2_box(
			array(
				'id'         => $this->metabox_id,
				'hookup'     => false,
				'cmb_styles' => false,
				'classes'    => 'js-fa-check',
				'show_on'    => array(
					'key'   => 'options-page',
					'value' => array( $this->key ),
				),
			)
		);

		$settings->add_field(
			array(
				'id'   => $this->prefix . 'gen_title',
				'type' => 'title',
				'name' => esc_html__( 'General Settings', 'foundry-social-links' ),
			)
		);

		$settings->add_field(
			array(
				'id'          => $this->prefix . 'social_networks_fa',
				'type'        => 'checkbox',
				'description' => esc_html__( 'Use Font Awesome Icons', 'foundry-social-links' ),
			)
		);

		$settings->add_field(
			array(
				'id'          => $this->prefix . 'social_networks_fa5',
				'type'        => 'checkbox',
				'description' => esc_html__( 'Use Font Awesome 5 Icons (using external stylesheet)', 'foundry-social-links' ),
			)
		);

		$settings->add_field(
			array(
				'id'          => $this->prefix . 'social_networks_load_fa',
				'type'        => 'checkbox',
				'description' => esc_html__( 'Disable plugin Font Awesome (check this if your theme already has font awesome embeded)', 'foundry-social-links' ),
			)
		);

		$settings->add_field(
			array(
				'id'          => $this->prefix . 'social_networks_load_css',
				'type'        => 'checkbox',
				'description' => esc_html__( 'Disable Plugin Style', 'foundry-social-links' ),
			)
		);

		$settings->add_field(
			array(
				'id'          => $this->prefix . 'social_networks_open_same_window',
				'type'        => 'checkbox',
				'description' => esc_html__( 'Open links in same window', 'foundry-social-links' ),
			)
		);

		// Set our CMB2 fields.
		$social_networks = $settings->add_field(
			array(
				'id'      => $this->prefix . 'social_networks_links',
				'type'    => 'group',
				'name'    => __( 'Social Network Links', 'foundry-social-links' ),
				'options' => array(
					'group_title'   => __( 'Social Network {#}', 'foundry-social-links' ),
					'add_button'    => __( 'Add New Link', 'foundry-social-links' ),
					'remove_button' => __( 'Remove Link', 'foundry-social-links' ),
					'sortable'      => true,
					'closed'        => true,
				),
			)
		);

		$settings->add_group_field(
			$social_networks,
			array(
				'name'       => __( 'Name', 'foundry-social-links' ),
				'id'         => 'name',
				'type'       => 'text',
				'attributes' => array(
					'required' => 'required',
				),
			)
		);

		$settings->add_group_field(
			$social_networks,
			array(
				'name' => __( 'Icon', 'foundry-social-links' ),
				'id'   => 'icon',
				'type' => 'fontawesome_icon',
			)
		);

		$settings->add_group_field(
			$social_networks,
			array(
				'name' => __( 'Custom Class', 'foundry-social-links' ),
				'id'   => 'custom_class',
				'type' => 'text_small',
			)
		);

		$settings->add_group_field(
			$social_networks,
			array(
				'name' => __( 'Color', 'foundry-social-links' ),
				'id'   => 'color',
				'type' => 'colorpicker',
			)
		);

		$settings->add_group_field(
			$social_networks,
			array(
				'name'       => __( 'URL', 'foundry-social-links' ),
				'id'         => 'url',
				'type'       => 'text_url',
				'attributes' => array(
					'required' => 'required',
				),
			)
		);

	}

	/**
	 * Show fontawesome icon select only if option is enabled
	 *
	 * @return boolean Show.
	 */
	private function show_fontawesome() {
		if ( 'on' === foundry_SL()->get_setting( $this->prefix . 'social_networks_fa' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Register settings notices for display
	 *
	 * @since  0.0.1
	 * @param  int   $object_id Option key.
	 * @param  array $updated   Array of updated fields.
	 * @return void
	 */
	public function settings_notices( $object_id, $updated ) {
		if ( $object_id !== $this->key || empty( $updated ) ) {
			return;
		}
		add_settings_error( $this->key . '-notices', '', __( 'Settings updated.', 'foundry-social-links' ), 'updated' );
		settings_errors( $this->key . '-notices' );
	}

	/**
	 * Public getter method for retrieving protected/private variables
	 *
	 * @since  0.0.1
	 * @param  string $field Field to retrieve.
	 *
	 * @return mixed   Field value or exception is thrown.
	 * @throws Exception Exception if invalid property.
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve.
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}
		throw new Exception( 'Invalid property: ' . $field );
	}
}
