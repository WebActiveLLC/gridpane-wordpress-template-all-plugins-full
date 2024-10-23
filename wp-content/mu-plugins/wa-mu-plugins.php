<?php
/**
 * Plugin Name: WA Must-use Plugins
 * Description: The plugin designed to work on WA's managed WordPress hosting platform.
 * Version: 1.0.0
 * Author: WA Team
 * Text Domain: WA-mu-plugins
 * Domain Path: /WA-mu-plugins/shared/translations
 *
 * @package WAMUPlugins
 */

if ( ! defined( 'ABSPATH' ) ) { // If this file is called directly.
	die( 'No script kiddies please!' );
}

define( 'WAMU_VERSION', '1.0.0' );

if ( ! defined( 'WAMU_WHITELABEL' ) ) {
	define( 'WAMU_WHITELABEL', false );
}

require_once plugin_dir_path( __FILE__ ) . 'wa-mu-plugins/utils.php';
require_once plugin_dir_path( __FILE__ ) . 'wa-mu-plugins/class-wap-admin.php';
require_once plugin_dir_path( __FILE__ ) . 'wa-mu-plugins/class-banned-plugins.php';
require_once plugin_dir_path( __FILE__ ) . 'wa-mu-plugins/class-wap.php';