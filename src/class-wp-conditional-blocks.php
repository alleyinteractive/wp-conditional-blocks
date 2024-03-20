<?php
/**
 * WP_Conditional_Blocks class file
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks;

/**
 * WP_Conditional_Blocks
 */
class WP_Conditional_Blocks {
	/**
	 * Singleton instance for this class.
	 *
	 * @var WP_Conditional_Blocks
	 */
	private static ?WP_Conditional_Blocks $instance = null;

	/**
	 * Array of conditions.
	 *
	 * @var array
	 */
	public static array $conditions = [];

	/**
	 * Private constructor.
	 */
	private function __construct() {}

	/**
	 * Creates the singleton.
	 *
	 * @return WP_Conditional_Blocks The singleton instance.
	 */
	public static function instance(): WP_Conditional_Blocks {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Adds a condition.
	 *
	 * @param string $name Name of the condition.
	 * @param string $slug Slug of the condition.
	 * @param callable $callable Callable function of the condition.
	 *
	 * @return void
	 */
	public function add_condition( string $name, string $slug, callable $callable ): void {
		self::$conditions[] = [
			'name'     => $name,
			'slug'     => $slug,
			'callable' => $callable
		];
	}

	public function get_condition() {

	}

	public function get_conditions() {

	}

	public function delete_condition() {

	}

}
add_action( 'wp', WP_Conditional_Blocks::instance() );
