<?php
namespace WP_Speak;

// See https://premium.wpmudev.org/blog/activate-deactivate-uninstall-hooks/

//global $wp_speak_img_db_version;
//$wp_speak_img_db_version = '1.0'; 

class Factory_Table extends Basic
{
    protected static $instance;

	private static $db;
	private static $tables;

	private $charset;
	private $id;
	private $tag;
	private $table;
	private $columns;
	private $create_table;
	
	
	const _COLUMNS = array(
	
	    "img" => array(
            "attr_alt",
            "alt",
            "attr_class",
            "attr_id",
            "use_alt",
            "img_id",
            "status",
            "wp_post_id",
            "wp_post_title"
            ),

        "image" => array(
            "src",
            "alt",
            "path",
            "img",
            "image_id",
            "status",
            "title"
            ),

        "img_image" => array(
            "img_image_id",
            "img_id",
            "image_id",
            "status"
            )

	    );
	    
	const _CREATE_TABLE = array(
	
    	"img" => "CREATE TABLE %s (
            id            mediumint(9)  NOT NULL AUTO_INCREMENT,
            attr_alt      varchar(1024) NOT NULL,
            alt           varchar(1024) NOT NULL,
            attr_class    varchar(255)  NOT NULL,
            attr_id       varchar(255)  NOT NULL,
            use_alt       varchar(255)  NOT NULL,
            img_id        varchar(255)  NOT NULL,
            status        varchar(8)    NOT NULL,
            wp_post_id    bigint(20)    NOT NULL,
            wp_post_title varchar(1024) NOT NULL,
            PRIMARY KEY ID (id)
            ) %s;",
            
        "image" => "CREATE TABLE %s (
            id          mediumint(9)  NOT NULL AUTO_INCREMENT,
            src         varchar(1024) NOT NULL,
            alt         varchar(1024) NOT NULL,
            path        varchar(1024) NOT NULL,
            img         varchar(1024) NOT NULL,
            image_id    varchar(255)  NOT NULL,
            status      varchar(8)    NOT NULL,
            title       varchar(255)  NOT NULL,
            PRIMARY KEY ID (id)
            ) %s;",
            
        "img_image" => "CREATE TABLE %s (
            id           mediumint(9) NOT NULL AUTO_INCREMENT,
            img_image_id varchar(32)  NOT NULL,
            img_id       varchar(32)  NOT NULL,
            image_id     varchar(32)  NOT NULL,
            status       varchar(8)   NOT NULL,
            PRIMARY KEY id (id)
            ) %s;"

    );
    	
	protected function __construct($arg_tag = NULL) { 
	    global $wpdb;
	    
	    if (NULL !== $arg_tag) {
            $this->_tag          = $arg_tag;
            $this->_id           = $arg_tag . "_id";
            $this->_table        = $wpdb->prefix . "speak_" . $arg_tag;
            $this->_charset      = $wpdb->get_charset_collate();
            $this->_columns      = self::_COLUMNS[$arg_tag];
            $this->_create_table = self::_CREATE_TABLE[$arg_tag];
	    }
	    
	    self::$tables = array();
	}
	
	public function create($arg_tag) {
	    $self = new self($arg_tag);
	    
	    self::$tables[$arg_tag] = $self;
	    
	    return new self($arg_tag);
	}
	
	public function get($arg_tag) {
	    return self::$tables[$arg_tag];
	}
	
	public function table() {
	    return $this->_table;
	}
	
	public function id() {
	    return $this->_id;
	}
	
	public function tag() {
	    return $this->_tag;
	}
	
	public function fetch( $arg_key, $arg_match ) {
        if ( !$results = self::$db->fetch($this->_table, $arg_key, $arg_match) ) {
            return FALSE;
        }

        return $results;        
	}

// 	public function select( $arg_match ) {
//         if ( !$id = self::$db->fetch($this->_table, $this->_id, $arg_match) ) {
//             return FALSE;
//         }
// 
//         return $id;        
// 	}

    public function update( $arg_column, $arg_value, $arg_key, $arg_match ) {
		if ( !self::$db->update( $this->_table, $arg_column, $arg_value, $arg_key, $arg_match ) ) {
		    return FALSE;
		}
		
		return TRUE;
	}
	
    public function update_all( $arg_column, $arg_value ) {
		if ( !self::$db->update_all( $this->_table, $arg_column, $arg_value ) ) {
		    return FALSE;
		}
		
		return TRUE;
	}
	
	public function insert_unique($arg_list) {
        
        if ( !self::validate($arg_list) ) {
            return FALSE;            
        }
        
        if ( !self::$db->insert_unique($this->_table, $this->_id, $arg_list[$this->_id], $arg_list) ) {
            return FALSE;
        }

        return TRUE;//$id;        
	}

	public function insert($arg_list) {
        
        if ( !self::validate($arg_list) ) {
            return FALSE;            
        }
        
        if ( !self::$db->insert($this->_table, $arg_list) ) {
            return FALSE;
        }

        return TRUE;//$id;        
	}

	public function fetch_all() {
        
        if ( !$results = self::$db->fetch_all($this->_table) ) {
            return FALSE;
        }

        return $results;        
	}

	public function install($arg_tag) {
        global $wpdb;
        global $wp_speak_img_db_version;

        $table   = $wpdb->prefix . "speak_" . $arg_tag;
        $charset = $wpdb->get_charset_collate();
        
        $sql = sprintf(self::_CREATE_TABLE[$arg_tag], $table, $charset);

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql );

        //add_option( 'wp_speak_img_db_version', $wp_speak_img_db_version );
	}
	
	public function uninstall($arg_tag) {
        global $wpdb;

        $table   = $wpdb->prefix . "speak_" . $arg_tag;
        self::$db->drop_table( $table );

        //delete_option( 'wp_speak_img_db_version' );
	}
	
    public function validate($arg_list) {
    
        foreach ($arg_list as $key => $arg) {
            if ( !in_array($key, $this->_columns) ) {
                Error::set_errmsg("Column '%s' not found in table '%s'.", $key, $this->_table);
                Error::set_errno( Error::ERR_DB_BAD_COLUMN );
                return FALSE;
            }
        }
        
        foreach ($this->_columns as $column) {
            if ( !array_key_exists($column, $arg_list) ) {
                Error::set_errmsg("Value for '%s' not found on insert in table '%s'.", $column, $this->_table);
                Error::set_errno( Error::ERR_DB_BAD_INSERT );
                return FALSE;
            }
        }
        
        foreach ($arg_list as $arg => $value) {
            if ( is_null($value) ) {
                Error::set_errmsg("Null values are disallowed for column '%s' on insert in table '%s'.", $arg, $this->_table);
                Error::set_errno( Error::ERR_DB_NULL_VALUE );
                return FALSE;
            }
        }
        
        foreach ($arg_list as $arg => $value) {
            if ( is_null($value) || 0 === strlen($value) ) {
                Error::set_errmsg("Empty strings are disallowed for column '%s' on insert in table '%s'.", $arg, $this->_table);
                Error::set_errno( Error::ERR_DB_EMPTY_STRING );
                return FALSE;
            }
        }
        
        return TRUE;
    }

	public function set_db(DB $arg_db)
	{
		//assert( '!is_null($arg_logger)' );
		self::$db = $arg_db;
		return $this;
	}
	
}

?>
