<?php

/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'bitadma_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */
if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/**
 * Constants. These values are required for the
 * plugin to function.
 */

// General
define( 'BITADMA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// API
define( 'BITADMA_API_NAMESPACE', 'bitrix24-admarula/v1' );
define( 'BITADMA_API_OUTBOUND_ROUTE', 'outbound_handle' );
define( 'BITADMA_API_ADMARULA_POST_BACK_TEST_ROUTE', 'post_back_test' );
define( 'BITADMA_API_BITRIX24_LEAD_SUFFIX', 'crm.lead.get?id=' );
define( 'BITADMA_API_BITRIX24_DEAL_SUFFIX', 'crm.deal.get?id=' );
define( 'BITADMA_API_ADMARULA_PARAM_KEY_ID', 'transactionID' );
define( 'BITADMA_API_ADMARULA_PARAM_KEY_CURRENCY', 'currency' );
define( 'BITADMA_API_ADMARULA_PARAM_KEY_HASH', 'tmtData' );

// Logging
define( 'BITADMA_ERROR_LOG_FILE', dirname( __FILE__ ) . '/logs/error.log' );
define( 'BITADMA_ERROR_LOG_URL', BITADMA_PLUGIN_URL . 'logs/error.log' );
define( 'BITADMA_ERROR_LOG_TITLE', 'Errors Log' );

define( 'BITADMA_ADMARULA_LOG_FILE', dirname( __FILE__ ) . '/logs/admarula.log' );
define( 'BITADMA_ADMARULA_LOG_URL', BITADMA_PLUGIN_URL . 'logs/admarula.log' );
define( 'BITADMA_ADMARULA_LOG_TITLE', 'Admarula Requests Log' );

define( 'BITADMA_INFO_LOG_FILE', dirname( __FILE__ ) . '/logs/info.log' );

/**
 * Inlcude required lib files.
 */
require_once dirname( __FILE__ ) . '/lib/logging.php';
require_once dirname( __FILE__ ) . '/lib/validations.php';

/**
 * Register plugin options.
 */
require_once dirname( __FILE__ ) . '/includes/plugin-options.php';

/**
 * Register WordPress API routes.
 */
require_once dirname( __FILE__ ) . '/includes/routes.php';
