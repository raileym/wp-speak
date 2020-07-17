<?php
namespace WP_Speak;

class Option
{
	// Pseudo Constants because I need to be consistent with myself
	// PHP does not support arrays as constants -- scalars only.  And I 
	// need constant arrays.  Sad state of affairs.
	//
	public static $COPYRIGHT = "wp_speak_admin_copyright_option";

	public static $INITIAL_PANEL = "media_option";

// 	public static $SECTIONS = 
// 	    array(
// 			"log_option",
// 			"image_option",
// 			"media_option",
//             "cache_option",
//             "copyright_option",
//             "debug_option",
//             "example_option",
//             "format_option",
//             "ibm_watson_option",
//             "include_option",
//             "register_option"
//         );
// 
// 	public static $SECTIONS_MINUS_LOG = 
// 	    array(
// 			"image_option",
// 			"media_option",
//             "cache_option",
//             "copyright_option",
//             "debug_option",
//             "example_option",
//             "format_option",
//             "ibm_watson_option",
//             "include_option",
//             "register_option"
//         );

	public static $SECTIONS = 
	    array(
			"Image_Option",
			"Media_Option",
            "Cache_Option",
            "Copyright_Option",
            "Debug_Option",
            "Example_Option",
            "Format_Option",
            "IBM_Watson_Option",
            "Include_Option",
            "Log_Option",
            "Register_Option"
        );

	public static $OPTION_EXTENDED_TITLE =
	    array(
	        "cache_option"      => "wp_speak_admin_cache_option",
	        "copyright_option"  => "wp_speak_admin_copyright_option",
	        "debug_option"      => "wp_speak_admin_debug_option",
	        "format_option"     => "wp_speak_admin_format_option",
	        "log_option"        => "wp_speak_admin_log_option",
	        "ibm_watson_option" => "wp_speak_admin_ibm_watson_option",
	        "register_option"   => "wp_speak_admin_register_option",
	        "include_option"    => "wp_speak_admin_include_option",
	        "media_option"      => "wp_speak_admin_media_option",
	        "image_option"      => "wp_speak_admin_image_option",
	        "example_option"    => "wp_speak_admin_example_option",
	    );
	    
	public static $OPTION_TITLE =
	    array(
	        "cache_option"      => "Cache",
	        "copyright_option"  => "Copyright",
	        "debug_option"      => "Debug",
	        "format_option"     => "Format",
	        "log_option"        => "Log",
	        "ibm_watson_option" => "IBM Watson",
	        "register_option"   => "Register",
	        "include_option"    => "Include",
	        "media_option"      => "Media",
	        "image_option"      => "Image",
	        "example_option"    => "Example"
	    );
	    
	public static $OPTION_LIST =
	    array(
	        "cache_option"     => array(
                                    "use_cache_shorturl"
		                        ),
	        "copyright_option" => array(
                                    "copyright_author",
                                    "copyright_date",
                                    "copyright_email",
                                    "custom_notice",
                                    "default_notice",
                                    "gpl3_notice",
                                    "mit_notice",
                                    "short_notice",
                                    "type_of_notice"
		                        ),
	        "debug_option"     => array(
                                    "expand_shorturl",
                                    "show_iframe",
                                    "show_comm"
		                        ),
	        "format_option"    => array(
                                    "use_extended_copyright",
                                    "use_grey_logo",
                                    "use_powered_by",
                                    "use_shorturl"
		                        ),
	        "log_option"       => array(
                                    "log_admin",
                                    "log_cache",
                                    "log_copyright",
                                    "log_debug",
                                    "log_example",
                                    "log_format",
                                    "log_ibm_watson",
                                    "log_image",
                                    "log_include",
                                    "log_log",
                                    "log_media",
                                    "log_register",
                                    "log_registry"
		                        ),
	        "ibm_watson_option"  => array(
                                    "ibm_watson_message",		// Dynamic Value ... not editable by user
                                    "ibm_watson_user_name",
                                    "ibm_watson_user_password"
		                        ),
	        "register_option"  => array(
                                    "wp_speak_home",
                                    "is_registered",		// Dynamic Value ... not editable by user
                                    "register_domain",
                                    "register_message",		// Dynamic Value ... not editable by user
                                    "register_user_name",
                                    "register_user_password",
                                    "shorturl_home",
                                    "status_name"			// Dynamic Value ... not editable by user
		                        ),
	        "include_option"  => array(
                                    "css_header_files",
                                    "javascript_header_files",
                                    "javascript_footer_files"
		                        ),
	        "media_option"   => array(
                                    "media_files"
		                        ),
	        "image_option"   => array(
                                    "image_files"
		                        ),
	        "example_option"   => array(
                                    "one_files",
                                    "two_files",
                                    "three_files",
                                    "four_files"
		                        )
	    );
}
?>
