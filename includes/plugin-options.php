<?php

add_action( 'cmb2_admin_init', 'bitadma_register_plugin_options_metabox' );

/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function bitadma_register_plugin_options_metabox() {

	$prefix = 'bitadma_plugin_';
	// readme info
	$readme = 'For more detail about these options see the <a href="https://github.com/Ruppell/wp-bitrix24-admarula" target="_blank">readme</a>.';

	// handler display setup.
	$handler_url = get_rest_url() . BITADMA_API_NAMESPACE . '/' . BITADMA_API_OUTBOUND_ROUTE;
	$handler_address = __( 'Outbound Webhook Address', 'bitrix24-admarula' );
	$handler_after_html = <<<HTML
		<div style="padding: 10px; margin: 10px 0; background-color: #d4d4d4; text-align: center;">
			<strong>$handler_address</strong>: $handler_url
		</div>
HTML;

	/**
	 * Registers options page menu item and form.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'           => 'bitadma_plugin_options_page',
		'title'        => esc_html__( 'Bitrix24 / Admarula', 'bitrix24-admarula' ),
		'object_types' => array( 'options-page' ),
		'parent_slug'  => 'options-general.php',
		'icon_url'     => 'dashicons-networking',
		'message_cb'   => 'bitadma_options_page_message_callback',
		'capability'   => 'manage_options',
		'option_key'   => 'bitadma_plugin_options',
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */

	// outbound webhook
	$cmb_options->add_field( array(
		'id'    => $prefix . 'bitrix24_outbound_title',
		'name'  => esc_html__( 'Bitrix24 Settings', 'bitrix24-admarula' ),
		'desc'  => __( 'Inbound and outbound webhook settings. ' . $readme, 'bitrix24-admarula' ),
		'after' => $handler_after_html,
		'type'  => 'title',
	) );
	$cmb_options->add_field( array(
		'id'   => $prefix . 'bitrix24_outbound_authentication_code',
		'name' => esc_html__( 'Authentication Code', 'bitrix24-admarula' ),
		'desc' => __( 'This code will be given to you by Bitrix24 after creating an <strong>outbound webhook</strong>.', 'bitrix24-admarula' ),
		'type' => 'text',
	) );
	$cmb_options->add_field( array(
		'id'   => $prefix . 'bitrix24_inbound_url',
		'name' => esc_html__( 'Inbound URL', 'bitrix24-admarula' ),
		'desc' => __( 'This <strong>inbound webhook</strong> URL should include the authentication code and should also have the <strong>CRM scope</strong>.', 'bitrix24-admarula' ),
		'type' => 'text_url',
	) );
	$cmb_options->add_field( array(
		'id'   => $prefix . 'bitrix24_inbound_tacking_information_key',
		'name' => esc_html__( 'Tracking Information Key', 'bitrix24-admarula' ),
		'desc' => __( 'This is the <strong>unique key</strong> that will be used to access the tracking information by using the inbound URL above. ', 'bitrix24-admarula' ),
		'type' => 'text',
	) );

	// admarula settings
	$cmb_options->add_field( array(
		'id'    => $prefix . 'admarula_settings_title',
		'name'  => esc_html__( 'Admarula Settings', 'bitrix24-admarula' ),
		'desc'  => __( 'Please provide the needed Admarula details. ' . $readme, 'bitrix24-admarula' ),
		'type'  => 'title',
	) );
	$cmb_options->add_field( array(
		'id'   => $prefix . 'admarula_post_back_url',
		'name' => esc_html__( 'Post Back URL', 'bitrix24-admarula' ),
		'desc' => __( 'The plain post back url, <strong>remove all parameters from url </strong>.', 'bitrix24-admarula' ),
		'type' => 'text_url',
	) );

}


/**
 * Callback to define the optionss-saved message.
 *
 * @param CMB2  $cmb The CMB2 object.
 * @param array $args {
 *     An array of message arguments
 *
 *     @type bool   $is_options_page Whether current page is this options page.
 *     @type bool   $should_notify   Whether options were saved and we should be notified.
 *     @type bool   $is_updated      Whether options were updated with save (or stayed the same).
 *     @type string $setting         For add_settings_error(), Slug title of the setting to which
 *                                   this error applies.
 *     @type string $code            For add_settings_error(), Slug-name to identify the error.
 *                                   Used as part of 'id' attribute in HTML output.
 *     @type string $message         For add_settings_error(), The formatted message text to display
 *                                   to the user (will be shown inside styled `<div>` and `<p>` tags).
 *                                   Will be 'Settings updated.' if $is_updated is true, else 'Nothing to update.'
 *     @type string $type            For add_settings_error(), Message type, controls HTML class.
 *                                   Accepts 'error', 'updated', '', 'notice-warning', etc.
 *                                   Will be 'updated' if $is_updated is true, else 'notice-warning'.
 * }
 */
function bitadma_options_page_message_callback( $cmb, $args ) {

	if ( ! empty( $args['should_notify'] ) ) {

		if ( $args['is_updated'] ) {

			// Modify the updated message.
			$args['message'] = sprintf( esc_html__( '%s &mdash; Updated!', 'cmb2' ), $cmb->prop( 'title' ) );
		}

		add_settings_error( $args['setting'], $args['code'], $args['message'], $args['type'] );
	}

}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 *
 * @param  string $key Options array key
 * @param  mixed $default Optional default value
 *
 * @return mixed           Option value
 */
function bitadma_get_plugin_option( $key = '', $default = '' ) {

	if ( function_exists( 'cmb2_get_option' ) ) {
		return cmb2_get_option( 'bitadma_plugin_options', $key, $default );
	}

	$opts = get_option( 'bitadma_plugin_options', $default );

	$val = $default;

	if ( 'all' == $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}

	return $val;

}

/**
 * Responsible for returning all plugin options in an array format.
 */
function bitadma_get_plugin_options() {

	// bitadma_plugin_
	$plugin_options = array(
		'bitrix24' => array(
			'outbound_authentication_code'     => bitadma_get_plugin_option( 'bitadma_plugin_bitrix24_outbound_authentication_code' , '' ),
			'inbound_url'                      => bitadma_get_plugin_option( 'bitadma_plugin_bitrix24_inbound_url' , '' ),
			'inbound_tracking_information_key' => bitadma_get_plugin_option( 'bitadma_plugin_bitrix24_inbound_tacking_information_key' , '' ),
		),
		'admarula' => array(
			'post_back_url'       => bitadma_get_plugin_option( 'bitadma_plugin_admarula_post_back_url' , '' ),
		)
	);

	return $plugin_options;

}

/**
 * Checks that all required plugin options are set correctly.
 */
function bitadma_does_plugin_options_suffice( $plugin_options ) {
	$plugin_options = bitadma_get_plugin_options();

	// validate values and return true or false.

	return true;
}
