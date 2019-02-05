<?php

/**
 * Log's information to the requests.log file.
 *
 * @param WP_REST_Request $request
 */
function bitadma_log_request( $request, $file_path ) {

	// TODO: change with proper logic
	// $title = 'testing';
	// $data = $request;
	// $log = "\n------------------------\n";
	// $log .= date("Y.m.d G:i:s") . "\n";
	// $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
	// $log .= print_r($data, 1);
	// $log .= "\n------------------------\n";

	file_put_contents( $file_path, 'testing out the logging.', FILE_APPEND );
}

/**
 * Log's information to the response.log file.
 *
 * @param WP_REST_Response $response
 */
function bitadma_log_response( $response, $file_path ) {

	file_put_contents( $file_path, 'testing out the logging.', FILE_APPEND );

}
