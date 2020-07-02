<?php
/**
 * OnInclusive Tests
 */
class OnInclusiveTest extends WP_UnitTestCase {

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
     * @covers Beciteable_ValidateImpl::inclusive
     * @expectedException Exception
     * @expectedExceptionMessage Required Parameter 'four' is missing.
     */
	public function testOnInclusiveSet02() {
		$result = $this->validate->inclusive(array('one','four'), array('two'=>2, 'three'=>3), array('one'=>1, 'two'=>2, 'three'=>3, 'fourX'=>4));
    }

	/**
     * @covers Beciteable_ValidateImpl::inclusive
     * @expectedException Exception
     * @expectedExceptionMessage There is no such Parameter 'twoX'.
     */
	public function testOnInclusiveSet03() {
		$result = $this->validate->inclusive(array('one','four'), array('two'=>2, 'three'=>3), array('one'=>1, 'twoX'=>2, 'three'=>3, 'four'=>4));
    }

	
	
	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
     * @covers Beciteable_ValidateImpl::inclusive
     */
	public function testOnInclusiveSet01() {
		$result = $this->validate->inclusive(array('one','four'), array('two'=>2, 'three'=>3), array('one'=>1, 'two'=>2, 'three'=>3, 'four'=>4));
		foreach ($result as $key => $value) {
			switch($key) {
				case 'one':	
			        $this->assertEquals($value, 1);
			        break;
				case 'two':	
			        $this->assertEquals($value, 2);
			        break;
				case 'three':	
			        $this->assertEquals($value, 3);
			        break;
				case 'one':	
			        $this->assertEquals($value, 4);
			        break;
				
			}
			//echo "Key: $key; Value: $value<br />\n";
		}
    }

}