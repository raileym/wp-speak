<?php
/**
 * MyPlugin Tests
 */
class MyPluginTest extends WP_UnitTestCase {
    public $plugin_slug = 'my-plugin';

    public function setUp() {
        parent::setUp();
        $this->wp_speak = $GLOBALS['wp-speak'];
    }

    public function testTrueStillEqualsTrue() {
        $this->assertTrue(true);
    }
}
