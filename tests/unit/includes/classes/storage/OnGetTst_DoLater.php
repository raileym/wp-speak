<?php
/**
 * OnGet Tests
 */
class OnGet extends WP_UnitTestCase {
    //public $plugin_slug = 'my-plugin';
    
	private $_storage;
	
    public function setUp() {
        parent::setUp();
    	
    	$this->_storage = new Beciteable_storageImpl();
    }

	
	
	
	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
     * @covers Beciteable__storageImpl::set
     * @covers Beciteable__storageImpl::get
     */
	public function testOnGetEmpty() {
		$result = $this->_storage->get('do nothing');
		$this->assertFalse( $result );
    }

	/**
     * @covers Beciteable__storageImpl::set
     * @covers Beciteable__storageImpl::get
     */
	public function testOnSetGet01() {
		$result = $this->_storage->set('my Test','my Test Value', 10);
		$result = $this->_storage->get('my Test');
		$this->assertEquals($result, 'my Test Value');
    }

	/**
     * @covers Beciteable__storageImpl::set
     * @covers Beciteable__storageImpl::get
     * @covers Beciteable__storageImpl::delete
     */
	public function testOnSetGet02() {
		$result = $this->_storage->set('my Test','my Test Value', 10);
		$result = $this->_storage->delete('my Test');
		$result = $this->_storage->get('my Test');
		$this->assertFalse( $result );
    }

	/**
     * @covers Beciteable__storageImpl::set
     * @covers Beciteable__storageImpl::get
     */
	public function testOnSetGet03() {
		$result = $this->_storage->set('my Test', null, 10);
		$result = $this->_storage->get('my Test');
		$this->assertEquals($result, null);
    }

	/**
     * @covers Beciteable__storageImpl::set
     * @covers Beciteable__storageImpl::get
     */
	public function testOnSetGet04() {
		$result = $this->_storage->set('my Test',null, 1);
		sleep(2);
		$result = $this->_storage->get('my Test');
		$this->assertFalse( $result );
    }

	/**
     * @covers Beciteable__storageImpl::set
     * @covers Beciteable__storageImpl::get
     */
	public function testOnSetGet05() {
		$result = $this->_storage->set('my Test','my Test Value', 5);
		sleep(2);
		$result = $this->_storage->get('my Test');
		$this->assertEquals($result, 'my Test Value');
    }

	/**
     * @covers Beciteable__storageImpl::set
     * @covers Beciteable__storageImpl::get
     */
	public function testOnSetGet06() {
		$result = $this->_storage->set('my Test','my Test Value', 5);
		sleep(2);
		$result = $this->_storage->get('my Test');
		$this->assertEquals($result, 'my Test Value');
		sleep(4);
		$result = $this->_storage->get('my Test');
		$this->assertFalse( $result );
    }
}
