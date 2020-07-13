<?php
namespace WP_Speak;

class Array_Registry extends Basic
{
    protected static $instance;

    private static $data;

    protected function __construct() { 
        self::$data = array();
    }

    public function set($arg_key, $arg_value)
    {
        self::$data[$arg_key] = $arg_value;
        return $this;
    }

    public function get($arg_key)
    {
        return isset(self::$data[$arg_key]) ? self::$data[$arg_key] : null;
    }

    public function dump()
    {
        error_log("*************** DUMP:ARRAY_REGISTRY ******************");
        error_log(print_r(self::$data, true));
        return true;
    }
}
