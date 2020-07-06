<?php
namespace WP_Speak;

// setting error logging to be active 
ini_set("log_errors", TRUE);  
  
// setting the logging file in php.ini 
ini_set('error_log', "mr-debug-log");
 

/**
 * OnAttributeTest Tests
 */
class test_first extends \WP_UnitTestCase {

	private $logger_arglist = array();

    public function setUp() {
        parent::setUp();
    }


    /*--------------------------------------------------------------*/


	/**
     * @test Nominal test for set_errnm.
     */
	public function test_errnm_01() {

		$tgt_errnm = Error::ERR_NM_PREPARE;
		
        Error::set_errnm( $tgt_errnm );

        $errnm = Error::get_errnm( );
    	
	    $this->assertEquals( $tgt_errnm, $errnm );	
    }


	/**
     * @test Nominal test for get_errno.
     */
	public function test_errnm_02() {

		$tgt_errno = Error::ERR_NO_PREPARE;
		$tgt_errnm = Error::$errnm[ $tgt_errno ];
		
    	Error::set_errno( $tgt_errno );

    	$errnm = Error::get_errnm( );
    	
	    $this->assertEquals( $tgt_errnm, $errnm );	

    }


	/**
     * @test Error test for set_errnm.
     * @expectedException WP_Speak\ErrorException
     */
	public function test_errnm_E02() {

		$tgt_errnm   = "XXXX";
		
    	Error::set_errnm( $tgt_errnm );
    	
        $this->expectException(ErrorException::class);

    }


    /*--------------------------------------------------------------*/


	/**
     * @test Nominal test for get_errno.
     */
	public function test_errno_01() {

		$tgt_errno = Error::ERR_NO_PREPARE;
		
    	Error::set_errno( $tgt_errno );

    	$errno = Error::get_errno(  );
    	
	    $this->assertEquals( $tgt_errno, $errno );	

    }


	/**
     * @test Nominal test for get_errno.
     */
	public function test_errno_02() {

		$tgt_errnm = Error::ERR_NM_PREPARE;
		$tgt_errno = Error::$errno[ $tgt_errnm ];
		
    	Error::set_errnm( $tgt_errnm );

    	$errno = Error::get_errno( );
    	
	    $this->assertEquals( $tgt_errno, $errno );	

    }


	/**
     * @test Error test for set_errno. Bad value.
     * @expectedException WP_Speak\ErrorException
     */
	public function test_errno_E01() {

        $tgt_errno  = count(Error::$errno) + 1;
		
    	Error::set_errno( $tgt_errno );

        $this->expectException(ErrorException::class);

    }


    /*--------------------------------------------------------------*/


	/**
     * @test Nominal test for set_errmsg. NULL value.
     */
	public function test_msg_01() {

		$tgt_errmsg   = Error::$errnm[Error::ERR_NO_UPDATE_ALL];
		
    	Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( );
    	
        $errmsg = Error::get_errmsg();
    	
        $this->assertEquals( $tgt_errmsg, $errmsg );	

    }


	/**
     * @test Nominal test for set_errmsg. NULL value.
     */
	public function test_msg_02() {

		$tgt_errmsg   = Error::$errnm[Error::ERR_NO_UPDATE_ALL] . ": " . "Dummy message";
		
        Error::clear_errmsg();
    	Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( "Dummy message" );
    	
        $errmsg = Error::get_errmsg();
        error_log($errmsg);
    	
        $this->assertEquals( trim($tgt_errmsg), trim($errmsg) );	

    }

	/**
     * @test Nominal test for set_errmsg. NULL value.
     */
	public function test_msg_03() {

		$tgt_errmsg  = Error::$errnm[Error::ERR_NO_UPDATE_ALL] . ": " . "Dummy message-02. ";
		$tgt_errmsg .= Error::$errnm[Error::ERR_NO_UPDATE_ALL] . ": " . "Dummy message-01";
		
        Error::clear_errmsg();
    	Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( "Dummy message-01" );
    	
    	Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( "Dummy message-02" );
    	
        $errmsg = Error::get_errmsg();
        error_log($errmsg);
    	
        $this->assertEquals( trim($tgt_errmsg), trim($errmsg) );	

    }

