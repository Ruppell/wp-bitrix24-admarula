<?php

add_action( 'cmb2_admin_init', 'bitadma_register_plugin_options_metabox' );

/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function bitadma_register_plugin_options_metabox() {

	$prefix = 'bitadma_plugin_';

	// handler display setup.
	$handler_url = get_rest_url() . 'bitrix24-admarula/v1/handle';
	$handler_address = __( 'Handler Address', 'bitrix24-admarula' );
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
		'option_key'   => 'bitadma_plugin_options',
		'icon_url'     => 'dashicons-networking',
		'message_cb'   => 'bitadma_options_page_message_callback',
		'capability'   => 'manage_options',
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */

	// outbound webhook
	$cmb_options->add_field( array(
		'id'    => $prefix . 'bitrix24_outbound_title',
		'name'  => esc_html__( 'Bitrix24 - Outbound Webhook', 'bitrix24-admarula' ),
		'desc'  => esc_html__( 'Outbound webhook settings.', 'bitrix24-admarula' ),
		'after' => $handler_after_html,
		'type'  => 'title',
	) );
	$cmb_options->add_field( array(
		'id'   => $prefix . 'bitrix24_outbound_authentication_code',
		'name' => esc_html__( 'Authentication Code', 'bitrix24-admarula' ),
		'desc' => esc_html__( 'This code will be given to you by Bitrix24 after creating an outbound webhook.', 'bitrix24-admarula' ),
		'type' => 'text',
	) );

	// inbound webhook
	$cmb_options->add_field( array(
		'id'    => $prefix . 'bitrix24_inbound_title',
		'name'  => esc_html__( 'Bitrix24 - Inbound Webhook', 'bitrix24-admarula' ),
		'desc'  => esc_html__( 'Inbound webhook settings. Access permissions to CRM is required.', 'bitrix24-admarula' ),
		'type'  => 'title',
	) );
	$cmb_options->add_field( array(
		'id'   => $prefix . 'bitrix24_inbound_authorization_code',
		'name' => esc_html__( 'Authorization Code', 'bitrix24-admarula' ),
		'desc' => esc_html__( 'This code is used to authenticate the webhook in Bitrix24. Save it in a safe place and keep it confidential. This code will be given to you by Bitrix24 after creating an inbound webhook.', 'bitrix24-admarula' ),
		'type' => 'text',
	) );

	// admarula settings
	$cmb_options->add_field( array(
		'id'    => $prefix . 'admarula_settings_title',
		'name'  => esc_html__( 'Admarula Settings', 'bitrix24-admarula' ),
		'desc'  => esc_html__( 'Please provide the needed Admarula details.', 'bitrix24-admarula' ),
		'type'  => 'title',
	) );
	$cmb_options->add_field( array(
		'id'   => $prefix . 'admarula_post_back_url',
		'name' => esc_html__( 'Post Back URL', 'bitrix24-admarula' ),
		'desc' => esc_html__( 'The plain post back url, please remove all parameters.', 'bitrix24-admarula' ),
		'type' => 'text',
	) );
	$cmb_options->add_field( array(
		'id'   => $prefix . 'admarula_post_back_url_param_transactionID',
		'name' => esc_html__( 'TransactionID Parameter Name', 'bitrix24-admarula' ),
		'desc' => esc_html__( '', 'bitrix24-admarula' ),
		'default' => 'transactionID',
		'type' => 'text',
	) );
	$cmb_options->add_field( array(
		'id'   => $prefix . 'admarula_post_back_url_param_currency',
		'name' => esc_html__( 'Currency Parameter Name', 'bitrix24-admarula' ),
		'desc' => esc_html__( '', 'bitrix24-admarula' ),
		'default' => 'currency',
		'type' => 'text',
	) );
	$cmb_options->add_field( array(
		'id'   => $prefix . 'admarula_post_back_url_param_tmpdata',
		'name' => esc_html__( 'Tmpdata Parameter Name', 'bitrix24-admarula' ),
		'desc' => esc_html__( '', 'bitrix24-admarula' ),
		'default' => 'tmpdata',
		'type' => 'text',
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
