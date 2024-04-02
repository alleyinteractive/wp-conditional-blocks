<?php
/**
 * WP_Conditional_Blocks class file
 *
 * @package wp-conditional-blocks
 */

declare( strict_types = 1 );

namespace Alley\WP\WP_Conditional_Blocks;

/**
 * Sets up the Singleton trait use.
 *
 * @phpstan-use-trait-for-class Singleton
 */
use Alley\WP\WP_Conditional_Blocks\traits\Singleton;

/**
 * WP_Conditional_Blocks
 */
class WP_Conditional_Blocks {
	/**
	 * Use the singleton.
	 *
	 * @use Singleton<static>
	 */
	use Singleton;

	/**
	 * Array of conditions.
	 *
	 * @var list{array{name:string, slug:string, callable:callable}}|array{}
	 */
	private array $conditions = [];

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
		if ( empty( $name ) || empty( $slug ) || ! is_callable( $condition_callback ) ) {
			return false;
		}

		$condition = [
			'name'     => $name,
			'slug'     => $slug,
			'callable' => $condition_callback,
		];

		/**
		 * Filters the condition.
		 *
		 * @param array $condition The condition array.
		 */
		$filtered_condition = apply_filters( 'wp_conditional_blocks_add_condition', $condition );

		if (
			isset( $filtered_condition['name'], $filtered_condition['slug'], $filtered_condition['callable'] )
			&& is_string( $filtered_condition['name'] )
			&& is_string( $filtered_condition['slug'] )
			&& is_callable( $filtered_condition['callable'] )
		) {
			$condition = $filtered_condition;
		}

		// @phpstan-ignore-next-line
		$this->conditions[] = $condition;

		return true;
	}

	/**
	 * Get a condition given a slug.
	 *
	 * @param string $slug Slug of the condition.
	 *
	 * @return array{name:string, slug:string, callable:callable}|array{}
	 */
	public function get_condition( string $slug ): array {
		$conditions = array_column( $this->conditions, null, 'slug' );
		$condition  = $conditions[ $slug ] ?? [];

		/**
		 * Filters the condition.
		 *
		 * @param array{name:string, slug:string, callable:callable}|array{} $condition The condition array.
		 * @param string $slug The condition's slug.
		 */
		return apply_filters( 'wp_conditional_blocks_get_condition', $condition, $slug );
	}

	/**
	 * Get all conditions
	 *
	 * @return array{int,array{name:string, slug:string, callable:callable}}|array{}
	 */
	public function get_conditions(): array {
		$conditions = $this->conditions;

		/**
		 * Filters the list of conditions.
		 *
		 * @param array $conditions The list of conditions.
		 */
		return apply_filters( 'wp_conditional_blocks_get_conditions', $conditions );
	}

	/**
	 * Deletes a condition given a slug.
	 *
	 * @param string $slug Slug of the condition.
	 *
	 * @return void
	 */
	public function delete_condition( string $slug ): void {
		$this->conditions = array_filter(
			$this->conditions,
			function ( $condition ) use ( $slug ) {
				return ! empty( $condition['slug'] ) && $condition['slug'] !== $slug;
			}
		);
	}

	/**
	 * Resets the conditions for testing purposes.
	 *
	 * @internal
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public function reset_conditions_for_testing(): void {
		$this->conditions = [];
	}
}
