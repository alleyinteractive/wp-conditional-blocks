<?php
/**
 * Trait file for Singletons.
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks\traits;

/**
 * Make a class into a singleton.
 */
trait Singleton {
	/**
	 * Singleton instance for this class.
	 *
	 * @var Singleton
	 */
	private static ?self $instance = null;

	/**
	 * Get class instance.
	 *
	 * @return static
	 */
	public static function get_instance(): static {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Private constructor to prevent instantiation from outside the class.
	 */
	private function __construct() {
	}
}
