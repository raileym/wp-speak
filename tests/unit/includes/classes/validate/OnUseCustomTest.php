<?php
/**
 * OnUseCustom Tests
 */
class OnUseCustomTest extends WP_UnitTestCase {
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
	 * @covers Beciteable_ValidateImpl::usecustom
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'one' is not a valid BOOLEAN.
     */
	public function testOnBadInput01() {
		$result = $this->validate->usecustom('one', 'Unit Test');
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecustom
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'falseX' is not a valid BOOLEAN.
     */
	public function testOnBadInput02() {
		$result = $this->validate->usecustom('falseX', 'Unit Test');
    }
	 
    

	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
	 * @covers Beciteable_ValidateImpl::usecustom
     */
	public function testOnTrue() {
		$result = $this->validate->usecustom('true', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecustom
     */
	public function testOnTrueMixedCase01() {
		$result = $this->validate->usecustom('True', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecustom
     */
	public function testOnTrueMixedCase02() {
		$result = $this->validate->usecustom('TrUe', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecustom
     */
	public function testOnTrueMixedCase03() {
		$result = $this->validate->usecustom('TRUE', 'Unit Test');
        $this->assertTrue($result);
    }



	/**
	 * @covers Beciteable_ValidateImpl::usecustom
     */
	public function testOnFalse() {
		$result = $this->validate->usecustom('false', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecustom
     */
	public function testOnFalseMixedCase01() {
		$result = $this->validate->usecustom('False', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecustom
     */
	public function testOnFalseMixedCase02() {
		$result = $this->validate->usecustom('FaLse', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecustom
     */
	public function testOnFalseMixedCase03() {
		$result = $this->validate->usecustom('FALSE', 'Unit Test');
        $this->assertFalse($result);
    }

}