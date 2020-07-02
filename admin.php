<?php
/**
 * wp-speak-admin.php - Creates admin page, validates entries, and manages settings
 *
 * Copyright (C) 2020 Malcolm Railey <legal@wp-speak.com>
 *
 * LICENSE: This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://opensource.org/licenses/gpl-license.php>;.
 *
 * @author    Malcolm Railey <malcolm@wp-speak.com>
 * @copyright Malcolm Railey 2014
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link      http://wp-speak.com
 * @version   1.0
 * @filesource
 */
namespace WP_Speak;

// function exception_error_handler($errno, $errstr, $errfile, $errline ) {
//     throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
// }
// set_error_handler('WP_Speak\exception_error_handler');

/**
 * Admin is a concrete class that orchestrates the creation
 * of the WP_Speak admin page, the application of validation routines, and 
 * the registration of settings.
 */
class Admin extends Basic
{
	/** Qualifies references that are scoped globally */
	const WPS_ADMIN         = "wp_speak_admin_";

	/** For Word Wrapping paragraphs of descriptions */
	const WORDWRAP_WIDTH = 100;

	/** Maximum width for a description paragraph */
	const MAX_WIDTH = "500px";

    /**
     * Static instance specific to this class
     * 
     * @var string
     */
    protected static $_instance;

    /**
     * HTML representation of the WP_Speak logo (left, center, or right)
     * 
     * @var string
     */
    private static $_logo;

    /**
     * HTML representation of the WP_Speak tagline
     * 
     * @var string
     */
    private static $_tagline;


    /**
     * Knock out the default constructor by virtue
     * of the Singleton.
     */
    protected function __construct() { }


    /**
     * Primary routine that sets up all callbacks for add_action and add_filter.
     */
    public static function init()
    {
        self::$_logo    = self::print_logo("center");
        self::$_tagline = self::print_tagline();

        add_action("admin_menu", array(self::get_instance(), "init_page"));
    }


    /**
     * Generate HTML that expresses the look of the WP_Speak
     * logo, positioned left, center, or right.
     *
     * @param string $arg_position    Left, center, or right
     * @return string                 HTML Representation of the WP_Speak logo
     */
    private static function print_logo($arg_position)
    {
        return<<<EOD
<div class="wps-site-title-box">
<div class="wps-site-title wps-site-{$arg_position}">
    <div class="wps-site-logo">
        <div style='width:fit-content; margin: 0 auto'>
            <div class="wps-site-logo-front">WP-</div>
            <div class="wps-site-logo-back">Speak</div>
        </div>
        <div class="wps-clear"></div>
        <div class="wps-site-tagline">Bringing Audio to Wordpress</div>
        <div class="wps-clear"></div>
    </div>
</div>
<div class="wps-site-break"></div>
</div>
EOD;
    }


    /**
     * Generate HTML that expresses the look of the WP_Speak tagline.
     *
     * @return string                 HTML Representation of the WP_Speak tagline
     */
    private static function print_tagline()
    {
        return<<<EOD
WP-Speak
EOD;
    }


// -------------------------------------------------------------------------------------------------


    public function init_page()
    {
        add_options_page(
            "WP-Speak Options",    // The value used to populate the browser"s title bar when the Settings>WP-Speak is active
            self::$_tagline,       // The text of the menu under "Settings > WP-Speak " in the administrator's sidebar
            "administrator",       // Capability: What roles are able/who is able to access the menu
            "wp_speak_admin",      // The ID used to bind submenu items to this menu
            array("WP_Speak\Admin", "init_page_callback")	// The callback function used to render this menu
        );
    }


    public static function init_page_callback( $arg_active_tab = null )
    {
        // These assignments have been set at init. See above.
        // I have to make this assignment because I am using
        // these two values in a heredoc below.
        $logo    = self::$_logo;
        $tagline = self::$_tagline;

        // From incoming URL Query String ... page= and tab=
        if( isset( $_GET[ "tab" ] ) )
        {
            $arg_active_tab = strtolower($_GET[ "tab" ]);
        } else {
            $arg_active_tab = "media_option"; //Option::$INITIAL_PANEL;
        }

        // TBD: Use array for these values
        //
        foreach ( Option::$SECTIONS as $section ) {
            $active_tab[strtolower($section)] = "";
        }

        ob_start();
        settings_fields( Option::$OPTION_EXTENDED_TITLE[$arg_active_tab] );
        do_settings_sections( Option::$OPTION_EXTENDED_TITLE[$arg_active_tab] );
        $active_tab[$arg_active_tab] = "nav-tab-active";
        $settings_section = ob_get_clean();

        ob_start();
        settings_errors(NULL, NULL, TRUE);
        $settings_errors = ob_get_clean();


        ob_start();
        submit_button();
        $submit_button = ob_get_clean();

        // Here, we are establishing whether we have officially registered: Yes or No.
        $option = get_option(Option::$OPTION_EXTENDED_TITLE["register_option"]);

        if ( array_key_exists("is_registered", $option) && $option["is_registered"])
        {
            $status = "<div class='wps-register-status wps-is-registered'>{$option['register_message']}: {$option['status_name']}</div>";
        }
        else
        {
            if ( array_key_exists("register_message", $option) && NULL !== $option['register_message']) {
                $status = "<div class='wps-register-status'>{$option['register_message']}</div>";
            } else {
                $status = "<div class='wps-register-status'>Registration not started</div>";
            }
        }

        echo<<<EOD
<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap">

<!-- Add the icon to the page -->
{$logo}
<h2>{$tagline} Options</h2>

<!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
{$settings_errors}

<h2 class="nav-tab-wrapper">
EOD;

        // Here, I am building the anchors across all of the tabs
        foreach( Option::$SECTIONS as $section ) {
            $section_lc = strtolower($section);
            $title = Option::$OPTION_TITLE[$section_lc];
            echo<<<EOD
    <a href="?page=wp_speak_admin&tab={$section}" class="nav-tab {$active_tab[$section_lc]}">{$title}</a>
EOD;
        }
        echo<<<EOD
</h2>

<!-- Create the form that will be used to render our options -->
{$status}
<form method="post" action="options.php">
    {$settings_section}
    {$submit_button}
</form>
</div><!-- /.wrap -->
EOD;

    }

} // end class admin


// -------------------------------------------------------------------------------------------------


?>
