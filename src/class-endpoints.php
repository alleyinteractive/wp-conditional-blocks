<?php
/**
 * This file registers REST API Endpoints.
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks;

use Alley\WP\Types\Feature;

/**
 * Class Endpoints
 *
 * This class implements the Feature interface and registers REST API Endpoints.
 */
class Endpoints implements Feature {
	/**
	 * Boot the feature.
	 *
	 * @return void
	 */
	public function boot(): void {
		new Endpoint_Get_Conditions();
	}
}
