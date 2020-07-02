<?php
/**
 * OnId Tests
 */
class OnIdTest extends WP_UnitTestCase {
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
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'a' is the wrong length for ID.
     */
	public function testOnBadInput01() {
		$result = $this->validate->id('a', 'Unit Test');
    }

	/**
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'Should not use %.' contains improper characters.
     */
	public function testOnBadInput02() {
		$result = $this->validate->id('Should not use %.', 'Unit Test');
    }

	
	
	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
     * @covers True::isTrueMixedLength
     */
	public function testOnFalseMixedLength() {

		for ($i=0;$i<10; $i++) {
			$randomValue = rand(1000, 9000);
			$result = $this->validate->id(strval($randomValue), 'Unit Test');
			$this->assertEquals($result, strval($randomValue));
		}
		
    }
	
	/**
     * @covers True::isTrue
     */
	public function testOnId() {
		$result = $this->validate->id('100', 'Unit Test');
        $this->assertEquals($result, '100');
    }

	/**
     * @covers True::isTrueMixedLength
     */
	public function testOnTrueMixedLength() {

		for ($i=0;$i<10; $i++) {
			$randomValue = rand(100, 900);
			$result = $this->validate->id(strval($randomValue), 'Unit Test');
			$this->assertEquals($result, strval($randomValue));
		}
	}

}
