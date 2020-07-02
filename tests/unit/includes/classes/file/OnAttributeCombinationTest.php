<?php
/**
 * OnAttributeCombinationTest Tests
 */
class OnAttributeCombinationTest extends WP_UnitTestCase {

	private $_file;
	private $_methodlist = array('background', 'buildtype', 'color', 'css_url', 'exactly_one', 'height', 'id', 'inclusive', 'longurl', 'no', 'preview', 'shorturl', 'showborder', 'showdesc', 'showurl', 'usecache', 'usecustom', 'useiframe', 'width');
	
    public function setUp() {
        parent::setUp();
    }

	public function testOn01() {

		$validate = $this->getMock('Beciteable_Validate', $this->_methodlist);
    	$this->_file = new Beciteable_FileImpl();
    	$this->_file->set_validate($validate);

		$validate->expects($this->any())
                 ->method('background')
             	 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('buildtype')
                  ->will($this->returnValue('DontCare'));
		
		$validate->expects($this->any())
                 ->method('color')
                 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('css_url')
                 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('no')
                 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('showborder')
                 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('showdesc')
                 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('usecache')
                 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('usecustom')
                 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('useiframe')
                 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('id')
                 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('shorturl')
                 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('longurl')
                 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('exactly_one')
				 ->will($this->throwException(new Exception('Unit Test')));

		$validate->expects($this->any())
                 ->method('inclusive')
                 ->will($this->returnValue(array(
                 	'background'=>'DontCare', 
                 	'buildtype'=>'DontCare', 
                 	'color'=>'DontCare', 
                 	'id'=>'DontCare', 
                 	'css_url'=>'DontCare', 
                 	'no'=>'Dontcare',
                 	'preview'=>null,
                 	'showborder'=>'DontCare',
                 	'showdesc'=>'DontCare',
                 	'usecache'=>'DontCare',
                 	'usecustom'=>'DontCare',
                 	'useiframe'=>'DontCare',
                 	'version'=>'1.0',
                 	'id'=>'DontCare',
                 	'url'=>'DontCare',
                 	'longurl'=>'DontCare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".'Unit Test'."</h5>", $result);
    }

	public function testOn02() {

    	$this->_file = new Beciteable_FileImpl();
    	$this->_file->set_validate(new Beciteable_ValidateImpl());

		$attr = array(
                 	'background'=>'white', 
                 	'buildtype'=>'re-package', 
                 	'color'=>'black', 
                 	'css_url'=>NULL, 
                 	'no'=>'1',
                 	'preview'=>null,
                 	'showborder'=>'FALSE',
                 	'showdesc'=>'FALSE',
                 	'usecache'=>'FALSE',
                 	'usecustom'=>'FALSE',
                 	'useiframe'=>'FALSE',
                 	'version'=>'1.0',
                 	'id'=>NULL,
                 	'url'=>NULL,
                 	'longurl'=>NULL);
		
		$result = $this->_file->_shortcode($attr, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_COMBINATION."</h5>", $result);
    }

	public function testOn03() {

    	$this->_file = new Beciteable_FileImpl();
    	$this->_file->set_validate(new Beciteable_ValidateImpl());

		$attr = array(
                 	'background'=>'white', 
                 	'buildtype'=>'re-package', 
                 	'color'=>'black', 
                 	'css_url'=>NULL, 
                 	'no'=>'1',
                 	'preview'=>null,
                 	'showborder'=>'FALSE',
                 	'showdesc'=>'FALSE',
                 	'usecache'=>'FALSE',
                 	'usecustom'=>'FALSE',
                 	'useiframe'=>'FALSE',
                 	'version'=>'1.0',
                 	'id'=>'This title is not important', 
                 	'url'=>'http://www.google.com',
                 	'longurl'=>NULL);
		
		$result = $this->_file->_shortcode($attr, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_COMBINATION."</h5>", $result);
    }

	public function testOn04() {

    	$this->_file = new Beciteable_FileImpl();
    	$this->_file->set_validate(new Beciteable_ValidateImpl());

		$attr = array(
                 	'background'=>'white', 
                 	'buildtype'=>'re-package', 
                 	'color'=>'black', 
                 	'css_url'=>NULL, 
                 	'no'=>'1',
                 	'preview'=>null,
                 	'showborder'=>'FALSE',
                 	'showdesc'=>'FALSE',
                 	'usecache'=>'FALSE',
                 	'usecustom'=>'FALSE',
                 	'useiframe'=>'FALSE',
                 	'version'=>'1.0',
                 	'id'=>'This title is not important', 
                 	'url'=>NULL,
                 	'longurl'=>'http://www.google.com');
		
		$result = $this->_file->_shortcode($attr, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_COMBINATION."</h5>", $result);
    }

	public function testOn05() {

    	$this->_file = new Beciteable_FileImpl();
    	$this->_file->set_validate(new Beciteable_ValidateImpl());

		$attr = array(
                 	'background'=>'white', 
                 	'buildtype'=>'re-package', 
                 	'color'=>'black', 
                 	'css_url'=>NULL, 
                 	'no'=>'1',
                 	'preview'=>null,
                 	'showborder'=>'FALSE',
                 	'showdesc'=>'FALSE',
                 	'usecache'=>'FALSE',
                 	'usecustom'=>'FALSE',
                 	'useiframe'=>'FALSE',
                 	'version'=>'1.0',
                 	'id'=>'This title is not important', 
                 	'url'=>'http://www.google.com',
                 	'longurl'=>'http://www.google.com');
		
		$result = $this->_file->_shortcode($attr, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_COMBINATION."</h5>", $result);
    }

	public function testOn06() {

    	$this->_file = new Beciteable_FileImpl();
    	$this->_file->set_validate(new Beciteable_ValidateImpl());

		$attr = array(
                 	'background'=>'white', 
                 	'buildtype'=>'re-package', 
                 	'color'=>'black', 
                 	'css_url'=>NULL, 
                 	'no'=>'1',
                 	'preview'=>null,
                 	'showborder'=>'FALSE',
                 	'showdesc'=>'FALSE',
                 	'usecache'=>'FALSE',
                 	'usecustom'=>'FALSE',
                 	'useiframe'=>'FALSE',
                 	'version'=>'1.0',
                 	'id'=>'This title is not important'
                 	);
		
		$result = $this->_file->_shortcode($attr, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_SMALL_COMBINATION."</h5>", $result);
    }


	public function testOn07() {

		$attr = array(
                 	'background'=>'white', 
                 	'buildtype'=>'re-package', 
                 	'color'=>'black', 
                 	'css_url'=>NULL, 
                 	'no'=>'1',
                 	'preview'=>null,
                 	'showborder'=>'FALSE',
                 	'showdesc'=>'FALSE',
                 	'usecache'=>'FALSE',
                 	'usecustom'=>'FALSE',
                 	'useiframe'=>'FALSE',
                 	'version'=>'1.0',
                 	'url'=>'http://google.com',
                 	'id'=>null,
                 	'longurl'=>null
                 	);
		
		$validate = $this->getMock('Beciteable_Validate', $this->_methodlist);
		$validate->expects($this->any())->method('background')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('buildtype')->will($this->returnValue('DontCare'));		
		$validate->expects($this->any())->method('color')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('css_url')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('no')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('showborder')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('showdesc')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('usecache')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('usecustom')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('useiframe')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('id')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('shorturl')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('longurl')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('exactly_one')->will($this->returnValue('DontCare'));
		$validate->expects($this->any())->method('inclusive')->will($this->returnValue($attr));

		$comm = $this->getMock('Beciteable_Comm', array('set_build_type', 'get_short_url', 'get_json', 'get_long_url', 'set_http', 'set_json', 'set_logger', 'set_storage', 'set_url'));
		$comm->expects($this->any())->method('set_build_type')->will($this->returnValue('DontCare'));
		$comm->expects($this->any())->method('get_short_url')->will($this->returnValue(array('status'=> FALSE, 'message'=>'Get Short URL Message is not important')));
		
		$logger = $this->getMock('Beciteable_Logger', array('log', 'getmask', 'setmask', 'write'));
		$logger->expects($this->any())->method('log')->will($this->returnValue('DontCare'));

    	$this->_file = new Beciteable_FileImpl();
    	$this->_file
    		->set_validate($validate)
    		->set_comm($comm)
    		->set_logger($logger);

		$result = $this->_file->_shortcode(null, null);

        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".'Get Short URL Message is not important'."</h5>", $result);
		
    }

}

