<?php
/**
 * Testing for class Registry.
 *
 * The following tests include both nominal and error tests.
 *
 * @file
 * @package tests
 */

namespace WP_Speak;

// setting error logging to be active.
ini_set( 'log_errors', true );

// setting the logging file in php.ini.
ini_set( 'error_log', 'mr-debug-log' );

use PHPUnit\Framework\TestCase;
//use phpmock\phpunit\PHPMock;

/**
 * Testing for class Registry.
 */
//class Test_Registry extends \PHPUnit_Framework_TestCase {
class Test_Registry extends TestCase {

    private static $logger;
    private static $wp_option;
    private static $array_registry;
    private static $table;




    //    use PHPMock;

    public function setUp() {
        parent::setUp();
        
		self::$logger         = $this->createMock(Logger::class);

		self::$wp_option      = $this->createMock(WP_Option::class);

		self::$array_registry = $this->createMock(Array_Registry::class);

		self::$table          = $this->createMock(Table::class);

    }

    /**
     * Error: Testing init_registry() on bad option.
     *
     * @test
     */
    public function test_init_registry_E01() {

        self::$logger->expects($this->exactly(3))
                     ->method('log')
                     ->withConsecutive(
                         [Logmask::$mask['log_registry'], 'init_registry(bogus)'],
                         [Logmask::$mask['log_registry'], 'init_registry'],
                         [Logmask::$mask['log_registry'], 'init_registry(bogus). get_option() returns \'false\'.']
                     );
        
        self::$wp_option->expects($this->once())
                        ->method('get_option')
                        ->with('bogus')
                        ->willReturn(false);
        
        $registry = Registry::get_instance()
                  ->set_wp_option( self::$wp_option )
                  ->set_logger( self::$logger )
                  ->set_mask(Logmask::$mask['log_registry']);
        
        $registry->init_registry('bogus', array());
    }

    /**
     * Nominal: Testing init_registry() on empty option.
     *
     * @test
     */
    public function test_init_registry_01() {

        self::$logger->expects($this->exactly(5))
                     ->method('log')
                     ->withConsecutive(
                         [Logmask::$mask['log_registry'], 'init_registry(bogus)'],
                         [Logmask::$mask['log_registry'], 'init_registry'],
                         [Logmask::$mask['log_registry'], 'init_registry(bogus). get_option() returns \'empty\'.'],
                         [Logmask::$mask['log_registry'], 'MASK OPTIONS on init: '],
                         [Logmask::$mask['log_registry'], '-2-----------------------------------']
                     );
        

        self::$wp_option->expects($this->once())
                        ->method('get_option')
                        ->with('bogus')
                        ->willReturn(array());
        
        $registry = Registry::get_instance()
                  ->set_wp_option( self::$wp_option )
                  ->set_logger( self::$logger )
                  ->set_mask(Logmask::$mask['log_registry']);
        
        $registry->init_registry('bogus', array());
    }


