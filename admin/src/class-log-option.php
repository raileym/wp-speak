<?php
namespace WP_Speak;

class Log_Option extends Basic
{
    protected static $instance;

    /**
     * $mask is the local (protected) copy of mask.
     *
     * @var int $mask
     */
    protected static $mask;

	private static $add_settings_section;
	private static $add_settings_field = array();
	private static $section = "log_option";
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

        add_action(
            "admin_init", 
            array(get_class(), "init")); 

        add_action(
            Action::$init[get_called_class()],
            array(self::$registry, "init_registry"),
            Callback::EXPECT_DEFAULT_PRIORITY,
            Callback::EXPECT_TWO_ARGUMENTS);

        add_action(
            Action::$init[get_called_class()],
            array(get_class(), 'init_log_mask'),
            Callback::EXPECT_DEFAULT_PRIORITY,
            Callback::EXPECT_ZERO_ARGUMENTS);

        add_action(
            Action::$validate[get_called_class()],
            array(get_class(), 'update_log_mask'),
            Callback::EXPECT_DEFAULT_PRIORITY,
            Callback::EXPECT_ONE_ARGUMENT);

        add_filter(
            Filter::$validate[get_called_class()],
            array(self::$registry, "update_registry"),
            Callback::EXPECT_DEFAULT_PRIORITY,
            Callback::EXPECT_TWO_ARGUMENTS);

	}
	
    public static function init_log_mask() {

        $log_mask = self::$array_registry->get( get_called_class() );

        self::$logger->set_logger_mask( 0 );

        foreach($log_mask as $log=>$mask) {
            if ( $mask ) {
                self::$logger->set_logger_mask( self::$logger->get_logger_mask() | Logmask::$mask[ $log ] );
            }
        }

    }
    
    public static function update_log_mask($arg_log_mask) {

        $log_mask = $arg_log_mask;

        self::$logger->set_logger_mask( 0 );

        foreach($log_mask as $log=>$mask) {
            if ( $mask ) {
                self::$logger->set_logger_mask( self::$logger->get_logger_mask() | Logmask::$mask[ $log ] );
            }
        }

    }
    
    public function get_section() {
        return self::$section;
    }
    
    /**
     *	Orchestrates the creation of the Log Panel
     */
    public static function init()
    {
        self::$logger->log( self::$mask, get_called_class() . " " . __FUNCTION__ );

        $option = self::$wp_option->get( WP_Option::$option[ get_called_class() ] );

        if( !$option )
        {
            self::$wp_option->update( WP_Option::$option[ get_called_class() ], self::filter_default_options( self::$default_options ) );
            $option = self::$wp_option->get( WP_Option::$option[ get_called_class() ] );
        }


        $paragraph = <<<EOD
Choose which type(s) of information is displayed in the WP log.
EOD;

        array_map( self::$add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."log",
             "title"=>"Debug Logs",
             "callback"=>Callback::PARAGRAPH,
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
            WP_Option::$option[ get_called_class() ],
            WP_Option::$option[ get_called_class() ],
            array(self::get_instance(), "validate_log_option")
        );

        do_action(
            Action::$init[get_called_class()],
            get_called_class(),
            $option );

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
        $output = apply_filters(
            Filter::$validate[get_called_class()],
            $output,
            Option::$OPTION_LIST[self::$section] );
        

        do_action(
            Action::$validate[get_called_class()],
            $output);

        return $output;
    }


    /**
     * Provides default values for the Debug Options.
     */
    public static function filter_default_options($arg_default_options)
    {
        return $arg_default_options;
    }

    public function set_add_settings_section($arg_add_settings_section)
	{
		//assert( '!is_null($arg_registry)' );
		self::$add_settings_section = $arg_add_settings_section->create( WP_Option::$option[ get_called_class() ] );
		return $this;
	}
	
    public function set_add_settings_field($arg_add_settings_field)
	{
		//assert( '!is_null($arg_registry)' );
		foreach(self::$fields as $field) {
            self::$add_settings_field[$field] = $arg_add_settings_field->create( WP_Option::$option[ get_called_class() ], Admin::WPS_ADMIN.$field);
            //self::$add_settings_field[$field] = $arg_add_settings_field->create( get_called_class(), Admin::WPS_ADMIN.$field);
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
