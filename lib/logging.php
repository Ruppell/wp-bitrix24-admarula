<?php

/**
 * Logs data to the info file.
 */
function bitadma_log_info( $data ) {

	$time_stamp = date("Y.m.d G:i:s") . "\n";
	$raw_data  = print_r( $data, 1 );

	$log = <<<HTML
----------------------------------- \n
$time_stamp | $raw_data
----------------------------------- \n
HTML;

	file_put_contents( BITADMA_INFO_LOG_FILE, $log, FILE_APPEND );

}

/**
 * Logs error messages.
 */
function bitadma_log_error_message( $message ) {

	$time_stamp = date("Y.m.d G:i:s");

	$log = <<<HTML
| ERROR_MESSAGE: $message | TIMESTAMP: $time_stamp | \n
HTML;

	file_put_contents( BITADMA_ERROR_LOG_FILE, $log, FILE_APPEND );

}

/**
 * Log's successful Admarula notifications.
 *
 * @param WP_REST_Request $request
 */
function bitadma_log_admarula_success( $request_params, $item_type, $required_status_id, $response ) {

	// response details
	$response_code    = $response['response']['code'];
	$response_message = $response['response']['message'];

	// item details
	$item_id          = $request_params[BITADMA_API_ADMARULA_PARAM_KEY_ID];
	$item_currency    = $request_params[BITADMA_API_ADMARULA_PARAM_KEY_CURRENCY];
	$item_hex         = $request_params[BITADMA_API_ADMARULA_PARAM_KEY_HEX];
	$item_status      = $required_status_id;
	$time_stamp       = date("Y.m.d G:i:s");

	$log = <<<HTML
| ID: $item_id | RESPONSE_CODE: $response_code | RESPONSE_MESSAGE: $response_message  | TYPE: $item_type | STATUS: $item_status  | CURRENCY: $item_currency | TMTDATA_HEX: $item_hex  | TIMESTAMP: $time_stamp | \n
HTML;

	file_put_contents( BITADMA_ADMARULA_LOG_FILE, $log, FILE_APPEND );
}


/**
 * This function creates a list of log file information if they exist.
 */
function bitadma_get_existing_log_files() {

	$log_files = array();

	if ( file_exists( BITADMA_ADMARULA_LOG_FILE ) ) {
		array_push( $log_files, array(
			'title' => BITADMA_ADMARULA_LOG_TITLE,
			'url'   => BITADMA_ADMARULA_LOG_URL,
		));
	}

	if ( file_exists( BITADMA_ERROR_LOG_FILE ) ) {
		array_push( $log_files, array(
			'title' => BITADMA_ERROR_LOG_TITLE,
			'url'   => BITADMA_ERROR_LOG_URL,
		));
	}

	return $log_files;

}
