<?php
namespace WP_Speak;

class IBM_Watson_Option extends Basic
{
    protected static $instance;

	private static $add_settings_section;
	private static $add_settings_field = array();
	private static $section = "ibm_watson_option";    //"wp_speak_admin_ibm_watson_option"

    private static $section_title;

    private static $filter;

	private static $fields = array (
            "wp_speak_admin_ibm_watson_option"
	    );

	private static $default_options = array(
            "ibm_watson_message"	    =>	"no message",
            "ibm_watson_user_name"	    =>	"no user name",
            "ibm_watson_user_password"  =>	"no user password"
        );

	
	protected function __construct() { 

    	self::$section_title = Admin::WPS_ADMIN . self::$section;
    	
        // Initialize this class upon admin_init.
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
     *	Orchestrates the creation of the IBM Watson Panel
     */
    public static function init($arg1)
    {
        $page = Option::$OPTION_EXTENDED_TITLE[self::$section];

        // If the IBM Watson Options don't exist, create them.
        if( !get_option( $page ) )
        {
            update_option( $page, self::filter_default_options( self::$default_options ) );
        }


        $paragraph = <<<EOD
Fill-in the details for your registration.
EOD;

        array_map(
            self::$add_settings_section, [
                ["id"=>ADMIN::WPS_ADMIN."ibm_watson", 
                 "title"=>"IBM Watson Options",
                 "callback"=>array("WP_Speak\Callback", "section_p_callback"),
                 "args"=>array( "paragraph" => $paragraph )]
            ]);


        array_map(
            self::$add_settings_field["ibm_watson"], [
                ["id"=>"ibm_watson_user_name",
                 "title"=>"User Name",
                 "callback"=>array("WP_Speak\Callback", "element_input_callback"),
                 "args"=>array( "label" => "ex: 20-chars, alphanumeric" )],

                ["id"=>"ibm_watson_user_password",
                 "title"=>"User Password",
                 "callback"=>array("WP_Speak\Callback", "element_input_callback"),
                 "args"=>array( "label" => "ex: 20-chars, alphanumeric" )]
            ]);

        register_setting(
            $page,
            $page,
            array(self::get_instance(), "validate_ibm_watson_option")
        );

        error_log( get_called_class() );

        do_action(
            Action::$init[get_called_class()],
            $page,
            Option::$OPTION_LIST[self::$section] );
    }

    public function validate_ibm_watson_option( $arg_input )
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

        $options = get_option( Option::$OPTION_EXTENDED_TITLE["debug_option"] );

        $ibm_watson_domain = get_site_url();
        
        add_settings_error( 
            'ibm_watson_user_name',
            'User Name',
            'Definitely an incorrect user name entered!',
            'error' );

        add_settings_error(
            'ibm_watson_user_password',
            'User Password',
            'Definitely an incorrect password entered!',
            'warning' );

        add_settings_error(
            'ibm_watson_user_password',
            'User Password',
            'Definitely an incorrect password entered!',
            'info' );

        add_settings_error(
            'ibm_watson_user_password',
            'User Password',
            'Definitely an incorrect password entered!',
            'success' );

        if ( false ) {
            
            if ( isset($arg_input["ibm_watson_user_name"], $arg_input["ibm_watson_user_password"], $ibm_watson_domain) ) {
                
//             $response = Comm::get_instance()->ibm_watson_user($arg_input["ibm_watson_user_name"], $arg_input["ibm_watson_user_password"], $ibm_watson_domain);
//             $options["show_comm"] && self::$logger->log( self::$mask, "Admin Register: ".print_r($response, TRUE));
// 
//             if ($response["status"] && "200" == $response["wp_speak_code"])
//             {
//                 $output["is_ibm_watsoned"]    = TRUE;
//                 $output["ibm_watson_message"] = $response["wp_speak_message"];
//                 $output["status_name"]      = $response["wp_speak_status_name"];
//                 $output["ibm_watson_domain"]  = $ibm_watson_domain;
//             }
//             else
//             {
//                 $output["is_ibm_watsoned"]    = FALSE;
//                 $output["ibm_watson_message"] = $response["wp_speak_message"];
//                 $output["status_name"]      = NULL;
//                 $output["ibm_watson_domain"]  = $ibm_watson_domain;
//             }

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
        return apply_filters(
            Filter::$validate[get_called_class()],
            $output,
            Option::$OPTION_LIST[self::$section]);
    }

    /**
     * Provides default values for the Media Options.
     */
    public static function filter_default_options(
        $arg_default_options) {

        return $arg_default_options;
        
    }

    public function set_add_settings_section(
        $arg_add_settings_section) {

		//assert( '!is_null($arg_registry)' );
		self::$add_settings_section = $arg_add_settings_section->create(Option::$OPTION_EXTENDED_TITLE[self::$section]);;
		return $this;
	}
	
    public function set_add_settings_field(
        $arg_add_settings_field) {

		//assert( '!is_null($arg_registry)' );
		$section = "wp_speak_admin_ibm_watson_option";
		$field   = "ibm_watson";
		self::$add_settings_field[$field] = $arg_add_settings_field->create($section, Admin::WPS_ADMIN.$field);
		return $this;
	}
	
}

?>
