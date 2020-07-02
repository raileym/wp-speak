<?php
namespace WP_Speak;

class Error implements Errno, Errnm
{

    private static $_errno;
    private static $_errmsg;

    public static function set_errno( $arg_errno ) {
        self::$_errno = $arg_errno;
    }

    public static function get_errno() {
        return self::$_errno;
    }

    public static function get_errnm() {
        if (array_key_exists(self::$_errno, self::NM)) {
            return self::NM[ self::$_errno ];        
        } else {
            return strval( self::$_errno );
        }
    }

    public static function set_errmsg( $arg_errmsg, ...$args) {
        
        if (is_null($arg_errmsg)) {

            self::$_errmsg = NULL;

        } else if (is_null($arg_errmsg)) {

            self::$_errmsg = vsprintf($arg_errmsg, $args);

        } else {

            self::$_errmsg = vsprintf($arg_errmsg, $args)." ".self::$_errmsg;

        }
    }

    public static function get_errmsg() {
        return self::get_errnm() . ": " . self::$_errmsg;
    }

}
?>
