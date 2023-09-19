<?php
/**
 * WP Conditional Blocks Tests: Bootstrap
 *
 * @package wp-conditional-blocks
 */

/**
 * Visit {@see https://mantle.alley.com/testing/test-framework.html} to learn more.
 */
\Mantle\Testing\manager()
	->maybe_rsync_plugin()
	->with_sqlite()
	// Load the main file of the plugin.
	->loaded( fn () => require_once __DIR__ . '/../wp-conditional-blocks.php' )
	->install();
