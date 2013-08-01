<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Snippets Controller
 *
 * @property Snippet $Snippet
 */
class SnippetsController extends AppController {

	public function beforeFilter(){
		parent::beforeFilter();

		$this->Snippet->Tag->contain(array('Snippet'));
		$this->Snippet->Tag->recursive = -1;
		$_tags = $this->Snippet->Tag->find('all');
		$tagcloudTags = array();
		foreach ($_tags as $_tag){
			$n = count($_tag['Snippet']);
			if ($n > 0){
				$key = $_tag['Tag']['name'];
				$tagcloudTags[$key] = $n;
			}
		}
		$this->set(compact('tagcloudTags'));

		if (in_array($this->request->params['action'], array('index', 'view'))){
			$this->set('showSearch', true);
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {

		$filters = array();
		$conditions = array();

		if ($this->request->is('post')){
			$conditions['OR'] = array(
				'Snippet.title LIKE' => '%'.$this->request->data['Snippet']['query'].'%',
				'Snippet.description LIKE' => '%'.$this->request->data['Snippet']['query'].'%'
			);
		}
		if ($this->request->is('ajax')){
			$this->layout = 'ajax';
		}

		if (!empty($this->request->params['named']['user_id'])){
			$conditions['Snippet.user_id'] = $this->request->params['named']['user_id'];
			$filters['user'] = $this->Snippet->User->field('name', array('id' => $this->request->params['named']['user_id']));
		}
		if (!empty($this->request->params['named']['tag_id'])){
			$this->Snippet->Tag->contain(array('Snippet'));
			$tag = $this->Snippet->Tag->read(null, $this->request->params['named']['tag_id']);
			$conditions['Snippet.id'] = Set::extract('/Snippet/id',  $tag);
			$filters['tag'] = $tag['Tag']['name'];
		}
		if (!empty($this->request->params['named']['tag_name'])){
			$this->Snippet->Tag->contain(array('Snippet'));
			$tag = $this->Snippet->Tag->findByName($this->request->params['named']['tag_name']);
			$conditions['Snippet.id'] = Set::extract('/Snippet/id',  $tag);
			$filters['tag'] = $tag['Tag']['name'];
		}

		$this->paginate = array(
			'limit' => 9,
			'order' => array('created' => 'desc'),
			'conditions' => $conditions
		);
		$this->Snippet->recursive = 0;
		$this->Snippet->contain(array('User', 'Comment', 'Tag'));
		$snippets = $this->paginate();
		$this->set(compact('snippets'));
		$this->set(compact('filters'));

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Snippet->id = $id;

		if (!$this->Snippet->exists()) {
			throw new NotFoundException(__('Invalid snippet'));
		}

		$this->Snippet->contain(array('User', 'Tag', 'Comment' => array('User')));
		$snippet = $this->Snippet->read(null, $id);
		$this->set(compact('snippet'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Snippet->create();
			$this->request->data['Snippet']['user_id'] = $this->activeUser['User']['id'];
			if ($this->Snippet->saveAll($this->request->data)) {
				$this->Session->setFlash('Schnipsel wurde gespeichert', 'flash', array('type' => 'success'));

				$this->_notify($this->Snippet->read());

				if (isset($this->request->data['Snippet']['fetch_remote']) && $this->request->data['Snippet']['fetch_remote'] == 1){
					$this->redirect(array('action' => 'after_remote', $this->Snippet->id));
				}

				$this->redirect(array('action' => 'index'));
			}
			else {
				$this->Session->setFlash('Der Schnipsel konnte nicht gespeichert werden. Bitte prüfe das Formular und versuche es noch einmal', 'flash', array('type' => 'alert'));
			}
		}

		foreach (array('url', 'image', 'title') as $getParam){
			if (!empty($_GET[$getParam])){
				$this->request->data['FromRemote'][$getParam] = $_GET[$getParam];
			}
		}

		if (!empty($this->request->data['FromRemote'])){
			$this->layout = 'remote';
		}

		$users = $this->Snippet->User->find('list');
		$tags = $this->Snippet->Tag->find('list');
		$this->set(compact('users', 'tags'));
	}

	public function after_remote($snippetId){
		$this->set(compact('snippetId'));
		$this->layout = 'remote';
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Snippet->id = $id;
		if (!$this->Snippet->exists()) {
			throw new NotFoundException(__('Invalid snippet'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Snippet->save($this->request->data)) {
				$this->Session->setFlash('Der Schnipsel wurde gespeichert', 'flash', array('type' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else {
				$this->Session->setFlash('Der Schnipsel konnte nicht gespeichert werden. Bitte prüfe das Formular und versuche es noch einmal', 'flash', array('type' => 'alert'));
			}
		} else {
			$this->request->data = $this->Snippet->read(null, $id);
			if ($this->request->data['Snippet']['user_id'] !== $this->Auth->user('id')){
				$this->Session->setFlash('Du kannst nur deine eigenen Schnipsel bearbeiten', 'flash', array('type' => 'alert'));
				$this->redirect($this->referer());
			}
		}
		$users = $this->Snippet->User->find('list');
		$tags = $this->Snippet->Tag->find('list');
		$this->set(compact('users', 'tags'));
	}

	public function starr($snippet_id){
		$this->Snippet->id = $snippet_id;
		if (!$this->Snippet->exists()) {
			throw new NotFoundException(__('Invalid snippet'));
		}

		$user_id = $this->activeUser['User']['id'];

		$query = sprintf('SELECT * FROM `snippets_users` WHERE `snippet_id`=%u AND `user_id`=%u', $snippet_id, $user_id);
		$result = $this->Snippet->query($query);

		if (empty($result)){

			if ($this->activeUser['User']['id']){
				$query = sprintf('INSERT into `snippets_users` (snippet_id, user_id) VALUES (%u, %u)', $snippet_id, $this->activeUser['User']['id']);
				$this->Snippet->query($query);
			}

			$this->Snippet->User->contain(array('Snippet', 'Favorite'));
			$user = $this->Snippet->User->read(null, $this->activeUser['User']['id']);
			$this->Session->write('User',  $user);
			$this->activeUser = $user;

			$this->Session->setFlash('Der Schnipsel wurde zu deinen Favoriten hinzugefügt', 'flash', array('type' => 'success'));
		}
		else {
			$this->Session->setFlash('Dieser Schnipsel befindet sich bereits in deinen Favoriten', 'flash');
		}
		$this->redirect(array('action' => 'index'));

	}

	public function unstarr($id){
		$this->Snippet->id = $id;
		if (!$this->Snippet->exists()) {
			throw new NotFoundException(__('Invalid snippet'));
		}

		$user_id = $this->activeUser['User']['id'];

		$query = sprintf('DELETE FROM `snippets_users` WHERE `snippet_id`=%u AND `user_id`=%u', $id, $user_id);
		$this->Snippet->query($query);

		$this->Snippet->User->contain(array('Snippet', 'Favorite'));
		$user = $this->Snippet->User->read(null, $this->activeUser['User']['id']);
		$this->Session->write('User',  $user);
		$this->activeUser = $user;

		$this->redirect(array('action' => 'index'));
	}

	public function recommend($id = null){
		if ($id == null && !empty($this->request->data['Snippet']['id'])){
			$id = $this->request->data['Snippet']['id'];
		}
		$this->Snippet->id = $id;
		if (!$this->Snippet->exists()){
			throw new NotFoundException(__('Invalid Snippet'));
		}
		$snippet = $this->Snippet->read(null, $id);

		if ($this->request->is('post')){
			$this->Snippet->User->displayField = 'email';
			$users = $this->Snippet->User->find('list', array('coditions' => array('User.id' => $this->request->data['Snippet']['emails'])));


			$Email = new CakeEmail();
			$Email->config('smtp');
			$Email->sender($this->activeUser['User']['email']);
			$Email->to($users);
			$Email->subject('Empfehlung von '.$this->activeUser['User']['name']);
			$Email->emailFormat('both');
			$Email->viewVars(array('snippet' => $snippet, 'sender' => $this->activeUser, 'comment' => $this->request->data['Snippet']['comment']));
			$Email->template('recommend');
			$Email->delivery = 'smtp';

			if ($Email->send()){
				$this->Session->setFlash('Deine Empfehlung wurde versandt', 'flash', array('type' => 'success'));
			}
			else {
				$this->Session->setFlash('Beim Versneden ist ein Fehler aufgetreten', 'flash', array('type' => 'alert'));
			}
			$this->redirect(array('action' => 'index'));
		}

		$users = $this->Snippet->User->find('list');
		$this->set(compact('users', 'snippet'));
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
		$this->Snippet->id = $id;
		if (!$this->Snippet->exists()) {
			throw new NotFoundException(__('Invalid snippet'));
		}
		$snippet = $this->Snippet->read();
		if ($snippet['Snippet']['user_id'] == $this->activeUser['User']['id']){
			if ($this->Snippet->delete()) {
				$this->Session->setFlash('Schnipsel wurde gelöscht', 'flash', array('type' => 'success'));
			}
			else {
				$this->Session->setFlash('Schnipsel konnte nicht gelöscht werden', 'flash', array('type' => 'alert'));
			}
		}
		else {
			$this->Session->setFlash('Du kannst nur deine eigenen Schnipsel löschen (Wo kömen wir denn da hin??!)', 'flash', array('type' => 'alert'));
		}

		$this->Snippet->User->contain(array('Favorite'));
		$user = $this->Snippet->User->read(null, $this->activeUser['User']['id']);
		$this->Session->write('User',  $user);
		$this->activeUser = $user;

		$this->redirect(array('action' => 'index'));
	}

	private function _notify($snippet){
		$users = $this->Snippet->User->find('all', array(
			'conditions' => array(
				'User.notify_on_new_snippet' => true
			)
		));
		if (count($users) > 0){
			foreach ($users as $user){
				$Email = new CakeEmail();
				$Email->config('smtp');
				$Email->to($user['User']['email']);
				$Email->subject('Neuer Schnipsel am Schwarzen Brett');
				$Email->emailFormat('both');
				$Email->viewVars(array('snippet' => $snippet, 'user' => $user));
				$Email->template('notify');
				$Email->send();
			}
		}
	}
}
