<?php
/**
 * Basic captures recurring functions employed by all classes.
 *
 * Basic pulls together operations for setting the mask,
 * logger, and registry. These three elements are used
 * consistently by every class.
 *
 * @file
 * @package admin
 */

namespace WP_Speak;

/**
 * Basic captures recurring functions employed by all classes.
 */
class Basic {

	/**
	 * $mask is a bitmask specific to a class.
	 *
	 * @var int $mask.
	 */
	protected static $mask;

	/**
	 * $registry is a handle to an registry instance.
	 *
	 * @var Registry $registry.
	 */
	protected static $registry;

	/**
	 * $logger is a handle to an logger instance.
	 *
	 * @var Logger $logger.
	 */
	protected static $logger;


	/**
	 * $wp_option is a handle to an wp_option.
	 *
	 * @var WP_Option $wp_option.
	 */
	protected static $wp_option;


	/**
	 * The function get_instance serves the role of returning an instance.
	 * This function supports the Singleton creation pattern.
	 */
	public static function get_instance() {
		if ( is_null( static::$instance ) ) {
			$class            = get_called_class();
			static::$instance = new $class();
		}

		return static::$instance;
	}

	/**
	 * The function set_logger sets the instance handle for the logger.
	 *
	 * @param Logger $arg_logger is a handle to a Logger instance.
	 */
	public function set_logger( Logger $arg_logger ) {
		self::$logger = $arg_logger;
		return $this;
	}

	/**
	 * The function set_mask sets the bit mask for a particular class.
	 *
	 * @param int $arg_mask is the integer mask specific to the binding class.
	 */
	public function set_mask( $arg_mask ) {
		self::$mask = $arg_mask;
		return $this;
	}

	/**
	 * The function set_wp_option sets the instance handle for the wp_option.
	 *
	 * @param Logger $arg_wp_option is a handle to a WP_Option instance.
	 */
	public function set_wp_option( WP_Option $arg_wp_option ) {
		self::$wp_option = $arg_wp_option;
		return $this;
	}

	/**
	 * The function set_registry sets the instance handle for the registry.
	 *
	 * @param Registry $arg_registry is a handle to a Registry instance.
	 */
	public function set_registry( Registry $arg_registry ) {
		self::$registry = $arg_registry;
		return $this;
	}

}
