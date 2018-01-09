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
	 * Undocumented class variable
	 *
	 * @var string
	 */
	private $views_dir;

	/**
	 * Undocumented class variable
	 *
	 * @var array
	 */
	private $base_data;

	/**
	 * A reference to the Pug template engine for PHP
	 *
	 * @var object
	 */
	private $pug;

	/**
	 * Pug_Press Constructor
	 */
	public function __construct() {
		$this->views_dir = template_path() . '/views/';
		$this->pug       = new \Pug\Pug( array(
			'pretty'             => true,
			'expressionLanguage' => 'js',
			'basedir'            => $this->views_dir,
		) );
		$this->set_base_data();
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	private function set_base_data() {
		$this->base_data = [
			'wp_head'   => $this->output_buffer_contents( 'wp_head' ),
			'wp_footer' => $this->output_buffer_contents( 'wp_footer' ),
			'base'      => get_template_directory_uri() . '/',
			'lang'      => get_bloginfo( 'language' ),
			'charset'   => get_bloginfo( 'charset' ),
		];
	}

	/**
	 * Undocumented function
	 *
	 * @param string $function Function name.
	 * @param array  $args     Function arguments.
	 * @return string
	 */
	private function output_buffer_contents( $function, $args = array() ) {
		ob_start();
		$function( $args );
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	/**
	 * Undocumented function
	 *
	 * @param string $name Template filename.
	 * @param array  $data Content for the template.
	 * @return string
	 */
	public function render( $name, $data = array() ) {
		$template = $this->views_dir . $name . '.pug';
		$data     = array_merge( $this->base_data, $data );
		return $this->pug->render( $template, $data );
	}
}

