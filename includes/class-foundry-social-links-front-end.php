<?php
/**
 * Foundry_Social_Links_Front_End
 *
 * Handles Social Links Front End Functions
 *
 * @class    @Foundry_Social_Links_Front_End
 * @version  0.0.1
 * @package  Foundry_Social_Links/Core/Foundry_Social_Links_Front_End
 * @category Class
 * @author   Performance Foundry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Settings Page
 */
class Foundry_Social_Links_Front_End {

	/**
	 * Fields Prefix
	 *
	 * @var string
	 */
	private $prefix = '_foundry_';

	/**
	 * Fields Prefix
	 *
	 * @var string
	 */
	public $social_networks = array();

	/**
	 * Use Font Awesome Icons
	 *
	 * @var boolean
	 */
	private $use_fa_icon = false;

	/**
	 * Use Font Awesome 5 Icons
	 *
	 * @var boolean
	 */
	private $use_fa5_icon = false;

	/**
	 * Use Plugin Font Awesome
	 *
	 * @var boolean
	 */
	private $disable_fa_css = false;

	/**
	 * Use Plugin Style
	 *
	 * @var boolean
	 */
	private $disable_plugin_css = false;

	/**
	 * Open links in the same window/tab. By default, links should open in a new window/tab.
	 *
	 * @var bool
	 */
	private $open_same_window = false;

	/**
	 * Constructor
	 *
	 * @since 0.0.1
	 */
	public function __construct() {

		if ( 'on' === foundry_SL()->get_setting( $this->prefix . 'social_networks_fa' ) ) {
			$this->use_fa_icon = true;
		}

		if ( 'on' === foundry_SL()->get_setting( $this->prefix . 'social_networks_fa5' ) ) {
			$this->use_fa5_icon = true;
		}

		if ( 'on' === foundry_SL()->get_setting( $this->prefix . 'social_networks_load_fa' ) ) {
			$this->disable_fa_css = true;
		}

		if ( 'on' === foundry_SL()->get_setting( $this->prefix . 'social_networks_load_css' ) ) {
			$this->disable_plugin_css = true;
		}

		if ( 'on' === foundry_SL()->get_setting( $this->prefix . 'social_networks_open_same_window' ) ) {
			$this->open_same_window = true;
		}

		$this->social_networks = foundry_SL()->get_setting( $this->prefix . 'social_networks_links' );

		if ( ! $this->disable_fa_css ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'load_fa_css' ) );
		}

		if ( ! $this->disable_plugin_css ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'load_plugin_css' ) );
		}

		add_shortcode( 'foundry_social_links', array( $this, 'shortcode' ) );
	}

	/**
	 * Public Getter For Social Networks
	 *
	 * @return array Social Networks Array
	 */
	public function get_social_networks() {
		return $this->social_networks;
	}

	/**
	 * Echoes Social Networks HTML
	 *
	 * @param  boolean $display_name Display Social Network Name and Icon.
	 */
	public function the_social_networks( $display_name ) {
		?>
		<div class="foundry-social">
			<div class="foundry-social__wrapper">
			<?php

			foreach ( $this->social_networks as $network ) {

				$fa_icon         = '';
				$name            = '';
				$name_class      = '';
				$icon_name_class = '';
				$icon_color      = '';

				if ( ! empty( $network['url'] ) ) {

					if ( $display_name ) {
						$name            = $network['name'];
						$name_class      = 'foundry-social__link--name';
						$icon_name_class = 'foundry-social__icon--name';
					}

					$custom_class = isset( $network['custom_class'] ) ? $network['custom_class'] : '';

					if ( $this->use_fa_icon ) {
						$fa_class = $this->use_fa5_icon ? 'fab' : 'fa';
						$fa_icon  = '<i class="' . $fa_class . ' ' . esc_html( $network['icon'] ) . ' foundry-social__icon ' . $icon_name_class . '" aria-hidden="true"></i>';
					}

					if ( ! $this->disable_plugin_css ) {
						$icon_color = 'style="background-color: ' . esc_attr( $network['color'] ) . '"';
					}

					$target = ' rel="noopener nofollow" target="_blank"';
					if ( $this->open_same_window ) {
						$target = '';
					}

					echo '<a ' . wp_kses_post( $icon_color ) . ' class="foundry-social__link ' . esc_attr( $custom_class ) . ' ' . esc_attr( $name_class ) . ' " href="' . esc_url( $network['url'] ) . '"' . $target . '>' . wp_kses_post( $fa_icon ) . esc_html( $name ) . '</a>';
				}
			}
			?>
			</div>
		</div>
		<?php
	}

	/**
	 * Add Shortcode to display Social Network Links
	 *
	 * @param  array $atts Attributes.
	 *
	 * @return string      Social Networks List HTML
	 */
	public function shortcode( $atts ) {

		$display_name = false;

		$atts = shortcode_atts(
			array(
				'display_name' => false,
			),
			$atts,
			'foundry_social_links'
		);

		if ( 'true' === $atts['display_name'] ) {
			$display_name = true;
		}

		ob_start();
		$this->the_social_networks( $display_name );

		return ob_get_clean();
	}

	/**
	 * Load Font Awesome CSS when required
	 */
	public function load_fa_css() {
		if ( foundry_SL()->is_request( 'frontend' ) ) {
			wp_enqueue_style( 'foundrysl-fa-css', FSL_PLUGIN_URL . 'assets/css/font-awesome.min.css', array(), foundry_SL()->version, 'all' );

		}
	}

	/**
	 * Load Plugin CSS when required
	 */
	public function load_plugin_css() {
		if ( foundry_SL()->is_request( 'frontend' ) ) {
			wp_enqueue_style( 'foundrysl-css', FSL_PLUGIN_URL . 'assets/css/foundrysl.css', array(), foundry_SL()->version, 'all' );

		}
	}
}
