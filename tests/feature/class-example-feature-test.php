<?php
/**
 * WP Conditional Blocks Tests: Example Feature Test
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks\Tests\Feature;

use Alley\WP\WP_Conditional_Blocks\Tests\Test_Case;

/**
 * A test suite for an example feature.
 *
 * @link https://mantle.alley.com/testing/test-framework.html
 */
class Example_Feature_Test extends Test_Case {
	/**
	 * An example test for the example feature. In practice, this should be updated to test an aspect of the feature.
	 */
	public function test_example() {
		$this->assertTrue( true );
		$this->assertNotEmpty( home_url() );
	}
}
