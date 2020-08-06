<?php
/**
 * Testing for class Table.
 *
 * The following tests include both nominal and error tests.
 *
 * @file
 * @package tests
 */

namespace WP_Speak;

/**
 * Testing for class Table.
 */
class Test_DB extends \WP_UnitTestCase {

    private static $db;
    private static $wpdb;
    private static $error;

    public function setUp() {
        parent::setUp();
        
        self::$db = DB::get_instance();
    }

    /**
     * Nominal: Testing drop_table.
     *
     * @test
     */
    public function test_drop_table_01() {

		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('query')
                   ->with('DROP TABLE IF EXISTS table;')
                   ->willReturn(true);
        
        
        self::$db->set_wpdb(self::$wpdb);

        $result = self::$db->drop_table('table');

        $this->assertTrue( $result );
    }

    /**
     * Nominal: Testing fetch.
     *
     * @test
     */
    public function test_fetch_01() {

        $table = 'table';
        $key   = 'key';
        $match = 'match';

		$sql = sprintf("SELECT * FROM %s WHERE %s = '%s'", $table, $key, $match) ;

		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('get_results')
                   ->with($sql)
                   ->willReturn( true );

        self::$db->set_wpdb(self::$wpdb);

        $result = self::$db->fetch($table, $key, $match);

        $this->assertTrue( $result );
    }

    /**
     * Nominal: Testing fetch_all.
     *
     * @test
     */
    public function test_fetch_all_01() {

        $table = 'table';

		$sql = sprintf("SELECT * FROM %s;", $table);

		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('get_results')
                   ->with($sql)
                   ->willReturn( true );

        self::$db->set_wpdb(self::$wpdb);

        $result = self::$db->fetch_all($table);

        $this->assertTrue( $result );
    }

    /**
     * Nominal: Testing basic set_tag()/tag().
     *
     * @test
     */
    public function test_update_01() {

        $table  = 'table';
        $column = 'column';
        $value  = 'value';
        $key    = 'key';
        $match  = 'match';

		$sql = "UPDATE {$table} SET {$column} = '%s' WHERE {$key} = '{$match}';";

		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('prepare')
                   ->with($sql, $value)
                   ->willReturn( sprintf($sql, $value) );

        self::$wpdb->expects($this->once())
                   ->method('query')
                   ->with( sprintf($sql, $value) )
                   ->willReturn( true );

        self::$db->set_wpdb(self::$wpdb);

        $result = self::$db->update($table, $column, $value, $key, $match);

        $this->assertTrue( $result );
    }

    /**
     * Error: Prepare fails.
     *
     * @test
     */
    public function test_update_E01() {

        $table  = 'table';
        $column = 'column';
        $value  = 'value';
        $key    = 'key';
        $match  = 'match';
        $error  = null;

		$sql = "UPDATE {$table} SET {$column} = '%s' WHERE {$key} = '{$match}';";

		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('prepare')
                   ->with($sql, $value)
                   ->willReturn( FALSE );//sprintf($sql, $value) );

		self::$error = $this->createMock(Error::class);

        self::$error->expects($this->once())
                    ->method('set_errno')
                    ->with( Errno::ERR_NO_PREPARE )
                    ->willReturn( true );
        
        self::$error->expects($this->once())
                    ->method('set_errmsg')
                    ->with( "PREPARE failed on UPDATE for Table %s for column %s with value (%s). %s", $table, $column, $value, $error )
                    ->willReturn( true );
        
        self::$db->set_wpdb(self::$wpdb)
                 ->set_error(self::$error);

        $result = self::$db->update($table, $column, $value, $key, $match);

        $this->assertFalse( $result );
    }

