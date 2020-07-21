<?php
namespace WP_Speak;

class Callback extends Basic
{
	const EXPECT_DEFAULT_PRIORITY = 10;         /** For add_action: use default priority of 10 */
	const EXPECT_NON_DEFAULT_PRIORITY = 11;

	const EXPECT_ZERO_ARGUMENTS  = 0;            /** For add_action: expect zero arguments */
	const EXPECT_ONE_ARGUMENT    = 1;            /** For add_action: expect one argument */
	const EXPECT_TWO_ARGUMENTS   = 2;            /** For add_action: expect two arguments */
	const EXPECT_THREE_ARGUMENTS = 3;            /** For add_action: expect three arguments */

    const CHECKBOX  = array("WP_Speak\Callback", "element_checkbox_callback");
    const PARAGRAPH = array("WP_Speak\Callback", "section_paragraph_callback");
    const INPUT     = array("WP_Speak\Callback", "element_input_callback");
    const TEXTAREA  = array("WP_Speak\Callback", "element_textarea_callback");

    protected static $instance;

    /**
     * $mask is the local (protected) copy of mask.
     *
     * @var int $mask
     */
    protected static $mask;

	protected function __construct() { }
		
    public static function section_paragraph_callback($arg_list)
    {
        $html = (isset($arg_list["paragraph"])) ? "<p>".wordwrap($arg_list['paragraph'], Admin::WORDWRAP_WIDTH, "<br/>")."</p>" : "";

        echo $html;
    }

    public static function element_textarea_callback_static($arg_list)
    {
        $checked = self::get_page_option($arg_list["page"], $arg_list["element"], array("action"=>"checkbox", "value"=>1));

        $html = "<input type='checkbox' id='{$arg_list['element']}' name='{$arg_list['page']}[{$arg_list['element']}]' value=1 {$checked} />";
        $html .= (isset($arg_list["label"])) ? "<label for='{$arg_list['element']}'>{$arg_list['label']}</label>" : "";

        echo $html;
    }

    public static function element_checkbox_callback($arg_list)
    {
        $checked = self::get_page_option($arg_list["page"], $arg_list["element"], array("action"=>"checkbox", "value"=>1));

        $html = "<input type='checkbox' id='{$arg_list['element']}' name='{$arg_list['page']}[{$arg_list['element']}]' value=1 {$checked} />";
        $html .= (isset($arg_list["label"])) ? "<label for='{$arg_list['element']}'>{$arg_list['label']}</label>" : "";

        echo $html;
    }

    public static function element_input_callback($arg_list)
    {
        $value = self::get_page_option($arg_list["page"], $arg_list["element"], array("action"=>"get"));

        $html = (isset($arg_list["description"])) ? "<p>{$arg_list['description']}</p><br/>" : "";
        $html .= "<input type='text' id='{$arg_list['element']}' name='{$arg_list['page']}[{$arg_list['element']}]' value='{$value}' />";
        $html .= (isset($arg_list["label"])) ? "<label for='{$arg_list['element']}'>{$arg_list['label']}</label>" : "";

        echo $html;

    }

    public static function element_textarea_callback($arg_list)
    {
        $max_width = Admin::WORDWRAP_WIDTH;
        
        $class = ( array_key_exists("class", $arg_list) ) ? $arg_list["class"] : "";
        
        $value = self::get_page_option($arg_list["page"], $arg_list["element"], array("action"=>"textarea"));
 
        $html = (isset($arg_list["description"])) ? "<p>".wordwrap($arg_list['description'], Admin::WORDWRAP_WIDTH, "<br/>")."</p>" : "";

        $html .= "<textarea class='wps-includes {$class}' id='{$arg_list['element']}' name='{$arg_list['page']}[{$arg_list['element']}]' rows='10' cols='{$max_width}'>{$value}</textarea>";
 
        echo $html;
    }

    public static function element_div_callback($arg_list)
    {
        $value = self::get_page_option($arg_list["page"], $arg_list["element"], array("action"=>"get"));
 
        $class = ( array_key_exists("class", $arg_list) ) ? $arg_list["class"] : "";

        $html  = "<div class='{$class}' id='{$arg_list['element']}'>{$value}</div>";
 
        echo $html;
    }

    public static function get_page_option($arg_page, $arg_option_name, $arg_command)
    {
        $option = get_option($arg_page);

        if ( !isset( $option[$arg_option_name] ))
        {
            return NULL;
        }

        switch ($arg_command["action"])
        {
            case "checkbox":

                $result =  checked($arg_command["value"], $option[$arg_option_name], FALSE);
                return $result;
                
            case "select":

                return selected($option[$arg_option_name], $arg_command["value"], FALSE);

            default:
            case "get":
            case "textarea":

                return $option[$arg_option_name];
        }
    }

// 		public function element_select_callback($arg_list)
// 		{
// 			$selected["never"] = self::get_page_option($arg_list["page"], $arg_list["element"], array("action"=>"select", "value"=>"never"));
// 			$selected["sometimes"] = self::get_page_option($arg_list["page"], $arg_list["element"], array("action"=>"select", "value"=>"sometimes"));
// 			$selected["always"] = self::get_page_option($arg_list["page"], $arg_list["element"], array("action"=>"select", "value"=>"always"));
// 
// 			$html = "<select id='{$arg_list['element']}' name='{$arg_list['page']}[{$arg_list['element']}]'>";
// 				$html .= "<option value='default'>Select a time option...</option>";
// 				$html .= "<option value='never' {$selected['never']}>Never</option>";
// 				$html .= "<option value='sometimes' {$selected['sometimes']}>Sometimes</option>";
// 				$html .= "<option value='always' {$selected['always']}>Always</option>";
// 			$html .= "</select>";
// 	
// 			echo $html;
// 		}

}

?>
