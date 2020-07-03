<?php
namespace WP_Speak;

class Format_Option extends Basic
{
    protected static $_instance;

	private static $_add_settings_section;
	private static $_image_table;
	private static $_img_table;
	private static $_img_image_table;
	private static $_add_settings_field = array();
	private static $_section = "format_option";
	private static $_section_title;
	private static $_fields = array (
            "format"
	    );
	private static $_default_options = array(
            "use_extended_copyright"	=>	"",
            "use_grey_logo"				=>	"",
            "use_powered_by"			=>	"",
            "use_shorturl"				=>	"default"
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
     *	Orchestrates the creation of the Format Panel
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
Choose among the FOUR options for Use-By.
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."format", "title"=>"Format Options", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);


        array_map( self::$_add_settings_field["format"], [
            ["id"=>"use_shorturl",           "title"=>"Use SHORTURL",           "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( "label" => "Use URL Shortening for references to citations." )],
            ["id"=>"use_powered_by",         "title"=>"Use POWERED BY",         "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( "label" => "Add Powered By Cite Reference to the bottom of your citations." )],
            ["id"=>"use_grey_logo",          "title"=>"Use GREY LOGO",          "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( "label" => "Use the Grey CITE Logo." )],
            ["id"=>"use_extended_copyright", "title"=>"Use EXTENDED COPYRIGHT", "callback"=>array("WP_Speak\Callback", "element_checkbox_callback"), "args"=>array( "label" => "Add the extended version of Cite references." )]
        ]);

        register_setting(
            $page,
            $page,
            array(self::get_instance(), "validate_format_option")
        );

        do_action( Admin::WPS_ADMIN.__FUNCTION__, $page, Option::$OPTION_LIST[self::$_section] );
    }

    public function validate_format_option( $arg_input )
    {
        self::$_logger->log( self::$_mask, "Validation: " . __FUNCTION__ );
        self::$_logger->log( self::$_mask, "Input");
        self::$_logger->log( self::$_mask, print_r( $arg_input, true ) );

        // Create our array for storing the validated options
        $output = array();

        if ( !isset($arg_input) )
        {
            return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section]);
        }

        // Loop through each of the incoming options
        foreach( $arg_input as $key => $value )
        {
            // Check to see if the current option has a value. If so, process it.
            if( isset( $arg_input[$key] ) )
            {
                // Strip all HTML and PHP tags and properly handle quoted strings
                $output[$key] = $arg_input[$key];
                //$output[$key] = strip_tags( stripslashes( $arg_input[ $key ] ) );
            }
        }

        // Return the array processing any additional functions filtered by this action
        return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section]);
    }



    /**
     * Provides default values for Format Options.
     */
    public static function filter_default_options($arg_default_options)
    {
        return $arg_default_options;
        
        $defaults = array(
            "use_extended_copyright"	=>	"",
            "use_grey_logo"				=>	"",
            "use_powered_by"			=>	"",
            "use_shorturl"				=>	"default"
        );

        return $defaults;
    }

	public function set_image_table( $arg_image_table)
	{
		//assert( '!is_null($arg_registry)' );
		self::$_image_table = $arg_image_table;
		return $this;
	}
	
	public function set_img_table( $arg_img_table)
	{
		//assert( '!is_null($arg_registry)' );
		self::$_img_table = $arg_img_table;
		return $this;
	}
	
	public function set_img_image_table( $arg_img_image_table)
	{
		//assert( '!is_null($arg_registry)' );
		self::$_img_image_table = $arg_img_image_table;
		return $this;
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