    /**
     * Error: Query fails.
     *
     * @test
     */
    public function test_update_E02() {

        $table  = 'table';
        $column = 'column';
        $value  = 'value';
        $key    = 'key';
        $match  = 'match';
        $error  = null;

		$sql = "UPDATE {$table} SET {$column} = '%s' WHERE {$key} = '{$match}';";

		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('prepare')
                   ->with($sql, $value)
                   ->willReturn( sprintf($sql, $value) );

        self::$wpdb->expects($this->once())
                   ->method('query')
                   ->with( sprintf($sql, $value) )
                   ->willReturn( FALSE );

		self::$error = $this->createMock(Error::class);

        self::$error->expects($this->once())
                    ->method('set_errno')
                    ->with( Errno::ERR_NO_UPDATE )
                    ->willReturn( true );
        
        self::$error->expects($this->once())
                    ->method('set_errmsg')
                    ->with( "UPDATE failed on Table %s for column %s with value (%s). %s", $table, $column, $value, $error )
                    ->willReturn( true );
        
        self::$db->set_wpdb(self::$wpdb)
                 ->set_error(self::$error);

        $result = self::$db->update($table, $column, $value, $key, $match);

        $this->assertFalse( $result );
    }

    /**
     * Nominal: Testing update_all.
     *
     * @test
     */
    public function test_update_all_01() {

        $table  = 'table';
        $column = 'column';
        $value  = 'value';

		$sql = "UPDATE {$table} SET {$column} = '%s';";
        
		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('prepare')
                   ->with($sql, $value)
                   ->willReturn( sprintf($sql, $value) );

        self::$wpdb->expects($this->once())
                   ->method('query')
                   ->with( sprintf($sql, $value) )
                   ->willReturn( true );

        self::$db->set_wpdb(self::$wpdb);

        $result = self::$db->update_all($table, $column, $value);

        $this->assertTrue( $result );
    }

    /**
     * Error: Prepare fails
      *
     * @test
     */
    public function test_update_all_E01() {

        $table  = 'table';
        $column = 'column';
        $value  = 'value';
        $error  = null;

		$sql = "UPDATE {$table} SET {$column} = '%s';";
        
		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('prepare')
                   ->with($sql, $value)
                   ->willReturn( FALSE );

		self::$error = $this->createMock(Error::class);

        self::$error->expects($this->once())
                    ->method('set_errno')
                    ->with( Errno::ERR_NO_PREPARE )
                    ->willReturn( true );
        
        self::$error->expects($this->once())
                    ->method('set_errmsg')
                    ->with( "PREPARE failed on UPDATE ALL for Table %s for column %s with value (%s). %s", $table, $column, $value, $error )
                    ->willReturn( true );
        
        self::$db->set_wpdb(self::$wpdb)
                 ->set_error(self::$error);

        $result = self::$db->update_all($table, $column, $value);

        $this->assertFalse( $result );
    }

    /**
     * Error: Query fails
      *
     * @test
     */
    public function test_update_all_E02() {

        $table  = 'table';
        $column = 'column';
        $value  = 'value';
        $error  = null;

		$sql = "UPDATE {$table} SET {$column} = '%s';";
        
		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('prepare')
                   ->with($sql, $value)
                   ->willReturn( sprintf($sql, $value) );

        self::$wpdb->expects($this->once())
                   ->method('query')
                   ->with( sprintf($sql, $value) )
                   ->willReturn( false );

		self::$error = $this->createMock(Error::class);

        self::$error->expects($this->once())
                    ->method('set_errno')
                    ->with( Errno::ERR_NO_UPDATE_ALL )
                    ->willReturn( true );
        
        self::$error->expects($this->once())
                    ->method('set_errmsg')
                    ->with( "UPDATE ALL failed on Table %s for column %s with value (%s). %s", $table, $column, $value, $error )
                    ->willReturn( true );
        
        self::$db->set_wpdb(self::$wpdb)
                 ->set_error(self::$error);

        $result = self::$db->update_all($table, $column, $value);

        $this->assertFalse( $result );
    }

    /**
     * Nominal: Testing insert.
     *
     * @test
     */
    public function test_insert_01() {

        $table  = 'table';
        $data   = 'data';

		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('insert')
                   ->with($table, $data)
                   ->willReturn( true );

        self::$wpdb->expects($this->once())
                   ->method('insert_id')
                   ->with()
                   ->willReturn( 1 );

		self::$error = $this->createMock(Error::class);

        self::$error->expects($this->once())
                    ->method('set_errno')
                    ->with( Errno::ERR_NO_OKAY )
                    ->willReturn( 1 );
        
        self::$db->set_error(self::$error)
                 ->set_wpdb(self::$wpdb);

        $result = self::$db->insert($table, $data);

        $this->assertEquals( 1, $result );
    }

