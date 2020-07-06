<?php
namespace WP_Speak;

class ErrorException extends \Exception {
}

class Error extends Errno
{

    private static $errno_idx;
    private static $errnm_idx;
    private static $errmsg;
    private static $errlog = "";
    private static $use_errlog = TRUE;
    private static $use_print_errlog = FALSE;

    public static function set_errnm( $arg_errnm_idx ) {

        if ( array_key_exists( $arg_errnm_idx, self::$errno ) ) {

            self::$errnm_idx = $arg_errnm_idx;
            self::$errno_idx = self::$errno[ $arg_errnm_idx ];

        } else {

            throw new ErrorException("ERRNM ({$arg_errnm_idx}) not found. ");

        }

    }

    public static function set_errno( $arg_errno_idx ) {

        if ( array_key_exists( $arg_errno_idx, self::$errnm ) ) {

            self::$errno_idx = $arg_errno_idx;
            self::$errnm_idx = self::$errnm[ $arg_errno_idx ];

        } else {

            throw new ErrorException("ERRNO ({$arg_errno_idx}) not found. ");

        }

    }

    public static function get_errnm( ) {
        assert('array_key_exists( self::$errno_idx, self::$errnm )', sprintf("Errno ('%s') not found", self::$errno_idx));
        return self::$errnm[ self::$errno_idx ];
    }

    public static function get_errno( ) {
        assert('array_key_exists( self::$errnm_idx, self::$errno )', sprintf("Errnm ('%s') not found", self::$errnm_idx));
        return self::$errno[ self::$errnm_idx ];
    }

//     public static function set_use_errlog( $arg_use_errlog = TRUE ) {
//         self::$use_errorlog = $arg_use_errlog;
//     }
// 

    public static function clear_errlog() {
        self::$errlog = "";
    }
    
    public static function print_errlog( $arg_clear_errlog = TRUE) {
        error_log( self::get_errlog( $arg_clear_errlog ) );
        if ( $arg_clear_errlog ) {
            self::clear_errlog();
        }
    }

    public static function clear_errmsg() {
        self::$errmsg = "";
    }
    
    public static function set_errmsg( $arg_errmsg = NULL, ...$args) {
        
        if (empty($arg_errmsg)) {

            self::$errmsg = self::get_errnm();

        } else if (empty(self::$errmsg)) {

            self::$errmsg = self::get_errnm() . ": " . vsprintf($arg_errmsg, $args);

        } else {

            self::$errmsg = self::get_errnm() . ": " . vsprintf($arg_errmsg, $args). ". " . self::$errmsg;

        }
    
        if ( self::$use_errlog && empty( self::$errlog ) ) {
            
            self::$errlog = self::$errmsg;

        } else if ( self::$use_errlog ) {
            
            self::$errlog .= PHP_EOL . self::$errmsg;

        }

        if ( self::$use_print_errlog ) {

            self::print_errlog();

        }

    }

    public static function get_errmsg( $arg_clear_errmsg = TRUE ) {
        
        $errmsg = self::$errmsg;

        if ( $arg_clear_errmsg ) {
            self::$errmsg = "";
        }

        return $errmsg;
    }

    public static function get_errlog( $arg_clear_errlog = TRUE ) {
        
        $errlog = self::$errlog;

        if ( $arg_clear_errlog ) {
            self::$errlog = "";
        }

        return $errlog;
    }

}
?>
