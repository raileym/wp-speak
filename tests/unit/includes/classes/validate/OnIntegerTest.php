<?php
/**
 * OnInteger Tests
 */
class OnIntegerTest extends WP_UnitTestCase {
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
	 * @covers Beciteable_ValidateImpl::integer
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'a' is not a valid INTEGER.
     */
	public function testOnBadInput01() {
		$result = $this->validate->_integer('a', 1, 1000, 'Unit Test');
    }

	/**
	 * @covers Beciteable_ValidateImpl::integer
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = '5000' is ABOVE the maximum range of '900'.
     */
	public function testOnFalseMixedLength01() {
		$result = $this->validate->_integer('5000', 100, 900, 'Unit Test');
    }

	/**
	 * @covers Beciteable_ValidateImpl::integer
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = '50' is BELOW the minimum range of '100'.
     */
	public function testOnFalseMixedLength02() {
		$result = $this->validate->_integer('50', 100, 900, 'Unit Test');
    }




	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
	 * @covers Beciteable_ValidateImpl::integer
     */
	public function testOnNullSetDefault() {
		$result = $this->validate->_integer(100, 1, 1000, 'Unit Test');
        $this->assertEquals($result, 100);
    }

	/**
	 * @covers Beciteable_ValidateImpl::integer
     */
	public function testOnTrueMixedLength() {

		for ($i=0;$i<10; $i++) {
			$randomValue = rand(100, 900);
			$result = $this->validate->_integer(strval($randomValue), 1, 1000, 'Unit Test');
			$this->assertEquals($result, $randomValue);
		}
	}
}
