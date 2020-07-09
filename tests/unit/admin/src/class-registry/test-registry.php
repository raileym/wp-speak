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

/**
 * Testing for class Registry.
 */
class Test_Registry extends \WP_UnitTestCase {

	private $logger_methodlist = array(
        'set_logger_mask', 
        'get_logger_mask', 
        'print_r',
        'write',
        'log');
	
    /**
     * Nominal: Testing the basic set_errnm()/get_errnm().
     *
     * @test
     */
    public function test_init_registry_01() {

        $registry = Registry::get_instance();

		$logger = $this->createMock('WP_Speak\Logger', $this->logger_methodlist);

		$logger->expects($this->any())
                 ->method('log')
             	 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('buildtype')
                  ->will($this->returnValue('DontCare'));
		
		$validate->expects($this->any())
                 ->method('color')
                 ->will($this->returnValue('DontCare'));


        $tgt_errnm = Error::ERR_NM_PREPARE;

        Error::set_errnm( $tgt_errnm );

        $errnm = Error::get_errnm();

        $this->assertEquals( $tgt_errnm, $errnm );
    }

}
