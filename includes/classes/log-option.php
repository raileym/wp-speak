<?php
namespace WP_Speak;

class Log_Option extends Basic
{
    protected static $_instance;

	private static $_add_settings_section;
	private static $_add_settings_field = array();
	private static $_section = "log_option";
	private static $_section_title;
	private static $_fields = array (
	        "log"
	    );
	private static $_default_options = array(
            "log_admin"      => 0,
            "log_cache"      => 0,
            "log_callback"   => 0,
            "log_copyright"  => 0,
            "log_debug"      => 0,
            "log_example"    => 0,
            "log_format"     => 0,
            "log_ibm_watson" => 0,
            "log_image"      => 0,
            "log_include"    => 0,
            "log_log"        => 0,
            "log_media"      => 0,
            "log_register"   => 0,
            "log_registry"   => 0
        );

	protected function __construct() { 

    	self::$_section_title = Admin::WPS_ADMIN . self::$_section;
    	
        add_action("admin_init", array(get_class(), "init")); 
        add_action(Admin::WPS_ADMIN."init_log_option",           array(Registry::get_instance(), "init_log_registry"),   Callback::EXPECT_DEFAULT_PRIORITY, Callback::EXPECT_TWO_ARGUMENTS);
        add_filter(Admin::WPS_ADMIN."validate_log_option",       array(Registry::get_instance(), "update_log_registry"), Callback::EXPECT_DEFAULT_PRIORITY, Callback::EXPECT_TWO_ARGUMENTS);

	}
	
    public function get_section() {
        return self::$_section;
    }
    
    /**
     *	Orchestrates the creation of the Log Panel
     */
    public static function init()
    {
        $page = Option::$OPTION_EXTENDED_TITLE[self::$_section];

        if( !get_option( $page ) )
        {
            update_option( $page, self::filter_default_options( self::$_default_options ) );
        }

        $paragraph = <<<EOD
Choose which type(s) of information is displayed in the WP log.
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."log", "title"=>"Debug Logs", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);


        array_map( self::$_add_settings_field["log"], [
            ["id"=>"log_admin",      "title"=>"Log ADMIN",      "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_cache",      "title"=>"Log CACHE",      "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_callback",   "title"=>"Log CALLBACK",   "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_copyright",  "title"=>"Log COPYRIGHT",  "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_debug",      "title"=>"Log DEBUG",      "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_example",    "title"=>"Log EXAMPLE",    "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_format",     "title"=>"Log FORMAT",     "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_ibm_watson", "title"=>"Log IBM WATSON", "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_image",      "title"=>"Log IMAGE",      "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_include",    "title"=>"Log INCLUDE",    "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_log",        "title"=>"Log LOG",        "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_media",      "title"=>"Log MEDIA",      "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_register",   "title"=>"Log REGISTER",   "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
            ["id"=>"log_registry",   "title"=>"Log REGISTRY",   "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( )],
        ]);

        register_setting(
            $page,
            $page,
            array(self::get_instance(), "validate_log_option")
        );

// error_log("DO ACTION: " . Admin::WPS_ADMIN.__FUNCTION__);

        do_action( Admin::WPS_ADMIN.__FUNCTION__, $page, Option::$OPTION_LIST[self::$_section] ); 

// error_log("POST-DO ACTION: " . Admin::WPS_ADMIN.__FUNCTION__);
    }



    public function validate_log_option( $arg_input )
    {
        Logger::get_instance()->log( self::$_mask, "Validation: " . __FUNCTION__ );
        Logger::get_instance()->log( self::$_mask, "Input");
        Logger::get_instance()->log( self::$_mask, print_r( $arg_input, true ) );

        // Define the array for the updated options
        $output = array();

        if ( !isset($arg_input) )
        {
// error_log("*** INPUT IS NOT SET ***");
// error_log("APPLY FILTER: " . Admin::WPS_ADMIN.__FUNCTION__);
// error_log( print_r(Option::$OPTION_LIST[self::$_section], true) );
            $results = apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section]);
// error_log("*** New RESULTS ***");
// error_log( print_r($results, true) );
            return $results;
        }
// error_log("**** arg_input ****");
// error_log( print_r($arg_input, true) );
// error_log("**** output ****");
// error_log( print_r($output, true) );

        // Loop through each of the options sanitizing the data
        foreach( $arg_input as $key => $val )
        {
            if( isset ( $arg_input[$key] ) )
            {
                $output[$key] = $arg_input[$key];
            }
        }

// error_log("*** INPUT IS SET ***");
// error_log("APPLY FILTER: " . Admin::WPS_ADMIN.__FUNCTION__);

        // Return the new collection
        return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section] );
    }


    /**
     * Provides default values for the Debug Options.
     */
    public static function filter_default_options($arg_default_options)
    {
        return $arg_default_options;
        
        $defaults = array(
            "log_admin"      => 0,
            "log_cache"      => 0,
            "log_callback"   => 0,
            "log_copyright"  => 0,
            "log_debug"      => 0,
            "log_example"    => 0,
            "log_format"     => 0,
            "log_ibm_watson" => 0,
            "log_image"      => 0,
            "log_include"    => 0,
            "log_log"        => 0,
            "log_media"      => 0,
            "log_register"   => 0,
            "log_registry"   => 0
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
		foreach(self::$_fields as $field) {
            self::$_add_settings_field[$field] = $arg_add_settings_field->create(self::$_section_title, Admin::WPS_ADMIN.$field);
		}
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
