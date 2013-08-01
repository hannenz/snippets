<?php
class Hit extends AppModel {

	var $displayField = 'ip';

	public $actsAs = array(
		'Containable'
	);

	public $belongsTo = array('Snippet');

	public function beforeValidate(){

		$existingHits = $this->find('count', array(
			'conditions' => array(
				'ip' => $this->data[$this->alias]['ip'],
				'snippet_id' => $this->data[$this->alias]['snippet_id'],
				'created >' => strftime('%x %T', strtotime('-1 day')),
			)
		));
		if ($existingHits == 0){
			$this->Snippet->score($this->data[$this->alias]['snippet_id'], 1);
			return true;
		}
		return false;
	}
}