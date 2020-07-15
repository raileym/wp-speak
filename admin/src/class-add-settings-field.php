<?php
namespace WP_Speak;

class Add_Settings_Field extends Basic
{
    protected static $instance;

    //     The following constants denote the ordered
    //     parameters for Wordpress add_settings_field.
    //     See https://developer.wordpress.org/reference/functions/add_settings_field/.
    //     
    const IDX_ID       = 0;
    const IDX_TITLE    = 1;
    const IDX_CALLBACK = 2;
    const IDX_PAGE     = 3;
    const IDX_SECTION  = 4;
    const IDX_ARGS     = 5;

	protected function __construct() { }
	
    public function create($arg_page, $arg_section) {

        $use_list     = array_fill(0, 6, NULL);
        $use_page     = $arg_page;
        $use_section  = $arg_section;
        
        return function($arg_list) use ($use_page, $use_section, $use_list) {
        
            // Doctor up our arg_list for our callable function
            $arg_list["args"]["page"]    = $use_page;
            $arg_list["args"]["element"] = $arg_list["id"];

            // Tee ourselves up for our call to Wordpress add_settings_field
            $use_list[self::IDX_ID]       = $arg_list["id"];
            $use_list[self::IDX_TITLE]    = $arg_list["title"];
//            $use_list[self::IDX_CALLBACK] = array($arg_list["class"], $arg_list["callback"]);
            $use_list[self::IDX_CALLBACK] = $arg_list["callback"];
            $use_list[self::IDX_PAGE]     = WP_Option::$option[ $use_page ];
            $use_list[self::IDX_SECTION]  = $use_section;
            $use_list[self::IDX_ARGS]     = $arg_list["args"];

            call_user_func_array("add_settings_field", $use_list);
            
        };
    }
}
?>
