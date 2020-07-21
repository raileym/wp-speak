<?php
/**
 * Registry_Datastore holds the data on behalf of the Registry.
 *
 * Registry_Datastore stores a set of values in cache for use by WP-Speak
 * classes. Using Registry/Registry_Datastore avoids the need for 
 * passing globals around or constantly hitting the database for some
 * cacheable value.
 *
 * @file
 * @package admin
 */

namespace WP_Speak;

/**
 * Registry captures functions for managing an in-process cache.
 */
class Registry_Datastore extends Basic {

    /**
     * $instance supports the Singleton creation design.
     *
     * @var Registry $instance.
     */
    protected static $instance;

    /**
     * $mask is the local (protected) copy of mask.
     *
     * @var int $data
     */
    protected static $data;

    /**
     * $mask is the local (protected) copy of mask.
     *
     * @var int $mask
     */
    protected static $mask;

    /**
     * This version of the constructor supports the Singleton
     * creation design.
     */
    protected function __construct() { 
        self::$data = array();
    }


    public function set(
        $arg_key,
        $arg_value)
    {
        self::$data[$arg_key] = $arg_value;
        return $this;
    }


    public function get(
        $arg_key)
    {
        return isset(self::$data[$arg_key]) ? self::$data[$arg_key] : null;
    }


    public function dump(
        $arg_class,
        $arg_function )
    {
        error_log("******** {$arg_class}->{$arg_function}(): DUMP:ARRAY_REGISTRY ********");
        error_log(print_r(self::$data, true));
        return true;
    }

}

