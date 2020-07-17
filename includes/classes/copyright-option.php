<?php
namespace WP_Speak;

class Copyright_Option extends Basic
{
    protected static $_instance;

	private static $_add_settings_section;
	private static $_add_settings_field = array();
	private static $_section = "copyright_option";    //"wp_speak_admin_register_option"
	private static $_section_title;// = Admin::WPS_ADMIN . self::$_section;
	private static $_fields = array (
	        "author_name",
	        "author_email",
	        "author_date",
	        "copyright_notice"
	    );
	private static $_default_options = array(
            "copyright_author"	=>	"your name here",
            "copyright_date"	=>	"your Copyright date here",
            "copyright_email"	=>	"your_email@your_address.com",
            "custom_notice"		=>	"Place your custom notice here",
            "default_notice"	=>	"Does Not Matter",
            "gpl3_notice"		=>	"Does Not Matter",
            "mit_notice"		=>	"Does Not Matter",
            "short_notice"		=>	"All rights reserved",
            "type_of_notice"	=>	"default_notice"
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
     *	Orchestrates the creation of the Copyright Panel
     */
    public static function init($arg1)
    {
        $page = Option::$OPTION_EXTENDED_TITLE[self::$_section];

        if( !$copyright = get_option( $page ) )
        {

            update_option( $page, self::filter_default_options( self::$_default_options ) );
            $copyright = get_option( $page );
        }
        
        // Copyright Notices are treated out-of-band since their value
        // depends on COPYRIGHT_AUTHOR, COPYRIGHT_EMAIL, and COPYRIGHT_DATE.
        //
        $default_notice = file_get_contents( dirname(__FILE__)."/../wp-speak-license-default.html");
        $default_notice = str_replace(
                array("%AUTHOR%", "%EMAIL%", "%DATE%"),
                array("<em>{$copyright['copyright_author']}</em>", "<em>{$copyright['copyright_email']}</em>", "<em>{$copyright['copyright_date']}</em>"),
                $default_notice);
        $copyright['default_notice'] = "<h1>DEFAULT LICENSE</h1>".$default_notice;

        $mit_notice = file_get_contents( dirname(__FILE__)."/../wp-speak-license-mit.html");
        $mit_notice = str_replace(
                array("%AUTHOR%", "%EMAIL%", "%DATE%"),
                array("<em>{$copyright['copyright_author']}</em>", "<em>{$copyright['copyright_email']}</em>", "<em>{$copyright['copyright_date']}</em>"),
                $mit_notice);
        $copyright['mit_notice'] = "<h1>MIT LICENSE</h1>".$mit_notice;

        $gpl3_notice = file_get_contents( dirname(__FILE__)."/../wp-speak-license-GPL3.html");
        $gpl3_notice = str_replace(
                array("%AUTHOR%", "%EMAIL%", "%DATE%"),
                array("<em>{$copyright['copyright_author']}</em>", "<em>{$copyright['copyright_email']}</em>", "<em>{$copyright['copyright_date']}</em>"),
                $gpl3_notice);
        $copyright['gpl3_notice'] = "<h1>GPL3 LICENSE</h1>".$gpl3_notice;

        update_option( Option::$OPTION_EXTENDED_TITLE["copyright_option"], $copyright );        

// error_log( print_r($copyright, true) );


        $paragraph = <<<EOD
Please provide the name -- your point-of-contact -- as it should appear in your Copyright Notice.
This name will be updated in your Notice when you save your citation.
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."author_name", "title"=>"Author Name", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);


        array_map( self::$_add_settings_field["author_name"], [
            ["id"=>"copyright_author", "title"=>"Copyright Author", "callback"=>array("WP_Speak\Callback", "element_input_callback"), "args"=>array( )]
        ]);

        $paragraph = <<<EOD
Please provide the email address as it should appear in your Copyright Notice so that others
can contact you regarding your Notice. Like your name above, your email address will be updated
in your Notice when you save your citation.
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."author_email", "title"=>"Author Email", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);


        array_map( self::$_add_settings_field["author_email"], [
            ["id"=>"copyright_email", "title"=>"Copyright E-mail Address", "callback"=>array("WP_Speak\Callback", "element_input_callback"), "args"=>array( )]
        ]);


        $paragraph = <<<EOD
Please provide the date or range of dates as it should appear in your Copyright Notice.
This date will be updated in your Notice when you save your citation.
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."author_date", "title"=>"Author Date", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);


        array_map( self::$_add_settings_field["author_date"], [
            ["id"=>"copyright_date", "title"=>"Copyright Date", "callback"=>array("WP_Speak\Callback", "element_input_callback"), "args"=>array( )]
        ]);


        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."copyright_notice", "title"=>"Copyright Notice", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => "" )]
        ]);



        $description_short_notice = <<<EOD
Please provide a short Copyright Notice that will appear immediately below
your citation.
EOD;

        $description_type_of_notice = <<<EOD
