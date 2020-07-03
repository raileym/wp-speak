<?php
namespace WP_Speak;

class Error implements Errno, Errnm
{

    private static $errno;
    private static $errmsg;

    public static function set_errno( $arg_errno ) {
        self::$errno = $arg_errno;
    }

    public static function get_errno() {
        return self::$errno;
    }

    public static function get_errnm() {
        if (array_key_exists(self::$errno, self::NM)) {
            return self::NM[ self::$errno ];        
        } else {
            return strval( self::$errno );
        }
    }

    public static function set_errmsg( $arg_errmsg, ...$args) {
        
        if (is_null($arg_errmsg)) {

            self::$errmsg = NULL;

        } else if (is_null($arg_errmsg)) {

            self::$errmsg = vsprintf($arg_errmsg, $args);

        } else {

            self::$errmsg = vsprintf($arg_errmsg, $args)." ".self::$errmsg;

        }
    }

    public static function get_errmsg() {
        return self::get_errnm() . ": " . self::$errmsg;
    }

}
?>
