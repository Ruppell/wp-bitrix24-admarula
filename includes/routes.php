<?php

/**
 * Register the api route that will be used on Bitrix24.
 */
add_action('rest_api_init', function () {
	register_rest_route( BITADMA_API_NAMESPACE, BITADMA_API_OUTBOUND_ROUTE, array(
		'methods'  => 'POST',
		'callback' => 'bitadma_route_outbound_handle'
	));

	// for testing only
	register_rest_route( BITADMA_API_NAMESPACE, 'post_back_test', array(
		'methods'  => 'POST',
		'callback' => 'bitadma_route_post_back_test_handle'
	));
});

/**
 * For testing only.
 */
function bitadma_route_post_back_test_handle( $request ) {

	bitadma_log_info( $request );

}

/**
 * Attempts to send the tracking information to Admarula.
 *
 * @param WP_REST_Request $response
 */
function bitadma_route_outbound_handle( $request ) {

	// setup response object
	$response = new WP_REST_Response([]);
    $response->set_status( 200 );

	// perform authentication check
	$plugin_options = bitadma_get_plugin_options();

	// we need to make sure all options are valid before we continue.
	if ( bitadma_does_plugin_options_suffice( $plugin_options ) ) {

		$authentication_code = $plugin_options['bitrix24']['outbound_authentication_code'];

		// make sure request is valid.
		if ( bitadma_is_valid_outbound_bitrix24_request( $request, $authentication_code ) ) {

			// all good
			try {

				// deal / lead details from bitrix
				$inbound_details = bitadma_request_item_details_from_bitrix24(
					$request->get_param('event'),
					$request->get_param('data')['FIELDS']['ID'],
					$plugin_options
				);

				// notify Admarual
				bitadma_handle_admarula_notification(
					$inbound_details['details'],
					$inbound_details['type'],
					$plugin_options
				);

			} catch( \Exception $e ) {
				// log exception error messages
				bitadma_log_error_message( $e->getMessage() );

				$response->set_status( 422 );
			}

		} else {
			// could not be authorized
			$response->set_status( 401 );
		}

	}

    return $response;
}


/**
 * This function will get the deal or lead's details by making a
 * request to the Bitrix24 Api, using the inbound details set inside
 * the plugin options. Important that all parameter data is correct.
 *
 * @throws \Exception
 * @return array The required deal/lead details.
 */
function bitadma_request_item_details_from_bitrix24( $event_type, $id, $plugin_options ) {

	$item_type = '';
	$request_api_suffix = '';

	// sets the api suffix
	switch( $event_type ) {
	case 'ONCRMLEADADD':
	case 'ONCRMLEADUPDATE':
	case 'ONCRMLEADDELETE':
		$item_type = 'LEAD';
		$request_api_suffix = BITADMA_API_BITRIX24_LEAD_SUFFIX;
		break;
	case 'ONCRMDEALADD':
	case 'ONCRMDEALUPDATE':
	case 'ONCRMDEALDELETE':
		$item_type = 'DEAL';
		$request_api_suffix = BITADMA_API_BITRIX24_DEAL_SUFFIX;
		break;
	default:
		throw new \Exception('Event type [' . $event_type . '] is not supported !');
	}

	// make request.
	$normalized_inbound_url = bitadma_normalize_url( $plugin_options['bitrix24']['inbound_url'], true );
	$response = wp_remote_get( $normalized_inbound_url . $request_api_suffix . $id );

	// incase of error.
	if ( is_wp_error( $response ) ) {
		throw new \Exception($response->get_error_message());
	}

	// check that status code is 200
	if ( $response['response']['code'] != 200 ) {
		throw new \Exception( 'Bitrix24 item details API request failed.' );
	}

	$decoded_body = json_decode( $response['body'], true );

	// jason decoding failed
	if ( $decoded_body == null ) {
		throw new \Exception( 'Bitrix item details, JSON could not be decoded.' );
	}

	return array(
		'details' => $decoded_body,
		'type'    => $item_type
	);

}


/**
 * This function will handle the Admarula notification. It will only
 * send the notification if the correct status is presented in the
 * item details.
 *
 * @throws \Exception
 * @return void
 */
function bitadma_handle_admarula_notification( $item_details, $item_type, $plugin_options ) {

	if ( bitadma_validate_inbound_bitrix24_response( $item_details, $item_type, $plugin_options ) ) {

		// get tracking key
		$tracking_info_key = bitadma_strip_whitespace(
			$plugin_options['bitrix24']['inbound_tracking_information_key']
		);

		// set status based on the item type
		$required_status_id = '';
		switch ( $item_type ) {
		case 'LEAD':
			$required_status_id = 'CONVERTED';
			break;
		case 'DEAL':
			$required_status_id = 'DONE';
			break;
		default:
			throw new \Exception( 'Item type could not be found.!' );
		}

		$results = $item_details['result'];

		// if the status is not correct exit.
		if ( $results['STATUS_ID'] != $required_status_id ) {
			return;
		}

		// setup post arguments
		$request_params = array();
		$request_params[BITADMA_API_ADMARULA_PARAM_KEY_ID]       = $results['ID'];
		$request_params[BITADMA_API_ADMARULA_PARAM_KEY_CURRENCY] = $results['CURRENCY_ID'];
		$request_params[BITADMA_API_ADMARULA_PARAM_KEY_HASH]     = bitadma_get_admarula_tmt_data_hash( $results[$tracking_info_key] );

		if ( is_bool( $request_params[BITADMA_API_ADMARULA_PARAM_KEY_HASH] ) ) {
			throw new \Exception('The tmtData tracking information could not be found.');
		}

		// notify admarula response
		$response = wp_remote_post(
			$plugin_options['admarula']['post_back_url'],
			array(
				'method' => 'POST',
				'body'   => $request_params,
			)
		);

		// incase of error.
		if ( is_wp_error( $response ) ) {
			throw new \Exception($response->get_error_message());
		}

		// on success log results.
		bitadma_log_admarula_success( $request_params, $item_type, $required_status_id );

	} else {

		throw new \Exception( 'The item does not have the required details!' );

	}

}
