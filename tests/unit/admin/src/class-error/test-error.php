<?php
/**
 * Testing for class Error.
 *
 * The following tests include both nominal and error tests.
 *
 * @file
 * @package tests
 */

namespace WP_Speak;

/**
 * Testing for class Error.
 */
class Test_Error extends \WP_UnitTestCase {

    private static $error;

    public function setUp() {
        parent::setUp();
        
        self::$error = Error::get_instance();
    }

    /**
     * Nominal: Testing the basic set_errnm()/get_errnm().
     *
     * @test
     */
    public function test_errnm_01() {

        $tgt_errnm = Errnm::ERR_NM_PREPARE;

        self::$error->set_errnm( $tgt_errnm );

        $errnm = self::$error->get_errnm();

        $this->assertEquals( $tgt_errnm, $errnm );
    }


    /**
     * Nominal: Testing combo of set_errno()/get_errnm().
     *
     * @test
     */
    public function test_errnm_02() {

        $tgt_errno = Errno::ERR_NO_PREPARE;
        $tgt_errnm = Error::$errnm[ $tgt_errno ];

        self::$error->set_errno( $tgt_errno );

        $errnm = self::$error->get_errnm();

        $this->assertEquals( $tgt_errnm, $errnm );

    }


    /*--------------------------------------------------------------*/


    /**
     * Nominal: Testing basis set_errno()/get_errno().
     *
     * @test
     */
    public function test_errno_01() {

        $tgt_errno = Errno::ERR_NO_PREPARE;

        self::$error->set_errno( $tgt_errno );

        $errno = self::$error->get_errno();

        $this->assertEquals( $tgt_errno, $errno );

    }


    /**
     * Nominal: Testing combo of set_errnm()/get_errno().
     *
     * @test
     */
    public function test_errno_02() {

        $tgt_errnm = Errnm::ERR_NM_PREPARE;
        $tgt_errno = Error::$errno[ $tgt_errnm ];

        self::$error->set_errnm( $tgt_errnm );

        $errno = self::$error->get_errno();

        $this->assertEquals( $tgt_errno, $errno );

    }


    /*--------------------------------------------------------------*/


    /**
     * Nominal: Testing set_errmsg() showing errnm only.
     *
     * @test
     */
    public function test_msg_01() {

        $tgt_errmsg = Error::$errnm[ Errno::ERR_NO_UPDATE_ALL ];

        self::$error->set_errno( Errno::ERR_NO_UPDATE_ALL );
        self::$error->set_errmsg();

        $errmsg = self::$error->get_errmsg();

        $this->assertEquals( $tgt_errmsg, $errmsg );

    }


    /**
     * Nominal: Testing set_errmsg() with dummy message.
     *
     * @test
     */
    public function test_msg_02() {

        $tgt_errmsg = Error::$errnm[ Errno::ERR_NO_UPDATE_ALL ] . ': Dummy message';

        self::$error->clear_errmsg();
        self::$error->set_errno( Errno::ERR_NO_UPDATE_ALL );
        self::$error->set_errmsg( 'Dummy message' );

        $errmsg = self::$error->get_errmsg();

        $this->assertEquals( trim( $tgt_errmsg ), trim( $errmsg ) );

    }

    /**
     * Nominal: Testing two set_errmsg() with one get_errmsg().
     *
     * @test
     */
    public function test_msg_03() {

        $tgt_errmsg  = Error::$errnm[ Errno::ERR_NO_UPDATE_ALL ] . ': Dummy message-02. ';
        $tgt_errmsg .= Error::$errnm[ Errno::ERR_NO_UPDATE_ALL ] . ': Dummy message-01';

        self::$error->clear_errmsg();
        self::$error->set_errno( Errno::ERR_NO_UPDATE_ALL );
        self::$error->set_errmsg( 'Dummy message-01' );

        self::$error->set_errno( Errno::ERR_NO_UPDATE_ALL );
        self::$error->set_errmsg( 'Dummy message-02' );

        $errmsg = self::$error->get_errmsg();

        $this->assertEquals( trim( $tgt_errmsg ), trim( $errmsg ) );

    }

    /**
     * Nominal: Testing a set of set_errmsg() and one get_errlog().
     *
     * @test
     */
    public function test_log_01() {

        $tgt_errlog  = Error::$errnm[ Errno::ERR_NO_UPDATE_ALL ] . ': Dummy message-01';
        $tgt_errlog .= PHP_EOL . Error::$errnm[ Errno::ERR_NO_UPDATE_ALL ] . ': Dummy message-02';
        $tgt_errlog .= PHP_EOL . Error::$errnm[ Errno::ERR_NO_UPDATE_ALL ] . ': Dummy message-03';
        $tgt_errlog .= PHP_EOL . Error::$errnm[ Errno::ERR_NO_UPDATE_ALL ] . ': Dummy message-04';

        self::$error->clear_errlog();

        self::$error->clear_errmsg();
        self::$error->set_errno( Errno::ERR_NO_UPDATE_ALL );
        self::$error->set_errmsg( 'Dummy message-01' );

        self::$error->clear_errmsg();
        self::$error->set_errno( Errno::ERR_NO_UPDATE_ALL );
        self::$error->set_errmsg( 'Dummy message-02' );

        self::$error->clear_errmsg();
        self::$error->set_errno( Errno::ERR_NO_UPDATE_ALL );
        self::$error->set_errmsg( 'Dummy message-03' );

        self::$error->clear_errmsg();
        self::$error->set_errno( Errno::ERR_NO_UPDATE_ALL );
        self::$error->set_errmsg( 'Dummy message-04' );

        $errlog = self::$error->get_errlog();

        $this->assertEquals( trim( $tgt_errlog ), trim( $errlog ) );

    }

}

