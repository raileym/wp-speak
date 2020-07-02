<?php
/**
 * OnCprtAuthor Tests
 */
class OnCprtAuthorTest extends WP_UnitTestCase {
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
	 * @covers Beciteable_ValidateImpl::cprt_author
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'John 0 Doe' is not a valid AUTHOR.
     */
	public function testOnBadInput01() {
		$result = $this->validate->cprt_author('John 0 Doe', 'Unit Test');
    }

	/**
	 * @covers Beciteable_ValidateImpl::cprt_author
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'John # Doe' is not a valid AUTHOR.
     */
	public function testOnBadInput02() {
		$result = $this->validate->cprt_author('John # Doe', 'Unit Test');
    }

	/**
	 * @covers Beciteable_ValidateImpl::cprt_author
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'John @ Doe' is not a valid AUTHOR.
     */
	public function testOnBadInput03() {
		$result = $this->validate->cprt_author('John @ Doe', 'Unit Test');
    }


	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
	 * @covers Beciteable_ValidateImpl::cprt_author
     */
	public function testOnTrue() {
		$result = $this->validate->cprt_author('John Doe', 'Unit Test');
        $this->assertEquals($result, 'John Doe');
    }

// 	/**
// 	 * @covers Beciteable_ValidateImpl::cprt_author
//      */
// 	public function testOnTrueMixedCase01() {
// 		$result = $this->validate->_cprt_author('True', 'Unit Test');
//         $this->assertTrue($result);
//     }
// 
// 	/**
// 	 * @covers Beciteable_ValidateImpl::cprt_author
//      */
// 	public function testOnTrueMixedCase02() {
// 		$result = $this->validate->_cprt_author('TrUe', 'Unit Test');
//         $this->assertTrue($result);
//     }
// 
// 	/**
// 	 * @covers Beciteable_ValidateImpl::cprt_author
//      */
// 	public function testOnTrueMixedCase03() {
// 		$result = $this->validate->_cprt_author('TRUE', 'Unit Test');
//         $this->assertTrue($result);
//     }
// 
// 
// 
// 	/**
// 	 * @covers Beciteable_ValidateImpl::cprt_author
//      */
// 	public function testOnFalse() {
// 		$result = $this->validate->_cprt_author('false', 'Unit Test');
//         $this->assertFalse($result);
//     }
// 
// 	/**
// 	 * @covers Beciteable_ValidateImpl::cprt_author
//      */
// 	public function testOnFalseMixedCase01() {
// 		$result = $this->validate->_cprt_author('False', 'Unit Test');
//         $this->assertFalse($result);
//     }
// 
// 	/**
// 	 * @covers Beciteable_ValidateImpl::cprt_author
//      */
// 	public function testOnFalseMixedCase02() {
// 		$result = $this->validate->_cprt_author('FaLse', 'Unit Test');
//         $this->assertFalse($result);
//     }
// 
// 	/**
// 	 * @covers Beciteable_ValidateImpl::cprt_author
//      */
// 	public function testOnFalseMixedCase03() {
// 		$result = $this->validate->_cprt_author('FALSE', 'Unit Test');
//         $this->assertFalse($result);
//     }

}