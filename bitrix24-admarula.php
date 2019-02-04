<?php

/**
 * Plugin Name: Bitrix24 Admarula
 * Plugin URI:  https://github.com/Ruppell/wp-bitrix24-admarula
 * Description: A WordPress plugin that makes use of Bitrix24 web hooks to pass tracking information to Admarula.
 * Version:     1.0.0
 * Author:      Ruppell
 * Author URI:  http://ruppell.io/
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: bitrix24-admarula
 * Domain Path: /languages
 *
 * The MIT License
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

$example = __( 'Example', 'bitrix24-admarula' );

/**
 * Performs activation actions.
 */
function bitadma_activation() {}
register_activation_hook( __FILE__, 'bitadma_activation' );

/**
 * Performs deactivation actions.
 */
function bitadma_deactivation() {}
register_deactivation_hook( __FILE__, 'bitadma_deactivation' );
