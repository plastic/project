<?php
require_once('AllTestsTest.php');

class AllTestsTestTest extends CakeTestCase
{
	public function setUp() {
		parent::setUp();
	}
	
	public function tearDown() {
		parent::tearDown();
	}
	
	public function testSuite()
	{
		$this->assertNotNull(AllTestsTest::suite());
	}
}