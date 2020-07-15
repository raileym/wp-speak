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
            "wp_speak_admin_register_option"
	    );
	private static $default_options = array(
            "wp_speak_home"		     =>	"No home",
            "is_registered"			 =>	"Not registered",
            "register_message"		 =>	"No message",
            "register_user_name"	 =>	"No user name",
            "register_user_password" =>	"No user password",
            "shorturl_home"			 =>	"No shorturl",
            "status_name"			 =>	"No status"
        );


	
	protected function __construct() { 

        add_action(
            "admin_init",
            array(get_class(), "init")); 

        add_action(
            Action::$init[get_called_class()],
            array(self::$registry, "init_registry"),
            Callback::EXPECT_NON_DEFAULT_PRIORITY,
            Callback::EXPECT_TWO_ARGUMENTS);

        add_filter(
            Filter::$validate[get_called_class()],
            array(self::$registry, "update_registry"),
            Callback::EXPECT_DEFAULT_PRIORITY,
            Callback::EXPECT_TWO_ARGUMENTS);
        
	}
	
    public function get_section() {
        return self::$section;
    }
    
    /**
     *	Orchestrates the creation of the Register Panel
     */
    public static function init($arg1)
    {
        self::$logger->log( self::$mask, get_called_class() . " " . __FUNCTION__ );

        $option = self::$wp_option->get( get_called_class() );

        if( !$option )
        {
            self::$wp_option->update( get_called_class(), self::filter_default_options( self::$default_options ) );
            $option = self::$wp_option->get( get_called_class() );
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

            ["id"=>"shorturl_home",
             "title"=>"ShortURL Home",
             "callback"=>Callback::INPUT,
             "args"=>array( "label" => "ex: http://wps.io" )],

            ["id"=>"wp_speak_home",
             "title"=>"WP_Speak Home",
             "callback"=>Callback::INPUT,
             "args"=>array( "label" => "ex: http://wp-speak.com" )]
        ]);
        
        register_setting(
            WP_Option::$option[ get_called_class() ],
            WP_Option::$option[ get_called_class() ],
            array(self::get_instance(), "validate_register_option")
        );

        do_action(
            Action::$init[get_called_class()],
            get_called_class(),
            $option );
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

        add_settings_error( 'register_user_name', 'User Name', 'Incorrect user name entered!', 'error' );
        add_settings_error( 'register_user_password', 'User Password', 'Incorrect password entered!', 'warning' );
        add_settings_error( 'register_user_password', 'User Password', 'Incorrect password entered!', 'info' );
        add_settings_error( 'register_user_password', 'User Password', 'Incorrect password entered!', 'success' );

        $output["is_registered"]    = TRUE;
        $output["register_message"] = "Register Message blah blah";
        $output["status_name"]      = "Status Name blah blah";
        $output["register_domain"]  = "Register Domain blah blah";

        // Return the new collection
        return apply_filters(
            Filter::$validate[get_called_class()],
            $output,
            Option::$OPTION_LIST[self::$section]);
    }

    /**
     * Provides default values for the Register Options.
     */
    public static function filter_default_options($arg_default_options)
    {
        return $arg_default_options;
    }

    public function set_add_settings_section($arg_add_settings_section)
	{
		//assert( '!is_null($arg_registry)' );
		self::$add_settings_section = $arg_add_settings_section->create(
            get_called_class() );
		return $this;
	}
	
    public function set_add_settings_field($arg_add_settings_field)
	{
		//assert( '!is_null($arg_registry)' );
		$section = "wp_speak_admin_register_option";
		$field   = "register";
		self::$add_settings_field[$field] = $arg_add_settings_field->create(
            get_called_class(),
            Admin::WPS_ADMIN.$field);
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
