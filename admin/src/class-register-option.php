<?php
namespace WP_Speak;

class Register_Option extends Basic
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
	private static $section = "register_option";    //"wp_speak_admin_register_option"
    private static $fields = array (
            "register"
	    );
	private static $default_options = array(
            "register_home"		     =>	"No home",
            "register_is_registered" =>	"Not registered",
            "register_message"		 =>	"No message",
            "register_user_name"	 =>	"No user name",
            "register_user_password" =>	"No user password",
            "register_shorturl_home" =>	"No shorturl",
            "register_status_name"	 =>	"No status"
        );


	
	protected function __construct() { 

        add_action(
            "admin_init",
            array(get_class(), "init")); 

	}
	
    public function get_section() {
        return self::$section;
    }
    
    /**
     *	Orchestrates the creation of the Register Panel
     */
    public static function init($arg1)
    {
        add_action(
            Action::$init[get_called_class()],
            array(self::$registry, "init_registry"),
            Callback::EXPECT_NON_DEFAULT_PRIORITY,
            Callback::EXPECT_TWO_ARGUMENTS);

        add_filter(
            Filter::$validate[get_called_class()],
            array(self::$registry, "update_registry"),
            Callback::EXPECT_DEFAULT_PRIORITY,
            Callback::EXPECT_THREE_ARGUMENTS);
        
        self::$logger->log( self::$mask, get_called_class() . " " . __FUNCTION__ );

        $option = self::$wp_option->get( get_called_class() );

        if( !$option )
        {
            self::$wp_option->update( get_called_class(), self::filter_default_options( self::$default_options ) );
            $option = self::$wp_option->get( get_called_class() );
        }



		self::$add_settings_section = self::$wp_settings->create_add_settings_section(
            get_called_class() );


		foreach(self::$fields as $field) {
            self::$add_settings_field[$field] = self::$wp_settings->create_add_settings_field(
                get_called_class(),
                Admin::WPS_ADMIN.$field);
		}


        $paragraph = <<<EOD
Fill-in the details for your registration.
EOD;

        array_map(
            self::$add_settings_section, [
                ["id"=>Admin::WPS_ADMIN."register",
                 "title"=>"Register Options",
                 "callback"=>Callback::PARAGRAPH,
                 "args"=>array( "paragraph" => $paragraph )]
            ]);


        array_map( self::$add_settings_field["register"], [
            ["id"=>"register_user_name",
             "title"=>"User Name",
             "callback"=>Callback::INPUT,
             "args"=>array( "label" => "ex: 20-chars, alphanumeric" )],

            ["id"=>"register_user_password",
             "title"=>"User Password",
             "callback"=>Callback::INPUT,
             "args"=>array( "label" => "ex: 20-chars, alphanumeric" )],

            ["id"=>"register_shorturl_home",
             "title"=>"ShortURL Home",
             "callback"=>Callback::INPUT,
             "args"=>array( "label" => "ex: http://wps.io" )],

            ["id"=>"register_home",
             "title"=>"Home",
             "callback"=>Callback::INPUT,
             "args"=>array( "label" => "ex: http://wp-speak.com" )]
        ]);
        
        self::$wp_settings->register_setting(
            WP_Option::$option[ get_called_class() ],
            WP_Option::$option[ get_called_class() ],
            array(self::get_instance(), "validate_register_option")
        );

        do_action(
            Action::$init[get_called_class()],
            get_called_class(),
            Option::$OPTION_LIST[self::$section] );
    }

    public function validate_register_option( $arg_input )
    {
        self::$logger->log( self::$mask, "Validation: " . __FUNCTION__ );
        self::$logger->log( self::$mask, "Input");
        self::$logger->log( self::$mask, print_r( $arg_input, true ) );

        // Define the array for the updated options
        $output = array();

        if ( !isset($arg_input) )
        {
            return apply_filters(
                Filter::$validate[get_called_class()],
                get_called_class(),
                $output,
                Option::$OPTION_LIST[self::$section]);
        }

        // Loop through each of the options sanitizing the data
        foreach( $arg_input as $key => $val )
        {
            if( isset ( $arg_input[$key] ) )
            {
                $output[$key] = $arg_input[$key];
            }
        }

        self::$wp_settings->add_settings_error( 'register_user_name', 'User Name', 'Incorrect user name entered!', 'error' );
        self::$wp_settings->add_settings_error( 'register_user_password', 'User Password', 'Incorrect password entered!', 'warning' );
        self::$wp_settings->add_settings_error( 'register_user_password', 'User Password', 'Incorrect password entered!', 'info' );
        self::$wp_settings->add_settings_error( 'register_user_password', 'User Password', 'Incorrect password entered!', 'success' );

        $output["register_is_registered"] = TRUE;
        $output["register_message"]       = "Register Message blah blah";
        $output["register_status_name"]   = "Status Name blah blah";
        $output["register_domain"]        = "Register Domain blah blah";

        //error_log("ABOVE");
        // Return the new collection
        $output = apply_filters(
            Filter::$validate[get_called_class()],
            get_called_class(),
            $output,
            Option::$OPTION_LIST[self::$section]);
        //error_log("BELOW");

        return $output;
    }

    /**
     * Provides default values for the Register Options.
     */
    public static function filter_default_options($arg_default_options)
    {
        return $arg_default_options;
    }

	public function set_db(DB $arg_db)
	{
		//assert( '!is_null($arg_logger)' );
		self::$db = $arg_db;
		return $this;
	}
	
}

?>