Please choose the type of Copyright Notice for your citation. This Notice
will appear in the HTML header section of each web page that includes
your citation. Select either default Copyright Notice or the custom Notice.<br/>
EOD;

        array_map( self::$_add_settings_field["copyright_notice"], [
            ["id"=>"short_notice",   "title"=>"Short Notice",   "callback"=>array("WP_Speak\Copyright_Option", "element_short_notice_callback"),   "args"=>array( "description"=>$description_short_notice )],
            ["id"=>"type_of_notice", "title"=>"Type of Notice", "callback"=>array("WP_Speak\Copyright_Option", "element_type_of_notice_callback"), "args"=>array( "description"=>$description_type_of_notice )],
            ["id"=>"default_notice", "title"=>NULL,             "callback"=>array("WP_Speak\Callback",         "element_div_callback"),            "args"=>array( "class" => "wps-notices" )],
            ["id"=>"gpl3_notice",    "title"=>NULL,             "callback"=>array("WP_Speak\Callback",         "element_div_callback"),            "args"=>array( "class" => "wps-notices" )],
            ["id"=>"mit_notice",     "title"=>NULL,             "callback"=>array("WP_Speak\Callback",         "element_div_callback"),            "args"=>array( "class" => "wps-notices" )],
            ["id"=>"custom_notice",  "title"=>NULL,             "callback"=>array("WP_Speak\Callback",         "element_textarea_callback"),       "args"=>array( "class" => "wps-notices" )]
        ]);

        register_setting(
            $page,
            $page,
            array(self::get_instance(), "validate_copyright_option")
        );

        do_action( Admin::WPS_ADMIN.__FUNCTION__, $page, Option::$OPTION_LIST[self::$_section] );
    }

    public function validate_copyright_option( $arg_input )
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

    /**
     * Provides default values for Copyright Options.
     */
    public static function filter_default_options($arg_default_options)
    {
        return $arg_default_options;
        
        $defaults = array(
            "copyright_author"	=>	"your name here",
            "copyright_date"	=>	"your Copyright date here",
            "copyright_email"	=>	"your_email@your_address.com",
            "custom_notice"		=>	"Place your custom notice here",
            "default_notice"	=>	"Does Not Matter",
            "gpl3_notice"		=>	"Does Not Matter",
            "mit_notice"		=>	"Does Not Matter",
            "short_notice"		=>	"All rights reserved",
            "type_of_notice"	=>	"default_notice"
        );

        return $defaults;
    }

    public static function element_short_notice_callback($arg_list)
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

    public static function element_type_of_notice_callback($arg_list)
    {
        $checked["default_notice"] = Callback::get_page_option($arg_list["page"], "type_of_notice", array("action"=>"checkbox", "value"=>"default_notice"));
        $checked["mit_notice"]     = Callback::get_page_option($arg_list["page"], "type_of_notice", array("action"=>"checkbox", "value"=>"mit_notice"));
        $checked["gpl3_notice"]    = Callback::get_page_option($arg_list["page"], "type_of_notice", array("action"=>"checkbox", "value"=>"gpl3_notice"));
        $checked["custom_notice"]  = Callback::get_page_option($arg_list["page"], "type_of_notice", array("action"=>"checkbox", "value"=>"custom_notice"));

        $html = (isset($arg_list["description"])) ? "<p>".wordwrap($arg_list['description'], Admin::WORDWRAP_WIDTH, "<br/>")."</p>" : "";

        $html .= "<input type='radio' class='wps-notices' id='{$arg_list['element']}_one' name='{$arg_list['page']}[{$arg_list['element']}]' value='default_notice' {$checked['default_notice']} />";
        $html .= "<label for='{$arg_list['element']}_one'>Use Default Notice</label>";

        $html .= "<input type='radio' class='wps-notices' id='{$arg_list['element']}_two' name='{$arg_list['page']}[{$arg_list['element']}]' value='mit_notice' {$checked['mit_notice']} />";
        $html .= "<label for='{$arg_list['element']}_two'>Use MIT Notice</label>";

        $html .= "<input type='radio' class='wps-notices' id='{$arg_list['element']}_three' name='{$arg_list['page']}[{$arg_list['element']}]' value='gpl3_notice' {$checked['gpl3_notice']} />";
        $html .= "<label for='{$arg_list['element']}_three'>Use GPL3 Notice</label>";

        $html .= "<input type='radio' class='wps-notices' id='{$arg_list['element']}_four' name='{$arg_list['page']}[{$arg_list['element']}]' value='custom_notice' {$checked['custom_notice']} />";
        $html .= "<label for='{$arg_list['element']}_four'>Use Custom Notice</label>";

        
        $html .= <<<EOD
<script>
(function($) {
/*    $("input[type=radio][name='{$arg_list['page']}[{$arg_list['element']}]']").change(function() { */
    $("input.wps-notices").change(function() {
        
        $( "div.wps-notices").addClass("wps-hide");
        $( "textarea.wps-notices").addClass("wps-hide");
    
        if (this.value == 'mit_notice') {
            $( "#mit_notice" ).removeClass("wps-hide");
        } else if (this.value == 'gpl3_notice') {
            $( "#gpl3_notice" ).removeClass("wps-hide");
        } else if (this.value == 'custom_notice') {
            $( "#custom_notice" ).removeClass("wps-hide");
        } else {
            $( "#default_notice" ).removeClass("wps-hide");
        }
    })
})(jQuery);
</script>    
EOD;
        
        echo $html;
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
