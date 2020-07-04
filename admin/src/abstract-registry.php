<?php
namespace WP_Speak;

// See http://www.devshed.com/c/a/PHP/Registry-Design-Pattern/1/
//
abstract class Abstract_Registry
{

    protected static $instances = array();

    // get Singleton instance of the registry (uses the 'get_called_class()' function available in PHP 5.3)
    public static function get_instance()
    {
        // resolves the called class at run time
        $class = get_called_class();

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class;
        }

        return self::$instances[$class];
    }

    // overriden by some subclasses
    protected function __construct()
    {
    }

    // prevent cloning instance of the registry
    protected function __clone()
    {
    }

}
