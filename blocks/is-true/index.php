<?php
/**
 * Block Name: Is True.
 *
 * @package wp-conditional-blocks
 */

use function Alley\WP\WP_Conditional_Blocks\is_active_block;
use function Alley\WP\WP_Conditional_Blocks\is_active_parent_block;
use function Alley\WP\WP_Conditional_Blocks\on_bool;
use function Alley\WP\WP_Conditional_Blocks\pre_render_on_bool;

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function wp_conditional_blocks_is_true_block_init(): void {
	// Register the block by passing the location of block.json.
	register_block_type(
		__DIR__,
		[
			'render_callback' => fn ( $attributes, $content ) => $content,
		],
	);
}
add_action( 'init', 'wp_conditional_blocks_is_true_block_init' );

/**
 * Short-circuit the display of blocks inside if the outer condition isn't true.
 *
 * @param string|null   $pre_render   The pre-rendered content. Default null.
 * @param array         $parsed_block The block being rendered.
 * @param WP_Block|null $parent_block If this is a nested block, a reference to the parent block.
 */
function wp_conditional_blocks_pre_render_is_true_block( $pre_render, $parsed_block, $parent_block ): string|null {
	return pre_render_on_bool( 'wp-conditional-blocks/is-true', true, $pre_render, $parsed_block, $parent_block );
}
add_filter( 'pre_render_block', 'wp_conditional_blocks_pre_render_is_true_block', 10, 3 );
