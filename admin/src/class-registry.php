<?php
/**
 * Registry captures functions for managing an in-process cache.
 *
 * Registry stores a set of values in cache for use by WP-Speak
 * classes. Using Registry avoids the need for passing globals
 * around or constantly hitting the database for some
 * cacheable value.
 *
 * @file
 * @package admin
 */

namespace WP_Speak;

/**
 * Registry captures functions for managing an in-process cache.
 */
class Registry extends Basic {

    /**
     * $instance supports the Singleton creation design.
     *
     * @var Registry $instance.
     */
    protected static $instance;

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
    protected function __construct() { }


    /**
     * The function init_registry() is grabbing all the DB
     * values ( from get_option() ) for the given page $arg_page, 
     * and pulling them into cache.
     *
     * @param string $arg_page refers to an admin panel / option name.
     * @param string $arg_name_list refers to the list of values for an admin panel.
     */
    public function init_registry(
        $arg_page,
        $arg_name_list ) {

        self::$logger->log( self::$mask, __FUNCTION__ . "({$arg_page})" );
        self::$logger->log( self::$mask, __FUNCTION__ . self::$logger->print_r( $arg_name_list ) );

        /**
         * Grab my option based on $arg_page.
         */
        $option = self::$wp_option->get( $arg_page );

        if ( false === $option ) {

            /**
             * Exit stage right if there is no such option.
             */
            self::$logger->log( self::$mask, __FUNCTION__ . "({$arg_page}). get_option() returns 'false'." );
            return $this;

        }

        if ( empty( $option ) ) {

            /**
             * I found the option, but its empty. Okay.
             */
            self::$logger->log( self::$mask, __FUNCTION__ . "({$arg_page}). get_option() returns 'empty'." );

        }

        self::$logger->log( self::$mask, 'From OPTIONS on init: ' . self::$logger->print_r( $option ) );


        /**
         * Cache the ENTIRE option set under the page name.
         */
        self::$registry_datastore->set( $arg_page, $option );


        /**
         * Now, cache each named item from the name list, as set in the option set.
         */
        foreach ( $arg_name_list as $name ) {

            /**
             * For each named element for this option, let's set our in-cache values.
             */
            self::$registry_datastore->set( $name, $value = ( isset( $option[ $name ] ) ) ? $option[ $name ] : null );

            /**
             * Show full details provided the attribute is NOT a password.
             */
            false === strpos( $name, 'password' )
                  && self::$logger->log( self::$mask, "Set Registry. {$name} = " . print_r($value, true) );

            /**
             * Hide full details if the attribute is a password.
             */
            false !== strpos( $name, 'password' )
                && self::$logger->log( self::$mask, "Set Registry. {$name} = " . str_repeat( '*', 8 ) );
        }


        /**
         * We're done.
         */
        return $this;
    }

    /**
     * The function update_registry() takes a new set of cache values,
     * and updates the in-process cache.
     *
     * @param string $arg_page refers to a particular panel.
     * @param string $arg_output refers to new values for a panel.
     * @param string $arg_name_list refers to the list of values for an admin panel.
     */
    public function update_registry(
        $arg_page,
        $arg_output,
        $arg_name_list ) {

        self::$logger->log( self::$mask, __FUNCTION__ . "({$arg_page})" );
        self::$logger->log( self::$mask, __FUNCTION__ . self::$logger->print_r( $arg_output ) );
        self::$logger->log( self::$mask, __FUNCTION__ . self::$logger->print_r( $arg_name_list ) );

        /**
         * Cache the ENTIRE option set under the page name.
         */
        self::$registry_datastore->set( $arg_page, $arg_output );


        /**
         * Now, update values for each named value.
         */
        foreach ( $arg_name_list as $name ) {
            self::$registry_datastore->set( $name, $value = ( isset( $arg_output[ $name ] ) ) ? $arg_output[ $name ] : null );
            false === strpos( $name, 'password' ) && self::$logger->log( self::$mask, "Update Registry. {$name} = " . print_r($value, true) );
            false !== strpos( $name, 'password' ) && self::$logger->log( self::$mask, "Update Registry. {$name} = " . str_repeat( '*', 8 ) );
        }

        return $arg_output;
    }

}

