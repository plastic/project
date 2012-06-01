<?php
App::uses('UsersController', 'Controller');

class UsersControllerTest extends ControllerTestCase {
	public $fixtures = array('app.user');
	public function setUp() {
		$this->Users = $this->generate('Users', 
			array(
				'models' => array('User'),
				'components' => array(
					'Session',
					'Email',
					'RequestHandler',
					'Auth'
				)
			)
		);
	}

	public function tearDown() {
		unset($this->Users);
		ClassRegistry::flush();
	}
	
	public function testInstance() {
		$this->assertIsA($this->Users, 'UsersController');
		$this->assertIsA($this->Users->User, 'User');
	}
	
	public function testLogin() {
		$this->Users->Auth->expects($this->once())->method('login')->will($this->returnValue(false));
		$this->testAction('/admin/users/login', array('return' => 'vars'));
		
		$this->Users->Auth->expects($this->any())->method('login')->will($this->returnValue(1));
		$this->testAction('/admin/users/login', array('return' => 'vars', 'method' => 'post'));
	}
	
	public function testLogout() {
		$this->Users->Auth->expects($this->once())->method('logout')->will($this->returnValue(1));
		$this->testAction('/admin/users/logout', array('return' => 'vars', 'method' => 'get'));
	}
	
	public function testIndex() {
		$this->generate('Users', array('models' => array()));
		$result = $this->testAction('/admin/users/index', array('return' => 'vars', 'method' => 'get'));
		$this->assertArrayHasKey('users', $result);
		$this->assertArrayHasKey('User', current($result['users']));
	}
	
	public function testAdd() {
		$this->generate('Users', array('models' => array()));
		$user = array(
			'User' => array(
				'id' => 2,
				'name' => 'Plastic',
				'email' => 'andre@mktvirtual.com.br',
				'password' => '123456',
				'cpassword' => '123456'
			)
		);
		$this->testAction('/admin/users/add', array('return' => 'vars', 'method' => 'post', 'data' => $user));
		$this->assertTrue($this->Users->User->find('count') == 2);
	}
	
	public function testEdit() {
		$this->generate('Users', array('models' => array()));
		$user = array(
			'User' => array(
				'id' => 1,
				'name' => 'Andre',
				'email' => 'andre@mktvirtual.com.br'
			)
		);
		
		$this->testAction('/admin/users/edit/1', array('return' => 'vars', 'method' => 'get'));
		$this->testAction('/admin/users/edit/1', array('return' => 'vars', 'method' => 'put', 'data' => $user));
		$usuario = $this->Users->User->find('first');
		$this->assertTrue($this->Users->User->find('count') == 1);
		$this->assertTrue($usuario['User']['name'] == 'Andre');
		
		$user['User']['password'] = '654321';
		$this->testAction('/admin/users/edit/1', array('return' => 'vars', 'method' => 'put', 'data' => $user));
		$user['User']['cpassword'] = '654321';
		$this->testAction('/admin/users/edit/1', array('return' => 'vars', 'method' => 'put', 'data' => $user));
	}
	
	public function testCreate() {
		$this->generate('Users', array('models' => array()));
		
		// vai falhar
		$result = $this->testAction('/users/create', array('render' => false, 'return' => 'vars', 'method' => 'get'));
		$this->assertTrue(empty($result));
		
		$this->Users->User->delete(1);
		// vai passar
		$this->testAction('/users/create', array('return' => 'vars', 'method' => 'get'));
		$this->assertTrue($this->Users->User->find('count') == 1);
	}
	
	public function testSearch() {
		$this->generate('Users', array('models' => array()));
		$result = $this->testAction('/admin/users/search', array('return' => 'vars', 'method' => 'get', 'data' => array('search' => 'mkt')));
	}
	
	public function testDel() {
		$this->generate('Users', array('models' => array()));
		$this->testAction('/admin/users/del/1', array('method' => 'delete'));
		$this->assertTrue($this->Users->User->find('count') == 0);
	}
}