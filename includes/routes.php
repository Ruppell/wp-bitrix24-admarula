<?php

/**
 * Register the api route that will be used on Bitrix24.
 */
add_action('rest_api_init', function () {
	register_rest_route( BITADMA_API_NAMESPACE, BITADMA_API_OUTBOUND_ROUTE,array(
		'methods'  => 'POST',
		'callback' => 'bitadma_route_handle'
	));
});

/**
 * Attempts to send the tracking information to Admarula.
 *
 * http://<YOUR_SITE_DOMAIN>/wp-json/bitrix24-admarula/v1/outbound_handle
 */
function bitadma_route_handle( $request ) {

	// log request details.
	bitadma_log_request( $request, BITADMA_REQUEST_LOG_FILE );

    $response = new WP_REST_Response([]);
    $response->set_status(200);

	// log response details.
	bitadma_log_response( $response, BITADMA_RESPONSE_LOG_FILE );

    return $response;

}
