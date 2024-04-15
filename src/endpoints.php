<?php
/**
 * This file registers REST API Endpoints.
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks;

/**
 * Registers endpoints.
 *
 * @return void
 */
function register_endpoints(): void {
	new Endpoint_Get_Conditions();
}
register_endpoints();
