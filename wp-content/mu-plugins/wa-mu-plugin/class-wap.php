<?php
/**
 * Main WAP class.
 *
 * This class is the global class for all the WAP classes and functionality
 *
 * @package WAMUPlugins
 * @since 3.0.0
 */

namespace WA;

if ( ! defined( 'ABSPATH' ) ) { // If this file is called directly.
	die( 'No script kiddies please!' );
}

/**
 * Cache class.
 *
 * Offers users cache settings and initiates full page and object cache clearing.
 *
 * @since 1.0.0
 */
class WAP {

	/**
	 * WAP_Admin instance.
	 *
	 * @var WAP_Admin
	 */
	public $wap_admin;

	/**
	 * Banned Plugins instance
	 *
	 * @var Banned_Plugins
	 */
	public $banned_plugins;

	/**
	 * Class constructor.
	 */
	public function __construct() {
		// Init the cache classes.
		add_action( 'init', array( $this, 'init_wap' ), 5 );
	}

	/**
	 * Init the classes when the WP is initialised, this is to ensure that the classes, global variables, and WordPress core functions are ready.
	 *
	 * @since 2.0.16
	 *
	 * @return void
	 */
	public function init_wap() {
		$this->wap_admin = new WAP_Admin( $this );
		$this->banned_plugins = new Banned_Plugins();
	}

}

global $WA_muplugin;
$WA_muplugin = new WAP();