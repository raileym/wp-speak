<?php
/**
 * OnUseIframe Tests
 */
class OnUseIframeTest extends WP_UnitTestCase {
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
	 * @covers Beciteable_ValidateImpl::useiframe
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'one' is not a valid BOOLEAN.
     */
	public function testOnBadInput01() {
		$result = $this->validate->useiframe('one', 'Unit Test');
    }

	/**
	 * @covers Beciteable_ValidateImpl::useiframe
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'falseX' is not a valid BOOLEAN.
     */
	public function testOnBadInput02() {
		$result = $this->validate->useiframe('falseX', 'Unit Test');
    }
	 
    

	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
	 * @covers Beciteable_ValidateImpl::useiframe
     */
	public function testOnTrue() {
		$result = $this->validate->useiframe('true', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::useiframe
     */
	public function testOnTrueMixedCase01() {
		$result = $this->validate->useiframe('True', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::useiframe
     */
	public function testOnTrueMixedCase02() {
		$result = $this->validate->useiframe('TrUe', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::useiframe
     */
	public function testOnTrueMixedCase03() {
		$result = $this->validate->useiframe('TRUE', 'Unit Test');
        $this->assertTrue($result);
    }



	/**
	 * @covers Beciteable_ValidateImpl::useiframe
     */
	public function testOnFalse() {
		$result = $this->validate->useiframe('false', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::useiframe
     */
	public function testOnFalseMixedCase01() {
		$result = $this->validate->useiframe('False', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::useiframe
     */
	public function testOnFalseMixedCase02() {
		$result = $this->validate->useiframe('FaLse', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::useiframe
     */
	public function testOnFalseMixedCase03() {
		$result = $this->validate->useiframe('FALSE', 'Unit Test');
        $this->assertFalse($result);
    }

}