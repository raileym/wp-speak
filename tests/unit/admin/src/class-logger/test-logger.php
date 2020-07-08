<?php
namespace WP_Speak;

// setting error logging to be active
ini_set( 'log_errors', true );

// setting the logging file in php.ini
ini_set( 'error_log', 'mr-debug-log' );


/**
 * OnAttributeTest Tests
 */
class test_logger extends \WP_UnitTestCase {

    private $logger_arglist = array();

    public function setUp() {
        parent::setUp();
    }


    /*--------------------------------------------------------------*/


    /**
     * @test Nominal test for set_logger_mask.
     */
    public function test_set_logger_mask_01() {

        $tgt_mask = 0x0010;

        Logger::set_logger_mask( $tgt_mask );

        $mask = Logger::get_logger_mask();

        $this->assertEquals( $tgt_mask, $mask );
    }


    /**
     * @test Nominal test for write().
     */
    public function test_write_01() {

        $tgt_mask    = 0x0010;
        $tgt_message = 'Dummy message: ' . __FUNCTION__;

        Error::clear_errlog();
        Error::clear_errmsg();

        Logger::set_logger_mask( $tgt_mask );
        Logger::write( $tgt_mask, $tgt_message, Logger::LOGGER_NO_PRINT );

        $errlog = Error::get_errlog();

        $this->assertEquals( $tgt_message, $errlog );

    }


    /**
     * @test Nominal test for write().
     */
    public function test_write_02() {

        $mask        = 0x0010;
        $other_mask  = 0x0100;
        $tgt_message = 'Dummy message: ' . __FUNCTION__;

        Error::clear_errlog();
        Error::clear_errmsg();

        Logger::set_logger_mask( $mask );
        Logger::write( $other_mask, $tgt_message, Logger::LOGGER_NO_PRINT );

        $errlog = Error::get_errlog();

        $this->assertEquals( '', $errlog );

    }


    /**
     * @test Nominal test for write().
     */
    public function test_write_03() {

        $mask        = 0x0010;
        $tgt_message = array();

        Error::clear_errlog();
        Error::clear_errmsg();

        Logger::set_logger_mask( $mask );

        foreach ( [ 1, 2, 3, 4 ] as $idx => $val ) {
            $tgt_message[ $idx ] = "Dummy message-{$val}: " . __FUNCTION__;
        }

        error_log( 'one' );
        error_log( print_r( $tgt_message, true ) );

        Logger::write( $mask, $tgt_message, Logger::LOGGER_NO_PRINT );

        $errlog = Error::get_errlog();

        $this->assertEquals( trim( print_r( $tgt_message, true ) ), $errlog );

    }


    /**
     * @test Nominal test for write().
     */
    public function test_write_04() {

        $mask        = 0x0010;
        $tgt_message = '';

        Error::clear_errlog();
        Error::clear_errmsg();

        Logger::set_logger_mask( $mask );

        foreach ( [ 1, 2, 3, 4 ] as $idx => $val ) {
            $message      = "Dummy message-{$val}: " . __FUNCTION__;
            $tgt_message .= $message . PHP_EOL;
            Logger::write( $mask, $message, Logger::LOGGER_NO_PRINT );

        }

        $errlog = Error::get_errlog();

        $this->assertEquals( print_r( trim( $tgt_message ), true ), $errlog );

    }


    /**
     * @test Nominal test for write().
     */
    public function test_write_05() {

        $mask        = 0x0010;
        $tgt_message = '';

        Error::clear_errlog();
        Error::clear_errmsg();

        Logger::set_logger_mask( $mask );

        foreach ( [ 1, 2, 3, 4 ] as $idx => $val ) {
            $message      = "Dummy message-{$idx}: " . __FUNCTION__;
            $tgt_message .= $message . PHP_EOL;
            Logger::write( $mask, $message, Logger::LOGGER_PRINT );

        }

        $errlog = Error::get_errlog();

        $this->assertEquals( print_r( '', true ), $errlog );

    }


    /**
     * @test Nominal test for write().
     */
    public function test_write_06() {

        $mask        = 0x0010;
        $tgt_message = '';

        Error::clear_errlog();
        Error::clear_errmsg();

        Logger::set_logger_mask( $mask );

        foreach ( [ 1, 2, 3, 4 ] as $idx_p => $p ) {
            foreach ( [ 1, 2, 3, 4 ] as $idx_n => $n ) {
                foreach ( [ 1, 2, 3, 4 ] as $idx_m => $m ) {
                    $message      = "Messages ({$p}, {$n},{$m}): " . __FUNCTION__;
                    $tgt_message .= $message . PHP_EOL;
                    Logger::write( $mask, $message, Logger::LOGGER_NO_PRINT );

                }
            }
        }

        $errlog = Error::get_errlog();

        $this->assertEquals( trim( print_r( $tgt_message, true ) ), $errlog );

    }

    /**
     * @test Nominal test for write().
     */
    public function test_write_07() {

        $mask        = 0x0010;
        $tgt_message = '';

        Error::clear_errlog();
        Error::clear_errmsg();

        Logger::set_logger_mask( $mask );

        foreach ( [ 1, 2, 3, 4 ] as $idx_p => $p ) {
            foreach ( [ 1, 2, 3, 4 ] as $idx_n => $n ) {
                foreach ( [ 1, 2, 3, 4 ] as $idx_m => $m ) {
                    $message      = "Messages ({$p}, {$n},{$m}): " . __FUNCTION__;
                    $tgt_message .= $message . PHP_EOL;
                    Logger::write( $mask, $message, Logger::LOGGER_NO_PRINT );

                }
            }
        }

        $errlog = Error::get_errlog();

        Error::clear_errlog();

        Logger::write( $mask, $errlog, Logger::LOGGER_PRINT );

        $this->assertEquals( trim( print_r( $tgt_message, true ) ), $errlog );

    }


    /**
     * @test Nominal test for write().
     */
    public function test_write_08() {

        $tgt_mask    = 0x0010;
        $tgt_message = 'Dummy message: ' . __FUNCTION__;

        Error::clear_errlog();
        Error::clear_errmsg();

        Logger::set_logger_mask( $tgt_mask );
        Logger::write( $tgt_mask, $tgt_message, Logger::LOGGER_PRINT );

        $errlog = Error::get_errlog();

        $this->assertEquals( '', $errlog );

    }


    /*--------------------------------------------------------------*/

}

