<?php
/**
 * OnShowBorder Tests
 */
class OnShowBorderTest extends WP_UnitTestCase {
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
	 * @covers Beciteable_ValidateImpl::showborder
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'one' is not a valid BOOLEAN.
     */
	public function testOnBadInput01() {
		$result = $this->validate->showborder('one', 'Unit Test');
    }

	/**
	 * @covers Beciteable_ValidateImpl::showborder
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'falseX' is not a valid BOOLEAN.
     */
	public function testOnBadInput02() {
		$result = $this->validate->showborder('falseX', 'Unit Test');
    }
	 
    

	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
	 * @covers Beciteable_ValidateImpl::showborder
     */
	public function testOnTrue() {
		$result = $this->validate->showborder('true', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::showborder
     */
	public function testOnTrueMixedCase01() {
		$result = $this->validate->showborder('True', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::showborder
     */
	public function testOnTrueMixedCase02() {
		$result = $this->validate->showborder('TrUe', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::showborder
     */
	public function testOnTrueMixedCase03() {
		$result = $this->validate->showborder('TRUE', 'Unit Test');
        $this->assertTrue($result);
    }



	/**
	 * @covers Beciteable_ValidateImpl::showborder
     */
	public function testOnFalse() {
		$result = $this->validate->showborder('false', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::showborder
     */
	public function testOnFalseMixedCase01() {
		$result = $this->validate->showborder('False', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::showborder
     */
	public function testOnFalseMixedCase02() {
		$result = $this->validate->showborder('FaLse', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::showborder
     */
	public function testOnFalseMixedCase03() {
		$result = $this->validate->showborder('FALSE', 'Unit Test');
        $this->assertFalse($result);
    }

}