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
	 * Load dev env Pug engine options.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	public $dev_env = false;

	/**
	 * Do not load Pug engine if a file is available in the cache.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	public $optimize = false;

	/**
	 * Pug engine options.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $options;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->set_options();

	}

	/**
	 * Set pug engine options.
	 *
	 * @since 1.0.0
	 */
	public function set_options() {

		$options_production = apply_filters(
			'pugpress_options_production',
			[
				'expressionLanguage' => 'js',
				'basedir'            => $this->get_views_dir(),
				'cache_dir'          => $this->get_cache_dir(),
				'up_to_date_check'   => true,
				'debug'              => false,
				'enable_profiler'    => false,
			]
		);

		$options_development = apply_filters(
			'pugpress_options_development',
			[
				'expressionLanguage' => 'js',
				'basedir'            => $this->get_views_dir(),
				'cache'              => false,
				'debug'              => true,
				'enable_profiler'    => true,
			]
		);

		$this->options = apply_filters( 'pugpress_options', $this->dev_env ? $options_development : $options_production );
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
				'head'       => $this->get_output_buffer_contents( 'wp_head' ),
				'foot'       => $this->get_output_buffer_contents( 'wp_footer' ),
				'language'   => get_bloginfo( 'language' ),
				'charset'    => get_bloginfo( 'charset' ),
				'body_class' => $this->get_output_buffer_contents( 'body_class' ),
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
	 * @param bool   $base_data Add base data to template content.
	 */
	public function render( $name, $data = [], $base_data = true ) {
		if ( $base_data ) {
			$data = array_merge( $this->get_base_data(), $data );
		}

		if ( $this->optimize ) {
			\Pug\Optimizer::call( 'displayFile', [ $this->get_view( $name ), $data ], $this->options );
		} else {
			\Pug\Facade::displayFile( $this->get_view( $name ), $data, $this->options );
		}
	}
}

