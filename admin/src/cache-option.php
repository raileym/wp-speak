<?php
namespace WP_Speak;

// See https://premium.wpmudev.org/blog/activate-deactivate-uninstall-hooks/

class Cache_Option extends Basic
{
    protected static $_instance;

	private static $_add_settings_section;
	private static $_add_settings_field = array();
	private static $_section = "cache_option";
	private static $_section_title;
	private static $_fields = array (
            "wp_speak_admin_cache_option"
	    );
	private static $_default_options = array(
            "use_cache_shorturl"	=>	""
        );


	
	protected function __construct() { 

    	self::$_section_title = Admin::WPS_ADMIN . self::$_section;
    	
        add_action("admin_init", array(get_class(), "init")); 
        add_action(Admin::WPS_ADMIN."init_".self::$_section,     array(self::$_registry, "init_registry"),   Callback::EXPECT_NON_DEFAULT_PRIORITY, Callback::EXPECT_TWO_ARGUMENTS);
        add_filter(Admin::WPS_ADMIN."validate_".self::$_section, array(self::$_registry, "update_registry"), Callback::EXPECT_DEFAULT_PRIORITY, Callback::EXPECT_TWO_ARGUMENTS);

	}
	
    public function get_section() {
        return self::$_section;
    }
    
    /**
     *	Orchestrates the creation of the Cache Panel
     */
    public static function init($arg1)
    {
        $page = Option::$OPTION_EXTENDED_TITLE[self::$_section];

// error_log($page);

        if( !get_option( $page ) )
        {
            update_option( $page, self::filter_default_options( self::$_default_options ) );
        }


        $paragraph = <<<EOD
Choose whether to engage certain cache(s).
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."cache", "title"=>"Cache Settings", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);



        array_map( self::$_add_settings_field["cache"], [
            ["id"=>"use_cache_shorturl", "title"=>"Use SHORTURL CACHE", "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )]
        ]);

        register_setting(
            $page,
            $page,
            array(self::get_instance(), "validate_cache_option")
        );

        do_action( Admin::WPS_ADMIN.__FUNCTION__, $page, Option::$OPTION_LIST[self::$_section] );
    }

    public function validate_cache_option( $arg_input )
    {
        Logger::get_instance()->log( self::$_mask, "Validation: " . __FUNCTION__ );
        Logger::get_instance()->log( self::$_mask, "Input");
        Logger::get_instance()->log( self::$_mask, print_r( $arg_input, true ) );

        // Define the array for the updated options
        $output = array();

        if ( !isset($arg_input) )
        {
            return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section]);
        }

        // Loop through each of the options sanitizing the data
        foreach( $arg_input as $key => $val )
        {
            if( isset ( $arg_input[$key] ) )
            {
                $output[$key] = $arg_input[$key];

                // FUTURE Example of what I can do to validate/strip content
                //$output[$key] = esc_url_raw( strip_tags( stripslashes( $arg_input[$key] ) ) );
            }
        }

        // Return the new collection
        return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section]);
    }


    /**
     * Provides default values for Cache Options.
     */
    public static function filter_default_options($arg_default_options)
    {
        return $arg_default_options;
        
        $defaults = array(
            "use_cache_shorturl"	=>	""
        );

        return $defaults;
    }

    public function set_add_settings_section($arg_add_settings_section)
	{
		//assert( '!is_null($arg_registry)' );
		self::$_add_settings_section = $arg_add_settings_section->create(Option::$OPTION_EXTENDED_TITLE[self::$_section]);;
		return $this;
	}
	
    public function set_add_settings_field($arg_add_settings_field)
	{
		//assert( '!is_null($arg_registry)' );
		$section = "wp_speak_admin_cache_option";
		$field   = "cache";
		self::$_add_settings_field[$field] = $arg_add_settings_field->create($section, Admin::WPS_ADMIN.$field);
		return $this;
	}
	
	public function set_db(DB $arg_db)
	{
		//assert( '!is_null($arg_logger)' );
		self::$_db = $arg_db;
		return $this;
	}
	
}

?>
