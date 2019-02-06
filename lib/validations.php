<?php

/**
 * Strip all linebreaks and whitespaces from a string.
 *
 * @return string The cleaned string.
 */
function bitadma_strip_whitespace( $string ) {

	$pattern = '/\s*/m';
    $replace = '';

    return preg_replace( $pattern, $replace, $string );
}


/**
 * Normalizes a url string.
 *
 * TODO: improve.
 *
 * @return string Normalized url string.
 */
function bitadma_normalize_url( $url_string, $force_trailing_slash = true ) {

	if ( $force_trailing_slash ) {
		$url_string = rtrim( $url_string ,"/") . '/';
	}

	return $url_string;
}


/**
 * This function will attempt to get the Admarula tracking data from
 * some random raw string data set.
 *
 * returns boolean | string Will return false if no match is found.
 */
function bitadma_get_admarula_tmt_data_hex( $raw_data ) {

	// pattern
	$pattern = '(&tmtData=([\S]{0,36}))';
	$matches = array();
	$has_match = preg_match( $pattern, $raw_data, $matches );

	// return match or false.
	if ( $has_match ) {
		if (isset($matches[1])) {

			return bitadma_strip_whitespace($matches[1]);

		} else {
			return false;
		}

	} else {
		return false;
	}

}

/**
 * This function makes sure that the outbound request coming from
 * bitrix24 is indeed valid.
 *
 * @return boolean
 */
function bitadma_is_valid_outbound_bitrix24_request( $request, $authentication_code ) {

	// required fields
	$required_field = array(
		$request->get_param('auth'),
		$request->get_param('event'),
		$request->get_param('data'),
	);

	// check that all fields are available.
	foreach( $required_field as $field ) {
		if ( $field == null ) {
			return false;
		}
	}

	// check that the data FIELDS, ID field is available.
	if ( isset( $request->get_param('data')['FIELDS']['ID'] ) == false ) {
		return false;
	}

	// check that application_token is available.
	if ( isset( $request->get_param('auth')['application_token'] ) == false ) {
		return false;
	}

	// make sure there is no whitespaces.
	$cleaned_request_auth_code = bitadma_strip_whitespace( $request->get_param('auth')['application_token'] );
	$cleaned_auth_code = bitadma_strip_whitespace( $authentication_code );

	// validate token.
	if ( $cleaned_request_auth_code != $cleaned_auth_code ) {
		return false;
	}

	return true;

}


/**
 * This function makes sure that the inbound response coming from
 * bitrix24 contains all the needed values.
 *
 * @return boolean
 */
function bitadma_validate_inbound_bitrix24_response( $item_details, $item_type, $plugin_options = array() ) {

	// var_dump( $item_details );

	// get inbound tracking information key
	$tracking_info_key = bitadma_strip_whitespace( $plugin_options['bitrix24']['inbound_tracking_information_key'] );

	// required values
	$required_values = array(
		isset( $item_details['result']['ID'] ),
		isset( $item_details['result']['CURRENCY_ID'] ),
		isset( $item_details['result']['STATUS_ID'] ),
		isset( $item_details['result'][$tracking_info_key] ),
	);

	// check that all fields are available.
	foreach( $required_values as $values ) {
		if ( $values == false ) {
			return false;
		}
	}

	return true;

}
