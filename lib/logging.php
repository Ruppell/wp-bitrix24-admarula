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
function bitadma_log_admarula_success( $request_params, $item_type, $required_status_id ) {

	$item_id       = $request_params[BITADMA_API_ADMARULA_PARAM_KEY_ID];
	$item_currency = $request_params[BITADMA_API_ADMARULA_PARAM_KEY_CURRENCY];
	$item_hash     = $request_params[BITADMA_API_ADMARULA_PARAM_KEY_HASH];
	$item_status   = $required_status_id;
	$time_stamp    = date("Y.m.d G:i:s");

	$log = <<<HTML
| TRACKING_ID: $item_id | TYPE: $item_type | STATUS: $item_status  | CURRENCY: $item_currency | TMTDATA_HASH: $item_hash  | TIMESTAMP: $time_stamp | \n
HTML;

	file_put_contents( BITADMA_ADMARULA_LOG_FILE, $log, FILE_APPEND );
}
