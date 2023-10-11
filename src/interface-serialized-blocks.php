<?php
/**
 * Serialized_Blocks interface file
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks;

/**
 * Describes a class that serializes block content.
 */
interface Serialized_Blocks {
	/**
	 * Serialized block content.
	 *
	 * @return string
	 */
	public function serialize(): string;
}
