<?php
/**
 * Plugin Name: PugPress
 * Plugin URI:  https://github.com/kubikplugins/pugpress
 * Description: Use Pug (previously Jade) template engine in WordPress themes.
 * Version:     1.1.1
 * Author:      Kubik Ltd.
 * Author URI:  http://kubikplugins.com/
 * License:     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 * Domain Path: /languages
 * Text Domain: pugpress
 *
 * Intellectual Property rights, and copyright, reserved by Kubik Ltd. as allowed by law include,
 * but are not limited to, the working concept, function, and behavior of this software,
 * the logical code structure and expression as written.
 *
 * @package     PugPress
 * @author      Kubik Ltd. http://kubikplugins.com/
 * @copyright   Copyright (c) Kubik Ltd. (support@kubikplugins.com)
 * @since       1.0.0
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pugpress_autoload = __DIR__ . '/vendor/autoload.php';

if ( file_exists( $pugpress_autoload ) ) {
	require $pugpress_autoload;
}

$pugpress = new \PugPress();

/**
 * Render pug template.
 *
 * @since 1.0.0
 * @param string $name Template filename.
 * @param array  $data Content for the template.
 * @param bool   $base_data Add base data to template content.
 * @return void
 */
function pugpress_render( $name, $data = [], $base_data = true ) {
	global $pugpress;
	$pugpress->render( $name, $data, $base_data ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