    /**
     * Error: Insert fails.
     *
     * @test
     */
    public function test_insert_E01() {

        $table  = 'table';
        $data   = 'data';
        $error  = null;

		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('insert')
                   ->with($table, $data)
                   ->willReturn( false );

		self::$error = $this->createMock(Error::class);

        self::$error->expects($this->once())
                    ->method('set_errno')
                    ->with( Errno::ERR_NO_INSERT )
                    ->willReturn( true );
        
        self::$error->expects($this->once())
                    ->method('set_errmsg')
                    ->with( "Insert failed on Table %s. %s", $table, $error )
                    ->willReturn( true );
        
        self::$db->set_error(self::$error)
                 ->set_wpdb(self::$wpdb);

        $result = self::$db->insert($table, $data);

        $this->assertFalse( $result );
    }

    /**
     * Nominal: Testing insert_unique.
     *
     * @test
     */
    public function test_insert_unique_01() {

        $table = 'table';
        $data  = 'data';
        $key   = 'key';
        $match = 'match';

		$sql   = "SELECT * FROM {$table} WHERE {$key} = '{$match}'";

		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('get_results')
                   ->with($sql)
                   ->willReturn( false );

        self::$wpdb->expects($this->once())
                   ->method('insert')
                   ->with($table, $data)
                   ->willReturn( true );

		self::$error = $this->createMock(Error::class);

        self::$error->expects($this->once())
                    ->method('set_errno')
                    ->with( Errno::ERR_NO_OKAY )
                    ->willReturn( true );
        
        self::$db->set_error(self::$error)
                 ->set_wpdb(self::$wpdb);

        $result = self::$db->insert_unique($table, $key, $match, $data);

        $this->assertTrue( $result );
    }

    /**
     * Nominal: Testing insert_unique.
     *
     * @test
     */
    public function test_insert_unique_E01() {

        $table = 'table';
        $data  = 'data';
        $key   = 'key';
        $match = 'match';

		$sql   = "SELECT * FROM {$table} WHERE {$key} = '{$match}'";

		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('get_results')
                   ->with($sql)
                   ->willReturn( array( 'not-empty' ) );

        self::$db->set_wpdb(self::$wpdb);

        $result = self::$db->insert_unique($table, $key, $match, $data);

        $this->assertTrue( $result );
    }

    /**
     * Nominal: Testing insert_unique.
     *
     * @test
     */
    public function test_insert_unique_E02() {

        $table = 'table';
        $data  = 'data';
        $key   = 'key';
        $match = 'match';
        $error = null;

		$sql   = "SELECT * FROM {$table} WHERE {$key} = '{$match}'";

		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('get_results')
                   ->with($sql)
                   ->willReturn( false );

        self::$wpdb->expects($this->once())
                   ->method('insert')
                   ->with($table, $data)
                   ->willReturn( false );

		self::$error = $this->createMock(Error::class);

        self::$error->expects($this->once())
                    ->method('set_errno')
                    ->with( Errno::ERR_NO_INSERT )
                    ->willReturn( true );
        
        self::$error->expects($this->once())
                    ->method('set_errmsg')
                    ->with( "Insert failed on Table %s. %s", $table, $error )
                    ->willReturn( true );
        
        self::$db->set_error(self::$error)
                 ->set_wpdb(self::$wpdb);

        $result = self::$db->insert_unique($table, $key, $match, $data);

        $this->assertFalse( $result );
    }

    /**
     * Nominal: Testing dbdelta.
     *
     * @test
     */
    public function test_dbdelta_01() {

        $table = 'table';
        $data  = 'data';
        $key   = 'key';
        $match = 'match';

		$sql   = "Not important";

		self::$wpdb = $this->createMock(WPDB::class);

        self::$wpdb->expects($this->once())
                   ->method('dbdelta')
                   ->with($sql)
                   ->willReturn( true );

        self::$db->set_wpdb(self::$wpdb);

        $result = self::$db->dbdelta($sql);

        $this->assertTrue( $result );
    }

}

