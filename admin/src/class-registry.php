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
     * @var int $data
     */
    protected static $data = array();

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


    public function dump()
    {
        error_log("*************** DUMP:ARRAY_REGISTRY ******************");
        error_log(print_r(self::$data, true));
        return true;
    }

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

        self::$logger->log( self::$mask, '************** init_registry **********************');
        self::$logger->log( self::$mask, __FUNCTION__ . "({$arg_page})" );
        self::$logger->log( self::$mask, __FUNCTION__ . self::$logger->print_r( $arg_name_list ) );

        /**
         * Grab my option based on $arg_page.
         */
        $option = self::$wp_option->get( WP_Option::$option[ $arg_page ] );

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


        $this->set( WP_Option::$option[ $arg_page ], $option );

        /**
         * We're done.
         */
        return $this;
    }

    /**
     * The function init_log_registry() sets of the logging activities
     * for pushing and pulling values from the cache.
     *
     * @param string $arg_page refers to an admin panel.
     * @param string $arg_name_list refers to the list of values for an admin panel.
     */
    public function init_log_registry(
        $arg_page,
        $arg_name_list ) {

        self::$logger->log( self::$mask, '***************** init_log_registry *******************');
        self::$logger->log( self::$mask, __FUNCTION__ . "({$arg_page})" );
        self::$logger->log( self::$mask, __FUNCTION__ . self::$logger->print_r( $arg_name_list ) );

        /**
         * Grab my option based on $arg_page.
         */
        $option = self::$wp_option->get( WP_Option::$option[ $arg_page ] );

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

        self::$logger->log( self::$mask, 'MASK OPTIONS on init: ' . self::$logger->print_r( $option ) );

        $name_list = array();

        foreach ( $arg_name_list as $name ) {

            /**
             * For each named element for this option, let's set our in-cache values.
             */
            $this->set( $name, $value = ( isset( $option[ $name ] ) ) ? $option[ $name ] : 0 );

            if ( isset( $option[ $name ] ) && 0 !== $option[ $name ] ) {

                $this->set( $name, $value = $option[ $name ] );
                $name_list[ $name ] = $option[ $name ];
                self::$logger->set_logger_mask( self::$logger->get_logger_mask() | Logmask::$mask[ $name ] );
                self::$logger->log( self::$mask, "Set Registry. {$name} = ON" );

            } else {

                $this->set( $name, $value = 0 );
                $name_list[ $name ] = 0;
                self::$logger->set_logger_mask( self::$logger->get_logger_mask() & ~Logmask::$mask[ $name ] );
                self::$logger->log( self::$mask, "Set Registry. {$name} = OFF" );

            }
        }

        $this->set( $arg_page, $name_list );

        return $this;
    }

    /**
     * The function update_registry() takes a new set of cache values,
     * and updates the in-process cache.
     *
     * @param string $arg_output refers to new values for a panel.
     * @param string $arg_name_list refers to the list of values for an admin panel.
     */
    public function update_registry( $arg_output, $arg_name_list ) {

        self::$logger->log( self::$mask, __FUNCTION__ . "HERE HERE HERE" );
        self::$logger->log( self::$mask, __FUNCTION__ . self::$logger->print_r( $arg_output ) );
        self::$logger->log( self::$mask, __FUNCTION__ . self::$logger->print_r( $arg_name_list ) );

        foreach ( $arg_name_list as $name ) {
            $this->set( $name, $value = ( isset( $arg_output[ $name ] ) ) ? $arg_output[ $name ] : null );
            false === strpos( $name, 'password' ) && self::$logger->log( self::$mask, "Update Registry. {$name} = " . print_r($value, true) );
            false !== strpos( $name, 'password' ) && self::$logger->log( self::$mask, "Update Registry. {$name} = " . str_repeat( '*', 8 ) );
        }

        return $arg_output;
    }

    /**
     * The function update_log_registry() takes a new set of cache values,
     * and updates the in-process cache.
     *
     * @param string $arg_output refers to new values for a panel.
     * @param string $arg_name_list refers to the list of values for an admin panel.
     */
    public function update_log_registry(
        $arg_output,
        $arg_name_list ) {

        self::$logger->log( self::$mask, __FUNCTION__ . ' ' . self::$logger->print_r( $arg_output ) );
        self::$logger->log( self::$mask, __FUNCTION__ . ' ' . self::$logger->print_r( $arg_name_list ) );

        self::$logger->log( self::$mask, 'MASK OPTIONS on update: ' . self::$logger->print_r( $arg_output ) );

        foreach ( $arg_name_list as $name ) {
            if ( isset( $arg_output[ $name ] ) ) {
                $this->set( $name, $value = $arg_output[ $name ] );
                self::$logger->set_logger_mask( self::$logger->get_logger_mask() | Logmask::$mask[ $name ] );
                self::$logger->log( self::$mask, "Update Registry. {$name} = ON" );
            } else {
                $this->set( $name, $value = 'OFF' );
                self::$logger->log( self::$mask, "Update Registry. {$name} = OFF" );
                self::$logger->set_logger_mask( self::$logger->get_logger_mask() & ~Logmask::$mask[ $name ] );
            }
        }

        return $arg_output;
    }


}

