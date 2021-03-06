<?php
namespace WP_Speak;

class Table extends Basic
{
    protected static $instance;

	private static $db;
	private $charset;
	private $id;
	private $tag;
	private $table;
	private $columns;
	private $sql;
	
	public function __construct( ) { }
    
    public function create( $arg_tag, $arg_columns, $arg_sql) {

        global $wpdb;

        $self = new self();

        $self->set_tag( $arg_tag )
             ->set_id( $arg_tag . "_id" )
             ->set_table( $wpdb->prefix . "speak_" . $arg_tag )
             ->set_charset( $wpdb->get_charset_collate() )
             ->set_sql ( $arg_sql )
             ->set_columns( $arg_columns );
        
        return $self;
    }

	public function table() {
	    return $this->table;
	}
	
	public function charset() {
	    return $this->charset;
	}
	
	public function id() {
	    return $this->id;
	}
	
	public function columns() {
	    return $this->columns;
	}
	
	public function tag() {
	    return $this->tag;
	}
	
	public function sql() {
	    return $this->sql;
	}
	
	public function fetch( $arg_key, $arg_match ) {
        if ( !$results = self::$db->fetch($this->table, $arg_key, $arg_match) ) {
            return FALSE;
        }

        return $results;        
	}

// 	public function select( $arg_match ) {
//         if ( !$id = self::$db->fetch($this->table, $this->id, $arg_match) ) {
//             return FALSE;
//         }
// 
//         return $id;        
// 	}

    public function update( $arg_column, $arg_value, $arg_key, $arg_match ) {
		if ( !self::$db->update( $this->table, $arg_column, $arg_value, $arg_key, $arg_match ) ) {
		    return FALSE;
		}
		
		return TRUE;
	}
	
    public function update_all( $arg_column, $arg_value ) {
		if ( !self::$db->update_all( $this->table, $arg_column, $arg_value ) ) {
		    return FALSE;
		}
		
		return TRUE;
	}
	
	public function insert_unique($arg_list) {
        
        if ( !self::validate($arg_list) ) {
            return FALSE;            
        }
        
        if ( !self::$db->insert_unique($this->table, $this->id, $arg_list[$this->id], $arg_list) ) {
            return FALSE;
        }

        return TRUE;//$id;        
	}

	public function insert($arg_list) {
        
        if ( !self::validate($arg_list) ) {
            return FALSE;            
        }
        
        if ( !self::$db->insert($this->table, $arg_list) ) {
            return FALSE;
        }

        return TRUE;//$id;        
	}

	public function fetch_all() {
        
        if ( !$results = self::$db->fetch_all($this->table) ) {
            return FALSE;
        }

        return $results;        
	}

	public function install($arg_tag) {

        global $wp_speak_img_db_version;

        $sql = sprintf( $this->sql, $this->table, $this->charset);

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        self::$db->dbDelta( $sql );

        //add_option( 'wp_speak_img_db_version', $wp_speak_img_db_version );
	}
	
	public function uninstall($arg_tag) {
        global $wpdb;

        self::$db->drop_table( $this->table );

        //delete_option( 'wp_speak_img_db_version' );
	}
	
    public function validate($arg_list) {
    
        foreach ($arg_list as $key => $arg) {
            if ( !in_array($key, $this->columns) ) {
                self::$error->set_errmsg("Column '%s' not found in table '%s'.", $key, $this->table);
                self::$error->set_errno( Errno::ERR_NO_BAD_COLUMN );
                return FALSE;
            }
        }
        
        foreach ($this->columns as $column) {
            if ( !array_key_exists($column, $arg_list) ) {
                self::$error->set_errmsg("Value for '%s' not found on insert in table '%s'.", $column, $this->table);
                self::$error->set_errno( Errno::ERR_NO_BAD_INSERT );
                return FALSE;
            }
        }
        
        foreach ($arg_list as $arg => $value) {
            if ( is_null($value) ) {
                self::$error->set_errmsg("Null values are disallowed for column '%s' on insert in table '%s'.", $arg, $this->table);
                self::$error->set_errno( Errno::ERR_NO_NULL_VALUE );
                return FALSE;
            }
        }
        
        foreach ($arg_list as $arg => $value) {
            if ( is_null($value) || 0 === strlen($value) ) {
                self::$error->set_errmsg("Empty strings are disallowed for column '%s' on insert in table '%s'.", $arg, $this->table);
                self::$error->set_errno( Errno::ERR_NO_EMPTY_STRING );
                return FALSE;
            }
        }
        
        return TRUE;
    }

	public function set_db(DB $arg_db)
	{
		assert( !is_null( $arg_db ) );
		self::$db = $arg_db;
		return $this;
	}
	
	private function set_tag($arg_tag)
	{
		assert( !is_null( $arg_tag ) );
		$this->tag = $arg_tag;
		return $this;
	}
	
	private function set_id($arg_id)
	{
		assert( !is_null( $arg_id ) );
		$this->id = $arg_id;
		return $this;
	}
	
	private function set_table($arg_table)
	{
		assert( !is_null( $arg_table ) );
		$this->table = $arg_table;
		return $this;
	}
	
	private function set_charset($arg_charset)
	{
		assert( !is_null( $arg_charset ) );
		$this->charset = $arg_charset;
		return $this;
	}
	
	private function set_columns($arg_columns)
	{
		assert( !is_null( $arg_columns ) );
		$this->columns = $arg_columns;
		return $this;
	}
	
	private function set_sql($arg_sql)
	{
		assert( !is_null( $arg_sql ) );
		$this->sql = $arg_sql;
		return $this;
	}
	
}

?>
