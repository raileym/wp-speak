<?php
namespace WP_Speak;

class Example_Option extends Basic
{
    protected static $_instance;

	private static $_add_settings_section;
	private static $_add_settings_field = array();
	private static $_section = "example_option";
	private static $_section_title;
	private static $_fields = array (
	        "example_group_of_fields"
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
     *	Orchestrates the creation of the Media Panel
     */
    public static function init($arg1)
    {
        $page = Option::$OPTION_EXTENDED_TITLE[self::$_section];

        if( !get_option( $page ) )
        {
            update_option( $page, self::filter_default_options( self::$_default_options ) );
        }

        $paragraph = <<<EOD
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis euismod ut nisl nec tincidunt. Donec quis tempus dui. Nam venenatis ullamcorper metus, at semper velit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus interdum egestas aliquam. Etiam efficitur, dolor et dignissim sagittis, ante nunc pellentesque nulla, ut tempus diam sapien lacinia dui. Curabitur lobortis urna a faucibus volutpat. Sed eget risus pharetra, porta risus et, fermentum ligula. Mauris sed hendrerit ex, sed vulputate lorem. Duis in lobortis justo. Aenean mattis odio tortor, sit amet fermentum orci tempus ut. Donec vitae elit facilisis, tincidunt augue id, tempus elit. Nullam sapien est, gravida nec luctus non, rhoncus vitae magna. Fusce dolor justo, ultricies non efficitur vitae, interdum in tortor.
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."example_group_of_fields", "title"=>"ONE Files", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);


        $description_one_files = <<<EOD
<strong>Here is some description that explains one_files.</strong>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi 
elementum congue nisl at fermentum. Lorem ipsum dolor sit amet, 
consectetur adipiscing elit. Duis venenatis justo facilisis odio 
tempus condimentum. In laoreet est dolor, aliquam semper tellus 
lobortis eu. Proin dictum pulvinar augue. Integer aliquet tempus 
lacinia. Interdum et malesuada fames ac ante ipsum primis in faucibus.
EOD;

        $description_four_files = <<<EOD
Please provide a short Description of the FOUR FILES as shown immediately below.
EOD;

        array_map( self::$_add_settings_field["example_group_of_fields"], [
            ["id"=>"example_one",   "title"=>"ONE-ONE Files",     "callback"=>array("WP_Speak\Callback",       "element_textarea_callback"),   "args"=>array( "description" => $description_one_files )],
            ["id"=>"example_two",   "title"=>"TWO-TWO Files",     "callback"=>array("WP_Speak\Callback",       "element_checkbox_callback"),   "args"=>array( )],
            ["id"=>"example_three", "title"=>"THREE-THREE Files", "callback"=>array("WP_Speak\Callback",       "element_input_callback"),      "args"=>array( )],
            ["id"=>"example_four",  "title"=>"FOUR-FOUR Files",   "callback"=>array("WP_Speak\Example_Option", "element_four_files_callback"), "args"=>array( "description" => $description_four_files )],
        ]);

        register_setting(
            $page,
            $page,
            array(self::get_instance(), "validate_example_option")
        );

        do_action( Admin::WPS_ADMIN.__FUNCTION__, $page, Option::$OPTION_LIST[self::$_section] );
    }


    public function validate_example_option( $arg_input )
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

        // Return the new collection
        return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section]);
    }

    public static function element_four_files_callback($arg_list)
    {
        $copyright = get_option( Option::$OPTION_EXTENDED_TITLE["copyright_option"] );
        
        $value = Callback::get_page_option($arg_list["page"], $arg_list["element"], array("action"=>"get"));

        $html = "<div style='width:".Admin::MAX_WIDTH.";'>";
        $html .= (isset($arg_list["description"])) ? "<p>".wordwrap($arg_list['description'], Admin::WORDWRAP_WIDTH, "<br/>")."</p>" : "";
        
        $html .= "&copy; {$copyright['copyright_date']} {$copyright['copyright_author']}. ";
        $html .= "<input type='text' id='{$arg_list['element']}' name='{$arg_list['page']}[{$arg_list['element']}]' value='{$value}' />";
        $html .= (isset($arg_list["label"])) ? "<label for='{$arg_list['element']}'>{$arg_list['label']}</label>" : "";
        $html .= "</div>";
        
        echo $html;
    }

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
