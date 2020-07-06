<?php
/**
 * Logger captures routines involved with logging.
 *
 * Logger pulls together all the routines necessary
 * to log certain messages (per class) as defined
 * thru the admin panel.
 *
 * @file
 * @package admin
 */

namespace WP_Speak;

/**
 * Logger captures routines involved with logging.
 */
class Logger extends Basic {

    /**
     * $instance supports the Singleton creation design.
     *
     * @var int $instance.
     */
    protected static $instance;

    /**
     * $logger_mask is the current mask for all logging.
     *
     * @var uint $logger_mask.
     */
    private static $logger_mask = 0;

    /**
     * This constructor supports the Singleton creation design.
     */
    protected function __construct() {     }

    /**
     * The function set_logger_mask() sets the updated
     * value for the logger_mask. This function is
     * distinguished from set_mask, as defined in the class
     * Basic.
     *
     * @param uint $arg_mask is the new logger_mask.
     */
    public function set_logger_mask( $arg_mask ) {
        self::$logger_mask = $arg_mask;
    }

    /**
     * The function get_logger_mask function returns the
     * current value for the logger_mask.
     */
    public function get_logger_mask() {
        return self::$logger_mask;
    }

    /**
     * The function write() is the explicit function for
     * writing to the log file.
     *
     * @param uint   $arg_mask is the mask to be tested (log or not).
     * @param string $arg_message is the message to be logged.
     */
    private function write( $arg_mask, $arg_message ) {
        if ( ! ( $arg_mask & self::$logger_mask ) ) {
            return;
        }

        if ( WP_DEBUG === true ) {
            if ( is_array( $arg_message ) || is_object( $arg_message ) ) {
                Error::write_errlog( print_r( $arg_message, true ) );
            } else {
                Error::write_errlog( $arg_message );
            }
        }
    }

    /**
     * The function log() is the primary go-to function
     * for writing to the logfile.
     *
     * @param uint   $arg_mask is the mask to be tested (log or not).
     * @param string $arg_message is the message to be logged.
     */
    public function log( $arg_mask, $arg_message ) {
        if ( is_array( $arg_message ) || is_object( $arg_message ) ) {
            $this->write( $arg_mask, print_r( $arg_message, true ) );
        } else {
            $this->write( $arg_mask, $arg_message );
        }
    }
}

