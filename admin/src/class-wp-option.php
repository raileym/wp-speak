<?php
namespace WP_Speak;

class WP_Option extends Basic
{
    protected static $instance;

    /**
     * $mask is the local (protected) copy of mask.
     *
     * @var int $mask
     */
    protected static $mask;

    public static $option = [
        'img_table'                  => 'wp_speak_admin_img_table',
        'image_table'                => 'wp_speak_admin_image_table',
        'img_image_table'            => 'wp_speak_admin_img_image_table',
        'log_option'                 => 'wp_speak_admin_log_option',
        'ibm_watson_option'          => 'wp_speak_admin_ibm_watson_option',
        'register_option'            => 'wp_speak_admin_register_option',
        'media_option'               => 'wp_speak_admin_media_option',
        'image_option'               => 'wp_speak_admin_image_option',
        'example_option'             => 'wp_speak_admin_example_option',
        'wp_speak\log_option'        => 'wp_speak_admin_log_option',
        'wp_speak\ibm_watson_option' => 'wp_speak_admin_ibm_watson_option',
        'wp_speak\register_option'   => 'wp_speak_admin_register_option',
        'wp_speak\media_option'      => 'wp_speak_admin_media_option',
        'wp_speak\image_option'      => 'wp_speak_admin_image_option',
        'wp_speak\example_option'    => 'wp_speak_admin_example_option',
        'WP_Speak\Log_Option'        => 'wp_speak_admin_log_option',
        'WP_Speak\IBM_Watson_Option' => 'wp_speak_admin_ibm_watson_option',
        'WP_Speak\Register_Option'   => 'wp_speak_admin_register_option',
        'WP_Speak\Media_Option'      => 'wp_speak_admin_media_option',
        'WP_Speak\Image_Option'      => 'wp_speak_admin_image_option',
        'WP_Speak\Example_Option'    => 'wp_speak_admin_example_option'
    ];

	protected function __construct() { }

    /**
     * The function get() isolates access to get_option()
     * for testing purposes. I can mock calls to get_option()
     * easily. For this plugin, WP-Speak, options (entries 
     * in the options table) are tied to plugin classes.
     *
     * @param string $arg_option maps to the wp-options table.
     */
    public function get( 
        $arg_option ) {

        assert( null !== $arg_option );
        assert( in_array( $arg_option, self::$option ) );

        return get_option( $arg_option );
    }
    
    /**
     * The function update() isolates access to update_option()
     * for testing purposes. I can mock calls to update_option()
     * easily. For this plugin, WP-Speak, options (entries in 
     * the options table) are tied to plugin classes.
     *
     * @param string $arg_option maps to the wp-options table.
     */
    public function update(
        $arg_option,
        $arg_value) {

        assert( null !== $arg_option );
        assert( null !== $arg_value );
        assert( in_array( $arg_option, self::$option ) );
        
        return update_option( $arg_option , $arg_value );
    }
    
}

?>
