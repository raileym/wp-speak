<?php
/**
 * OnShortenTest Tests
 */
class OnShortenTest extends WP_UnitTestCase {
    
	private $_url;

    public function setUp() {
        parent::setUp();
    }

	/**
     */
	public function testOn01() {

		$http = $this->getMock('Beciteable_Http', array('post', 'is_error'));
		$json = $this->getMock('Beciteable_Json', array('encode', 'decode'));
		$logger = $this->getMock('Beciteable_Logger', array('getmask', 'setmask', 'write', 'log'));
		$registry = $this->getMock('Beciteable_ArrayRegistry', array('get', 'set'));
    	    	
		$map = array(
        	array('shorturl_user_name',     'admin'),
        	array('shorturl_user_password', 'sMcVDHFdN7Z8zqjG'),
        	array('shorturl_home',          'http://cited.co')
        );  		
		
		$registry->expects($this->any())
                 ->method('get')
             	 ->will($this->returnValueMap($map));

        $http->expects($this->any())
        	->method('post')
        	->will($this->returnValue(array('status'=>FALSE, 'message'=>'HTTP Message is not important')));
        	        
    	$this->_url = new Beciteable_UrlImpl();
    	$this->_url
    		->set_registry($registry)
    		->set_http($http)
    		->set_json($json)
    		->set_logger($logger);

		$result = $this->_url->shorten('Test URL', 'Does not matter');
		
		
        $this->assertEquals(sprintf(BECITEABLE_ERRMSG_SHORTEN_BAD_COMM, 'Test URL', ': HTTP Message is not important', 'MC500'), $result['message']);
		
    }
    
    /**
     */
	public function testOn02() {

		$http = $this->getMock('Beciteable_Http', array('post', 'is_error'));
		$json = $this->getMock('Beciteable_Json', array('encode', 'decode'));
		$logger = $this->getMock('Beciteable_Logger', array('getmask', 'setmask', 'write', 'log'));
		$registry = $this->getMock('Beciteable_ArrayRegistry', array('get', 'set'));
    	    	
		$map = array(
        	array('shorturl_user_name',     'admin'),
        	array('shorturl_user_password', 'sMcVDHFdN7Z8zqjG'),
        	array('shorturl_home',          'http://cited.co')
        );  		
		
		$registry
			->expects($this->any())
        	->method('get')
        	->will($this->returnValueMap($map));

        $http
        	->expects($this->any())
        	->method('post')
        	->will($this->returnValue(array('status'=>TRUE, 'body'=>'Does not matter')));
        	
		$json_result = new stdClass;
		$json_result->statusCode = 400;
		$json_result->message = ': JSON Message is not important';

		$json
			->expects($this->any())
			->method('decode')
        	->will($this->returnValue($json_result));

    	$this->_url = new Beciteable_UrlImpl();
    	$this->_url
    		->set_registry($registry)
    		->set_http($http)
    		->set_json($json)
    		->set_logger($logger);

		$result = $this->_url->shorten('Test URL', 'Does not matter');
		
        $this->assertEquals(sprintf(BECITEABLE_ERRMSG_SHORTEN_BAD_UNKNOWN, 'Test URL', ': JSON Message is not important', 'SC400'), $result['message']);
		
    }
    
    
    /**
     */
	public function testOn03() {

		$http = $this->getMock('Beciteable_Http', array('post', 'is_error'));
		$json = $this->getMock('Beciteable_Json', array('encode', 'decode'));
		$logger = $this->getMock('Beciteable_Logger', array('getmask', 'setmask', 'write', 'log'));
		$registry = $this->getMock('Beciteable_ArrayRegistry', array('get', 'set'));
    	    	
		$map = array(
        	array('shorturl_user_name',     'admin'),
        	array('shorturl_user_password', 'sMcVDHFdN7Z8zqjG'),
        	array('shorturl_home',          'http://cited.co')
        );  		
		
		$registry
			->expects($this->any())
        	->method('get')
        	->will($this->returnValueMap($map));

        $http
        	->expects($this->any())
        	->method('post')
        	->will($this->returnValue(array('status'=>TRUE, 'body'=>'Does not matter')));
        	
		$json_result = new stdClass;

		$json
			->expects($this->any())
			->method('decode')
        	->will($this->returnValue($json_result));

    	$this->_url = new Beciteable_UrlImpl();
    	$this->_url
    		->set_registry($registry)
    		->set_http($http)
    		->set_json($json)
    		->set_logger($logger);

		$result = $this->_url->shorten('Test URL', 'Does not matter');
		
        $this->assertEquals(sprintf(BECITEABLE_ERRMSG_SHORTEN_BAD_JSON, 'Test URL', '', 'EC0'), $result['message']);
		
    }    


    /**
     */
	public function testOn04() {

		$http = $this->getMock('Beciteable_Http', array('post', 'is_error'));
		$json = $this->getMock('Beciteable_Json', array('encode', 'decode'));
		$logger = $this->getMock('Beciteable_Logger', array('getmask', 'setmask', 'write', 'log'));
		$registry = $this->getMock('Beciteable_ArrayRegistry', array('get', 'set'));
    	    	
		$map = array(
        	array('shorturl_user_name',     'admin'),
        	array('shorturl_user_password', 'sMcVDHFdN7Z8zqjG'),
        	array('shorturl_home',          'http://cited.co')
        );  		
		
		$registry
			->expects($this->any())
        	->method('get')
        	->will($this->returnValueMap($map));

        $http
        	->expects($this->any())
        	->method('post')
        	->will($this->returnValue(array('status'=>TRUE, 'body'=>'Does not matter')));
        	
		$json_result = new stdClass;
		$json_result->statusCode = 200;
		$json_result->message = 'Everything worked';
		$json_result->shorturl = 'http://google.com';

		$json
			->expects($this->any())
			->method('decode')
        	->will($this->returnValue($json_result));

    	$this->_url = new Beciteable_UrlImpl();
    	$this->_url
    		->set_registry($registry)
    		->set_http($http)
    		->set_json($json)
    		->set_logger($logger);

		$result = $this->_url->shorten('Test URL', 'Does not matter');
		
        $this->assertEquals('200', $result['code']);
        $this->assertEquals('Everything worked', $result['message']);
        $this->assertEquals('http://google.com', $result['short_url']);
		
    }    
}
