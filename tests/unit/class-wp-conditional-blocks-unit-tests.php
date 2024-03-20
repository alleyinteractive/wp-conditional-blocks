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
class WP_Conditional_Blocks_Unit_Tests extends TestCase {
	/**
	 * Tests the add and get condition methods.
	 *
	 * @return void
	 */
	public function test_add_and_get_condition() {
		$instance = WP_Conditional_Blocks::instance();
		$instance->add_condition( 'Condition 1', 'condition-1', fn() => true );
		$instance->add_condition( 'Condition 2', 'condition-2', fn() => true );

		$conditions = $instance->get_conditions();

		$this->assertCount( 2, $conditions );
		$this->assertContainsOnlyInstancesOf( \Closure::class, array_column( $conditions, 'callable' ) );
	}
}
