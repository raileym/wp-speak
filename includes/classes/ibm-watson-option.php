<?php
namespace WP_Speak;

class IBM_Watson_Option extends Basic
{
    protected static $_instance;

	private static $_add_settings_section;
	private static $_add_settings_field = array();
	private static $_section = "ibm_watson_option";    //"wp_speak_admin_ibm_watson_option"
	private static $_section_title;
	private static $_fields = array (
            "wp_speak_admin_ibm_watson_option"
	    );
	private static $_default_options = array(
            "ibm_watson_message"	    =>	"no message",
            "ibm_watson_user_name"	    =>	"no user name",
            "ibm_watson_user_password"  =>	"no user password"
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
     *	Orchestrates the creation of the IBM Watson Panel
     */
    public static function init($arg1)
    {
        $page = Option::$OPTION_EXTENDED_TITLE[self::$_section];

        // If the IBM Watson Options don't exist, create them.
        if( !get_option( $page ) )
        {
            update_option( $page, self::filter_default_options( self::$_default_options ) );
        }


        $paragraph = <<<EOD
Fill-in the details for your registration.
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>ADMIN::WPS_ADMIN."ibm_watson", "title"=>"IBM Watson Options", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);


        array_map( self::$_add_settings_field["ibm_watson"], [
            ["id"=>"ibm_watson_user_name",     "title"=>"User Name",     "callback"=>array("WP_Speak\Callback", "element_input_callback"), "args"=>array( "label" => "ex: 20-chars, alphanumeric" )],
            ["id"=>"ibm_watson_user_password", "title"=>"User Password", "callback"=>array("WP_Speak\Callback", "element_input_callback"), "args"=>array( "label" => "ex: 20-chars, alphanumeric" )]
        ]);

        register_setting(
            $page,
            $page,
            array(self::get_instance(), "validate_ibm_watson_option")
        );

        do_action( ADMIN::WPS_ADMIN.__FUNCTION__, $page, Option::$OPTION_LIST[self::$_section] );
    }

    public function validate_ibm_watson_option( $arg_input )
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

        $ibm_watson_domain = get_site_url();
        
        add_settings_error( 'ibm_watson_user_name',     'User Name',     'Definitely an incorrect user name entered!', 'error' );
        add_settings_error( 'ibm_watson_user_password', 'User Password', 'Definitely an incorrect password entered!', 'warning' );
        add_settings_error( 'ibm_watson_user_password', 'User Password', 'Definitely an incorrect password entered!', 'info' );
        add_settings_error( 'ibm_watson_user_password', 'User Password', 'Definitely an incorrect password entered!', 'success' );

    if ( false ) {

        if ( isset($arg_input["ibm_watson_user_name"], $arg_input["ibm_watson_user_password"], $ibm_watson_domain) ) {

            $response = Comm::get_instance()->ibm_watson_user($arg_input["ibm_watson_user_name"], $arg_input["ibm_watson_user_password"], $ibm_watson_domain);
            $options["show_comm"] && Logger::get_instance()->log( self::$_mask, "Admin Register: ".print_r($response, TRUE));

            if ($response["status"] && "200" == $response["wp_speak_code"])
            {
                $output["is_ibm_watsoned"]    = TRUE;
                $output["ibm_watson_message"] = $response["wp_speak_message"];
                $output["status_name"]      = $response["wp_speak_status_name"];
                $output["ibm_watson_domain"]  = $ibm_watson_domain;
            }
            else
            {
                $output["is_ibm_watsoned"]    = FALSE;
                $output["ibm_watson_message"] = $response["wp_speak_message"];
                $output["status_name"]      = NULL;
                $output["ibm_watson_domain"]  = $ibm_watson_domain;
            }

        }
        else
        {
            $output["is_ibm_watsoned"]    = FALSE;
            $output["ibm_watson_message"] = "Domain Not Registered";
            $output["status_name"]      = NULL;
            $output["ibm_watson_domain"]  = $ibm_watson_domain;
        }
    } else {
        $output["is_ibm_watsoned"]    = TRUE;
        $output["ibm_watson_message"] = "Register Message blah blah";
        $output["status_name"]        = "Status Name blah blah";
        $output["ibm_watson_domain"]  = "Register Domain blah blah";
    }

        // Return the new collection
        return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section]);
    }

    /**
     * Provides default values for the Media Options.
     */
    public static function filter_default_options($arg_default_options)
    {
        return $arg_default_options;
        
        // These are not actually the default values, btw.
        $defaults = array(
            "css_header_files"			=>	"IBM Watson",
            "javascript_header_files"	=>	"IBM Watson",
            "javascript_footer_files"	=>	"IBM Watson"
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
		$section = "wp_speak_admin_ibm_watson_option";
		$field   = "ibm_watson";
		self::$_add_settings_field[$field] = $arg_add_settings_field->create($section, Admin::WPS_ADMIN.$field);
		return $this;
	}
	
}

?>
