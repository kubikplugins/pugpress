<?php
/**
 * Plugin Name: PugPress
 * Plugin URI:  https://github.com/kubikplugins/pugpress
 * Description: Use Pug (previously Jade) template engine in WordPress themes.
 * Version:     0.0.1
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
 * @since       0.0.1
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( file_exists( $autoload = __DIR__ . '/vendor/autoload.php' ) ) {
	require $autoload;
}

/**
 * Undocumented function
 *
 * @since 0.0.1
 * @param string $name Template filename.
 * @param array  $data Content for the template.
 * @return void
 */
function pugpress_render( $name, $data = array() ) {
	$pugpress = new \Pug_Press();
	echo $pugpress->render( $name, $data );
}

