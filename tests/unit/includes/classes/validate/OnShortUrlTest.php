<?php
/**
 * OnValidate Tests
 */
class OnShortUrlTest extends WP_UnitTestCase {

	public $validate;
	
    public function setUp() {
        parent::setUp();
    	
    	$this->validate = new Beciteable_ValidateImpl();
    }


    
	######################################################
	#
	#		BAD TESTS
	#
	######################################################

	/**
     * @covers Beciteable_ValidateImpl::shorturl
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'one' is not a valid URL.
     */
	public function testOnBadInput01() {
		$result = $this->validate->shorturl('one', 'Unit Test');
    }

	/**
     * @covers Beciteable_ValidateImpl::shorturl
     * @expectedException Exception
     */
	public function testOnMalformedInput01() {
		$result = $this->validate->shorturl('http://www.google.com!', 'Unit Test');
    }

	/**
     * @covers Beciteable_ValidateImpl::shorturl
     * @expectedException Exception
     */
	public function testOnMalformedInput03() {
		$result = $this->validate->shorturl('http:/www.google.com', 'Unit Test');
    }

	/**
     * @covers Beciteable_ValidateImpl::shorturl
     * @expectedException Exception
     */
	public function testOnMalformedInput04() {
		$result = $this->validate->shorturl('http;//www.google.com', 'Unit Test');
    }
    
    
	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
     * @covers Beciteable_ValidateImpl::shorturl
     */
	public function testOnProperInput01() {
		$result = $this->validate->shorturl('www.google.com', 'Unit Test');
    }

	/**
     * @covers Beciteable_ValidateImpl::shorturl
     */
	public function testOnProperInput02() {
		$result = $this->validate->shorturl('http://www.google.com', 'Unit Test');
    }

}
