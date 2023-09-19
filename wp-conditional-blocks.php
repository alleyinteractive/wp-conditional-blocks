<?php
/**
 * Plugin Name: WP Conditional Blocks
 * Plugin URI: https://github.com/alleyinteractive/wp-conditional-blocks
 * Description: WordPress blocks that can be shown based on conditions
 * Version: 0.1.0
 * Author: Alley Interactive
 * Author URI: https://github.com/alleyinteractive/wp-conditional-blocks
 * Requires at least: 5.9
 * Tested up to: 6.2
 *
 * Text Domain: wp-conditional-blocks
 * Domain Path: /languages/
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Root directory to this plugin.
 */
define( 'WP_CONDITIONAL_BLOCKS_DIR', __DIR__ );

// Check if Composer is installed (remove if Composer is not required for your plugin).
if ( ! file_exists( __DIR__ . '/vendor/wordpress-autoload.php' ) ) {
	// Will also check for the presence of an already loaded Composer autoloader
	// to see if the Composer dependencies have been installed in a parent
	// folder. This is useful for when the plugin is loaded as a Composer
	// dependency in a larger project.
	if ( ! class_exists( \Composer\InstalledVersions::class ) ) {
		\add_action(
			'admin_notices',
			function () {
				?>
				<div class="notice notice-error">
					<p><?php esc_html_e( 'Composer is not installed and wp-conditional-blocks cannot load. Try using a `*-built` branch if the plugin is being loaded as a submodule.', 'wp-conditional-blocks' ); ?></p>
				</div>
				<?php
			}
		);

		return;
	}
} else {
	// Load Composer dependencies.
	require_once __DIR__ . '/vendor/wordpress-autoload.php';
}

// Load the plugin's main files.
require_once __DIR__ . '/src/assets.php';
require_once __DIR__ . '/src/meta.php';

/**
 * Instantiate the plugin.
 */
function main(): void {
	// ...
}
main();
