<?php
namespace WP_Speak;

class DB extends Basic {

    private   static $wpdb;

    protected static $mask;

    protected static $instance;

	protected function __construct( ) { }
	
    /*
	private function fetch_sql( $arg_table, $arg_value ) {
		$sql = sprintf( 'SELECT * FROM %s WHERE %s = %%s', $arg_table, static::$primary_key );
		return self::$wpdb->prepare( $sql, $arg_value );
	}
	
	function get( $value ) {
		return self::$wpdb->get_row( self::fetch_sql( $value ) );
	}
    */

    function dbdelta( $arg_sql ) {
        return self::$wpdb->dbdelta( $arg_sql );
    }

	function insert_unique( $arg_table, $arg_key, $arg_match, $arg_data ) {

		$sql   = sprintf("SELECT * FROM %s WHERE %s = '%s'", $arg_table, $arg_key, $arg_match) ;
		$status = self::$wpdb->get_results( $sql );
		if ( !empty($status) ) {
		    return TRUE;
		}

		$status = self::$wpdb->insert( $arg_table, $arg_data );
		if (FALSE === $status) {

            self::$error->set_errno( Errno::ERR_NO_INSERT );
            self::$error->set_errmsg( "Insert failed on Table %s. %s", $arg_table, self::$wpdb->last_error() );
            return FALSE;

		} else {

            self::$error->set_errno( Errno::ERR_NO_OKAY );
            return TRUE; //self::$wpdb->insert_id;

		}
	
	}

	function insert( $arg_table, $arg_data ) {

		$status = self::$wpdb->insert( $arg_table, $arg_data );
		if (FALSE === $status) {

            self::$error->set_errno( Errno::ERR_NO_INSERT );
            self::$error->set_errmsg( "Insert failed on Table %s. %s", $arg_table, self::$wpdb->last_error() );
            return FALSE;

		} else {

            self::$error->set_errno( Errno::ERR_NO_OKAY );
            return self::$wpdb->insert_id();

		}
	
	}

	function update( $arg_table, $arg_column, $arg_value, $arg_key, $arg_match ) {

		$prepare = self::$wpdb->prepare( "UPDATE {$arg_table} SET {$arg_column} = '%s' WHERE {$arg_key} = '{$arg_match}';", $arg_value );
        if ( FALSE === $prepare ) {
            self::$error->set_errno( Errno::ERR_NO_PREPARE );
            self::$error->set_errmsg( "PREPARE failed on UPDATE for Table %s for column %s with value (%s). %s", $arg_table, $arg_column, $arg_value, self::$wpdb->last_error() );
            return FALSE;
        }
		
        $status = self::$wpdb->query( $prepare );
        if ( FALSE === $status ) {
            self::$error->set_errno( Errno::ERR_NO_UPDATE );
            self::$error->set_errmsg( "UPDATE failed on Table %s for column %s with value (%s). %s", $arg_table, $arg_column, $arg_value, self::$wpdb->last_error() );
            return FALSE;
        }
	
        return TRUE;
	}

	function update_all( $arg_table, $arg_column, $arg_value ) {

        $prepare = self::$wpdb->prepare( "UPDATE {$arg_table} SET {$arg_column} = '%s';", $arg_value );
        if ( FALSE === $prepare ) {
            self::$error->set_errno( Errno::ERR_NO_PREPARE );
            self::$error->set_errmsg( "PREPARE failed on UPDATE ALL for Table %s for column %s with value (%s). %s", $arg_table, $arg_column, $arg_value, self::$wpdb->last_error() );
            return FALSE;
        }

        $status = self::$wpdb->query( $prepare );
        if ( FALSE === $status ) {
            self::$error->set_errno( Errno::ERR_NO_UPDATE_ALL );
            self::$error->set_errmsg( "UPDATE ALL failed on Table %s for column %s with value (%s). %s", $arg_table, $arg_column, $arg_value, self::$wpdb->last_error() );
            return FALSE;
        }
        
        return TRUE;
	}

	function drop_table( $arg_table ) {

		$sql = sprintf( 'DROP TABLE IF EXISTS %s;', $arg_table );
		return self::$wpdb->query( $sql );

	}

	function fetch_all( $arg_table ) {
		$sql   = sprintf("SELECT * FROM %s;", $arg_table);
		return self::$wpdb->get_results( $sql );
	}

	function fetch( $arg_table, $arg_key, $arg_match ) {
		$sql   = sprintf("SELECT * FROM %s WHERE %s = '%s'", $arg_table, $arg_key, $arg_match) ;
		$results = self::$wpdb->get_results( $sql );
		return $results;
	}

    function set_wpdb( $arg_wpdb ) {
		self::$wpdb = $arg_wpdb;
        return $this;
	}

}

?>
