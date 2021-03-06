<?php
/**
 * OnAttributeTest Tests
 */
class OnAttributeTest extends WP_UnitTestCase {
    //public $plugin_slug = 'my-plugin';
    
	private $_file;
	private $_arglist = array('background', 'buildtype', 'color', 'css_url', 'exactly_one', 'height', 'id', 'inclusive', 'longurl', 'no', 'preview', 'shorturl', 'showborder', 'showdesc', 'showurl', 'usecache', 'usecustom', 'useiframe', 'width');
	
    public function setUp() {
        parent::setUp();
    }

	/**
     * @covers True::isTrue
     */
	public function testOnTrue01() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
    	$this->_file = new Beciteable_FileImpl();
    	$this->_file->set_validate($validate);

		$validate->expects($this->any())
                 ->method('background')
             	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_BACKGROUND)));

		$validate->expects($this->any())
                 ->method('inclusive')
                 ->will($this->returnValue(array('background'=>'DontCare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_BACKGROUND."</h5>", $result);
    }



	public function testOnTrue02() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
    	$this->_file = new Beciteable_FileImpl();
    	$this->_file->set_validate($validate);

		$validate->expects($this->any())
                 ->method('background')
             	 ->will($this->returnValue('DontCare'));

		$validate->expects($this->any())
                 ->method('buildtype')
             	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_BUILDTYPE)));
		
		$validate->expects($this->any())
                 ->method('inclusive')
                 ->will($this->returnValue(array('background'=>'DontCare', 'buildtype'=>'DontCare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_BUILDTYPE."</h5>", $result);
    }

	public function testOnTrue03() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
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
             	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_COLOR)));

		$validate->expects($this->any())
                 ->method('inclusive')
                 ->will($this->returnValue(array('background'=>'DontCare', 'buildtype'=>'DontCare', 'color'=>'DontCare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_COLOR."</h5>", $result);
    }



	public function testOnTrue04() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
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
             	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_CSS_URL)));

		$validate->expects($this->any())
                 ->method('inclusive')
                 ->will($this->returnValue(array('background'=>'DontCare', 'buildtype'=>'DontCare', 'color'=>'DontCare', 'id'=>'DontCare', 'css_url'=>'DontCare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_CSS_URL."</h5>", $result);
    }

	public function testOnTrue05() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
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
             	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_NO)));

		$validate->expects($this->any())
                 ->method('inclusive')
                 ->will($this->returnValue(array(
                 	'background'=>'DontCare', 
                 	'buildtype'=>'DontCare', 
                 	'color'=>'DontCare', 
                 	'id'=>'DontCare', 
                 	'css_url'=>'DontCare', 
                 	'no'=>'Dontcare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_NO."</h5>", $result);
    }

	public function testOnTrue06() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
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
                 ->method('showborder','showdesc')
             	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_SHOWBORDER)));

		$validate->expects($this->any())
                 ->method('inclusive')
                 ->will($this->returnValue(array(
                 	'background'=>'DontCare', 
                 	'buildtype'=>'DontCare', 
                 	'color'=>'DontCare', 
                 	'id'=>'DontCare', 
                 	'css_url'=>'DontCare', 
                 	'no'=>'Dontcare',
                 	'showborder'=>'DontCare',
                 	'showdesc'=>'DontCare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_SHOWBORDER."</h5>", $result);
    }

	public function testOnTrue07() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
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
             	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_SHOWDESC)));

		$validate->expects($this->any())
                 ->method('inclusive')
                 ->will($this->returnValue(array(
                 	'background'=>'DontCare', 
                 	'buildtype'=>'DontCare', 
                 	'color'=>'DontCare', 
                 	'id'=>'DontCare', 
                 	'css_url'=>'DontCare', 
                 	'no'=>'Dontcare',
                 	'showborder'=>'DontCare',
                 	'showdesc'=>'DontCare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_SHOWDESC."</h5>", $result);
    }

	public function testOnTrue08() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
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
             	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_USECACHE)));

		$validate->expects($this->any())
                 ->method('inclusive')
                 ->will($this->returnValue(array(
                 	'background'=>'DontCare', 
                 	'buildtype'=>'DontCare', 
                 	'color'=>'DontCare', 
                 	'id'=>'DontCare', 
                 	'css_url'=>'DontCare', 
                 	'no'=>'Dontcare',
                 	'showborder'=>'DontCare',
                 	'showdesc'=>'DontCare',
                 	'usecache'=>'DontCare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_USECACHE."</h5>", $result);
    }

	public function testOnTrue09() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
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
             	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_USECUSTOM)));

		$validate->expects($this->any())
                 ->method('inclusive')
                 ->will($this->returnValue(array(
                 	'background'=>'DontCare', 
                 	'buildtype'=>'DontCare', 
                 	'color'=>'DontCare', 
                 	'id'=>'DontCare', 
                 	'css_url'=>'DontCare', 
                 	'no'=>'Dontcare',
                 	'showborder'=>'DontCare',
                 	'showdesc'=>'DontCare',
                 	'usecache'=>'DontCare',
                 	'usecustom'=>'DontCare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_USECUSTOM."</h5>", $result);
    }

	public function testOnTrue10() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
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
             	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_USEIFRAME)));

		$validate->expects($this->any())
                 ->method('inclusive')
                 ->will($this->returnValue(array(
                 	'background'=>'DontCare', 
                 	'buildtype'=>'DontCare', 
                 	'color'=>'DontCare', 
                 	'id'=>'DontCare', 
                 	'css_url'=>'DontCare', 
                 	'no'=>'Dontcare',
                 	'showborder'=>'DontCare',
                 	'showdesc'=>'DontCare',
                 	'usecache'=>'DontCare',
                 	'usecustom'=>'DontCare',
                 	'useiframe'=>'DontCare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_USEIFRAME."</h5>", $result);
    }

	public function testOnTrue11() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
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
             	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_ID)));

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
                 	'id'=>'DontCare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_ID."</h5>", $result);
    }

	public function testOnTrue12() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
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
             	 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_SHORTURL)));

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
                 	'url'=>'DontCare')));
		
		$result = $this->_file->_shortcode(null, null);
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_SHORTURL."</h5>", $result);
    }

	public function testOnTrue13() {

		$validate = $this->getMock('Beciteable_Validate', $this->_arglist);
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
				 ->will($this->throwException(new Exception(BECITEABLE_ERRMSG_BAD_LONGURL)));

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
		
        $this->assertEquals("<h5 style='color:red;font-family:verdana;font-weight:bold;'>[beciteable_cite ...]<br/>".BECITEABLE_ERRMSG_BAD_LONGURL."</h5>", $result);
    }

}

