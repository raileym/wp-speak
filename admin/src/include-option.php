<?php
namespace WP_Speak;

class Include_Option extends Basic
{
    protected static $_instance;

	private static $_add_settings_section;
	private static $_image_table;
	private static $_img_table;
	private static $_img_image_table;
	private static $_add_settings_field = array();
	private static $_section = "include_option";
	private static $_section_title;
	private static $_fields = array (
            "css_header",
            "javascript_header",
            "javascript_footer"
	    );
	private static $_default_options = array(
            "css_header_files"			=>	"",
            "javascript_header_files"	=>	"",
            "javascript_footer_files"	=>	""
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
     *	Orchestrates the creation of the Includes Panel
     */
    public static function init($arg1)
    {
        $page = Option::$OPTION_EXTENDED_TITLE[self::$_section];

        if( !get_option( $page ) )
        {
            update_option( $page, self::filter_default_options( self::$_default_options ) );
        }


        $paragraph = <<<EOD
Provide a list of <em>CSS Files here that should be included in the header</em>.  You 
can provide a list of files by separating them by commas. Also, you should provide 
the full path to these files, not their relative paths.
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."css_header", "title"=>"CSS Header Files", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);



        array_map( self::$_add_settings_field["css_header"], [
            ["id"=>"css_header_files", "title"=>"CSS Header Files", "callback"=>array("WP_Speak\Callback", "element_textarea_callback"), "args"=>array( )]
        ]);

        $paragraph = <<<EOD
Provide a list of <em>Javascript Files here that should be included in the header</em>.  You 
can provide a list of files by separating them by commas. Also, you should provide 
the full path to these files, not their relative paths.
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."javascript_header", "title"=>"Javascript Header Files", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);


        array_map( self::$_add_settings_field["javascript_header"], [
            ["id"=>"javascript_header_files", "title"=>"Javascript Header Files", "callback"=>array("WP_Speak\Callback", "element_textarea_callback"), "args"=>array( )]
        ]);

        $paragraph = <<<EOD
Provide a list of <em>Javascript Files here that should be included in the footer</em>.  You 
can provide a list of files by separating them by commas. Also, you should provide 
the full path to these files, not their relative paths.
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."javascript_footer", "title"=>"Javascript Footer Files", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);


        array_map( self::$_add_settings_field["javascript_footer"], [
            ["id"=>"javascript_footer_files", "title"=>"Javascript Footer Files", "callback"=>array("WP_Speak\Callback", "element_textarea_callback"), "args"=>array( )]
        ]);


        register_setting(
            $page,
            $page,
            array(self::get_instance(), "validate_includes_option")
        );

        do_action( Admin::WPS_ADMIN.__FUNCTION__, $page, Option::$OPTION_LIST[self::$_section] );
    }


    public function validate_includes_option( $arg_input )
    {
        self::$_logger->log( self::$_mask, "Validation: " . __FUNCTION__ );
        self::$_logger->log( self::$_mask, "Input");
        self::$_logger->log( self::$_mask, print_r( $arg_input, true ) );

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

        // Return the new collection
        return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section]);
    }



    /**
     * Provides default values for the Includes Options.
     */
    public static function filter_default_options($arg_default_options)
    {
        return $arg_default_options;
        
        $defaults = array(
            "css_header_files"			=>	"",
            "javascript_header_files"	=>	"",
            "javascript_footer_files"	=>	""
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
		self::$_add_settings_section = $arg_add_settings_section->create(self::$_section_title);;
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
