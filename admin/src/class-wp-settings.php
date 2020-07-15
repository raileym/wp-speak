<?php
namespace WP_Speak;

class WP_Settings extends Basic
{
    //     The following constants denote the ordered
    //     parameters for Wordpress add_settings_section.
    //     See https://developer.wordpress.org/reference/functions/add_settings_section/.
    //     
    const SECTION_IDX_ID       = 0;
    const SECTION_IDX_TITLE    = 1;
    const SECTION_IDX_CALLBACK = 2;
    const SECTION_IDX_PAGE     = 3;
    
    //     The following constants denote the ordered
    //     parameters for Wordpress add_settings_field.
    //     See https://developer.wordpress.org/reference/functions/add_settings_field/.
    //     
    const FIELD_IDX_ID       = 0;
    const FIELD_IDX_TITLE    = 1;
    const FIELD_IDX_CALLBACK = 2;
    const FIELD_IDX_PAGE     = 3;
    const FIELD_IDX_SECTION  = 4;
    const FIELD_IDX_ARGS     = 5;
        
    protected static $instance;

    /**
     * $mask is the local (protected) copy of mask.
     *
     * @var int $mask
     */
    protected static $mask;

	protected function __construct() { }
	
    public function create_add_settings_field($arg_page, $arg_section) {

        $use_list     = array_fill(0, 6, NULL);
        $use_page     = $arg_page;
        $use_section  = $arg_section;
        
        return function($arg_list) use ($use_page, $use_section, $use_list) {
        
            // Doctor up our arg_list for our callable function
            $arg_list["args"]["page"]    = $use_page;
            $arg_list["args"]["element"] = $arg_list["id"];

            // Tee ourselves up for our call to Wordpress add_settings_field
            $use_list[self::FIELD_IDX_ID]       = $arg_list["id"];
            $use_list[self::FIELD_IDX_TITLE]    = $arg_list["title"];
            $use_list[self::FIELD_IDX_CALLBACK] = $arg_list["callback"];
            $use_list[self::FIELD_IDX_PAGE]     = WP_Option::$option[ $use_page ];
            $use_list[self::FIELD_IDX_SECTION]  = $use_section;
            $use_list[self::FIELD_IDX_ARGS]     = $arg_list["args"];

            call_user_func_array("add_settings_field", $use_list);
            
        };
    }

    public function create_add_settings_section($arg_page) {

        $use_list     = array_fill(0, 6, NULL);
        $use_page     = $arg_page;
        
        return function($arg_list) use ($use_page, $use_list) {
        
            // Doctor up our arg_list for our callable function
            // Doctor $args NOT $arg_list
            $arg_list["args"]["page"]    = $use_page;
            $arg_list["args"]["section"] = $arg_list["id"]; // "section", not "element"
            
            $use_callback = $arg_list["callback"];
            $use_args     = $arg_list["args"];

            // Tee ourselves up for our call to Wordpress add_settings_field
            $use_list[self::SECTION_IDX_ID]       = $arg_list["id"];
            $use_list[self::SECTION_IDX_TITLE]    = $arg_list["title"];
            $use_list[self::SECTION_IDX_CALLBACK] = function() use ($use_callback, $use_args) { return $use_callback( $use_args ); };
            $use_list[self::SECTION_IDX_PAGE]     = WP_Option::$option[ $use_page ];

            call_user_func_array("add_settings_section", $use_list);
            
        };
    }

    public function register_setting(
        $option_group,
        $option_name,
        $args ) {

        return register_setting(
            $option_group,
            $option_name,
            $args);

    }
}
?>
