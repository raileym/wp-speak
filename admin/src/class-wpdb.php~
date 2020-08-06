<?php
namespace WP_Speak;

class WPDB extends Basic
{
    protected static $instance;

    protected static $mask;

	protected function __construct() { }

    public function prepare( $arg_sql, $arg_value ) {
        global $wpdb;

        self::$logger->log( self::$mask, __FUNCTION__ . ':' . $arg_sql . ' | ' . $arg_value);
        return $wpdb->prepare( $arg_sql, $arg_value );
    }

    public function get_row( $arg_query ) {
        global $wpdb;

        self::$logger->log( self::$mask, __FUNCTION__ . ':' . $arg_query);
        return $wpdb->get_row( $arg_query );
    }

    public function last_error( ) {
        global $wpdb;

        return $wpdb->last_error;
    }

    public function insert_id( ) {
        global $wpdb;

        return $wpdb->insert_id;
    }

    public function dbdelta( $arg_sql ) {
        global $wpdb;

        self::$logger->log( self::$mask, __FUNCTION__ . ':' . $arg_sql);
        return $wpdb->get_row( $arg_sql );
    }

    public function insert( $arg_table, $arg_data ) {
        global $wpdb;

        self::$logger->log( self::$mask, __FUNCTION__ );
        return $wpdb->insert( $arg_table, $arg_data );
    }

    public function query( $arg_prepare ) {
        global $wpdb;

        self::$logger->log( self::$mask, __FUNCTION__ . ':' . $arg_prepare);

        return $wpdb->query( $arg_prepare );
    }

    public function get_results( $arg_sql ) {
        global $wpdb;

        self::$logger->log( self::$mask, __FUNCTION__ . ':' . $arg_sql);
        return $wpdb->get_results( $arg_sql, ARRAY_A );
    }

}

?>
