<?php
/**
 * Action defines the names for plugin actions.
 *
 * Action simply pulls together all the names
 * of add_action() / do_action() behaviors for
 * this plugin.
 *
 * @file
 * @package admin
 */

namespace WP_Speak;

/**
 * Action defines the names for plugin actions.
 */
class Action
{
    public static $init = array(
        'WP_Speak\Example_Option'    => 'wp_speak_init_example_option',
        'WP_Speak\IBM_Watson_Option' => 'wp_speak_init_ibm_watson_option',
        'WP_Speak\Image_Option'      => 'wp_speak_init_image_option',
        'WP_Speak\Log_Option'        => 'wp_speak_init_log_option',
        'WP_Speak\Media_Option'      => 'wp_speak_init_media_option',
        'WP_Speak\Register_Option'   => 'wp_speak_init_register_option'
    );
}
