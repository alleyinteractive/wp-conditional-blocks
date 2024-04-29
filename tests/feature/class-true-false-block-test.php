<?php
/**
 * WP Conditional Blocks Tests: Is True and Is False Block Feature Tests
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks\Tests\Feature;

use Alley\WP\WP_Conditional_Blocks\Conditions;
use Alley\WP\WP_Conditional_Blocks\Tests\Test_Case;

/**
 * A test suite for the is-true and is-false blocks.
 *
 * @link https://mantle.alley.com/testing/test-framework.html
 */
class True_False_Block_Test extends Test_Case {
	public function test_is_true_and_is_false_render_block_as_expected() {
		$post = self::factory()->post->as_models()->create_and_get([
			'post_content' => <<<HTML
				<!-- wp:wp-conditional-blocks/condition {"post":"","query":"is_single"} -->
				<div class="wp-block-wp-conditional-blocks-condition"><!-- wp:wp-conditional-blocks/is-true -->
				<div class="wp-block-wp-conditional-blocks-is-true"><!-- wp:paragraph -->
				<p>This is an is_single page.</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:wp-conditional-blocks/is-true -->

				<!-- wp:wp-conditional-blocks/is-false -->
				<div class="wp-block-wp-conditional-blocks-is-false"><!-- wp:paragraph -->
				<p>This is NOT an is_single page.</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:wp-conditional-blocks/is-false --></div>
				<!-- /wp:wp-conditional-blocks/condition -->
			HTML
		]);

		$this->get( $post->permalink() )
			->assertSee( 'This is an is_single page.' )
			->assertDontSee( 'This is NOT an is_single page.' );
	}
}
