<?php
App::uses('User', 'Model');

class UserTestCase extends CakeTestCase {
	public $fixtures = array('app.user');
	public function setUp() {
		parent::setUp();
		$this->User = ClassRegistry::init('User');
	}
	
	public function tearDown() {
		unset($this->User);
		parent::tearDown();
	}
	
	public function testInstance() {
		$this->assertIsA($this->User, 'User');
	}
	
	public function testSave() {
		$this->assertFalse($this->User->save(array('name' => 'andre', 'email' => '', 'password' => '123456', 'cpassword' => '')));
		$this->assertFalse($this->User->save(array('name' => 'andre', 'email' => 'mktvirtual@mktvirtual.com.br', 'password' => '123456')));
		$this->assertFalse($this->User->save(array('name' => 'andre', 'email' => 'mktvirtual@mktvirtual.com.br', 'password' => '')));
		$this->assertFalse($this->User->save(array('name' => 'andre', 'email' => 'mktvirtual@mktvirtual.com.br', 'password' => '12345', 'cpassword' => '12345')));
		$this->assertFalse($this->User->save(array('name' => 'andre', 'email' => 'mktvirtual@mktvirtual.com.br', 'password' => '123456', 'cpassword' => '123455')));
		$this->assertFalse($this->User->save(array('name' => 'andre', 'email' => 'mktvirtual@mktvirtual.com.br', 'password' => '123456', 'cpassword' => '123456')));
		$this->assertInternalType('array', $this->User->save(array('name' => 'andre', 'email' => 'andre@mktvirtual.com.br', 'password' => '123456', 'cpassword' => '123456')));
		$this->assertTrue(empty($this->User->validationErrors));
		$this->assertTrue($this->User->find('count') == 2);
	}
}