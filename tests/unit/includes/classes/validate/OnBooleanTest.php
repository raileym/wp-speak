<?php
/**
 * OnBoolean Tests
 */
class OnBooleanTest extends WP_UnitTestCase {
    //public $plugin_slug = 'my-plugin';
    
	public $validate;
	
    public function setUp() {
        parent::setUp();
        //$this->beciteable = $GLOBALS['beciteable'];
    	
    	$this->validate = new Beciteable_ValidateImpl();
    }


    
	######################################################
	#
	#		BAD TESTS
	#
	######################################################

	/**
	 * @covers Beciteable_ValidateImpl::boolean
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'one' is not a valid BOOLEAN.
     */
	public function testOnBadInput01() {
		$result = $this->validate->_boolean('one', 'Unit Test');
    }

	/**
	 * @covers Beciteable_ValidateImpl::boolean
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'falseX' is not a valid BOOLEAN.
     */
	public function testOnBadInput02() {
		$result = $this->validate->_boolean('falseX', 'Unit Test');
    }
	 
    

	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
	 * @covers Beciteable_ValidateImpl::boolean
     */
	public function testOnTrue() {
		$result = $this->validate->_boolean('true', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::boolean
     */
	public function testOnTrueMixedCase01() {
		$result = $this->validate->_boolean('True', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::boolean
     */
	public function testOnTrueMixedCase02() {
		$result = $this->validate->_boolean('TrUe', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::boolean
     */
	public function testOnTrueMixedCase03() {
		$result = $this->validate->_boolean('TRUE', 'Unit Test');
        $this->assertTrue($result);
    }



	/**
	 * @covers Beciteable_ValidateImpl::boolean
     */
	public function testOnFalse() {
		$result = $this->validate->_boolean('false', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::boolean
     */
	public function testOnFalseMixedCase01() {
		$result = $this->validate->_boolean('False', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::boolean
     */
	public function testOnFalseMixedCase02() {
		$result = $this->validate->_boolean('FaLse', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::boolean
     */
	public function testOnFalseMixedCase03() {
		$result = $this->validate->_boolean('FALSE', 'Unit Test');
        $this->assertFalse($result);
    }

}