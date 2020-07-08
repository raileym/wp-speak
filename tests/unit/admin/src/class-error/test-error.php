<?php
/**
 * Error provides the assorted constructs for error-handling.
 *
 * Error includes all the functions to handle errno, errnm,
 * errmsg, and errlog.
 *
 * @file
 * @package tests
 */

namespace WP_Speak;

// setting error logging to be active.
ini_set( 'log_errors', true );

// setting the logging file in php.ini.
ini_set( 'error_log', 'mr-debug-log' );


/**
 * OnAttributeTest Tests
 */
class Test_Error extends \WP_UnitTestCase {

    /**
     * Nominal: Testing the basic set_errnm()/get_errnm().
     *
     * @test
     */
    public function test_errnm_01() {

        $tgt_errnm = Error::ERR_NM_PREPARE;

        Error::set_errnm( $tgt_errnm );

        $errnm = Error::get_errnm();

        $this->assertEquals( $tgt_errnm, $errnm );
    }


    /**
     * Nominal: Testing combo of set_errno()/get_errnm().
     *
     * @test
     */
    public function test_errnm_02() {

        $tgt_errno = Error::ERR_NO_PREPARE;
        $tgt_errnm = Error::$errnm[ $tgt_errno ];

        Error::set_errno( $tgt_errno );

        $errnm = Error::get_errnm();

        $this->assertEquals( $tgt_errnm, $errnm );

    }


    /*--------------------------------------------------------------*/


    /**
     * Nominal: Testing basis set_errno()/get_errno().
     *
     * @test
     */
    public function test_errno_01() {

        $tgt_errno = Error::ERR_NO_PREPARE;

        Error::set_errno( $tgt_errno );

        $errno = Error::get_errno();

        $this->assertEquals( $tgt_errno, $errno );

    }


    /**
     * Nominal: Testing combo of set_errnm()/get_errno().
     *
     * @test
     */
    public function test_errno_02() {

        $tgt_errnm = Error::ERR_NM_PREPARE;
        $tgt_errno = Error::$errno[ $tgt_errnm ];

        Error::set_errnm( $tgt_errnm );

        $errno = Error::get_errno();

        $this->assertEquals( $tgt_errno, $errno );

    }


    /*--------------------------------------------------------------*/


    /**
     * Nominal: Testing set_errmsg() showing errnm only.
     *
     * @test
     */
    public function test_msg_01() {

        $tgt_errmsg = Error::$errnm[ Error::ERR_NO_UPDATE_ALL ];

        Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg();

        $errmsg = Error::get_errmsg();

        $this->assertEquals( $tgt_errmsg, $errmsg );

    }


    /**
     * Nominal: Testing set_errmsg() with dummy message.
     *
     * @test
     */
    public function test_msg_02() {

        $tgt_errmsg = Error::$errnm[ Error::ERR_NO_UPDATE_ALL ] . ': Dummy message';

        Error::clear_errmsg();
        Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( 'Dummy message' );

        $errmsg = Error::get_errmsg();

        $this->assertEquals( trim( $tgt_errmsg ), trim( $errmsg ) );

    }

    /**
     * Nominal: Testing two set_errmsg() with one get_errmsg().
     *
     * @test
     */
    public function test_msg_03() {

        $tgt_errmsg  = Error::$errnm[ Error::ERR_NO_UPDATE_ALL ] . ': Dummy message-02. ';
        $tgt_errmsg .= Error::$errnm[ Error::ERR_NO_UPDATE_ALL ] . ': Dummy message-01';

        Error::clear_errmsg();
        Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( 'Dummy message-01' );

        Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( 'Dummy message-02' );

        $errmsg = Error::get_errmsg();

        $this->assertEquals( trim( $tgt_errmsg ), trim( $errmsg ) );

    }

    /**
     * Nominal: Testing a set of set_errmsg() and one get_errlog().
     *
     * @test
     */
    public function test_log_01() {

        $tgt_errlog  = Error::$errnm[ Error::ERR_NO_UPDATE_ALL ] . ': Dummy message-01';
        $tgt_errlog .= PHP_EOL . Error::$errnm[ Error::ERR_NO_UPDATE_ALL ] . ': Dummy message-02';
        $tgt_errlog .= PHP_EOL . Error::$errnm[ Error::ERR_NO_UPDATE_ALL ] . ': Dummy message-03';
        $tgt_errlog .= PHP_EOL . Error::$errnm[ Error::ERR_NO_UPDATE_ALL ] . ': Dummy message-04';

        Error::clear_errlog();

        Error::clear_errmsg();
        Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( 'Dummy message-01' );

        Error::clear_errmsg();
        Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( 'Dummy message-02' );

        Error::clear_errmsg();
        Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( 'Dummy message-03' );

        Error::clear_errmsg();
        Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( 'Dummy message-04' );

        $errlog = Error::get_errlog();

        $this->assertEquals( trim( $tgt_errlog ), trim( $errlog ) );

    }

}

