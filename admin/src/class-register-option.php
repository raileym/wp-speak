<?php
namespace WP_Speak;

class Register_Option extends Basic
{
    protected static $_instance;

	private static $_add_settings_section;
	private static $_add_settings_field = array();
	private static $_section = "register_option";    //"wp_speak_admin_register_option"
	private static $_section_title;
    private static $_fields = array (
            "wp_speak_admin_register_option"
	    );
	private static $_default_options = array(
            "wp_speak_home"		     =>	"No home",
            "is_registered"			 =>	"Not registered",
            "register_message"		 =>	"No message",
            "register_user_name"	 =>	"No user name",
            "register_user_password" =>	"No user password",
            "shorturl_home"			 =>	"No shorturl",
            "status_name"			 =>	"No status"
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
     *	Orchestrates the creation of the Register Panel
     */
    public static function init($arg1)
    {
        $page = Option::$OPTION_EXTENDED_TITLE[self::$_section];

        // If the Register Options don't exist, create them.
        if( !get_option( $page ) )
        {
            update_option( $page, self::filter_default_options( self::$_default_options ) );
        }


        $paragraph = <<<EOD
Fill-in the details for your registration.
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."register", "title"=>"Register Options", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);


        array_map( self::$_add_settings_field["register"], [
            ["id"=>"register_user_name",     "title"=>"User Name",     "callback"=>array("WP_Speak\Callback", "element_input_callback"), "args"=>array( "label" => "ex: 20-chars, alphanumeric" )],
            ["id"=>"register_user_password", "title"=>"User Password", "callback"=>array("WP_Speak\Callback", "element_input_callback"), "args"=>array( "label" => "ex: 20-chars, alphanumeric" )],
            ["id"=>"shorturl_home",          "title"=>"ShortURL Home", "callback"=>array("WP_Speak\Callback", "element_input_callback"), "args"=>array( "label" => "ex: http://wps.io" )],
            ["id"=>"wp_speak_home",          "title"=>"WP_Speak Home", "callback"=>array("WP_Speak\Callback", "element_input_callback"), "args"=>array( "label" => "ex: http://wp-speak.com" )]
        ]);

        register_setting(
            $page,
            $page,
            array(self::get_instance(), "validate_register_option")
        );

        do_action( Admin::WPS_ADMIN.__FUNCTION__, $page, Option::$OPTION_LIST[self::$_section] );
    }

    public function validate_register_option( $arg_input )
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
            }
        }

        $options = get_option( Option::$OPTION_EXTENDED_TITLE["debug_option"] );

        $register_domain = get_site_url();
        
        add_settings_error( 'register_user_name', 'User Name', 'Incorrect user name entered!', 'error' );
        add_settings_error( 'register_user_password', 'User Password', 'Incorrect password entered!', 'warning' );
        add_settings_error( 'register_user_password', 'User Password', 'Incorrect password entered!', 'info' );
        add_settings_error( 'register_user_password', 'User Password', 'Incorrect password entered!', 'success' );

    if ( false ) {

        if ( isset($arg_input["register_user_name"], $arg_input["register_user_password"], $register_domain) ) {

            $response = Comm::get_instance()->register_user($arg_input["register_user_name"], $arg_input["register_user_password"], $register_domain);
            $options["show_comm"] && Logger::get_instance()->log( self::$_mask, "Admin Register: ".print_r($response, TRUE));

            if ($response["status"] && "200" == $response["wp_speak_code"])
            {
                $output["is_registered"]    = TRUE;
                $output["register_message"] = $response["wp_speak_message"];
                $output["status_name"]      = $response["wp_speak_status_name"];
                $output["register_domain"]  = $register_domain;
            }
            else
            {
                $output["is_registered"]    = FALSE;
                $output["register_message"] = $response["wp_speak_message"];
                $output["status_name"]      = NULL;
                $output["register_domain"]  = $register_domain;
            }

        }
        else
        {
            $output["is_registered"]    = FALSE;
            $output["register_message"] = "Domain Not Registered";
            $output["status_name"]      = NULL;
            $output["register_domain"]  = $register_domain;
        }
    } else {
        $output["is_registered"]    = TRUE;
        $output["register_message"] = "Register Message blah blah";
        $output["status_name"]      = "Status Name blah blah";
        $output["register_domain"]  = "Register Domain blah blah";
    }

// 			FUTURE Example that uses settings_error feature
//			add_settings_error(
// 				Option::$REGISTER, // whatever you registered in register_setting
// 				"a_code_here", // doesn't really mater
// 				__($output["register_message"].": ".$output["status_name"], "wpse"),
// 				"error" // error or notice works to make things pretty
// 			);

        // Return the new collection
        return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section]);
    }

    /**
     * Provides default values for the Register Options.
     */
    public static function filter_default_options($arg_default_options)
    {
        return $arg_default_options;
        
        $defaults = array(
            "wp_speak_home"		     =>	"",
            "is_registered"			 =>	"",
            "register_message"		 =>	"",
            "register_user_name"	 =>	"",
            "register_user_password" =>	"",
            "shorturl_home"			 =>	"",
            "status_name"			 =>	""
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
		$section = "wp_speak_admin_register_option";
		$field   = "register";
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
