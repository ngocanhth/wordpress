<?php
/**
 * Plugin Name: Olive One Click Demo Import
 * Description: One Click Demo Import for WordPress sites. Specially works for FSE Themes.
 * Author: Olive Themes
 * Author URI: https://www.olivethemes.com
 * Version: 1.0.5
 * Text Domain: olive-one-click-demo-import
 * Domain Path: /languages
 * Tested up to: 6.1
 *
 * Olive One Click Demo Import is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * You should have received a copy of the GNU General Public License
 * along with Olive One Click Demo Import. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Olive One Click Demo Import
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants.
define( 'OLIVE_ONE_CLICK_DEMO_IMPORT_VERSION', '1.0.5' );
define( 'OLIVE_ONE_CLICK_DEMO_IMPORT_BASE_DIR', plugin_dir_path( __FILE__ ) );
define( 'OLIVE_ONE_CLICK_DEMO_IMPORT_BASE_URL', plugin_dir_url( __FILE__ ) );
define( 'OLIVE_ONE_CLICK_DEMO_IMPORT_BASE_FILE', __FILE__ );

/**
 * Initialize function.
 *
 * @return void
 */
function olive_one_click_demo_init() {
	include 'inc/helpers.php';
	include 'inc/rest.php';
	include 'inc/admin-menu.php';
	include 'inc/admin-assets.php';
	include 'inc/import.php';
}

olive_one_click_demo_init();
