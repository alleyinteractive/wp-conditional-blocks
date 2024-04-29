<?php
/**
 * Contains helper functions to be used elsewhere in the plugin.
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks;

use WP_Block;

/**
 * Check if the defined block is the active block. Useful in pre_render_block
 * callbacks.
 *
 * @param string     $block_name The block name to look for. Should be the full namespace.
 * @param array|null $parsed_block The parsed block array, or null.
 * @return bool
 */
function is_active_block( string $block_name, ?array $parsed_block ): bool {
	if ( ! isset( $parsed_block['blockName'] ) ) {
		return false;
	}

	return $block_name === $parsed_block['blockName'];
}

/**
 * Check if the defined block is the active parent block. Useful in pre_render_block
 * callbacks.
 *
 * @param string        $block_name The block name to look for. Should be the full namespace.
 * @param WP_Block|null $parent_block The parent block to check.
 * @return bool
 */
function is_active_parent_block( string $block_name, ?WP_Block $parent_block ): bool {
	if ( ! ( $parent_block instanceof WP_Block ) ) {
		return false;
	}

	return is_active_block( $block_name, $parent_block->parsed_block );
}

/**
 * Handles performing a callback when a condition block returns the expected result.
 *
 * @param bool     $result The expected result of the evaluation.
 * @param WP_Block $parent_block The parent block object.
 * @param callable $callback The callback to execute on true.
 * @param array    ...$args An array of arguments passed to the callback function.
 * @return mixed
 */
function on_bool( bool $result, WP_Block $parent_block, callable $callback, ...$args ): void {
	$context = [];

	if ( isset( $parent_block->context['postId'] ) ) {
		$context['postId'] = $parent_block->context['postId'];
	}

	if ( wp_conditional_blocks_condition_block_result( $parent_block->parsed_block, $context ) === $result ) {
		$callback( ...$args );
	}
}

/**
 * A filter used by both the is-true and is-false blocks to filter their render content,
 * and either show or hide it based on the result.
 *
 * @param string        $block_name   The block name to run on.
 * @param bool          $bool         True or false. The expected value of the evaluation.
 * @param string|null   $pre_render   The pre-rendered content. Default null.
 * @param array         $parsed_block The block being rendered.
 * @param WP_Block|null $parent_block If this is a nested block, a reference to the parent block.
 */
function pre_render_on_bool( string $block_name, bool $bool, $pre_render, $parsed_block, $parent_block ): string|null {
	/*
	 * Previously, the condition block added 'conditionResult' as context to this block. However,
	 * limitations in the context API meant that the context didn't get passed to child blocks when
	 * the condition block was itself a child block. We now pass the condition block back to a
	 * separate function that lives outside the context API and evaluates the result.
	 */
	if (
		is_active_block( $block_name, $parsed_block )
		&& is_active_parent_block( 'wp-conditional-blocks/condition', $parent_block )
	) {
		$context = [];

		if ( isset( $parent_block->context['postId'] ) ) {
			$context['postId'] = $parent_block->context['postId'];
		}

		if ( wp_conditional_blocks_condition_block_result( $parent_block->parsed_block, $context ) !== $bool ) {
			$pre_render = '';
		}
	}

	return $pre_render;
}
