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
	 * @var WP_Conditional_Blocks|null
	 */
	private static ?self $instance = null;

	/**
	 * Array of conditions.
	 *
	 * @var array
	 */
	private array $conditions = [];

	/**
	 * Private constructor.
	 */
	protected function __construct() {}

	/**
	 * Creates the singleton instance.
	 *
	 * @return self The singleton instance.
	 */
	public static function instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Adds a condition.
	 *
	 * @param string   $name Name of the condition.
	 * @param string   $slug Slug of the condition.
	 * @param callable $callable Callable function of the condition.
	 *
	 * @return void
	 */
	public function add_condition( string $name, string $slug, callable $callable ): void {
		$this->conditions[] = [
			'name'     => $name,
			'slug'     => $slug,
			'callable' => $callable,
		];
	}

	/**
	 * Get a condition given a slug.
	 *
	 * @param string $slug Slug of the condition.
	 *
	 * @return array|null
	 */
	public function get_condition( string $slug ): ?array {
		$conditions = array_column( $this->conditions, null, 'slug' );
		return $conditions[ $slug ] ?? null;
	}

	/**
	 * Get all conditions
	 *
	 * @return array
	 */
	public function get_conditions(): array {
		return $this->conditions;
	}

	/**
	 * Deletes a condition given a slug.
	 *
	 * @param string $slug Slug of the condition.
	 *
	 * @return void
	 */
	public function delete_condition( string $slug ): void {
		$this->conditions = array_filter( $this->conditions, function ( $condition ) use ( $slug ) {
			return $condition['slug'] !== $slug;
		});
	}
}
add_action( 'wp', [ WP_Conditional_Blocks::instance(), '__construct' ] );
