<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
		'Session',
		'Cookie',
		'Auth' => array(
			'authenticate' =>  array(
				'Form' => array(
					'fields' => array(
						'username' => 'email'
					)
				)
			),
			'loginRedirect' => array('controller' => 'snippets', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'snippets', 'action' => 'index')
		)
	);

	public $helpers = array(
		'Html', 'Form', 'Session', 'Text', 'Time', 'Tagcloud'
	);

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index', 'view', 'display');

		$this->Cookie->httpOnly = true;

		if (!$this->Auth->loggedIn() && $this->Cookie->read('rememberMe')){
			$cookie = $this->Cookie->read('rememberMe');
			$this->loadModel('User');

			$user = $this->User->find('first', array(
				'conditions' => array(
					'User.email' => $cookie['email'],
					'User.password' => $cookie['password']
				)
			));

			if ($user && !$this->Auth->login($user['User'])){
				$this->redirect('/users/logout');
			}

			$this->User->id = $this->Auth->user('id');
			$this->User->contain(array('Snippet', 'Favorite'));
			$this->Session->write('User', $this->User->read());
		}

		$this->activeUser = $this->Session->read('User');
		$this->set('activeUser', $this->activeUser);

		$this->set('title_for_layout', 'Blackboard');
	}
}
