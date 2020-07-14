<?php
/**
Plugin Name: Professor Malcolm's WP-Speak (wp-speak)
Plugin URI: https://wp-speak.com 
Description: Plugin for adding audio to your Wordpress site
Author: Professor Malcolms LLC
Version: 1.0 
Author URI: https://wp-speak.com 
License: GPLv2 or later
*/

/**
 * wp-speak.php - Creates main plugin features page, validates entries, and manages settings
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

$wp_speak_version = "1.0.10";

function wp_speak_enqueue_styles()
{
    global $wp_speak_version;
	
    wp_enqueue_style("wp-speak-css",     WP_SPEAK_CSS_URL, false, $wp_speak_version, "all");
    wp_enqueue_style("font-awesome-css", FONT_AWESOME_URL, false, $wp_speak_version, "all");

}
	
function wp_speak_enqueue_scripts()
{
	global $wp_speak_version;
	
    wp_enqueue_script("jquery");
    wp_enqueue_script("wps-init", WP_SPEAK_INIT_JS_URL, NULL, $wp_speak_version, false);//WPS_ENQUEUE_HEADER);
    wp_enqueue_script("wps-main", WP_SPEAK_MAIN_JS_URL, NULL, $wp_speak_version, false);//WPS_ENQUEUE_HEADER);
}
	
function wp_speak_admin_enqueue_styles()
{
	global $wp_speak_version;
	
    wp_enqueue_style("wp-speak-css",       WP_SPEAK_CSS_URL, false, $wp_speak_version, "all");
	wp_enqueue_style("wp-speak-admin-css", WP_SPEAK_ADMIN_CSS_URL, false, $wp_speak_version, "all");
    wp_enqueue_style("font-awesome-css",   FONT_AWESOME_URL, false, $wp_speak_version, "all");
}
	
function wp_speak_admin_enqueue_scripts()
{
	global $wp_speak_version;
	
    wp_enqueue_script("jquery");
    wp_enqueue_script("wps-init", WP_SPEAK_INIT_JS_URL, NULL, $wp_speak_version, false);//WPS_ENQUEUE_HEADER);
    wp_enqueue_script("wps-main", WP_SPEAK_MAIN_JS_URL, NULL, $wp_speak_version, false);//WPS_ENQUEUE_HEADER);
}
	
if ( is_admin() )
{
	add_action("admin_enqueue_scripts", "WP_Speak\wp_speak_admin_enqueue_styles");
	add_action("admin_enqueue_scripts", "WP_Speak\wp_speak_admin_enqueue_scripts");

} else {

    add_action("wp_enqueue_scripts", "WP_Speak\wp_speak_enqueue_styles");
    add_action("wp_enqueue_scripts", "WP_Speak\wp_speak_enqueue_scripts");

}

// Autoloader details ...
// See http://www.joelambert.co.uk/article/creating-a-psr4-wordpress-plugin/
// See https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
//
// Choosing PSR-4 Autoload ... 
//     https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
//     https://enshrined.co.uk/2015/02/27/psr-4-autoloading-wordpress/
require 'autoload.php';
//
// Create a new instance of the autoloader
$loader = new Psr4AutoloaderClass();
//
// Register this instance
$loader->register();
//
// Add our namespace and the folder it maps to
$loader->addNamespace('WP_Speak', dirname( __FILE__) . '/includes/classes');


add_action('init', function() {
    // NB: If your custom post type is hierarchical, meaning it has 
    // 'hierarchical' => true in its register_post_type(), you need 
    // to switch out the constant EP_PERMALINK with EP_PAGES.

	add_rewrite_endpoint('wp-speak-audio', EP_ROOT);
});

add_filter('request', function($vars) {
	return $vars;
});

add_action( 'template_redirect', 'WP_Speak\pmg_rewrite_catch_form' );
function pmg_rewrite_catch_form()
{
    if( get_query_var( 'wp-speak-audio' ) )
    {
        return Audio::get_instance()->wp_speak_getfile();
    }
}

add_filter( 'query_vars', 'WP_Speak\add_query_var' );
function add_query_var( $vars ) {
    $vars[] = 'audio';

    return $vars;
}

require( dirname(__FILE__)."/wp-speak-config.php" );
require( dirname(__FILE__)."/admin/src/utils.php" );
require( dirname(__FILE__)."/admin/src/class-assert.php" );
require( dirname(__FILE__)."/admin/src/class-error-exception.php" );
require( dirname(__FILE__)."/admin/src/class-errno.php" );
// require( dirname(__FILE__)."/admin/src/class-errnm.php" );
require( dirname(__FILE__)."/admin/src/class-error.php" );
require( dirname(__FILE__)."/admin/src/class-option.php" );
require( dirname(__FILE__)."/admin/src/class-logmask.php" );
require( dirname(__FILE__)."/admin/src/class-basic.php" );
require( dirname(__FILE__)."/admin/src/class-wp-option.php" );
require( dirname(__FILE__)."/admin/src/class-add-settings-field.php" );
require( dirname(__FILE__)."/admin/src/class-add-settings-section.php" );
require( dirname(__FILE__)."/admin/src/class-db.php" );
require( dirname(__FILE__)."/admin/src/class-sql.php" );
require( dirname(__FILE__)."/admin/src/class-table.php" );
require( dirname(__FILE__)."/admin/src/class-factory-table.php" );
require( dirname(__FILE__)."/admin/src/class-callback.php" );
require( dirname(__FILE__)."/admin/src/class-action.php" );
require( dirname(__FILE__)."/admin/src/class-filter.php" );
require( dirname(__FILE__)."/admin/src/class-ibm-watson-option.php" );
require( dirname(__FILE__)."/admin/src/class-register-option.php" );
require( dirname(__FILE__)."/admin/src/class-example-option.php" );
require( dirname(__FILE__)."/admin/src/class-log-option.php" );
require( dirname(__FILE__)."/admin/src/class-media-option.php" );
require( dirname(__FILE__)."/admin/src/class-image-option.php" );
require( dirname(__FILE__)."/admin/src/abstract-registry.php" );
require( dirname(__FILE__)."/admin/src/class-array-registry.php" );
require( dirname(__FILE__)."/admin/src/class-registry.php" );
require( dirname(__FILE__)."/admin/src/class-logger.php" );
// require( dirname(__FILE__)."/includes/classes/audio.php" );
require( dirname(__FILE__)."/audio.php" );

if ( is_admin() )
{
	require( dirname(__FILE__)."/admin.php" );
}


// Audio::get_instance();

WP_Option::get_instance()
    ->set_logger(Logger::get_instance())
    ->set_mask(Logmask::$mask["log_wp_option"]);

Registry::get_instance()
    ->set_wp_option(WP_Option::get_instance())
    ->set_logger(Logger::get_instance())
    ->set_mask(Logmask::$mask["log_registry"])
    ->set_array_registry(Array_Registry::get_instance());


Registry::get_instance()->init_log_registry(
    'WP_Speak\Log_Option',
    Option::$OPTION_LIST['log_option']);

foreach (Option::$SECTIONS as $section) {

    $section_lc = strtolower($section);

    if ($section !== "Log_Option") {

        Registry::get_instance()->init_registry(
            'WP_Speak\\'.$section,
            Option::$OPTION_LIST[$section_lc]);
        
    }

}


Callback::get_instance()
    ->set_logger(Logger::get_instance())
    ->set_registry(Registry::get_instance())
    ->set_mask(Logmask::$mask["log_callback"]);

Add_Settings_Field::get_instance()
    ->set_logger(Logger::get_instance())
    ->set_registry(Registry::get_instance());

Add_Settings_Section::get_instance()
    ->set_logger(Logger::get_instance())
    ->set_registry(Registry::get_instance());

DB::get_instance()
    ->set_logger(Logger::get_instance())
    ->set_registry(Registry::get_instance());

Audio::get_instance()
    ->set_logger(Logger::get_instance())
    ->set_registry(Registry::get_instance());

Table::get_instance()
    ->set_db(DB::get_instance());

Factory_Table::get_instance()
    ->set_logger(Logger::get_instance())
    ->set_registry(Registry::get_instance())
    ->set_table(Table::get_instance());

$image_table     = Factory_Table::get_instance()->create('image');
$img_table       = Factory_Table::get_instance()->create('img');
$img_image_table = Factory_Table::get_instance()->create('img_image');

if ( is_admin() )
{
    Admin::get_instance()
        ->set_logger(Logger::get_instance())
        ->set_registry(Registry::get_instance())
        ->set_mask(Logmask::$mask["log_admin"]);

    IBM_Watson_Option::get_instance()
        ->set_wp_option(WP_Option::get_instance())
        ->set_logger(Logger::get_instance())
        ->set_registry(Registry::get_instance())
        ->set_add_settings_section(Add_Settings_Section::get_instance())
        ->set_add_settings_field(Add_Settings_Field::get_instance())
        ->set_mask(Logmask::$mask["log_ibm_watson"]);

    Register_Option::get_instance()
        ->set_wp_option(WP_Option::get_instance())
        ->set_logger(Logger::get_instance())
        ->set_registry(Registry::get_instance())
        ->set_add_settings_section(Add_Settings_Section::get_instance())
        ->set_add_settings_field(Add_Settings_Field::get_instance())
        ->set_mask(Logmask::$mask["log_register"]);

    Example_Option::get_instance()
        ->set_wp_option(WP_Option::get_instance())
        ->set_logger(Logger::get_instance())
        ->set_registry(Registry::get_instance())
        ->set_add_settings_section(Add_Settings_Section::get_instance())
        ->set_add_settings_field(Add_Settings_Field::get_instance())
        ->set_mask(Logmask::$mask["log_example"]);

    Log_Option::get_instance()
        ->set_wp_option(WP_Option::get_instance())
        ->set_logger(Logger::get_instance())
        ->set_registry(Registry::get_instance())
        ->set_array_registry(Array_Registry::get_instance())
        ->set_add_settings_section(Add_Settings_Section::get_instance())
        ->set_add_settings_field(Add_Settings_Field::get_instance())
        ->set_mask(Logmask::$mask["log_log"]);

    Media_Option::get_instance()
        ->set_wp_option(WP_Option::get_instance())
        ->set_image_table($image_table)
        ->set_img_table($img_table)
        ->set_img_image_table($img_image_table)
        ->set_logger(Logger::get_instance())
        ->set_registry(Registry::get_instance())
        ->set_array_registry(Array_Registry::get_instance())
        ->set_add_settings_section(Add_Settings_Section::get_instance())
        ->set_add_settings_field(Add_Settings_Field::get_instance())
        ->set_mask(Logmask::$mask["log_media"]);

    Image_Option::get_instance()
        ->set_wp_option(WP_Option::get_instance())
        ->set_image_table($image_table)
        ->set_img_table($img_table)
        ->set_img_image_table($img_image_table)
        ->set_logger(Logger::get_instance())
        ->set_registry(Registry::get_instance())
        ->set_add_settings_section(Add_Settings_Section::get_instance())
        ->set_add_settings_field(Add_Settings_Field::get_instance())
        ->set_mask(Logmask::$mask["log_image"]);

    Admin::init();
}    

function wps_localize() {

    $image_table     = Factory_Table::get_instance()->create('image');
    $img_table       = Factory_Table::get_instance()->create('img');
    $img_image_table = Factory_Table::get_instance()->create('img_image');
    
    $img_image_rows  = $img_image_table->fetch_all();
    $image_rows      = $image_table->fetch_all();
    $img_rows        = $img_table->fetch_all();

    $image_table = array();
    foreach( $image_rows as $row ) {
        $image_table[$row["image_id"]] = $row;
    }

    $img_table = array();
    foreach( $img_rows as $row ) {
        $img_table[$row["img_id"]] = $row;
    }

    $params = array();
    foreach($img_image_rows as $img_image_row) {
    
// error_log( print_r($img_image_row, true) );

//         $param = array();
    
        $img   = $img_table[   $img_image_row[  "img_id"] ];
        $image = $image_table[ $img_image_row["image_id"] ];
    
//         $param["img_alt"]      = $img["alt"];
//         $param["img_attr_alt"] = $img["attr_alt"];
//         $param["wp_post_id"]   = $img["wp_post_id"];
//         $param["use_alt"]      = $img["use_alt"];
//         $param["image_alt"]    = $image["alt"];
//         $param["src"]          = $image["src"];

        $search = "body.postid-{$img['wp_post_id']} img[src='{$image['src']}'][alt='{$img['attr_alt']}']";
        
// error_log( $search );

        switch( $img["use_alt"] ) {
        
            case "use_img_alt":
                $params[$search] = $img["alt"];
                break; 
                       
            case "use_img_attr_alt":
                $params[$search] = $img["attr_alt"];
                break;  
                      
            default:
            case "use_image_alt":
                $params[$search] = $image["alt"];
                break;   
                     
        }
        
    }
    
//     $param = array(
//         "one" => json_encode($params),
//         "two" => 222,
//     );
// error_log( print_r($params, true) );

    wp_localize_script("wps-main", 'IMAGES', $params );
}
add_action("wp_enqueue_scripts",    "WP_Speak\wps_localize" );
add_action("admin_enqueue_scripts", "WP_Speak\wps_localize" );


register_activation_hook(__FILE__,'WP_Speak\wp_speak_activate');
function wp_speak_activate()
{
     error_log("**** INSIDE ACTIVATION ****");
     
     Factory_Table::get_instance()->create('image')->install();
     Factory_Table::get_instance()->create('img')->install();
     Factory_Table::get_instance()->create('img_image')->install();

}

register_deactivation_hook(__FILE__,'WP_Speak\wp_speak_deactivate');
function wp_speak_deactivate()
{
    error_log("**** INSIDE (DE)ACTIVATION ****");

     Factory_Table::get_instance()->create('image')->uninstall();
     Factory_Table::get_instance()->create('img')->uninstall();
     Factory_Table::get_instance()->create('img_image')->uninstall();

	foreach( Option::$OPTION_EXTENDED_TITLE as $title ) {
	    delete_option($title);
	}

}
?>