    /**
     * Nominal: Testing init_registry() on fake option.
     *
     * @test
     */
    public function test_init_registry_02() {

        self::$logger->expects($this->exactly(8))
                     ->method('log')
                     ->withConsecutive(
                         [Logmask::$mask['log_registry'], 'init_registry(fake)'],
                         [Logmask::$mask['log_registry'], 'init_registry'],
                         [Logmask::$mask['log_registry'], 'MASK OPTIONS on init: '],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-01 = FAKE-01'],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-02 = FAKE-02'],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-03 = FAKE-03'],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-04 = FAKE-04'],
                         [Logmask::$mask['log_registry'], '-2-----------------------------------']
                     );
        
        self::$wp_option->expects($this->once())
                        ->method('get_option')
                        ->with('fake')
                        ->willReturn(array(
                            'fake-01'=> 'FAKE-01', 
                            'fake-02'=> 'FAKE-02', 
                            'fake-03'=> 'FAKE-03', 
                            'fake-04'=> 'FAKE-04'));
        
        self::$array_registry->expects($this->exactly(4))
                             ->method('set')
                             ->willReturn('Dont care')
                             ->withConsecutive(
                                 ['fake-01', 'FAKE-01'],
                                 ['fake-02', 'FAKE-02'],
                                 ['fake-03', 'FAKE-03'],
                                 ['fake-04', 'FAKE-04']
                             );
        
        $registry = Registry::get_instance()
                  ->set_array_registry( self::$array_registry )
                  ->set_wp_option( self::$wp_option )
                  ->set_logger( self::$logger )
                  ->set_mask(Logmask::$mask['log_registry']);
        
        $registry->init_registry('fake', 
                                 array('fake-01', 
                                       'fake-02',
                                       'fake-03',
                                       'fake-04'));
    }
    
    /**
     * Nominal: Testing init_registry() on fake option.
     *
     * @test
     */
    public function test_init_registry_03() {

        self::$logger->expects($this->exactly(8))
                     ->method('log')
                     ->withConsecutive(
                         [Logmask::$mask['log_registry'], 'init_registry(fake)'],
                         [Logmask::$mask['log_registry'], 'init_registry'],
                         [Logmask::$mask['log_registry'], 'MASK OPTIONS on init: '],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-01 = FAKE-01'],
                         [Logmask::$mask['log_registry'], 'Set Registry. password = ********'],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-03 = FAKE-03'],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-04 = FAKE-04'],
                         [Logmask::$mask['log_registry'], '-2-----------------------------------']
                     );
        
        self::$wp_option->expects($this->once())
                        ->method('get_option')
                        ->with('fake')
                        ->willReturn(array(
                            'fake-01'=> 'FAKE-01', 
                            'password'=> 'FAKE-02', 
                            'fake-03'=> 'FAKE-03', 
                            'fake-04'=> 'FAKE-04'));
        
        self::$array_registry->expects($this->exactly(4))
                             ->method('set')
                             ->willReturn('Dont care')
                             ->withConsecutive(
                                 ['fake-01', 'FAKE-01'],
                                 ['password', 'FAKE-02'],
                                 ['fake-03', 'FAKE-03'],
                                 ['fake-04', 'FAKE-04']
                             );
        
        $registry = Registry::get_instance()
                  ->set_array_registry( self::$array_registry )
                  ->set_wp_option( self::$wp_option )
                  ->set_logger( self::$logger )
                  ->set_mask(Logmask::$mask['log_registry']);
        
        $registry->init_registry('fake', 
                                 array('fake-01', 
                                       'password',
                                       'fake-03',
                                       'fake-04'));
    }
    
    /**
     * Nominal: Testing init_registry() on fake option.
     *
     * @test
     */
    public function test_init_table_registry_01() {

        $expected = array();

        /**
         * Talk about threading the needle.
         */
        foreach( ['1', '2', '3', '4'] as $key=>$val_no ) {
            $row = array();
            foreach( ['a', 'b', 'c'] as $val_alpha ) {
                $row[$val_alpha . $val_no] = $val_alpha . $val_no;
            }

            // Start with the fake table name.
            $table_name = 'fake-id-' . $val_no;

            // Add the one row-element that is tied
            // to the table name, so to speak.
            $row['fake-id'] = $table_name;
            $expected[$table_name] = $row;
        }

        self::$table->expects($this->once())
                    ->method('id')
                    ->willReturn(
                        'fake-id');
        
        self::$table->expects($this->once())
                    ->method('tag')
                    ->willReturn(
                        'fake-tag');

        self::$table->expects($this->once())
                    ->method('fetch_all')
                    ->willReturn(
                        $expected);

        self::$array_registry->expects($this->once())
                             ->method('set')
                             ->willReturn(array(['Dont care']))
                             ->with( 'fake-tag', $expected );
        
        $registry = Registry::get_instance()
                  ->set_array_registry( self::$array_registry );
        
        $registry->init_table_registry(self::$table);

    }
}
