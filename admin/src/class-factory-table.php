<?php
namespace WP_Speak;

class Factory_Table extends Basic
{
    protected static $instance;

	private static $db;

    private static $table;

	private static $tables = array();

	protected function __construct( ) { }
	
	public function create($arg_tag) {

        if ( !array_key_exists( $arg_tag, self::$tables ) ) {

            $table = self::$table->create(
                $arg_tag,
                SQL::$columns[$arg_tag],
                SQL::$create_table_sql[$arg_tag] );

            self::$tables[$arg_tag] = $table;

        }

	    return self::$tables[$arg_tag];
	}
	
	public function set_table($arg_table)
	{
		assert( !is_null( $arg_table ) );
		self::$table = $arg_table;
		return $this;
	}
	
}

?>
