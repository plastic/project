<?php
App::uses('Post', 'Model');

class PostTestCase extends CakeTestCase
{
	public $fixtures = array('app.post');
	
	public function setUp() {
		parent::setUp();
		$this->Post = ClassRegistry::init('Post');
	}
	
	public function testPostInstance()
	{
		$this->assertTrue(is_a($this->Post, 'Post'));
	}
	
	public function tearDown() {
		unset($this->Post);
		parent::tearDown();
	}
}
