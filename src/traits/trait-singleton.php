<?php
/**
 * Trait file for Singletons.
 *
 * @package wp-conditional-blocks
 */

declare( strict_types = 1 );

namespace Alley\WP\WP_Conditional_Blocks\traits;

/**
 * Make a class into a singleton.
 *
 * @template T
 */
trait Singleton {
	/**
	 * Singleton instance for this class.
	 *
	 * @var self
	 */
	private static $instance = null;

	/**
	 * Get class instance.
	 *
	 * @return self
	 */
	public static function get_instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new static();
		}

		return self::$instance;
	}

	/**
	 * Private constructor to prevent instantiation from outside the class.
	 */
	final private function __construct() {
	}

	/**
	 * Initializes the class.
	 *
	 * Use this function instead of the constructor for any required initialization.
	 *
	 * @return void
	 */
	protected function init() {
	}
}
