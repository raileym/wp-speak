<?php
namespace WP_Speak;

class Add_Settings_Section extends Basic
{
    protected static $instance;

    //     The following constants denote the ordered
    //     parameters for Wordpress add_settings_section.
    //     See https://developer.wordpress.org/reference/functions/add_settings_section/.
    //     
    const _ID       = 0;
    const _TITLE    = 1;
    const _CALLBACK = 2;
    const _PAGE     = 3;

	protected function __construct() { }
	
    public function create($arg_page) {

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
            $use_list[self::_ID]       = $arg_list["id"];
            $use_list[self::_TITLE]    = $arg_list["title"];
            $use_list[self::_CALLBACK] = function() use ($use_callback, $use_args) { return $use_callback( $use_args ); };
            $use_list[self::_PAGE]     = $use_page;

            call_user_func_array("add_settings_section", $use_list);
            
        };
    }
}
?>
