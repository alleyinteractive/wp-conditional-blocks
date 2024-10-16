<?php
/**
 * WP Conditional Blocks Tests
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks\Tests\Unit;

use Alley\WP\WP_Conditional_Blocks\Conditions;
use PHPUnit\Framework\TestCase;

/**
 * WP Conditional Blocks unit test suite.
 *
 * @link https://mantle.alley.com/testing/test-framework.html
 */
class Conditional_Blocks_Unit_Tests extends TestCase {
	/**
	 * Contains a static instance of the class.
	 *
	 * @var Conditions
	 */
	private static Conditions $instance;

	/**
	 * Fixture method to set up the state of the tests.
	 *
	 * @return void
	 */
	public static function setUpBeforeClass(): void {
		self::$instance = Conditions::get_instance();
	}

	/**
	 * Fixture method to set up the state of each test.
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		// Reset the conditions before each test.
		self::$instance->reset_conditions_for_testing();
	}

	/**
	 * Tests the get conditions method.
	 *
	 * @return void
	 */
	public function test_get_conditions() {
		$this->add_test_conditions(
			[
				[
					'name'     => 'Condition 1',
					'slug'     => 'condition-1',
					'callable' => fn() => true,
				],
				[
					'name'     => 'Condition 2',
					'slug'     => 'condition-2',
					'callable' => fn() => true,
				],
			]
		);

		$conditions = self::$instance->get_conditions();

		$this->assertCount( 2, $conditions );
		$this->assertContainsOnlyInstancesOf( \Closure::class, array_column( $conditions, 'callable' ) );
	}

	/**
	 * Tests the get condition method.
	 *
	 * @return void
	 */
	public function test_get_condition() {
		$this->add_test_conditions(
			[
				[
					'name'     => 'Condition 1',
					'slug'     => 'condition-1',
					'callable' => fn() => true,
				],
				[
					'name'     => 'Condition 2',
					'slug'     => 'condition-2',
					'callable' => fn() => true,
				],
			]
		);

		$condition_1 = self::$instance->get_condition( 'condition-1' );
		$condition_2 = self::$instance->get_condition( 'condition-2' );

		foreach ( [ $condition_1, $condition_2 ] as $condition ) {
			$this->assertIsArray( $condition );
			$this->assertArrayHasKey( 'name', $condition );
			$this->assertArrayHasKey( 'slug', $condition );
			$this->assertArrayHasKey( 'callable', $condition );
		}
	}

	/**
	 * Helper method to add multiple conditions at once.
	 *
	 * @param array $conditions Conditions to be added.
	 *
	 * @return void
	 */
	private function add_test_conditions( array $conditions ): void {
		foreach ( $conditions as $condition ) {
			self::$instance->add_condition(
				$condition['name'],
				$condition['slug'],
				$condition['callable'],
			);
		}
	}

	/**
	 * Test the get_conditions endpoint.
	 *
	 * @return void
	 */
	public function test_get_conditions_endpoint(): void {
		$this->add_test_conditions(
			[
				[
					'name'     => 'Condition 1',
					'slug'     => 'condition-1',
					'callable' => fn() => true,
				],
				[
					'name'     => 'Condition 2',
					'slug'     => 'condition-2',
					'callable' => fn() => true,
				],
			]
		);

		// Create a user and log them in.
		$user_id = wp_create_user( 'test_user', 'password', 'unit@test.com' );
		wp_set_current_user( $user_id );

		// Perform the REST request.
		$request  = new \WP_REST_Request( 'GET', '/conditional-blocks/v1/get-conditions' );
		$server   = rest_get_server();
		$response = $server->dispatch( $request );
		$data     = $response->get_data();

		// Log out the user.
		wp_set_current_user( null );

		$this->assertIsArray( $data );

		// We should have two items in the message, ie, both conditions.
		$this->assertCount( 2, $data['message'] );
	}
}
