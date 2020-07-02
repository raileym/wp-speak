<?php
/**
 * OnValidate Tests
 */
class OnUrlTest extends WP_UnitTestCase {

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
     * @covers Beciteable_ValidateImpl::url
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'one' is not a valid URL.
     */
	public function testOnBadInput01() {
		$result = $this->validate->_url('one', 'Unit Test');
    }

	/**
     * @covers Beciteable_ValidateImpl::url
     * @expectedException Exception
     */
	public function testOnMalformedInput01() {
		$result = $this->validate->_url('http://www.google.com!', 'Unit Test');
    }

	/**
     * @covers Beciteable_ValidateImpl::url
     * @expectedException Exception
     */
	public function testOnMalformedInput03() {
		$result = $this->validate->_url('http:/www.google.com', 'Unit Test');
    }

	/**
     * @covers Beciteable_ValidateImpl::url
     * @expectedException Exception
     */
	public function testOnMalformedInput04() {
		$result = $this->validate->_url('http;//www.google.com', 'Unit Test');
    }
    
    
	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
     * @covers Beciteable_ValidateImpl::url
     */
	public function testOnProperInput01() {
		$result = $this->validate->_url('www.google.com', 'Unit Test');
    }

	/**
     * @covers Beciteable_ValidateImpl::url
     */
	public function testOnProperInput02() {
		$result = $this->validate->_url('http://www.google.com', 'Unit Test');
    }

}
