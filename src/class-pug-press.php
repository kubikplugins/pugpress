<?php
/**
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

/**
 * Class Pug_Press
 */
class Pug_Press {
	/**
	 * A reference to the Pug template engine for PHP
	 *
	 * @since 0.0.1
	 * @var object
	 */
	private $pug;

	/**
	 * Pug_Press Constructor
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		$this->pug = new \Pug\Pug( array(
			'pretty'             => true,
			'expressionLanguage' => 'js',
			'basedir'            => $this->get_views_dir(),
		) );
	}

	/**
	 * Undocumented function
	 *
	 * @since 0.0.1
	 * @return array
	 */
	private function get_base_data() {
		return [
			'wp_head'   => $this->get_output_buffer_contents( 'wp_head' ),
			'wp_footer' => $this->get_output_buffer_contents( 'wp_footer' ),
			'base'      => get_template_directory_uri() . '/',
			'language'  => get_bloginfo( 'language' ),
			'charset'   => get_bloginfo( 'charset' ),
		];
	}

	/**
	 * Undocumented function
	 *
	 * @since 0.0.1
	 * @return string
	 */
	private function get_views_dir() {
		return get_template_directory() . '/views/';
	}

	/**
	 * Undocumented function
	 *
	 * @since 0.0.1
	 * @param string $name Template filename.
	 * @return string
	 */
	private function get_view( $name ) {
		return $this->get_views_dir() . $name . '.pug';
	}

	/**
	 * Undocumented function
	 *
	 * @since 0.0.1
	 * @param string $function Function name.
	 * @param array  $args     Function arguments.
	 * @return string
	 */
	private function get_output_buffer_contents( $function, $args = array() ) {
		ob_start();
		$function( $args );
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	/**
	 * Undocumented function
	 *
	 * @since 0.0.1
	 * @param string $name Template filename.
	 * @param array  $data Content for the template.
	 * @return string
	 */
	public function render( $name, $data = array() ) {
		$data = array_merge( $this->get_base_data(), $data );
		return $this->pug->render( $this->get_view( $name ), $data );
	}
}

