<?php
namespace WP_Speak;

// See https://premium.wpmudev.org/blog/activate-deactivate-uninstall-hooks/
class Cache_Option extends Basic {

	protected static $instance;

	private static $add_settings_section;
	private static $section_title;
	private static $section            = 'cache_option';
	private static $add_settings_field = array();
	private static $fields             = array(
		'wp_speak_admin_cache_option',
	);
	private static $default_options    = array(
		'use_cache_shorturl' => '',
	);



	protected function __construct() {

		self::$section_title = Admin::WPS_ADMIN . self::$section;

		add_action( 'admin_init', array( get_class(), 'init' ) );
		add_action( Admin::WPS_ADMIN . 'init_' . self::$section, 
		    array( self::$registry, 'init_registry' ), 
		    Callback::EXPECT_NON_DEFAULT_PRIORITY, 
		    Callback::EXPECT_TWO_ARGUMENTS );
		add_filter( Admin::WPS_ADMIN . 'validate_' . self::$section, 
		    array( self::$registry, 'update_registry' ), 
		    Callback::EXPECT_DEFAULT_PRIORITY, 
		    Callback::EXPECT_TWO_ARGUMENTS );

	}

	public function get_section() {
		return self::$section;
	}

	/**
	 *  Orchestrates the creation of the Cache Panel
	 */
	public static function init( $arg1 ) {

		if ( ! get_option( self::$section_title ) ) {
			update_option( self::$section_title, self::filter_default_options( self::$default_options ) );
		}

		$paragraph = <<<EOD
Choose whether to engage certain cache(s).
EOD;

		array_map(
			self::$add_settings_section,
			[
				[
					'id'       => Admin::WPS_ADMIN . 'cache',
					'title'    => 'Cache Settings',
					'callback' => array( 'WP_Speak\Callback', 'section_p_callback' ),
					'args'     => array( 'paragraph' => $paragraph ),
				],
			]
		);

		array_map(
			self::$add_settings_field['cache'],
			[
				[
					'id'       => 'use_cache_shorturl',
					'title'    => 'Use SHORTURL CACHE',
					'callback' => array( 'WP_Speak\Callback', 'element_checkbox_callback' ),
					'args'     => array(),
				],
			]
		);

		register_setting(
			self::$section_title,
			self::$section_title,
			array( self::get_instance(), 'validate_cache_option' )
		);

		do_action( Admin::WPS_ADMIN . __FUNCTION__, self::$section_title, Option::$OPTION_LIST[ self::$section ] );
	}

	public function validate_cache_option( $arg_input ) {
		Logger::get_instance()->log( self::$mask, 'Validation: ' . __FUNCTION__ );
		Logger::get_instance()->log( self::$mask, 'Input' );
		Logger::get_instance()->log( self::$mask, print_r( $arg_input, true ) );

		// Define the array for the updated options
		$output = array();

		if ( ! isset( $arg_input ) ) {
			return apply_filters( Admin::WPS_ADMIN . __FUNCTION__, $output, Option::$OPTION_LIST[ self::$section ] );
		}

		// Loop through each of the options sanitizing the data
		foreach ( $arg_input as $key => $val ) {
			if ( isset( $arg_input[ $key ] ) ) {
				$output[ $key ] = $arg_input[ $key ];
			}
		}

		// Return the new collection
		return apply_filters( Admin::WPS_ADMIN . __FUNCTION__, $output, Option::$OPTION_LIST[ self::$section ] );
	}


	/**
	 * Provides default values for Cache Options.
	 */
	public static function filter_default_options( $arg_default_options ) {

		$defaults = array(
			'use_cache_shorturl' => '',
		);

		return $arg_default_options;
	}

	public function set_add_settings_section( $arg_add_settings_section ) {
		self::$add_settings_section = $arg_add_settings_section->create( self::$section_title );

		return $this;
	}

	public function set_add_settings_field( $arg_add_settings_field ) {
		self::$add_settings_field[ 'cache' ] = $arg_add_settings_field->create( 
		    self::$section_title, 
		    Admin::WPS_ADMIN . 'cache' 
		);
		return $this;
	}

	public function set_db( DB $arg_db ) {
		self::$db = $arg_db;
		return $this;
	}

}


