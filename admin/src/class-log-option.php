<?php
namespace WP_Speak;

class Log_Option extends Basic
{
    protected static $instance;

	private static $add_settings_section;
	private static $add_settings_field = array();
	private static $section = "log_option";
	private static $section_title;
	private static $fields = array (
	        "log"
	    );
	private static $default_options = array(
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

    	self::$section_title = Admin::WPS_ADMIN . self::$section;
    	
        add_action(
            "admin_init", 
            array(get_class(), "init")); 

        add_action(
            Action::$init[get_called_class()],
            array(self::$registry, "init_log_registry"),
            Callback::EXPECT_DEFAULT_PRIORITY,
            Callback::EXPECT_TWO_ARGUMENTS);

        add_filter(
            Filter::$validate[get_called_class()],
            array(self::$registry, "update_log_registry"),
            Callback::EXPECT_DEFAULT_PRIORITY,
            Callback::EXPECT_TWO_ARGUMENTS);

	}
	
    public function get_section() {
        return self::$section;
    }
    
    /**
     *	Orchestrates the creation of the Log Panel
     */
    public static function init()
    {
        $page = Option::$OPTION_EXTENDED_TITLE[self::$section];

        if( !get_option( $page ) )
        {
            update_option( $page, self::filter_default_options( self::$default_options ) );
        }

        $paragraph = <<<EOD
Choose which type(s) of information is displayed in the WP log.
EOD;

        array_map( self::$add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."log",
             "title"=>"Debug Logs",
             "callback"=>array("WP_Speak\Callback", "section_p_callback"),
             "args"=>array( "paragraph" => $paragraph )]
        ]);


        array_map( self::$add_settings_field["log"], [
            ["id"=>"log_admin",      "title"=>"Log ADMIN",      "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_cache",      "title"=>"Log CACHE",      "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_callback",   "title"=>"Log CALLBACK",   "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_copyright",  "title"=>"Log COPYRIGHT",  "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_debug",      "title"=>"Log DEBUG",      "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_example",    "title"=>"Log EXAMPLE",    "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_format",     "title"=>"Log FORMAT",     "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_ibm_watson", "title"=>"Log IBM WATSON", "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_image",      "title"=>"Log IMAGE",      "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_include",    "title"=>"Log INCLUDE",    "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_log",        "title"=>"Log LOG",        "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_media",      "title"=>"Log MEDIA",      "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_register",   "title"=>"Log REGISTER",   "callback"=>Callback::CHECKBOX, "args"=>array( )],
            ["id"=>"log_registry",   "title"=>"Log REGISTRY",   "callback"=>Callback::CHECKBOX, "args"=>array( )],
        ]);

        register_setting(
            $page,
            $page,
            array(self::get_instance(), "validate_log_option")
        );

// error_log("DO ACTION: " . Admin::WPS_ADMIN.__FUNCTION__);

        do_action(
            Action::$init[get_called_class()],
            $page,
            Option::$OPTION_LIST[self::$section] ); 

// error_log("POST-DO ACTION: " . Admin::WPS_ADMIN.__FUNCTION__);
    }



    public function validate_log_option( $arg_input )
    {
        self::$logger->log( self::$mask, "Validation: " . __FUNCTION__ );
        self::$logger->log( self::$mask, "Input");
        self::$logger->log( self::$mask, print_r( $arg_input, true ) );

        // Define the array for the updated options
        $output = array();

        if ( !isset($arg_input) )
        {
            $results = apply_filters(
                Filter::$validate[get_called_class()],
                $output,
                Option::$OPTION_LIST[self::$section]);

            return $results;
        }

        // Loop through each of the options sanitizing the data
        foreach( $arg_input as $key => $val )
        {
            if( isset ( $arg_input[$key] ) )
            {
                $output[$key] = $arg_input[$key];
            }
        }

        // Return the new collection
        return apply_filters(
                Filter::$validate[get_called_class()],
                $output,
                Option::$OPTION_LIST[self::$section] );
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
		self::$add_settings_section = $arg_add_settings_section->create(Option::$OPTION_EXTENDED_TITLE[self::$section]);;
		return $this;
	}
	
    public function set_add_settings_field($arg_add_settings_field)
	{
		//assert( '!is_null($arg_registry)' );
		foreach(self::$fields as $field) {
            self::$add_settings_field[$field] = $arg_add_settings_field->create(self::$section_title, Admin::WPS_ADMIN.$field);
		}
		return $this;
	}
	
	public function set_db(DB $arg_db)
	{
		//assert( '!is_null($arg_logger)' );
		self::$db = $arg_db;
		return $this;
	}
	
}

?>
