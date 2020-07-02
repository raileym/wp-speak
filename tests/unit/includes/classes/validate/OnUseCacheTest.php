<?php
/**
 * OnUseCache Tests
 */
class OnUseCacheTest extends WP_UnitTestCase {
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
	 * @covers Beciteable_ValidateImpl::usecache
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'one' is not a valid BOOLEAN.
     */
	public function testOnBadInput01() {
		$result = $this->validate->usecache('one', 'Unit Test');
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecache
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'falseX' is not a valid BOOLEAN.
     */
	public function testOnBadInput02() {
		$result = $this->validate->usecache('falseX', 'Unit Test');
    }
	 
    

	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
	 * @covers Beciteable_ValidateImpl::usecache
     */
	public function testOnTrue() {
		$result = $this->validate->usecache('true', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecache
     */
	public function testOnTrueMixedCase01() {
		$result = $this->validate->usecache('True', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecache
     */
	public function testOnTrueMixedCase02() {
		$result = $this->validate->usecache('TrUe', 'Unit Test');
        $this->assertTrue($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecache
     */
	public function testOnTrueMixedCase03() {
		$result = $this->validate->usecache('TRUE', 'Unit Test');
        $this->assertTrue($result);
    }



	/**
	 * @covers Beciteable_ValidateImpl::usecache
     */
	public function testOnFalse() {
		$result = $this->validate->usecache('false', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecache
     */
	public function testOnFalseMixedCase01() {
		$result = $this->validate->usecache('False', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecache
     */
	public function testOnFalseMixedCase02() {
		$result = $this->validate->usecache('FaLse', 'Unit Test');
        $this->assertFalse($result);
    }

	/**
	 * @covers Beciteable_ValidateImpl::usecache
     */
	public function testOnFalseMixedCase03() {
		$result = $this->validate->usecache('FALSE', 'Unit Test');
        $this->assertFalse($result);
    }

}