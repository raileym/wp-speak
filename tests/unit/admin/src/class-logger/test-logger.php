<?php
/**
 * Testing for class Logger.
 *
 * The following tests include both nominal and error tests.
 *
 * @file
 * @package tests
 */

namespace WP_Speak;

/**
 * Testing for class Logger.
 */
class Test_Logger extends \WP_UnitTestCase {

    private static $logger;
    private static $error;

    public function setUp() {
        parent::setUp();
        
        self::$logger = Logger::get_instance();
        self::$error = Error::get_instance();
    }

    /**
     * Nominal: Testing basic set_logger_mask()/get_logger_mask().
     *
     * @test
     */
    public function test_set_logger_mask_01() {

        $tgt_mask = 0x0010;

        self::$logger->set_logger_mask( $tgt_mask );

        $mask = self::$logger->get_logger_mask();

        $this->assertEquals( $tgt_mask, $mask );
    }


    /**
     * Nominal: Testing single write() with dummy message.
     *
     * @test
     */
    public function test_write_01() {

        $tgt_mask    = 0x0010;
        $tgt_message = 'Dummy message: ' . __FUNCTION__;

        self::$error->clear_errlog();
        self::$error->clear_errmsg();

        self::$logger->set_logger_mask( $tgt_mask );
        self::$logger->write( $tgt_mask, $tgt_message, Logger::LOGGER_NO_PRINT );

        $errlog = self::$error->get_errlog();

        $this->assertEquals( $tgt_message, $errlog );

    }


    /**
     * Nominal: Testing single write() with wrong mask.
     *
     * @test
     */
    public function test_write_02() {

        $mask        = 0x0010;
        $other_mask  = 0x0100;
        $tgt_message = 'Dummy message: ' . __FUNCTION__;

        self::$error->clear_errlog();
        self::$error->clear_errmsg();

        self::$logger->set_logger_mask( $mask );
        self::$logger->write( $other_mask, $tgt_message, Logger::LOGGER_NO_PRINT );

        $errlog = self::$error->get_errlog();

        $this->assertEquals( '', $errlog );

    }


    /**
     * Nominal: Testing write() with an array of messages.
     *
     * @test
     */
    public function test_write_03() {

        $mask        = 0x0010;
        $tgt_message = array();

        self::$error->clear_errlog();
        self::$error->clear_errmsg();

        self::$logger->set_logger_mask( $mask );

        foreach ( [ 1, 2, 3, 4 ] as $idx => $val ) {
            $tgt_message[ $idx ] = "Dummy message-{$val}: " . __FUNCTION__;
        }

        self::$logger->write( $mask, $tgt_message, Logger::LOGGER_NO_PRINT );

        $errlog = self::$error->get_errlog();

        $this->assertEquals( trim( print_r( $tgt_message, true ) ), $errlog );

    }


    /**
     * Nominal: Testing write() with multiple messages.
     *
     * @test
     */
    public function test_write_04() {

        $mask        = 0x0010;
        $tgt_message = '';

        self::$error->clear_errlog();
        self::$error->clear_errmsg();

        self::$logger->set_logger_mask( $mask );

        foreach ( [ 1, 2, 3, 4 ] as $idx => $val ) {
            $message      = "Dummy message-{$val}: " . __FUNCTION__;
            $tgt_message .= $message . PHP_EOL;
            self::$logger->write( $mask, $message, Logger::LOGGER_NO_PRINT );

        }

        $errlog = self::$error->get_errlog();

        $this->assertEquals( print_r( trim( $tgt_message ), true ), $errlog );

    }


    /**
     * Nominal: Testing write() with multiple messages printed to errlog.
     *
     * @test Nominal test for write().
     */
    public function test_write_05() {

        $mask        = 0x0010;
        $tgt_message = '';

        self::$error->clear_errlog();
        self::$error->clear_errmsg();

        self::$logger->set_logger_mask( $mask );

        foreach ( [ 1, 2, 3, 4 ] as $idx => $val ) {
            $message      = "Dummy message-{$idx}: " . __FUNCTION__;
            $tgt_message .= $message . PHP_EOL;
            self::$logger->write( $mask, $message, Logger::LOGGER_PRINT );

        }

        $errlog = self::$error->get_errlog();

        $this->assertEquals( print_r( '', true ), $errlog );

    }


    /**
     * Nominal: Testing write() for many messages, grouped, not printed.
     *
     * @test
     */
    public function test_write_06() {

        $mask        = 0x0010;
        $tgt_message = '';

        self::$error->clear_errlog();
        self::$error->clear_errmsg();

        self::$logger->set_logger_mask( $mask );

        foreach ( [ 1, 2, 3, 4 ] as $idx_p => $p ) {
            foreach ( [ 1, 2, 3, 4 ] as $idx_n => $n ) {
                foreach ( [ 1, 2, 3, 4 ] as $idx_m => $m ) {
                    $message      = "Messages ({$p}, {$n},{$m}): " . __FUNCTION__;
                    $tgt_message .= $message . PHP_EOL;
                    self::$logger->write( $mask, $message, Logger::LOGGER_NO_PRINT );

                }
            }
        }

        $errlog = self::$error->get_errlog();

        $this->assertEquals( trim( print_r( $tgt_message, true ) ), $errlog );

    }

    /**
     * Nominal: Testing write() with many messages, not printed, then printed.
     *
     * @test Nominal test for write().
     */
    public function test_write_07() {

        $mask        = 0x0010;
        $tgt_message = '';

        self::$error->clear_errlog();
        self::$error->clear_errmsg();

        self::$logger->set_logger_mask( $mask );

        foreach ( [ 1, 2, 3, 4 ] as $idx_p => $p ) {
            foreach ( [ 1, 2, 3, 4 ] as $idx_n => $n ) {
                foreach ( [ 1, 2, 3, 4 ] as $idx_m => $m ) {
                    $message      = "Messages ({$p}, {$n},{$m}): " . __FUNCTION__;
                    $tgt_message .= $message . PHP_EOL;
                    self::$logger->write( $mask, $message, Logger::LOGGER_NO_PRINT );

                }
            }
        }

        $errlog = self::$error->get_errlog();

        self::$error->clear_errlog();

        self::$logger->write( $mask, $errlog, Logger::LOGGER_PRINT );

        $this->assertEquals( trim( print_r( $tgt_message, true ) ), $errlog );

    }


    /**
     * Nominal: Testing write() for one message, printed.
     *
     * @test Nominal test for write().
     */
    public function test_write_08() {

        $tgt_mask    = 0x0010;
        $tgt_message = 'Dummy message: ' . __FUNCTION__;

        self::$error->clear_errlog();
        self::$error->clear_errmsg();

        self::$logger->set_logger_mask( $tgt_mask );
        self::$logger->write( $tgt_mask, $tgt_message, Logger::LOGGER_PRINT );

        $errlog = self::$error->get_errlog();

        $this->assertEquals( '', $errlog );

    }


    /*--------------------------------------------------------------*/

}

