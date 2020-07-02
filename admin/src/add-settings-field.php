<?php
namespace WP_Speak;

class Add_Settings_Field extends Basic
{
    protected static $_instance;

    //     The following constants denote the ordered
    //     parameters for Wordpress add_settings_field.
    //     See https://developer.wordpress.org/reference/functions/add_settings_field/.
    //     
    const _ID       = 0;
    const _TITLE    = 1;
    const _CALLBACK = 2;
    const _PAGE     = 3;
    const _SECTION  = 4;
    const _ARGS     = 5;

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
            $use_list[self::_ID]       = $arg_list["id"];
            $use_list[self::_TITLE]    = $arg_list["title"];
//            $use_list[self::_CALLBACK] = array($arg_list["class"], $arg_list["callback"]);
            $use_list[self::_CALLBACK] = $arg_list["callback"];
            $use_list[self::_PAGE]     = $use_page;
            $use_list[self::_SECTION]  = $use_section;
            $use_list[self::_ARGS]     = $arg_list["args"];

            call_user_func_array("add_settings_field", $use_list);
            
        };
    }
}
?>
