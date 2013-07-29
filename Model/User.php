<?php
class User extends AppModel {
	public $validate = array(
		'email' => array(
			'unique' => array(
				'rule' => 'isUnique'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
			'valid' => array(
				'rule' => array('email', true)
			)
		),
		'password' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Bitte geben Sie ein Passwort ein'
			),
			'valid' => array(
				'rule' => '/.{6,}/',
				'message' => 'Das Password muss aus mindestens 6 Zeichen bestehen'
			),
			'match' => array(
				'rule' => 'matchConfirm',
				'message' => 'Die beiden eingegeben Passwörter stimmen nicht überein'

			)
		)
	);

	public function beforeSave($options = array()){
		if (isset($this->data[$this->alias]['password'])){
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}

	public function matchConfirm($check){
		return ($check['password'] == $this->data[$this->alias]['password_confirm']);
	}
}
