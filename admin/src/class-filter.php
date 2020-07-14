<?php
/**
 * Filter defines the names for plugin filters.
 *
 * Filter simply pulls together all the names
 * of add_filter() / do_filter() behaviors for
 * this plugin.
 *
 * @file
 * @package admin
 */

namespace WP_Speak;

/**
 * Filter defines the names for plugin filters.
 */
class Filter
{
    public static $validate = array(
        'WP_Speak\Example_Option'    => 'wp_speak_filter_validate_example_option',
        'WP_Speak\IBM_Watson_Option' => 'wp_speak_filter_validate_ibm_watson_option',
        'WP_Speak\Image_Option'      => 'wp_speak_filter_validate_image_option',
        'WP_Speak\Log_Option'        => 'wp_speak_filter_validate_log_option',
        'WP_Speak\Media_Option'      => 'wp_speak_filter_validate_media_option',
        'WP_Speak\Register_Option'   => 'wp_speak_filter_validate_register_option'
    );
}
