<?php
App::uses('AppController', 'Controller');
/**
 * Snippets Controller
 *
 * @property Snippet $Snippet
 */
class SnippetsController extends AppController {

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('add');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$filters = array();
		$conditions = array();

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

		$this->paginate = array(
			'limit' => 8,
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
			if ($this->Snippet->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The snippet has been saved'));

				if ($this->request->data['Snippet']['fetch_remote'] == 1){
					$this->redirect(array('action' => 'after_remote', $this->Snippet->id));
				}

				$this->request->data['Snippet']['user_id'] = $this->Auth->user('id');
				debug ($this->request->data);
				die();


				$this->redirect(array('action' => 'index'));
			}
			else {
				$this->Session->setFlash(__('The snippet could not be saved. Please, try again.'));
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
				$this->Session->setFlash(__('The snippet has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The snippet could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Snippet->read(null, $id);
		}
		$users = $this->Snippet->User->find('list');
		$tags = $this->Snippet->Tag->find('list');
		$this->set(compact('users', 'tags'));
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
		if ($this->Snippet->delete()) {
			$this->Session->setFlash(__('Snippet has been deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Snippet could not been deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
