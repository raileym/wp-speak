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
    private static $table;
    private static $registry_datastore;




    //    use PHPMock;

    public function setUp() {
        parent::setUp();
        
		self::$logger             = $this->createMock(Logger::class);

		self::$wp_option          = $this->createMock(WP_Option::class);

		self::$table              = $this->createMock(Table::class);

        self::$registry_datastore = $this->createMock(Registry_Datastore::class);
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
                        ->method('get')
                        ->with('bogus')
                        ->willReturn(false);
        
        $registry = Registry::get_instance()
                  ->set_wp_option( self::$wp_option )
                  ->set_logger( self::$logger )
                  ->set_mask(Logmask::$mask['log_registry']);
        
        $registry->init_registry('bogus', array());
    }

    /**
     * Error: Testing init_registry() on empty option.
     *
     * @test
     */
    public function test_init_registry_E02() {

        self::$logger->expects($this->exactly(4))
                     ->method('log')
                     ->withConsecutive(
                         [Logmask::$mask['log_registry'], 'init_registry(bogus)'],
                         [Logmask::$mask['log_registry'], 'init_registry'],
                         [Logmask::$mask['log_registry'], 'init_registry(bogus). get_option() returns \'empty\'.'],
                         [Logmask::$mask['log_registry'], 'From OPTIONS on init: ']
                     );

        self::$wp_option->expects($this->once())
                        ->method('get')
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

        self::$logger->expects($this->exactly(7))
                     ->method('log')
                     ->withConsecutive(
                         [Logmask::$mask['log_registry'], 'init_registry(fake)'],
                         [Logmask::$mask['log_registry'], 'init_registry'],
                         [Logmask::$mask['log_registry'], 'From OPTIONS on init: '],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-01 = FAKE-01'],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-02 = FAKE-02'],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-03 = FAKE-03'],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-04 = FAKE-04']
                     );
        
        $option = array(
            'fake-01'=> 'FAKE-01', 
            'fake-02'=> 'FAKE-02', 
            'fake-03'=> 'FAKE-03', 
            'fake-04'=> 'FAKE-04');
        
        self::$wp_option
            ->expects($this->once())
            ->method('get')
            ->with('fake')
            ->willReturn($option);
        
        $registry = Registry::get_instance()
                  ->set_registry_datastore( self::$registry_datastore )
                  ->set_wp_option( self::$wp_option )
                  ->set_logger( self::$logger )
                  ->set_mask(Logmask::$mask['log_registry']);
        
        self::$registry_datastore
            ->expects($this->exactly(5))
            ->method('set')
            ->willReturn('Dont care')
            ->withConsecutive(
                ['fake',    $option],
                ['fake-01', 'FAKE-01'],
                ['fake-02', 'FAKE-02'],
                ['fake-03', 'FAKE-03'],
                ['fake-04', 'FAKE-04']
            );
        
        $registry
            ->init_registry('fake', 
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

        $option = array(
            'fake-01'=> 'FAKE-01', 
            'password'=> 'FAKE-02', 
            'fake-03'=> 'FAKE-03', 
            'fake-04'=> 'FAKE-04');
                
        self::$logger->expects($this->exactly(7))
                     ->method('log')
                     ->withConsecutive(
                         [Logmask::$mask['log_registry'], 'init_registry(fake)'],
                         [Logmask::$mask['log_registry'], 'init_registry'],
                         [Logmask::$mask['log_registry'], 'From OPTIONS on init: '],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-01 = FAKE-01'],
                         [Logmask::$mask['log_registry'], 'Set Registry. password = ********'],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-03 = FAKE-03'],
                         [Logmask::$mask['log_registry'], 'Set Registry. fake-04 = FAKE-04']
                     );
        
        self::$wp_option->expects($this->once())
                        ->method('get')
                        ->with('fake')
                        ->willReturn($option);
        
        self::$registry_datastore
            ->expects($this->exactly(5))
            ->method('set')
            ->willReturn('Dont care')
            ->withConsecutive(
                ['fake',    $option],
                ['fake-01', 'FAKE-01'],
                ['password', 'FAKE-02'],
                ['fake-03', 'FAKE-03'],
                ['fake-04', 'FAKE-04']
            );
        
        $registry = Registry::get_instance()
                  ->set_registry_datastore( self::$registry_datastore )
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
    public function test_update_registry_01() {

        $name_list = array(
            'fake-01',
            'password',
            'fake-03',
            'fake-04'
        );

        $output = array(
            'fake-01'=> 'FAKE-01', 
            'password'=> 'FAKE-02', 
            'fake-03'=> 'FAKE-03', 
            'fake-04'=> 'FAKE-04');
                
        self::$logger->expects($this->exactly(7))
                     ->method('log')
                     ->withConsecutive(
                         [Logmask::$mask['log_registry'], 'update_registry(fake)'],
                         [Logmask::$mask['log_registry'], 'update_registry'],
                         [Logmask::$mask['log_registry'], 'update_registry'],
                         [Logmask::$mask['log_registry'], 'Update Registry. fake-01 = FAKE-01'],
                         [Logmask::$mask['log_registry'], 'Update Registry. password = ********'],
                         [Logmask::$mask['log_registry'], 'Update Registry. fake-03 = FAKE-03'],
                         [Logmask::$mask['log_registry'], 'Update Registry. fake-04 = FAKE-04']
                     );
        
        self::$registry_datastore
            ->expects($this->exactly(5))
            ->method('set')
            ->willReturn('Dont care')
            ->withConsecutive(
                ['fake',    $output],
                ['fake-01', 'FAKE-01'],
                ['password', 'FAKE-02'],
                ['fake-03', 'FAKE-03'],
                ['fake-04', 'FAKE-04']
            );
        
        $registry = Registry::get_instance()
                  ->set_registry_datastore( self::$registry_datastore )
                  ->set_wp_option( self::$wp_option )
                  ->set_logger( self::$logger )
                  ->set_mask(Logmask::$mask['log_registry']);
        
        $registry->update_registry(
            "fake",
            $output,
            $name_list);

    }
    
}
