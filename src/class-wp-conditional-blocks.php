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
	 * @param callable $condition_callback Callable function of the condition.
	 *
	 * @return bool True if the condition was added successfully, false otherwise.
	 */
	public function add_condition( string $name, string $slug, callable $condition_callback ): bool {
		// Validate input parameters.
		if ( empty( $name ) || empty( $slug ) || !is_callable( $condition_callback ) ) {
			return false;
		}

		$condition_data = [
			'name'     => $name,
			'slug'     => $slug,
			'callable' => $condition_callback,
		];

		/**
		 * Filters the condition.
		 *
		 * @param string $name Name of the condition.
		 * @param string $slug Slug of the condition.
		 * @param callable $condition_callback Callable function of the condition.
		 */
		$condition_data = apply_filters( 'conditional_blocks_add_condition', $name, $slug, $condition_callback );

		$this->conditions[] = $condition_data;

		return true;
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
		$condition = $conditions[ $slug ] ?? null;

		/**
		 * Filters the condition.
		 *
		 * @param array $condition The condition array.
		 * @param string $slug The condition's slug.
		 */
		return apply_filters( 'conditional_blocks_get_condition', $condition, $slug );
	}

	/**
	 * Get all conditions
	 *
	 * @return array
	 */
	public function get_conditions(): array {
		$conditions = $this->conditions;

		/**
		 * Filters the list of conditions.
		 *
		 * @param array $conditions The list of conditions.
		 */
		return apply_filters( 'conditional_blocks_get_conditions', $conditions );
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
