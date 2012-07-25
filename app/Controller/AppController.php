<?php
class AppController extends Controller {
	
	public $helpers = array('Html', 'Form', 'Session', 'Image', 'ScriptCombiner', 'Text');
	public $components = array(
		'Auth' => array(
			'autoRedirect' => true,
			'loginRedirect' => array('admin' => true, 'controller' => 'users', 'action' => 'index'),
			'logoutRedirect' => array('admin' => true, 'controller' => 'users', 'action' => 'login'),
			'fields' => array(
				'username' => 'email',
				'password' => 'password'
			),
			'authenticate' => array(
				'Form' => array(
					'userModel' => 'User',
					'fields' => array(
						'username' => 'email',
						'password' => 'password'
					)
				)
			)
		),
		'Session',
		'RequestHandler'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		if ( !$this->_isAdmin() ) {
			$this->Auth->allow('login', 'logout', 'display');
		} else {
			$this->theme = 'Adminus';
			$this->layoutPath = 'admin';
			$this->layout = 'admin';
			$this->helpers[] = 'Adminable.Admin';
		}
	}
	
	protected function _isAdmin() {
		return isset($this->params['admin']) && $this->params['admin'];
	}
	
	public function setFlashMessage($message = null, $class = null, $redirect = false) {
		$this->Session->setFlash($message, '', array('class' => 'alert alert-' . $class), $class);
		if ($redirect) {
			$this->redirect($redirect);
		}
	}
}