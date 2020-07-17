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

	public static $SECTIONS = 
	    array(
            "Log_Option",
			"Image_Option",
			"Media_Option",
            "Example_Option",
            "IBM_Watson_Option",
            "Register_Option"
        );

	public static $OPTION_EXTENDED_TITLE = array(
        "log_option"        => "wp_speak_admin_log_option",
        "ibm_watson_option" => "wp_speak_admin_ibm_watson_option",
        "register_option"   => "wp_speak_admin_register_option",
        "media_option"      => "wp_speak_admin_media_option",
        "image_option"      => "wp_speak_admin_image_option",
        "example_option"    => "wp_speak_admin_example_option",
    );
	    
	public static $OPTION_TITLE =
	    array(
	        "log_option"        => "Log",
	        "ibm_watson_option" => "IBM Watson",
	        "register_option"   => "Register",
	        "media_option"      => "Media",
	        "image_option"      => "Image",
	        "example_option"    => "Example"
	    );
	    
	public static $OPTION_LIST =
	    array(
	        "log_option"       => array(
                                    "log_registry",
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
                                    "log_register"
		                        ),
	        "ibm_watson_option"  => array(
                "ibm_watson_message",		// Dynamic Value ... not editable by user
                "ibm_watson_user_name",
                "ibm_watson_user_password",
                "ibm_watson_status_name",
                "ibm_watson_domain"
		                        ),
	        "register_option"  => array(
                                    "register_home",
                                    "register_is_registered",		// Dynamic Value ... not editable by user
                                    "register_domain",
                                    "register_message",		// Dynamic Value ... not editable by user
                                    "register_user_name",
                                    "register_user_password",
                                    "register_shorturl_home",
                                    "register_status_name"			// Dynamic Value ... not editable by user
		                        ),
	        "media_option"   => array(
                                    "media_files"
		                        ),
	        "image_option"   => array(
                                    "image_files"
		                        ),
	        "example_option"   => array(
                "example_one",
                "example_two",
                "example_three"
            )
	    );

}
?>
