<?php
/**
 * OnSet Tests
 */
class OnSetTest extends WP_UnitTestCase {
    //public $plugin_slug = 'my-plugin';
    
	public $validate;
	
    public function setUp() {
        parent::setUp();
    	
    	$this->validate = new Beciteable_ValidateImpl();
    }



	/**
     *	Nominal cases
     */
	public function testOnMatchSet01() {
		$result = $this->validate->set(array('one', 'two'), array('one', 'two'), 'Unit Test');
    }

	public function testOnMatchSet02() {
		$result = $this->validate->set(array('one'=>1, 'two'=>2), array('one', 'two'), 'Unit Test');
    }

	public function testOnMatchSet03() {
		$result = $this->validate->set(array('one', 'two'), array('one'=>1, 'two'=>2), 'Unit Test');
    }

	public function testOnMatchSet04() {
		$result = $this->validate->set(array('one'=>1, 'two'=>2), array('one'=>1, 'two'=>2), 'Unit Test');
    }

	/* Assorted Error Situations
	 */
	 
	/**
     * @expectedException Exception
	 */
	public function testOnMisMatchSet01() {
		$result = $this->validate->set(array('one', 'two', 'three'), array('one', 'two'), 'Unit Test');
    }

	/**
     * @expectedException Exception
	 */
	public function testOnMisMatchSet02() {
		$result = $this->validate->set(array('one'=>1, 'two'=>2, 'three'=>3), array('one', 'two'), 'Unit Test');
    }

	/**
     * @expectedException Exception
	 */
	public function testOnMisMatchSet03() {
		$result = $this->validate->set(array('one', 'two', 'three'), array('one'=>1, 'two'=>2), 'Unit Test');
    }

	/**
     * @expectedException Exception
	 */
	public function testOnMisMatchSet04() {
		$result = $this->validate->set(array('one'=>1, 'two'=>2, 'three'=>3), array('one'=>1, 'two'=>2), 'Unit Test');
    }
	 
}
