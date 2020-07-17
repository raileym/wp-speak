<?php
namespace WP_Speak;

class IBM_Watson_Option extends Basic
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

	private static $section = "ibm_watson_option";    //"wp_speak_admin_ibm_watson_option"

    private static $filter;

	private static $fields = array (
            "ibm_watson"
	    );

	private static $default_options = array(
        "ibm_watson_message"	   => "no message",
        "ibm_watson_user_name"	   => "no user name",
        "ibm_watson_user_password" => "no user password",
        "ibm_watson_status_name"   => "no status",
        "ibm_watson_domain"        => "no domain"
    );

	
	protected function __construct() { 

        add_action(
            "admin_init",
            array(get_called_class(), "init")); 

	}
	
    public function get_section() {
        return self::$section;
    }
    
    /**
     *	Orchestrates the creation of the IBM Watson Panel
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
            Callback::EXPECT_TWO_ARGUMENTS);

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
                ["id"=>ADMIN::WPS_ADMIN."ibm_watson", 
                 "title"=>"IBM Watson Options",
                 "callback" =>Callback::PARAGRAPH,
                 "args"=>array( "paragraph" => $paragraph )]
            ]);
        

        array_map(
            self::$add_settings_field["ibm_watson"], [
                ["id"=>"ibm_watson_user_name",
                 "title"=>"User Name",
                 "callback"=>Callback::INPUT,
                 "args"=>array( "label" => "ex: 20-chars, alphanumeric" )],

                ["id"=>"ibm_watson_user_password",
                 "title"=>"User Password",
                 "callback"=>Callback::INPUT,
                 "args"=>array( "label" => "ex: 20-chars, alphanumeric" )]
            ]);

        self::$wp_settings->register_setting(
            WP_Option::$option[ get_called_class() ],
            WP_Option::$option[ get_called_class() ],
            array(self::get_instance(), "validate_ibm_watson_option")
        );

        do_action(
            Action::$init[get_called_class()],
            get_called_class(),
            $option);
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

        self::$wp_settings->add_settings_error( 
            'ibm_watson_user_name',
            'User Name',
            'Definitely an incorrect user name entered!',
            'error' );

        self::$wp_settings->add_settings_error(
            'ibm_watson_user_password',
            'User Password',
            'Definitely an incorrect password entered!',
            'warning' );

        self::$wp_settings->add_settings_error(
            'ibm_watson_user_password',
            'User Password',
            'Definitely an incorrect password entered!',
            'info' );

        self::$wp_settings->add_settings_error(
            'ibm_watson_user_password',
            'User Password',
            'Definitely an incorrect password entered!',
            'success' );

        $output["ibm_watson_message"]     = "Register Message blah blah";
        $output["ibm_watson_status_name"] = "Status Name blah blah";
        $output["ibm_watson_domain"]      = "Register Domain blah blah";
        
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

}

?>
