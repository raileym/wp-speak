<?php
/**
 * OnValidate Tests
 */
class OnValidateTest extends WP_UnitTestCase {
    //public $plugin_slug = 'my-plugin';
    
	public $comm;
	
    public function setUp() {
        parent::setUp();
    	
    	$this->comm = new Beciteable_CommImpl();
    }

	/* Error cases.
	 *
	 *	Malformed URLS
	 *
	 *		Added !
	 *		Only used one slash /
	 *		Used semi-colon, not colon
	 *		
	 */

	/**
     * @covers True::isTrue
     * @expectedException Exception
     */
	public function testOnMalformedInput01() {
		$result = $this->comm->validate('http://www.google.com!', null, 'Unit Test');
    }

	/**
     * @covers True::isTrue
     * @expectedException Exception
     */
	public function testOnMalformedInput03() {
		$result = $this->comm->validate('http:/www.google.com', null, 'Unit Test');
    }

	/**
     * @covers True::isTrue
     * @expectedException Exception
     */
	public function testOnMalformedInput04() {
		$result = $this->comm->validate('http;//www.google.com', null, 'Unit Test');
    }
    
    
    /* Nominal cases
     *
     *		Without http:
     *		With http:
     */

	/**
     * @covers True::isTrue
     */
	public function testOnProperInput01() {
		$result = $this->comm->validate('www.google.com', null, 'Unit Test');
    }

	/**
     * @covers True::isTrue
     */
	public function testOnProperInput02() {
		$result = $this->comm->validate('http://www.google.com', null, 'Unit Test');
    }

	/**
     * @covers True::isTrue
     */
	public function testOnProperInput03() {
		$result = $this->comm->validate(null, null, 'Unit Test');
    }

    

}
