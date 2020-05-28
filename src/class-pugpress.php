<?php
/**
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

/**
 * Main plugin class.
 */
class PugPress {

	/**
	 * Pug template engine for PHP.
	 *
	 * @since 1.0.0
	 * @var Pug\Pug
	 */
	private $pug;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$options = apply_filters(
			'pugpress_options',
			[
				'pretty'             => true,
				'expressionLanguage' => 'js',
				'basedir'            => $this->get_views_dir(),
				'cache'              => $this->get_cache_dir(),
				'upToDateCheck'      => true,
				'debug'              => false,
				'enable_profiler'    => false,
			]
		);

		$this->pug = new \Pug\Pug( $options );
	}

	/**
	 * Base data to pass to all template.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	private function get_base_data() {
		return apply_filters(
			'pugpress_base_data',
			[
				'wp_head'   => $this->get_output_buffer_contents( 'wp_head' ),
				'wp_footer' => $this->get_output_buffer_contents( 'wp_footer' ),
				'base'      => get_template_directory_uri() . '/',
				'language'  => get_bloginfo( 'language' ),
				'charset'   => get_bloginfo( 'charset' ),
			]
		);
	}

	/**
	 * Get cache directory.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_cache_dir() {
		return get_temp_dir() . str_replace( [ 'http:', 'https:' ], '', site_url() );
	}

	/**
	 * Get pug directory.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	private function get_views_dir() {
		return get_template_directory() . '/views/';
	}

	/**
	 * Get pug template.
	 *
	 * @since 1.0.0
	 * @param string $name Template filename.
	 * @return string
	 */
	private function get_view( $name ) {
		return $this->get_views_dir() . $name . '.pug';
	}

	/**
	 * Return function content instead of echoeing it.
	 *
	 * @since 1.0.0
	 * @param string $function Function name.
	 * @param array  $args     Function arguments.
	 * @return string
	 */
	private function get_output_buffer_contents( $function, $args = [] ) {
		ob_start();
		$function( $args );
		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	/**
	 * Render pug template.
	 *
	 * @since 1.0.0
	 * @param string $name Template filename.
	 * @param array  $data Content for the template.
	 * @return string
	 */
	public function render( $name, $data = [] ) {
		$data = array_merge( $this->get_base_data(), $data );
		return $this->pug->render( $this->get_view( $name ), $data );
	}
}

