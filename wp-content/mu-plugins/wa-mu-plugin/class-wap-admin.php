<?php
/**
 * Shared classes
 * @package WAMUPlugins
 * @subpackage Shared
 * @since 1.0.0
 */

namespace WA;

if ( ! defined( 'ABSPATH' ) ) { // If this file is called directly.
	die( 'No script kiddies please!' );
}

/**
 * Shared class
 * Common functionalities required in the 'mu-plugins'.
 * @since 1.0.0
 */
class WAP_Admin {
	/**
	 * WA/Cache Object.
	 * @var object
	 */
	public $wap;

	/**
	 * The role or capability to view and use cache options.
	 * @var string
	 */
	private $view_role_or_capability;

	/**
	 * Plugin constructor.
	 * Sets the hooks required for the plugin's functionality.
	 * @param \WA\WAP $wap The WAP object.
	 */
	public function __construct( \WA\WAP $wap ) {
		$this->wap = $wap;
		$this->view_role_or_capability = set_view_role_or_capability();
		if ( WAMU_WHITELABEL === false ) {
			add_filter( 'admin_footer_text', array( $this, 'modify_admin_footer_text' ), 99 );
		}
	}

	/**
	 * Fix missing recource issues with mu plugin's static files
	 * @param string $path optional param which is added to the end of the returned string.
	 * @return string URL path of the WA-mu-plugins.
	 */
	public static function shared_resource_url( $path = '' ) {
		$mu_url = ( is_ssl() ) ? str_replace( 'http://', 'https://', WPMU_PLUGIN_URL ) : WPMU_PLUGIN_URL;
		$full_path = $mu_url . '/wa-mu-plugins/' . $path;

		if ( defined( 'WAMU_CUSTOM_MUPLUGIN_URL' ) && WAMU_CUSTOM_MUPLUGIN_URL !== '' ) {
			$full_path = WAMU_CUSTOM_MUPLUGIN_URL . '/wa-mu-plugins/' . $path;
		}

		return $full_path;
	}

	/**
	 * Modify Footer Text
	 * Modifies the thank you text in the bottom of the admin
	 */
	public function modify_admin_footer_text() {
		// Translators: %1$s WordPress, %2$s WA URL.
		return '<span id="footer-thankyou">' . sprintf( __( 'Thanks for creating with %1$s and hosting with %2$s', 'wa-mu-plugins' ), '<a href="https://wordpress.org/">WordPress</a>', '<a href="https://webactive.io" target="_blank">WA</a>' ) . '</span>';
	}

	/**
	 * AJAX Action to save custom path
	 * @return void
	 */
	public function action_wa_save_custom_path() {
		check_ajax_referer( 'save_plugin_options', 'wa_nonce' );

		$paths = get_option( 'wa-cache-additional-paths' );
		if ( empty( $paths ) ) {
			$paths = array();
		}

		$paths[] = array(
			'path' => sanitize_text_field( $_POST['path'] ),
			'type' => sanitize_text_field( wp_unslash( $_POST['type'] ) ),
		);
		$paths = array_values( $paths );

		update_option( 'wa-cache-additional-paths', $paths );

		die();
	}

	/**
	 * AJAX action to remove custom path.
	 * @return void
	 */
	public function action_wa_remove_custom_path() {
		check_ajax_referer( 'save_plugin_options', 'wa_nonce' );
		if ( ! isset( $_POST['index'] ) || ( isset( $_POST['index'] ) && is_int( $_POST['index'] ) ) ) {
			return;
		}

		$index = sanitize_text_field( wp_unslash( $_POST['index'] ) );
		$paths = get_option( 'wa-cache-additional-paths' );
		if ( ! empty( $paths[ $index ] ) ) {
			unset( $paths[ $index ] );
		}

		if ( count( $paths ) === 0 ) {
			delete_option( 'wa-cache-additional-paths' );
		} else {
			$paths = array_values( $paths );
			update_option( 'wa-cache-additional-paths', $paths );
		}

		die();
	}
}
