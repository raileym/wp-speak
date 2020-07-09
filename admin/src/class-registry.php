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
     * $array_registry is a handle to an array of registries.
     *
     * @var Array_Registry $array_registry.
     */
    private static $array_registry;


    /**
     * This version of the constructor supports the Singleton
     * creation design.
     */
    protected function __construct() {     }

    /**
     * The function init_table_registry() grabs all the values
     * from the given table, and stores the values in-cache.
     *
     * @param string $arg_table is the db table to grab.
     */
    public function init_table_registry(
        $arg_table ) {

        $id      = $arg_table->id();
        $tag     = $arg_table->tag();
        $results = $arg_table->fetch_all();

        /**
         * For all the rows fetched from the table,
         * grab all the assorted data.
         */
        $row_list = array();
        foreach ( $results as $result ) {
            $row_list[ $result[ $id ] ] = $result;
        }

        self::$array_registry->set( $tag, $row_list );

        return $this;
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

        self::$logger->log( self::$mask, __FUNCTION__ . "({$arg_page})" );

        /**
         * Grab my option based on $arg_page.
         */
        $option = self::$wp_option->get_option( $arg_page );

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

        /**
         * Now, let's work each named item in the name list.
         */
        foreach ( $arg_name_list as $name ) {

            /**
             * For each named element for this option, let's set our in-cache values.
             */
            self::$array_registry->set( $name, $value = ( isset( $option[ $name ] ) ) ? $option[ $name ] : null );

            /**
             * Show full details provided the attribute is NOT a password.
             */
            false === strpos( $name, 'password' )
                && self::$logger->log( self::$mask, "Set Registry. {$name} = {$value}" );

            /**
             * Hide full details if the attribute is a password.
             */
            false !== strpos( $name, 'password' )
                && self::$logger->log( self::$mask, "Set Registry. {$name} = " . str_repeat( '*', 8 ) );
        }


        /**
         * We're done.
         */
        self::$logger->log( self::$mask, '-2-----------------------------------' );
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

        self::$logger->log( self::$mask, __FUNCTION__ . "({$arg_page})" );
        self::$logger->log( self::$mask, __FUNCTION__ . self::$logger->print_r( $arg_name_list ) );

        $option = self::$wp_option->get_option( $arg_page );

        self::$logger->log( self::$mask, 'MASK OPTIONS on init: ' . self::$logger->print_r( $option ) );

        foreach ( $arg_name_list as $name ) {
            if ( isset( $option[ $name ] ) && 0 !== $option[ $name ] ) {
                self::$array_registry->set( $name, $value = $option[ $name ] );
                self::$logger->set_logger_mask( self::$logger->get_logger_mask() | Logmask::$mask[ $name ] );
                self::$logger->log( self::$mask, "Set Registry. {$name} = ON" );
            } else {
                self::$array_registry->set( $name, $value = null );
                self::$logger->set_logger_mask( self::$logger->get_logger_mask() & ~Logmask::$mask[ $name ] );
                self::$logger->log( self::$mask, "Set Registry. {$name} = OFF" );
            }
        }

        self::$logger->log( self::$mask, '-3-----------------------------------' );
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
        self::$logger->log( self::$mask, __FUNCTION__ . self::$logger->print_r( $arg_output ) );
        self::$logger->log( self::$mask, __FUNCTION__ . self::$logger->print_r( $arg_name_list ) );

        foreach ( $arg_name_list as $name ) {
            self::$array_registry->set( $name, $value = ( isset( $arg_output[ $name ] ) ) ? $arg_output[ $name ] : null );
            false === strpos( $name, 'password' ) && self::$logger->log( self::$mask, "Update Registry. {$name} = {$value}" );
            false !== strpos( $name, 'password' ) && self::$logger->log( self::$mask, "Update Registry. {$name} = " . str_repeat( '*', 8 ) );
        }

        self::$logger->log( self::$mask, '-4-----------------------------------' );
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
                self::$array_registry->set( $name, $value = $arg_output[ $name ] );
                self::$logger->set_logger_mask( self::$logger->get_logger_mask() | Logmask::$mask[ $name ] );
                self::$logger->log( self::$mask, "Update Registry. {$name} = ON" );
            } else {
                self::$array_registry->set( $name, $value = 'OFF' );
                self::$logger->log( self::$mask, "Update Registry. {$name} = OFF" );
                self::$logger->set_logger_mask( self::$logger->get_logger_mask() & ~Logmask::$mask[ $name ] );
            }
        }

        self::$logger->log( self::$mask, '-5-----------------------------------' );
        return $arg_output;
    }


    /**
     * The function set_array_registry sets the instance handle for the array_registry.
     *
     * @param Array_Registry $arg_array_registry is a handle to an array_registry instance.
     */
    public function set_array_registry( Array_Registry $arg_array_registry ) {
        self::$array_registry = $arg_array_registry;
        return $this;
    }

}

