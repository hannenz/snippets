<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('add');
	}

	public function login(){

		if ($this->request->is('post')){
			if ($this->Auth->login()){

				$this->User->id = $this->Auth->user('id');
				$this->User->contain(array('Snippet', 'Favorite'));
				$this->Session->write('User', $this->User->read());


				if ($this->request->data['User']['rememberme'] == 1) {
					$cookieTime = "12 months"; // You can do e.g: 1 week, 17 weeks, 14 days
					unset($this->request->data['User']['rememberme']);
					$this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
					$this->Cookie->write('rememberMe', $this->request->data['User'], true, $cookieTime);
				}

				$this->redirect($this->Auth->redirect());
			}
			else {
				$this->Session->setFlash('Ungültiger Benutzername oder Passwort', 'flash', array('type' => 'alert'), 'auth');
			}
		}
	}

	public function logout(){
		$this->Session->setFlash('Du hast dich abgemeldet', 'flash', array('type' => ''));
		$this->Cookie->delete('rememberMe');
		$this->redirect($this->Auth->logout());
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('controller' => 'snippets', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if (empty($this->request->data['User']['password_confirm'])){
				unset($this->request->data['User']['password']);
				unset($this->request->data['User']['password_confirm']);
			}
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('Profil wurde gespeichert', 'flash', array('type' => 'success'));

				$this->User->contain(array('Snippet', 'Favorite'));
				$user = $this->User->read();
				$this->Session->write('User', $user);

				$this->redirect(array('controller' => 'snippets', 'action' => 'index'));
			}
			else {
				$this->Session->setFlash('Profil konnte nicht gespeichert werden. Bitte prüfe das Formular und versuche es noch einmal', 'flash', array('type' => 'alert'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
