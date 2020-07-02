<?php
/**
 * OnInclusive Tests
 */
class OnExactlyOneTest extends WP_UnitTestCase {

	public $validate;
	
    public function setUp() {
        parent::setUp();
    	
    	$this->validate = new Beciteable_ValidateImpl();
    }



	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
     * Nominal cases
     */
	public function testOnExactlyOne01() {
		$result = $this->validate->exactly_one(array('one', null, null), 'Exactly One Test');
    }

	/**
     * Nominal cases
     */
	public function testOnExactlyOne02() {
		$result = $this->validate->exactly_one(array(null, 'two', null), 'Exactly One Test');
    }

	/**
     * Nominal cases
     */
	public function testOnExactlyOne03() {
		$result = $this->validate->exactly_one(array(null, null, 'three'), 'Exactly One Test');
    }



	######################################################
	#
	#		BAD TESTS
	#
	######################################################

	/**
     * Nominal cases
     * @expectedException Exception
     * @expectedExceptionMessage Exactly One Test
     */
	public function testOnExactlyOne04() {
		$result = $this->validate->exactly_one(array('one', 'two', null), 'Exactly One Test');
    }

	/**
     * Nominal cases
     * @expectedException Exception
     * @expectedExceptionMessage Exactly One Test
     */
	public function testOnExactlyOne05() {
		$result = $this->validate->exactly_one(array(null, 'two', 'three'), 'Exactly One Test');
    }

	/**
     * Nominal cases
     * @expectedException Exception
     * @expectedExceptionMessage Exactly One Test
     */
	public function testOnExactlyOne06() {
		$result = $this->validate->exactly_one(array('one', null, 'three'), 'Exactly One Test');
    }

	/**
     * Nominal cases
     * @expectedException Exception
     * @expectedExceptionMessage Exactly One Test
     */
	public function testOnExactlyOne07() {
		$result = $this->validate->exactly_one(array('one', 'two', 'three'), 'Exactly One Test');
    }

	/**
     * Nominal cases
     * @expectedException Exception
     * @expectedExceptionMessage Exactly One Test
     */
	public function testOnExactlyOne08() {
		$result = $this->validate->exactly_one(array(null, null, null), 'Exactly One Test');
    }

}
