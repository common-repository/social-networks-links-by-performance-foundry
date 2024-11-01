<?php
/**
Plugin Name: Social Networks Links by Performance Foundry
Plugin URI:  http://performancefoundry.com
Description: Easily add any links to your social networks accounts to your website, using a widget, shortcode or adding a function to your template.
Version:     0.3.0
Author:      Performance Foundry
Author URI:  http://performancefoundry.com
License:     GPLv2 or later
Domain Path: /languages
Text Domain: foundry-social-links

Foundry Social Networks Links is free software: you can redistribute it
and/or modify it under the terms of the GNU General Public License as published
by the Free Software Foundation, either version 2 of the License, or
any later version.

Foundry Social Networks Links is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Foundry Social Networks Links.
If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 *
 * @package Foundry Social Networks Links
 * @category Core
 * @author Performance Foundry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

if ( ! class_exists( 'Foundry_Social_Links' ) ) {

	// Define Plugin Constants.
	define( 'FSL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	define( 'FSL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

	/**
	 * Foundry_Social_Links
	 */
	class Foundry_Social_Links {

		/**
		 * Current Version
		 *
		 * @var string
		 */
		public $version = '0.1.1';

		/**
		 * Suffix for Scripts Loading
		 *
		 * @var string
		 */
		public $suffix = '';

		/**
		 * Single instance of the class
		 *
		 * @var Foundry_Social_Links The single instance of the class
		 * @since 0.0.1
		 */
		protected static $instance = null;

		/**
		 * Main Foundry_Social_Links Instance
		 *
		 * Ensures only one instance of Foundry Social Links is loaded or can be loaded.
		 *
		 * @since 0.0.1
		 * @static
		 * @see foundry_SL()
		 * @return Foundry Social Links - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @since 0.0.1
		 */
		public function __construct() {
			$this->suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		}

		/**
		 * Initiate our hooks
		 *
		 *  @since 0.0.1
		 */
		public function init_hooks() {

			add_action( 'init', array( $this, 'init' ), 0 );
			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		}

		/**
		 * Init Actions according to requests
		 *
		 *  @since 0.0.1
		 */
		public function init() {

			// Load CMB2.
			if ( file_exists( __DIR__ . '/vendor/cmb2/init.php' ) ) {
				require_once __DIR__ . '/vendor/cmb2/init.php';
			} elseif ( file_exists( __DIR__ . '/vendor/CMB2/init.php' ) ) {
				require_once __DIR__ . '/vendor/CMB2/init.php';
			}

		}

		/**
		 * Load Plugin Text-domain for translations
		 */
		public function load_plugin_textdomain() {

			load_plugin_textdomain( 'foundry-social-links', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * What type of request is this?
		 * string $type ajax, frontend or admin
		 *
		 * @param string $type Request Type.
		 * @return bool
		 */
		public function is_request( $type ) {
			switch ( $type ) {
				case 'admin':
					return is_admin();
				case 'ajax':
					return defined( 'DOING_AJAX' );
				case 'cron':
					return defined( 'DOING_CRON' );
				case 'frontend':
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			}
		}

		/**
		 * Include core files used in admin and on the frontend.
		 *
		 * @version Trunk
		 */
		public function includes() {

			// Include Classes.
			include_once 'includes/class-foundry-social-links-widget.php';
			include_once 'includes/class-foundry-social-links-settings.php';
			include_once 'includes/class-foundry-social-links-front-end.php';
			include_once 'includes/foundry-social-links-functions.php';

			if ( $this->is_request( 'admin' ) ) {
				// Load vendor components.
				require_once __DIR__ . '/vendor/cmb2-fontawesome-icon-picker/cmb2-fontawesome-picker.php';
			}

			$this->settings = new Foundry_Social_Links_Settings();
			$this->settings->hooks();
			$this->front_end = new Foundry_Social_Links_Front_End();
		}

		/**
		 * Get social setting by meta key
		 *
		 * @param string $key meta key.
		 * @return string
		 */
		public function get_setting( $key ) {
			$settings = get_option( 'foundry_social_links_settings' );

			if ( ! isset( $settings[ $key ] ) ) {
				return false;
			}

			return $settings[ $key ];
		}
	}

	/**
	 * Returns the main instance of Foundry Social Links to prevent the need to use globals.
	 *
	 * @since  0.1.0
	 * @return Foundry_Social_Links
	 */
	function foundry_SL() {
		return Foundry_Social_Links::instance();
	}
	foundry_SL();
	foundry_SL()->includes();
	foundry_SL()->init_hooks();
}
