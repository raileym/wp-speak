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
class Test_Table extends \WP_UnitTestCase {

    private static $table;

    public function setUp() {
        parent::setUp();
        
        self::$table       = Table::get_instance();
    }

    /**
     * Nominal: Testing basic set_tag()/tag().
     *
     * @test
     */
    public function test_create_01() {

        global $wpdb;

        $tag = 'TAG';
        $columns = SQL::$columns['img'];
        $sql = SQL::$create_table_sql['img'];

        $table = self::$table->create($tag, $columns, $sql);

        $this->assertEquals( $tag, $table->tag() );
        $this->assertEquals( $tag.'_id', $table->id() );
        $this->assertEquals( $wpdb->prefix . "speak_" . $tag, $table->table() );
        $this->assertEquals( $wpdb->get_charset_collate(), $table->charset() );
        $this->assertEquals( $columns, $table->columns() );
        $this->assertEquals( $sql, $table->sql() );
    }

    /**
     * Nominal: Testing basic set_tag()/tag().
     *
     * @test
     */
    public function test_install_01() {

        global $wpdb;

        $tag = 'TAG';
        $src = 'https://www.cnn.com';
        $columns = SQL::$columns['img'];
        $sql = SQL::$create_table_sql['img'];

        $image = array();
        
        $image['status']      = 'No status';
        $image['src']         = 'http://google.com';
        $image['alt']         = "No ALT";
        $image['img']         = "<img src='{$src}'></img>";
        $image['path']        = str_replace(array("http://", "https://"), array("", ""), $image['src']);
        $image['title']       = basename( $image['src'] );
        $image['image_id']    = md5( $image['src'] );

        $table = self::$table->create($tag, $columns, $sql);

        $this->assertTrue( $table->validate( $image ) );
            
    }

}

