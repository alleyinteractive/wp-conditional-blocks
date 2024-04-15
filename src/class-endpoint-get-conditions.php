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
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_route' ] );
	}

	/**
	 * Registers the route.
	 *
	 * @return void
	 */
	public function register_route(): void {
		register_rest_route('conditional-blocks/v1', '/get-conditions/', [
			'methods'  => 'GET',
			'callback' => [ $this, 'get_response' ],
		] );
	}

	/**
	 * Retrieves the response for the get-conditions endpoint.
	 *
	 * @return \WP_REST_Response The REST response object.
	 */
	public function get_response(): \WP_REST_Response {
		$conditions = Conditions::get_instance();

		return new \WP_REST_Response( [
			'message' => !empty( $conditions->get_conditions() ) ? $conditions->get_conditions() : 'No conditions found.'
		], 200 );
	}
}
