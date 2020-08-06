<?php
/**
 * Logmask defines a set of bitmask for logging.
 *
 * Logmask gathers constants for logging purposes.
 * These values align to bitmasks.
 *
 * @file
 * @package admin
 */

namespace WP_Speak;

/**
 * Logmask is simply a mapping from a log name
 * to a bitmask.
 */
class Logmask
{
    public static $mask =
        array(
            'log_all'        => 0xFFFF,
            'log_admin'      => 0x0001,
            'log_wpdb'       => 0x0002,
            'log_callback'   => 0x0004,
            'log_copyright'  => 0x0008,
            'log_debug'      => 0x0010,
            'log_example'    => 0x0020,
            'log_format'     => 0x0040,
            'log_ibm_watson' => 0x0080,
            'log_image'      => 0x0100,
            'log_include'    => 0x0200,
            'log_log'        => 0x0400,
            'log_media'      => 0x0800,
            'log_register'   => 0x1000,
            'log_registry'   => 0x2000,
            'log_error'      => 0x4000,
            'log_wp_option'  => 0x8000,
        );
}
