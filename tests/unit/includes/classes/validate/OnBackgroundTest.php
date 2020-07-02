<?php
/**
 * OnBackground Tests
 */
class OnBackgroundTest extends WP_UnitTestCase {

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
     * @covers Beciteable_ValidateImpl::background
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'yellow' is not a valid BACKGROUND.
     */
	public function testOnBackground05() {
		$result = $this->_validate->background('yellow', 'Unit Test');
    }


	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
     * @covers Beciteable_ValidateImpl::background
     */
	public function testOnBackground06() {
		$result = $this->_validate->background('grey', 'Unit Test');
		
        $this->assertSame($result, 'grey');
    }


	/**
     * @covers Beciteable_ValidateImpl::background
     */
	public function testOnBackground07() {
		$result = $this->_validate->background('white', 'Unit Test');
		
        $this->assertSame($result, 'white');
    }

	/**
     * @covers Beciteable_ValidateImpl::background
     */
	public function testOnBackground08() {
		$result = $this->_validate->background('blue', 'Unit Test');
		
        $this->assertSame($result, 'blue');
    }
	
	/**
     * @covers Beciteable_ValidateImpl::background
     */
	public function testOnBackground09() {
		$result = $this->_validate->background('purple', 'Unit Test');
		
        $this->assertSame($result, 'purple');
    }
	
	/**
     * @covers Beciteable_ValidateImpl::background
     */
	public function testOnBackground10() {
		$result = $this->_validate->background('green', 'Unit Test');
		
        $this->assertSame($result, 'green');
    }
	
}
