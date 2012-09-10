<?php
class UsersController extends AppController {
	
	public $paginate = array(
		'limit' => 20,
		'paramType' => 'querystring',
		'order' => array(
			'User.created' => 'DESC'
		)
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('create', 'contato');
	}
	
	public function admin_login() {
		if ($this->Auth->user()) {
			return $this->redirect($this->Auth->redirect());
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->setFlashMessage('Login inválido', 'error');
			}
		}
	}
	
	public function admin_search() {
		$this->autoRender = false;
		$conditions = null;
		if (isset($this->request->query['search']) && !empty($this->request->query['search'])) {
			$conditions[] = array(
				'OR' => array(
					'User.name LIKE' => '%' . $this->request->query['search'] . '%',
					'User.email LIKE' => '%' . $this->request->query['search'] . '%'
				)
			);
			$this->paginate['conditions'] = $conditions;
			$this->set('users', $this->paginate('User'));
			$this->render('admin_index');
		}
	}
	
	public function admin_logout() {
		$this->redirect($this->Auth->logout());
	}
	
	public function admin_index() {
		$this->set('users', $this->paginate('User'));
	}
	
	public function admin_edit($id=null) {
		$this->User->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->User->read();
			unset($this->request->data['User']['password']);
		} else {
			if (empty($this->request->data['User']['password'])) {
				unset($this->request->data['User']['password']);
				unset($this->request->data['User']['cpassword']);
			}
			if ($this->User->save($this->request->data)) {
				$this->setFlashMessage('Usuário alterado com sucesso!', 'success', array('action' => 'index'));
			} else {
				$this->setFlashMessage('Não foi possível alterar, tente novamente!', 'error');
			}
		}
	}
	
	public function admin_add() {
		if ($this->request->is('post') && !empty($this->request->data)) {
			if ($this->User->save($this->request->data)) {
				$this->setFlashMessage('Usuário criado com sucesso!', 'success', array('action' => 'index'));
			}
		}
	}
	
	public function admin_del($id=null) {
		if ($this->request->is('get') || $this->request->is('delete')) {
			if ($this->User->delete($id)) {
				$this->setFlashMessage('Usuário excluído com sucesso!', 'success', array('action' => 'index'));
			}
		}
	}
	
	/* cria o primeiro usuário/operador */
	public function create() {
		$this->autoRender = false;
		if ($this->User->save(array('name' => 'Mkt Virtual', 'email' => 'mktvirtual@mktvirtual.com.br', 'password' => '123456', 'cpassword' => '123456'))) {
			$this->setFlashMessage('Usuário adicionado com sucesso!', 'success', array('admin' => true, 'controller' => 'users', 'action' => 'login'));
		}
	}
	
	public function contato() {
		if (!empty($this->request->data)) {
			$this->User->contato($this->request->data);
		}
	}
}