	/**
     * @test Nominal test for set_errmsg. NULL value.
     */
	public function test_log_01() {

		$tgt_errlog  =           Error::$errnm[Error::ERR_NO_UPDATE_ALL] . ": " . "Dummy message-01";
		$tgt_errlog .= PHP_EOL . Error::$errnm[Error::ERR_NO_UPDATE_ALL] . ": " . "Dummy message-02";
		$tgt_errlog .= PHP_EOL . Error::$errnm[Error::ERR_NO_UPDATE_ALL] . ": " . "Dummy message-03";
		$tgt_errlog .= PHP_EOL . Error::$errnm[Error::ERR_NO_UPDATE_ALL] . ": " . "Dummy message-04";
		
        error_log( "TARGET" );
        error_log( $tgt_errlog );

        Error::clear_errlog();

        Error::clear_errmsg();
    	Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( "Dummy message-01" );
    	
        Error::clear_errmsg();
    	Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( "Dummy message-02" );
    	
        Error::clear_errmsg();
    	Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( "Dummy message-03" );
    	
        Error::clear_errmsg();
    	Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( "Dummy message-04" );

        $errlog = Error::get_errlog();
        error_log( "RESULT" );
        error_log($errlog);
    	
        $this->assertEquals( trim($tgt_errlog), trim($errlog) );	

    }

