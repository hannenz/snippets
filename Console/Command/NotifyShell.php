<?php
App::uses('AppModel', 'Model');
App::uses('User', 'Model');
App::uses('Snippet', 'Model');
App::uses('CakeEmail', 'Network/Email');

class NotifyShell extends AppShell {


	public function main(){
		$this->User = new User();

		$this->Snippet = new Snippet();
		$conditions = array(
				'Snippet.created >' => strftime('%Y-%m-%d %H:%M', strtotime('-1 day'))
		);

		$snippets = $this->Snippet->find('all', compact('conditions'));

		if (count($snippets) > 0){

			$users = $this->User->find('all', array(
				'conditions' => array(
					'User.notify_daily' => true
				)
			));
			if (count($users) > 0){
				foreach ($users as $user){
					$Email = new CakeEmail();
					$Email->config('smtp');
					$Email->to($user['User']['email']);
					$Email->subject('Blackboard: Your Daily Dose');
					$Email->emailFormat('both');
					$Email->template('notify_daily');
					$Email->viewVars(array('user' => $user, 'snippets' => $snippets, 'servername' => 'blackboard.agentur-halma.de'));
					$Email->send();
				}
			}
		}
	}
}
?>

