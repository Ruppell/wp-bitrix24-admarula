<?php

/**
 * Register the api route that will be used on Bitrix24.
 */
add_action('rest_api_init', function () {
	register_rest_route( 'bitrix24-admarula/v1', 'handle',array(
		// 'methods'  => 'POST',
		'methods'  => 'GET',
		'callback' => 'bitadma_route_handle'
	));
});

/**
 * Attempts to send the tracking information to Admarula.
 *
 * http://<YOUR_SITE_DOMAIN>/wp-json/bitrix24-admarula/v1/handle
 */
function bitadma_route_handle( $request ) {

	// temp: debugging.
	$title = 'testing';
	$data = $request;
	$log = "\n------------------------\n";
	$log .= date("Y.m.d G:i:s") . "\n";
	$log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
	$log .= print_r($data, 1);
	$log .= "\n------------------------\n";

	file_put_contents( dirname( __FILE__ ) . '/hook.log', $log, FILE_APPEND );

	// perform data sending here:
	// $response = new WP_REST_Response($posts);
    $response = new WP_REST_Response([]);
    $response->set_status(200);

    return $response;

}