	/**
     * @test Nominal test for set_errmsg. NULL value.
     */
	public function test_log_02() {

		$tgt_errlog  =           Error::$errnm[Error::ERR_NO_UPDATE_ALL] . ": " . "Dummy message-01";
		$tgt_errlog .= PHP_EOL . Error::$errnm[Error::ERR_NO_UPDATE_ALL] . ": " . "Dummy message-02";
		$tgt_errlog .= PHP_EOL . Error::$errnm[Error::ERR_NO_UPDATE_ALL] . ": " . "Dummy message-03";
		$tgt_errlog .= PHP_EOL . Error::$errnm[Error::ERR_NO_UPDATE_ALL] . ": " . "Dummy message-04";
		
        error_log( "TARGET" );
        error_log( $tgt_errlog );

        Error::clear_errlog();

        Error::clear_errmsg();
    	Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( "Dummy message-01" );
    	
        Error::clear_errmsg();
    	Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( "Dummy message-02" );
    	
        Error::clear_errmsg();
    	Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( "Dummy message-03" );
    	
        Error::clear_errmsg();
    	Error::set_errno( Error::ERR_NO_UPDATE_ALL );
        Error::set_errmsg( "Dummy message-04" );

        Error::print_errlog(FALSE);
        Error::print_errlog(FALSE);

        $errlog = Error::get_errlog();
        error_log( "RESULT" );
        error_log($errlog);
    	
        $this->assertEquals( trim($tgt_errlog), trim($errlog) );	

    }

// 
// 
// 	public function testOnTrue02() {
// 
// 		$validate = $this->getMock('Beciteable_Validate', $this->arglist);
//     	$this->file = new Beciteable_FileImpl();
//     	$this->file->set_validate($validate);
// 
// 		$validate->expects($this->any())
//                  ->method('background')
//              	 ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('buildtype')
//              	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_BUILDTYPE)));
// 		
// 		$validate->expects($this->any())
//                  ->method('inclusive')
//                  ->will($this->returnValue(array('background'=>'DontCare', 'buildtype'=>'DontCare')));
// 		
// 		$result = $this->file->shortcode(null, null);
// 		
//         $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_BUILDTYPE."</h5>", $result);
//     }
// 
// 	public function testOnTrue03() {
// 
// 		$validate = $this->getMock('Beciteable_Validate', $this->arglist);
//     	$this->file = new Beciteable_FileImpl();
//     	$this->file->set_validate($validate);
// 
// 		$validate->expects($this->any())
//                  ->method('background')
//              	 ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('buildtype')
//                   ->will($this->returnValue('DontCare'));
// 		
// 		$validate->expects($this->any())
//                  ->method('color')
//              	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_COLOR)));
// 
// 		$validate->expects($this->any())
//                  ->method('inclusive')
//                  ->will($this->returnValue(array('background'=>'DontCare', 'buildtype'=>'DontCare', 'color'=>'DontCare')));
// 		
// 		$result = $this->file->shortcode(null, null);
// 		
//         $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_COLOR."</h5>", $result);
//     }
// 
// 
// 
// 	public function testOnTrue04() {
// 
// 		$validate = $this->getMock('Beciteable_Validate', $this->arglist);
//     	$this->file = new Beciteable_FileImpl();
//     	$this->file->set_validate($validate);
// 
// 		$validate->expects($this->any())
//                  ->method('background')
//              	 ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('buildtype')
//                   ->will($this->returnValue('DontCare'));
// 		
// 		$validate->expects($this->any())
//                  ->method('color')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('css_url')
//              	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_CSS_URL)));
// 
// 		$validate->expects($this->any())
//                  ->method('inclusive')
//                  ->will($this->returnValue(array('background'=>'DontCare', 'buildtype'=>'DontCare', 'color'=>'DontCare', 'id'=>'DontCare', 'css_url'=>'DontCare')));
// 		
// 		$result = $this->file->shortcode(null, null);
// 		
//         $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_CSS_URL."</h5>", $result);
//     }
// 
// 	public function testOnTrue05() {
// 
// 		$validate = $this->getMock('Beciteable_Validate', $this->arglist);
//     	$this->file = new Beciteable_FileImpl();
//     	$this->file->set_validate($validate);
// 
// 		$validate->expects($this->any())
//                  ->method('background')
//              	 ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('buildtype')
//                   ->will($this->returnValue('DontCare'));
// 		
// 		$validate->expects($this->any())
//                  ->method('color')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('css_url')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('no')
//              	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_NO)));
// 
// 		$validate->expects($this->any())
//                  ->method('inclusive')
//                  ->will($this->returnValue(array(
//                  	'background'=>'DontCare', 
//                  	'buildtype'=>'DontCare', 
//                  	'color'=>'DontCare', 
//                  	'id'=>'DontCare', 
//                  	'css_url'=>'DontCare', 
//                  	'no'=>'Dontcare')));
// 		
// 		$result = $this->file->shortcode(null, null);
// 		
//         $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_NO."</h5>", $result);
//     }
// 
// 	public function testOnTrue06() {
// 
// 		$validate = $this->getMock('Beciteable_Validate', $this->arglist);
//     	$this->file = new Beciteable_FileImpl();
//     	$this->file->set_validate($validate);
// 
// 		$validate->expects($this->any())
//                  ->method('background')
//              	 ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('buildtype')
//                   ->will($this->returnValue('DontCare'));
// 		
// 		$validate->expects($this->any())
//                  ->method('color')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('css_url')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('no')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showborder','showdesc')
//              	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_SHOWBORDER)));
// 
// 		$validate->expects($this->any())
//                  ->method('inclusive')
//                  ->will($this->returnValue(array(
//                  	'background'=>'DontCare', 
//                  	'buildtype'=>'DontCare', 
//                  	'color'=>'DontCare', 
//                  	'id'=>'DontCare', 
//                  	'css_url'=>'DontCare', 
//                  	'no'=>'Dontcare',
//                  	'showborder'=>'DontCare',
//                  	'showdesc'=>'DontCare')));
// 		
// 		$result = $this->file->shortcode(null, null);
// 		
//         $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_SHOWBORDER."</h5>", $result);
//     }
// 
// 	public function testOnTrue07() {
// 
// 		$validate = $this->getMock('Beciteable_Validate', $this->arglist);
//     	$this->file = new Beciteable_FileImpl();
//     	$this->file->set_validate($validate);
// 
// 		$validate->expects($this->any())
//                  ->method('background')
//              	 ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('buildtype')
//                   ->will($this->returnValue('DontCare'));
// 		
// 		$validate->expects($this->any())
//                  ->method('color')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('css_url')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('no')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showborder')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showdesc')
//              	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_SHOWDESC)));
// 
// 		$validate->expects($this->any())
//                  ->method('inclusive')
//                  ->will($this->returnValue(array(
//                  	'background'=>'DontCare', 
//                  	'buildtype'=>'DontCare', 
//                  	'color'=>'DontCare', 
//                  	'id'=>'DontCare', 
//                  	'css_url'=>'DontCare', 
//                  	'no'=>'Dontcare',
//                  	'showborder'=>'DontCare',
//                  	'showdesc'=>'DontCare')));
// 		
// 		$result = $this->file->shortcode(null, null);
// 		
//         $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_SHOWDESC."</h5>", $result);
//     }
// 
// 	public function testOnTrue08() {
// 
// 		$validate = $this->getMock('Beciteable_Validate', $this->arglist);
//     	$this->file = new Beciteable_FileImpl();
//     	$this->file->set_validate($validate);
// 
// 		$validate->expects($this->any())
//                  ->method('background')
//              	 ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('buildtype')
//                   ->will($this->returnValue('DontCare'));
// 		
// 		$validate->expects($this->any())
//                  ->method('color')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('css_url')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('no')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showborder')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showdesc')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('usecache')
//              	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_USECACHE)));
// 
// 		$validate->expects($this->any())
//                  ->method('inclusive')
//                  ->will($this->returnValue(array(
//                  	'background'=>'DontCare', 
//                  	'buildtype'=>'DontCare', 
//                  	'color'=>'DontCare', 
//                  	'id'=>'DontCare', 
//                  	'css_url'=>'DontCare', 
//                  	'no'=>'Dontcare',
//                  	'showborder'=>'DontCare',
//                  	'showdesc'=>'DontCare',
//                  	'usecache'=>'DontCare')));
// 		
// 		$result = $this->file->shortcode(null, null);
// 		
//         $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_USECACHE."</h5>", $result);
//     }
// 
// 	public function testOnTrue09() {
// 
// 		$validate = $this->getMock('Beciteable_Validate', $this->arglist);
//     	$this->file = new Beciteable_FileImpl();
//     	$this->file->set_validate($validate);
// 
// 		$validate->expects($this->any())
//                  ->method('background')
//              	 ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('buildtype')
//                   ->will($this->returnValue('DontCare'));
// 		
// 		$validate->expects($this->any())
//                  ->method('color')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('css_url')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('no')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showborder')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showdesc')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('usecache')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('usecustom')
//              	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_USECUSTOM)));
// 
// 		$validate->expects($this->any())
//                  ->method('inclusive')
//                  ->will($this->returnValue(array(
//                  	'background'=>'DontCare', 
//                  	'buildtype'=>'DontCare', 
//                  	'color'=>'DontCare', 
//                  	'id'=>'DontCare', 
//                  	'css_url'=>'DontCare', 
//                  	'no'=>'Dontcare',
//                  	'showborder'=>'DontCare',
//                  	'showdesc'=>'DontCare',
//                  	'usecache'=>'DontCare',
//                  	'usecustom'=>'DontCare')));
// 		
// 		$result = $this->file->shortcode(null, null);
// 		
//         $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_USECUSTOM."</h5>", $result);
//     }
// 
// 	public function testOnTrue10() {
// 
// 		$validate = $this->getMock('Beciteable_Validate', $this->arglist);
//     	$this->file = new Beciteable_FileImpl();
//     	$this->file->set_validate($validate);
// 
// 		$validate->expects($this->any())
//                  ->method('background')
//              	 ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('buildtype')
//                   ->will($this->returnValue('DontCare'));
// 		
// 		$validate->expects($this->any())
//                  ->method('color')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('css_url')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('no')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showborder')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showdesc')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('usecache')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('usecustom')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('useiframe')
//              	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_USEIFRAME)));
// 
// 		$validate->expects($this->any())
//                  ->method('inclusive')
//                  ->will($this->returnValue(array(
//                  	'background'=>'DontCare', 
//                  	'buildtype'=>'DontCare', 
//                  	'color'=>'DontCare', 
//                  	'id'=>'DontCare', 
//                  	'css_url'=>'DontCare', 
//                  	'no'=>'Dontcare',
//                  	'showborder'=>'DontCare',
//                  	'showdesc'=>'DontCare',
//                  	'usecache'=>'DontCare',
//                  	'usecustom'=>'DontCare',
//                  	'useiframe'=>'DontCare')));
// 		
// 		$result = $this->file->shortcode(null, null);
// 		
//         $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_USEIFRAME."</h5>", $result);
//     }
// 
// 	public function testOnTrue11() {
// 
// 		$validate = $this->getMock('Beciteable_Validate', $this->arglist);
//     	$this->file = new Beciteable_FileImpl();
//     	$this->file->set_validate($validate);
// 
// 		$validate->expects($this->any())
//                  ->method('background')
//              	 ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('buildtype')
//                   ->will($this->returnValue('DontCare'));
// 		
// 		$validate->expects($this->any())
//                  ->method('color')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('css_url')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('no')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showborder')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showdesc')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('usecache')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('usecustom')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('useiframe')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('id')
//              	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_ID)));
// 
// 		$validate->expects($this->any())
//                  ->method('inclusive')
//                  ->will($this->returnValue(array(
//                  	'background'=>'DontCare', 
//                  	'buildtype'=>'DontCare', 
//                  	'color'=>'DontCare', 
//                  	'id'=>'DontCare', 
//                  	'css_url'=>'DontCare', 
//                  	'no'=>'Dontcare',
//                  	'preview'=>null,
//                  	'showborder'=>'DontCare',
//                  	'showdesc'=>'DontCare',
//                  	'usecache'=>'DontCare',
//                  	'usecustom'=>'DontCare',
//                  	'useiframe'=>'DontCare',
//                  	'version'=>'1.0',
//                  	'id'=>'DontCare')));
// 		
// 		$result = $this->file->shortcode(null, null);
// 		
//         $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_ID."</h5>", $result);
//     }
// 
// 	public function testOnTrue12() {
// 
// 		$validate = $this->getMock('Beciteable_Validate', $this->arglist);
//     	$this->file = new Beciteable_FileImpl();
//     	$this->file->set_validate($validate);
// 
// 		$validate->expects($this->any())
//                  ->method('background')
//              	 ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('buildtype')
//                   ->will($this->returnValue('DontCare'));
// 		
// 		$validate->expects($this->any())
//                  ->method('color')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('css_url')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('no')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showborder')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showdesc')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('usecache')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('usecustom')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('useiframe')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('id')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('shorturl')
//              	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_SHORTURL)));
// 
// 		$validate->expects($this->any())
//                  ->method('inclusive')
//                  ->will($this->returnValue(array(
//                  	'background'=>'DontCare', 
//                  	'buildtype'=>'DontCare', 
//                  	'color'=>'DontCare', 
//                  	'id'=>'DontCare', 
//                  	'css_url'=>'DontCare', 
//                  	'no'=>'Dontcare',
//                  	'preview'=>null,
//                  	'showborder'=>'DontCare',
//                  	'showdesc'=>'DontCare',
//                  	'usecache'=>'DontCare',
//                  	'usecustom'=>'DontCare',
//                  	'useiframe'=>'DontCare',
//                  	'version'=>'1.0',
//                  	'id'=>'DontCare',
//                  	'url'=>'DontCare')));
// 		
// 		$result = $this->file->shortcode(null, null);
// 		
//         $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_SHORTURL."</h5>", $result);
//     }
// 
// 	public function testOnTrue13() {
// 
// 		$validate = $this->getMock('Beciteable_Validate', $this->arglist);
//     	$this->file = new Beciteable_FileImpl();
//     	$this->file->set_validate($validate);
// 
// 		$validate->expects($this->any())
//                  ->method('background')
//              	 ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('buildtype')
//                   ->will($this->returnValue('DontCare'));
// 		
// 		$validate->expects($this->any())
//                  ->method('color')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('css_url')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('no')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showborder')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('showdesc')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('usecache')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('usecustom')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('useiframe')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('id')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('shorturl')
//                  ->will($this->returnValue('DontCare'));
// 
// 		$validate->expects($this->any())
//                  ->method('longurl')
// 				 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_LONGURL)));
// 
// 		$validate->expects($this->any())
//                  ->method('inclusive')
//                  ->will($this->returnValue(array(
//                  	'background'=>'DontCare', 
//                  	'buildtype'=>'DontCare', 
//                  	'color'=>'DontCare', 
//                  	'id'=>'DontCare', 
//                  	'css_url'=>'DontCare', 
//                  	'no'=>'Dontcare',
//                  	'preview'=>null,
//                  	'showborder'=>'DontCare',
//                  	'showdesc'=>'DontCare',
//                  	'usecache'=>'DontCare',
//                  	'usecustom'=>'DontCare',
//                  	'useiframe'=>'DontCare',
//                  	'version'=>'1.0',
//                  	'id'=>'DontCare',
//                  	'url'=>'DontCare',
//                  	'longurl'=>'DontCare')));
// 		
// 		$result = $this->file->shortcode(null, null);
// 		
//         $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_LONGURL."</h5>", $result);
//     }

}

