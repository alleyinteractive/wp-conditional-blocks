<?php
/**
 * This file registers REST endpoints.
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks;

/**
 * Boots the endpoints.
 *
 * @return void
 */
function boot_endpoints(): void {
	$endpoints = new Endpoints();
	$endpoints->boot();
}

boot_endpoints();
