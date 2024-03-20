<?php
/**
 * WP Conditional Blocks Tests
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks\Tests\Unit;

use Alley\WP\WP_Conditional_Blocks\WP_Conditional_Blocks;
use PHPUnit\Framework\TestCase;

/**
 * WP Conditional Blocks unit test suite.
 *
 * @link https://mantle.alley.com/testing/test-framework.html
 */
class WP_Conditional_Blocks_Tests extends TestCase {
	/**
	 *
	 *
	 * @return void
	 */
	public function test_add_condition() {
		$conditional_blocks = WP_Conditional_Blocks::instance();
		$conditional_blocks->add_condition( 'Condition from Unit Test', 'is_home', fn() => is_home() );

		// Assert the condition was added.
		$this->assertNotEmpty( $conditional_blocks::$conditions, 'The conditions are not empty' );
	}
}
