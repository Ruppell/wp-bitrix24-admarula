<?php

/**
 * Log's information to the requests.log file.
 *
 * @param WP_REST_Request $request
 */
function bitadma_log( $data, $file_path ) {

	$title = 'testing';
	$log = "\n------------------------\n";
	$log .= date("Y.m.d G:i:s") . "\n";
	$log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
	$log .= print_r($data, 1);
	$log .= "\n------------------------\n";

	file_put_contents( $file_path, $log, FILE_APPEND );
}

/**
 * Log's successful Admarula notifications.
 *
 * @param WP_REST_Request $request
 */
function bitadma_log_admarula_success( $response, $item_details, $item_type ) {

	// $title = 'testing';
	// $log = "\n------------------------\n";
	// $log .= date("Y.m.d G:i:s") . "\n";
	// $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
	// $log .= print_r($data, 1);
	// $log .= "\n------------------------\n";

	file_put_contents( BITADMA_ADMARULA_LOG_FILE, 'success', FILE_APPEND );
}
