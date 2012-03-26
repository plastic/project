<?php
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
	
	public $displayField = 'name';
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'message' => 'O nome deve ser preenchido'
		),
		'email' => array(
			'mustNotEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'O e-mail deve ser preenchido!',
				'last' => true
			),
			'mustBeEmail' => array(
				'rule' => array('email'),
				'message' => 'E-mail inválido',
				'last' => true),
			'mustUnique' => array(
				'rule' => 'isUnique',
				'on' => 'create',
				'message' => 'E-mail já cadastrado!',
			)
		),
		'password' => array(
			'mustNotEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Senha é obrigatório!',
				'on' => 'create',
				'last' => true),
			'mustBeLonger' => array(
				'rule' => array('minLength', 6),
				'message' => 'Senha deve conter mais de 5 caracteres!',
				'last' => true
			),
			'mustMatch' => array(
				'rule' => array('verifies'),
				'message' => 'Senha inválida, confirme a sua senha novamente'
			)
		)
	);
	
	public function beforeSave() {
		if (isset($this->data[$this->alias]['password']) && !empty($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
	
	protected function verifies() {
		if (!isset($this->data['User']['cpassword'])) {
			return false;
		}
		return ($this->data['User']['password'] === $this->data['User']['cpassword']);
	}
}