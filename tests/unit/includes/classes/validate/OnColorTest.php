<?php
/**
 * OnColor Tests
 */
class OnColorTest extends WP_UnitTestCase {

	public $_validate;
	
    public function setUp() {
        parent::setUp();
    	
    	$this->_validate = new Beciteable_ValidateImpl();
    }


	######################################################
	#
	#		BAD TESTS
	#
	######################################################

	/**
     * @covers Beciteable_ValidateImpl::color
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'yellow' is not a valid COLOR.
     */
	public function testOnColor05() {
		$result = $this->_validate->color('yellow', 'Unit Test');
    }


	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
     * @covers Beciteable_ValidateImpl::color
     */
	public function testOnColor06() {
		$result = $this->_validate->color('white', 'Unit Test');
		
        $this->assertSame($result, 'white');
    }


	/**
     * @covers Beciteable_ValidateImpl::color
     */
	public function testOnColor07() {
		$result = $this->_validate->color('blue', 'Unit Test');
		
        $this->assertSame($result, 'blue');
    }

	/**
     * @covers Beciteable_ValidateImpl::color
     */
	public function testOnColor08() {
		$result = $this->_validate->color('green', 'Unit Test');
		
        $this->assertSame($result, 'green');
    }
	
	/**
     * @covers Beciteable_ValidateImpl::color
     */
	public function testOnColor09() {
		$result = $this->_validate->color('black', 'Unit Test');
		
        $this->assertSame($result, 'black');
    }
	
	/**
     * @covers Beciteable_ValidateImpl::color
     */
	public function testOnColor10() {
		$result = $this->_validate->color('red', 'Unit Test');
		
        $this->assertSame($result, 'red');
    }
	
}
