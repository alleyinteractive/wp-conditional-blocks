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
	 * @var WP_Conditional_Blocks
	 */
	private static WP_Conditional_Blocks $instance;

	public static function setUpBeforeClass(): void {
		self::$instance = WP_Conditional_Blocks::instance();
	}

	public function setUp(): void {
		// Reset the conditions before each test.
		self::$instance->reset_conditions_for_testing();
	}

	/**
	 * Tests the get conditions methods.
	 *
	 * @return void
	 */
	public function test_get_conditions() {
		$this->add_test_conditions(
			[
				[
					'name'     => 'Condition 1',
					'slug'     => 'condition-1',
					'callable' => fn() => true
				],
				[
					'name'     => 'Condition 2',
					'slug'     => 'condition-2',
					'callable' => fn() => true
				]
			]
		);

		$conditions = self::$instance->get_conditions();

		$this->assertCount( 2, $conditions );
		$this->assertContainsOnlyInstancesOf( \Closure::class, array_column( $conditions, 'callable' ) );
	}

	public function test_get_condition() {
		$this->add_test_conditions(
			[
				[
					'name'     => 'Condition 1',
					'slug'     => 'condition-1',
					'callable' => fn() => true
				],
				[
					'name'     => 'Condition 2',
					'slug'     => 'condition-2',
					'callable' => fn() => true
				]
			]
		);

		$condition_1 = self::$instance->get_condition( 'condition-1' );
		$condition_2 = self::$instance->get_condition( 'condition-2' );

		foreach( [ $condition_1, $condition_2 ] as $condition ) {
			$this->assertIsArray( $condition );
			$this->assertArrayHasKey( 'name', $condition );
			$this->assertArrayHasKey( 'slug', $condition );
			$this->assertArrayHasKey( 'callable', $condition );
		}
	}

	/**
	 * Helper method to add multiple conditions at once.
	 *
	 * @param array $conditions
	 *
	 * @return void
	 */
	private function add_test_conditions( array $conditions ): void {
		foreach( $conditions as $condition ) {
			self::$instance->add_condition(
				$condition['name'],
				$condition['slug'],
				$condition['callable'],
			);
		}
	}

}
