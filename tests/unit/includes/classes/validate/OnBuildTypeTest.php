<?php
/**
 * OnBuildType Tests
 */
class OnBuildTypeTest extends WP_UnitTestCase {

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
     * @covers Beciteable_ValidateImpl::buildtype
     * @expectedException Exception
     * @expectedExceptionMessage argument(Unit Test) = 'from-cacheX' is not a valid BUILDTYPE.
     */
	public function testOnBuildType05() {
		$result = $this->validate->buildtype('from-cacheX', 'Unit Test');
    }


	######################################################
	#
	#		NORMAL TESTS
	#
	######################################################

	/**
     * @covers Beciteable_ValidateImpl::buildtype
     */
	public function testOnBuildType06() {
		$result = $this->validate->buildtype('from-cache', 'Unit Test');
		
        $this->assertSame($result, 'from-cache');
    }


	/**
     * @covers Beciteable_ValidateImpl::buildtype
     */
	public function testOnBuildType07() {
		$result = $this->validate->buildtype('re-package', 'Unit Test');
		
        $this->assertSame($result, 're-package');
    }

	/**
     * @covers Beciteable_ValidateImpl::buildtype
     */
	public function testOnBuildType08() {
		$result = $this->validate->buildtype('re-package-all', 'Unit Test');
		
        $this->assertSame($result, 're-package-all');
    }
	
}
