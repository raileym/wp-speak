<?php
/**
 * OnShowDesc Tests
 */
class OnShowDescTest extends WP_UnitTestCase {
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
	 * @covers Beciteable_ValidateImpl::showdesc
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'one' is not a valid BOOLEAN.
     */
	public function testOnBadInput01() {
		$result = $this->validate->showdesc('one', 'Unit Test');
    }

	/**
	 * @covers Beciteable_ValidateImpl::showdesc
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'falseX' is not a valid BOOLEAN.
     */
	public function testOnBadInput02() {
		$result = $this->validate->showdesc('falseX', 'Unit Test');
    }
	 
    

	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
	 * @covers Beciteable_ValidateImpl::showdesc
     */
	public function testOnTrue() {
		$result = $this->validate->showdesc('true', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::showdesc
     */
	public function testOnTrueMixedCase01() {
		$result = $this->validate->showdesc('True', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::showdesc
     */
	public function testOnTrueMixedCase02() {
		$result = $this->validate->showdesc('TrUe', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::showdesc
     */
	public function testOnTrueMixedCase03() {
		$result = $this->validate->showdesc('TRUE', 'Unit Test');
        $this->assertTrue($result);
    }



	/**
	 * @covers Beciteable_ValidateImpl::showdesc
     */
	public function testOnFalse() {
		$result = $this->validate->showdesc('false', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::showdesc
     */
	public function testOnFalseMixedCase01() {
		$result = $this->validate->showdesc('False', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::showdesc
     */
	public function testOnFalseMixedCase02() {
		$result = $this->validate->showdesc('FaLse', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::showdesc
     */
	public function testOnFalseMixedCase03() {
		$result = $this->validate->showdesc('FALSE', 'Unit Test');
        $this->assertFalse($result);
    }

}