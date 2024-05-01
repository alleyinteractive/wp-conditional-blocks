<?php
/**
 * Block Name: Query Condition.
 *
 * @package wp-conditional-blocks
 *
 * phpcs:disable Squiz.Commenting.FunctionComment.MissingParamTag
 * phpcs:disable Squiz.Commenting.FunctionComment.MissingParamName
 */

use Alley\WP\WP_Conditional_Blocks\Global_Post_Query;
use Alley\WP\WP_Conditional_Blocks\Validator\Slug_Is_In_Category;
use \Alley\WP\WP_Conditional_Blocks\Conditions;

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function wp_conditional_blocks_condition_block_init(): void {
	// Register the block by passing the location of block.json.
	register_block_type(
		__DIR__,
		[
			'render_callback' => fn ( $attributes, $content ) => $content,
		],
	);
}
add_action( 'init', 'wp_conditional_blocks_condition_block_init' );

/**
 * Evaluate the result of condition block attributes.
 *
 * @param array{
 *   attrs?: array{
 *      condition?: string,
 *   }
 * } $parsed_block Parsed condition block.
 * @param array{'postId'?: int} $context Available context.
 * @return bool
 */
function wp_conditional_blocks_condition_block_result( array $parsed_block, array $context ): bool {
	global $wp_query;

	$condition_slug = '';

	if ( isset( $parsed_block['attrs']['condition'] ) ) {
		$condition_slug = $parsed_block['attrs']['condition'];
	}

	$wp_block_condition = Conditions::get_instance()->get_condition( $condition_slug );
	// Validate callable function.
	if (
		empty( $wp_block_condition['callable'] )
		|| ! is_callable( $wp_block_condition['callable'] )
		|| ! $wp_query instanceof WP_Query
	) {
		return false;
	}

	// Execute conditional's callable.
	$callable_result = call_user_func( $wp_block_condition['callable'] );

	 /**
	 * Filters the condition block's result for the given condition.
	 *
	 * @param bool     $result   Condition result.
	 * @param array    $context  Available context.
	 * @param WP_Query $wp_query Global query object.
	 */
	return apply_filters( "wp_conditional_blocks_condition_block_{$wp_block_condition['slug']}_condition", $callable_result, $context, $wp_query );
}
