<?php
/**
 * Endpoint class file that gets all the conditions.
 *
 * @package wp-conditional-blocks
 */

namespace Alley\WP\WP_Conditional_Blocks;

/**
 * Class Endpoint_Get_Conditions
 *
 * This class is responsible for registering a REST API endpoint and defining its functionality.
 */
class Endpoint_Get_Conditions {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_route' ] );
	}

	/**
	 * Registers the route.
	 *
	 * @return void
	 */
	public function register_route(): void {
		register_rest_route(
			'conditional-blocks/v1',
			'/get-conditions/',
			[
				'methods'             => 'GET',
				'callback'            => [ $this, 'get_response' ],
				'permission_callback' => 'is_user_logged_in',
			]
		);
	}

	/**
	 * Retrieves the response for the get-conditions endpoint.
	 *
	 * @return \WP_REST_Response The REST response object.
	 */
	public function get_response(): \WP_REST_Response {
		$conditions = Conditions::get_instance();

		return new \WP_REST_Response(
			[
				'message' => $this->format_conditions( $conditions->get_conditions() ),
			],
			200
		);
	}

	/**
	 * Formats the conditions.
	 *
	 * @param array{int, array{name:string, slug:string, callable:callable}}|array{} $conditions The conditions to be formatted.
	 *
	 * @return array{array{name:string, slug:string}}|array{} formatted conditions.
	 */
	private function format_conditions( array $conditions ): array {
		if ( empty( $conditions ) ) {
			return $conditions;
		}

		return array_map(
			/**
			 * Removes the `callable`.
			 * see https://github.com/alleyinteractive/wp-conditional-blocks/issues/14
			 */
			function ( $item ) {
				unset( $item['callable'] );
				return $item;
			},
			$conditions
		);
	}
}
