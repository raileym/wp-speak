<?php
namespace WP_Speak;

class Example_Option extends Basic
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
	private static $section = "example_option";
	private static $fields = array (
	        "example_group_of_fields"
	    );
	private static $default_options = array(
            "css_header_files"			=>	"",
            "javascript_header_files"	=>	"",
            "javascript_footer_files"	=>	""
        );

	protected function __construct() { 

        add_action(
            "admin_init",
            array(get_called_class(), "init")); 
        
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
     *	Orchestrates the creation of the Media Panel
     */
    public static function init($arg1)
    {
        self::$logger->log( self::$mask, get_called_class() . " " . __FUNCTION__ );

        $option = self::$wp_option->get( WP_Option::$option [ get_called_class() ] );

        if( !$option )
        {
            self::$wp_option->update( WP_Option::$option[ get_called_class() ], self::filter_default_options( self::$default_options ) );
            $option = self::$wp_option->get( WP_Option::$option [ get_called_class() ] );
        }

        $paragraph = <<<EOD
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis euismod ut nisl nec tincidunt. Donec quis tempus dui. 
Nam venenatis ullamcorper metus, at semper velit. Pellentesque habitant morbi tristique senectus et netus et 
malesuada fames ac turpis egestas. Phasellus interdum egestas aliquam. Etiam efficitur, dolor et dignissim 
sagittis, ante nunc pellentesque nulla, ut tempus diam sapien lacinia dui. Curabitur lobortis urna a faucibus 
volutpat. Sed eget risus pharetra, porta risus et, fermentum ligula. Mauris sed hendrerit ex, sed vulputate lorem. 
Duis in lobortis justo. Aenean mattis odio tortor, sit amet fermentum orci tempus ut. Donec vitae elit facilisis, 
tincidunt augue id, tempus elit. Nullam sapien est, gravida nec luctus non, rhoncus vitae magna. Fusce dolor 
justo, ultricies non efficitur vitae, interdum in tortor.
EOD;

        array_map(
            self::$add_settings_section, [
                ["id"       =>Admin::WPS_ADMIN."example_group_of_fields", 
                 "title"    =>"ONE Files", 
                 "callback" =>Callback::PARAGRAPH,
                 "args"     =>array( "paragraph" => $paragraph )]
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

        array_map( self::$add_settings_field["example_group_of_fields"], [
            ["id"=>"example_one",   
             "title"=>"ONE-ONE Files",     
             "callback"=>Callback::TEXTAREA,
             "args"=>array( "description" => $description_one_files )],
             
            ["id"=>"example_two",   
             "title"=>"TWO-TWO Files",     
             "callback"=>Callback::CHECKBOX,
             "args"=>array( )],
             
            ["id"=>"example_three", 
             "title"=>"THREE-THREE Files", 
             "callback"=>Callback::INPUT,
             "args"=>array( )],
             
            ["id"=>"example_four",  
             "title"=>"FOUR-FOUR Files",   
             "callback"=>array("WP_Speak\Example_Option", "element_four_files_callback"), 
             "args"=>array( "description" => $description_four_files )],
        ]);

        register_setting(
            WP_Option::$option[ get_called_class() ],
            WP_Option::$option[ get_called_class() ],
            array(self::get_instance(), "validate_example_option")
        );

        do_action(
            Action::$init[get_called_class()],
            get_called_class(),
            $option );

    }


    public function validate_example_option( $arg_input )
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

        // Return the new collection
        return apply_filters(
            Filter::$validate[get_called_class()],
            $output,
            Option::$OPTION_LIST[self::$section]);
    }

    public static function element_four_files_callback($arg_list)
    {
        $html = "<h1>Fix this when you are ready</h1>";
        
        echo $html;
    }

    public static function filter_default_options($arg_default_options)
    {
        return $arg_default_options;
    }

    public function set_add_settings_section($arg_add_settings_section)
	{
		//assert( '!is_null($arg_registry)' );
		self::$add_settings_section = $arg_add_settings_section->create( WP_Option::$option[ get_called_class() ]);;
		return $this;
	}
	
    public function set_add_settings_field($arg_add_settings_field)
	{
		//assert( '!is_null($arg_registry)' );
		foreach(self::$fields as $field) {
            self::$add_settings_field[$field] = $arg_add_settings_field->create(
                WP_Option::$option[ get_called_class() ], 
                Admin::WPS_ADMIN.$field);
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
