<?php
/**
 * Block Name: Counter.
 *
 * @package wp-conditional-blocks
 *
 * phpcs:disable Squiz.Commenting.FunctionComment.MissingParamTag
 * phpcs:disable Squiz.Commenting.FunctionComment.MissingParamName
 */

use Alley\WP\WP_Conditional_Blocks\Block;

use function Alley\WP\add_filter_side_effect;
use function Alley\WP\match_block;

global $wp_conditional_blocks_template_stack;

$wp_conditional_blocks_template_stack = [];

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function wp_conditional_blocks_counter_block_init(): void {
	// Register the block by passing the location of block.json.
	register_block_type(
		__DIR__,
		[
			'render_callback' => 'wp_conditional_blocks_render_counter_block',
		],
	);
}
add_action( 'init', 'wp_conditional_blocks_counter_block_init' );

/**
 * Inject a counter block into the post template block being rendered.
 *
 * @param array{
 *   blockName?: string,
 *   innerBlocks?: mixed[],
 *   innerContent?: mixed[],
 * } $parsed_block The block being rendered.
 * @return array{
 *   blockName?: string,
 *   innerBlocks?: mixed[],
 *   innerContent?: mixed[],
 * }
 */
function wp_conditional_blocks_inject_counter_block( array $parsed_block ): array {
	global $wp_conditional_blocks_template_stack;

	if ( isset( $parsed_block['blockName'] ) && 'core/post-template' === $parsed_block['blockName'] ) {
		$wp_conditional_blocks_template_stack[] = -1;

		if ( ! isset( $parsed_block['innerBlocks'] ) || ! is_array( $parsed_block['innerBlocks'] ) ) { // @phpstan-ignore-line
			$parsed_block['innerBlocks'] = [];
		}

		array_unshift(
			$parsed_block['innerBlocks'],
			Block::create( 'wp-conditional-blocks/counter' )->parsed_block(),
		);

		if ( ! isset( $parsed_block['innerContent'] ) || ! is_array( $parsed_block['innerContent'] ) ) { // @phpstan-ignore-line
			$parsed_block['innerContent'] = [];
		}

		array_unshift( $parsed_block['innerContent'], null );
	}

	return $parsed_block;
}
add_filter( 'render_block_data', 'wp_conditional_blocks_inject_counter_block', 100 );

/**
 * When the counter block renders, increase the count of the current template's iterations.
 *
 * @param array<mixed> $attributes Block attributes.
 * @param string       $content    Block default content.
 * @return string Block output.
 */
function wp_conditional_blocks_render_counter_block( $attributes, $content ): string {
	global $wp_conditional_blocks_template_stack;

	if ( is_array( $wp_conditional_blocks_template_stack ) && count( $wp_conditional_blocks_template_stack ) > 0 ) {
		$last                                   = array_pop( $wp_conditional_blocks_template_stack );
		$wp_conditional_blocks_template_stack[] = $last + 1;
	}

	return $content;
}

/**
 * Current iteration of the current template block.
 *
 * @return int
 */
function wp_conditional_blocks_current_counter_block(): int {
	global $wp_conditional_blocks_template_stack;

	$current = -1;

	if ( is_array( $wp_conditional_blocks_template_stack ) && count( $wp_conditional_blocks_template_stack ) > 0 ) {
		$key     = array_key_last( $wp_conditional_blocks_template_stack );
		$current = $wp_conditional_blocks_template_stack[ $key ];
	}

	return $current;
}

/**
 * Remove the last iteration count from the top of the stack after the template block renders.
 *
 * @param string $block_content The block content.
 * @param array{
 *   name: string,
 *   attrs: array<string, mixed>,
 *   innerBlocks: array<mixed>,
 *   innerHTML: string,
 *   innerContent: array<string>,
 * } $block The full block, including name and attributes.
 */
function wp_conditional_blocks_after_counter_block( $block_content, $block ): void {
	global $wp_conditional_blocks_template_stack;

	if ( is_array( $wp_conditional_blocks_template_stack ) && count( $wp_conditional_blocks_template_stack ) > 0 ) {
		$inner_counter = match_block(
			$block,
			[
				'name'    => 'wp-conditional-blocks/counter',
				'flatten' => false,
			],
		);

		// Pop only if there was a counter in this template.
		if ( null !== $inner_counter ) {
			array_pop( $wp_conditional_blocks_template_stack );
		}
	}
}
add_filter_side_effect( 'render_block_core/post-template', 'wp_conditional_blocks_after_counter_block', 10, 2 );
