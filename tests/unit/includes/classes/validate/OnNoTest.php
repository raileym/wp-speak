<?php
/**
 * OnNo Tests
 */
class OnNoTest extends WP_UnitTestCase {
    //public $plugin_slug = 'my-plugin';
    
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
	 * @covers Beciteable_ValidateImpl::no
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'a' is not a valid INTEGER.
     */
	public function testOnBadInput01() {
		$result = $this->validate->no('a', 'Unit Test');
    }

	/**
	 * @covers Beciteable_ValidateImpl::no
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = '5000' is ABOVE the maximum range of '999'.
     */
	public function testOnFalseMixedLength01() {
		$result = $this->validate->no('5000', 'Unit Test');
    }





	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
	 * @covers Beciteable_ValidateImpl::no
     */
	public function testOnNullSetDefault() {
		$result = $this->validate->no(100, 'Unit Test');
        $this->assertEquals($result, 100);
    }

	/**
	 * @covers Beciteable_ValidateImpl::no
     */
	public function testOnTrueMixedLength() {

		for ($i=0;$i<10; $i++) {
			$randomValue = rand(100, 900);
			$result = $this->validate->no(strval($randomValue), 'Unit Test');
			$this->assertEquals($result, $randomValue);
		}
	}
}
