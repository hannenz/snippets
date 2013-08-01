<?php
App::uses('AppController', 'Controller');
/**
 * Comments Controller
 *
 * @property Comment $Comment
 */
class CommentsController extends AppController {


/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Comment->create();
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash('Dein Kommentar wurde gespeichert.', 'flash', array('type' => 'success'));

				$this->Comment->contain(array(
					'Snippet' => array(
						'User'
					),
					'User'
				));
				$comment = $this->Comment->read();

				if ($comment['Snippet']['User']['notify_on_comments']){
					App::uses('CakeEmail', 'Network/Email');
					$Email = new CakeEmail();
					$Email->config('smtp');
					$Email->to($comment['Snippet']['User']['email']);
					$Email->subject('Einer deiner Schnipsel wurde kommentiert');
					$Email->emailFormat('both');
					$Email->template('notify_comment');
					$Email->viewVars(compact('comment'));
					$Email->send();
				}

				$this->redirect(array('controller' => 'snippets', 'action' => 'view', $this->request->data['Comment']['snippet_id']));
			}
			else {
				$this->Session->setFlash('Kommentar konnte nicht gespeichert werden. Bitte prüfe das Formular und versuche es noch einmal', 'flash', array('type' => 'alert'));
				$this->redirect(array('controller' => 'snippets', 'action' => 'view', $this->request->data['Comment']['snippet_id']));
			}
		}
		$users = $this->Comment->User->find('list');
		$snippets = $this->Comment->Snippet->find('list');
		$this->set(compact('users', 'snippets'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('The comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Kommentar konnte nicht gespeichert werden. Bitte prüfe das Formular und versuche es noch einmal', 'flash', array('type' => 'alert'));
			}
		} else {
			$this->request->data = $this->Comment->read(null, $id);
		}
		$users = $this->Comment->User->find('list');
		$snippets = $this->Comment->Snippet->find('list');
		$this->set(compact('users', 'snippets'));
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
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->Comment->delete()) {
			$this->Session->setFlash(__('Comment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Comment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
