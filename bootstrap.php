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

// API
define( 'BITADMA_API_NAMESPACE', 'bitrix24-admarula/v1' );
define( 'BITADMA_API_OUTBOUND_ROUTE', 'outbound_handle' );

// Logging
define( 'BITADMA_REQUEST_LOG_FILE', dirname( __FILE__ ) . '/logs/requests.log' );
define( 'BITADMA_RESPONSE_LOG_FILE', dirname( __FILE__ ) . '/logs/responses.log' );

/**
 * Inlcude required lib files.
 */
require_once dirname( __FILE__ ) . '/lib/logging.php';

/**
 * Register plugin options.
 */
require_once dirname( __FILE__ ) . '/includes/plugin-options.php';

/**
 * Register WordPress API routes.
 */
require_once dirname( __FILE__ ) . '/includes/routes.php';
