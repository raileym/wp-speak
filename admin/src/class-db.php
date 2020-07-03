<?php
namespace WP_Speak;

class DB extends Basic {

    protected static $instance;

	protected function __construct( ) { }
	
	private static function _fetch_sql( $arg_table, $arg_value ) {
		global $wpdb;
		$sql = sprintf( 'SELECT * FROM %s WHERE %s = %%s', $arg_table, static::$primary_key );
		return $wpdb->prepare( $sql, $arg_value );
	}
	
// 	static function valid_check( $data ) {
// 		global $wpdb;
// 
// 		$sql_where       = '';
// 		$sql_where_count = count( $data );
// 		$i               = 1;
// 		foreach ( $data as $key => $row ) {
// 			if ( $i < $sql_where_count ) {
// 				$sql_where .= "`$key` = '$row' and ";
// 			} else {
// 				$sql_where .= "`$key` = '$row'";
// 			}
// 			$i++;
// 		}
// 		$sql     = 'SELECT * FROM ' . self::_table() . " WHERE $sql_where";
// 		$results = $wpdb->get_results( $sql );
// 		if ( count( $results ) != 0 ) {
// 			return false;
// 		} else {
// 			return true;
// 		}
// 	}

	static function get( $value ) {
		global $wpdb;
		return $wpdb->get_row( self::_fetch_sql( $value ) );
	}

	static function insert_unique( $arg_table, $arg_key, $arg_value, $arg_data ) {

	    global $wpdb;

		$status = self::fetch($arg_table, $arg_key, $arg_value);
		if ( !empty($status) ) {
		    return TRUE;
		}

		$status = $wpdb->insert( $arg_table, $arg_data );
		if (FALSE === $status) {

            Error::set_errno( Error::ERR_DB_INSERT );
            Error::set_errmsg( "Insert failed on Table %s. %s", $arg_table, $wpdb->last_error );
            return FALSE;

		} else {

            Error::set_errno( Errno::OKAY );
            return TRUE; //$wpdb->insert_id;

		}
	
	}

	static function insert( $arg_table, $arg_data ) {

	    global $wpdb;

		$status = $wpdb->insert( $arg_table, $arg_data );
		if (FALSE === $status) {

            Error::set_errno( Error::ERR_DB_INSERT );
            Error::set_errmsg( "Insert failed on Table %s. %s", $arg_table, $wpdb->last_error );
            return FALSE;

		} else {

            Error::set_errno( Errno::OKAY );
            return $wpdb->insert_id;

		}
	
	}

	static function update( $arg_table, $arg_column, $arg_value, $arg_key, $arg_match ) {
		global $wpdb;
		$prepare = $wpdb->prepare( "UPDATE {$arg_table} SET {$arg_column} = '%s' WHERE {$arg_key} = '{$arg_match}';", $arg_value );
        if ( FALSE === $prepare ) {
            Error::set_errno( Error::ERR_DB_PREPARE );
            Error::set_errmsg( "PREPARE failed on UPDATE for Table %s for column %s with value (%s). %s", $arg_table, $arg_column, $arg_value, $wpdb->last_error );
            return FALSE;
        }
		
        $status = $wpdb->query( $prepare );
        if ( FALSE === $status ) {
            Error::set_errno( Error::ERR_DB_UPDATE );
            Error::set_errmsg( "UPDATE failed on Table %s for column %s with value (%s). %s", $arg_table, $arg_column, $arg_value, $wpdb->last_error );
            return FALSE;
        }
	
        return TRUE;
	}

	static function update_all( $arg_table, $arg_column, $arg_value ) {
		global $wpdb;
        $prepare = $wpdb->prepare( "UPDATE {$arg_table} SET {$arg_column} = '%s';", $arg_value );
        if ( FALSE === $prepare ) {
            Error::set_errno( Error::ERR_DB_PREPARE );
            Error::set_errmsg( "PREPARE failed on UPDATE ALL for Table %s for column %s with value (%s). %s", $arg_table, $arg_column, $arg_value, $wpdb->last_error );
            return FALSE;
        }

        $status = $wpdb->query( $wpdb->prepare( "UPDATE {$arg_table} SET {$arg_column} = '%s'", $arg_value ) );
        if ( FALSE === $status ) {
            Error::set_errno( Error::ERR_DB_UPDATE_ALL );
            Error::set_errmsg( "UPDATE ALL failed on Table %s for column %s with value (%s). %s", $arg_table, $arg_column, $arg_value, $wpdb->last_error );
            return FALSE;
        }
        
        return TRUE;
	}

	static function drop_table( $arg_table ) {
		global $wpdb;
		$sql = sprintf( 'DROP TABLE IF EXISTS %s;', $arg_table );
		return $wpdb->query( $sql );
 		//return $wpdb->query( $wpdb->prepare( $sql, $value ) );
	}

	static function delete( $value ) {
		global $wpdb;
		$sql = sprintf( 'DELETE FROM %s WHERE %s = %%s', self::_table(), static::$primary_key );
		return $wpdb->query( $wpdb->prepare( $sql, $value ) );
	}

	static function fetch_all( $arg_table ) {
		global $wpdb;
// 		$sql   = 'SELECT * FROM ' . $arg_table . " ORDER BY `created_at` DESC";
		$sql   = sprintf("SELECT * FROM %s;", $arg_table);
// 		Error::set_errmsg($sql);
// 		Error::set_errno(Error::OKAY);
// 		return FALSE;
		return $wpdb->get_results( $sql, ARRAY_A );
	}

	static function fetch( $arg_table, $arg_key, $arg_match ) {
		global $wpdb;
		$sql   = sprintf("SELECT * FROM %s WHERE %s = '%s'", $arg_table, $arg_key, $arg_match) ;
		$results = $wpdb->get_results( $sql, ARRAY_A );
		return $results;
	}

// 	static function select( $arg_table, $arg_key, $arg_match ) {
// 		global $wpdb;
// 		$sql   = sprintf("SELECT * FROM %s WHERE %s = '%s'", $arg_table, $arg_key, $arg_match) ;
// 		$results = $wpdb->get_results( $sql, ARRAY_A );
// 		return $results;
// 	}

}

// class quicksaves extends WP_Speak_DBImpl {
// 
// 	static $primary_key = 'quicksave_id';
// 
// }
?>
