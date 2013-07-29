<?php
App::uses('AppModel', 'Model');
/**
 * Snippet Model
 *
 * @property User $User
 * @property Tag $Tag
 */
class Snippet extends AppModel {

	public $actsAs = array(
		'Containable'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'url' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
			'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'snippets_tags',
			'foreignKey' => 'snippet_id',
			'associationForeignKey' => 'tag_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	public $hasMany = array(
		'Comment'
	);

	public function beforeValidate($options = array()){
		if (!empty($this->data[$this->alias]['tags'])){
			$tags = explode(' ', $this->data[$this->alias]['tags']);
			$tag_ids = array();
			foreach ($tags as $tag){
				$name = strtolower(trim($tag));
				$tag_id = $this->Tag->field('id', compact('name'));
				if (empty($tag_id)){
					$this->Tag->create();
					$this->Tag->save(array('Tag' => compact('name')));
					$tag_id = $this->Tag->id;
				}
				$tag_ids[] = $tag_id;
			}

			$this->data['Tag']['Tag'] = array_merge($tag_ids, $this->data['Tag']['Tag']);
		}

		return true;
	}

	public function beforeSave($options = array()){

		if (isset($this->data[$this->alias]['fetch_remote']) && $this->data[$this->alias]['fetch_remote'] == 1){
			$filename = $this->uniqueFilename();
			file_put_contents(WWW_ROOT . 'files' . DS . $filename, file_get_contents($this->data['Snippet']['image']));
			$this->data['Snippet']['image'] = '/files/'.$filename;
		}
		else {
			
			if (!empty($this->data[$this->alias]['image_upload']['name']) && $this->data[$this->alias]['image_upload']['error'] == 0 && is_uploaded_file($this->data[$this->alias]['image_upload']['tmp_name'])){
				move_uploaded_file($this->data[$this->alias]['image_upload']['tmp_name'], WWW_ROOT . 'files' . DS . $this->data[$this->alias]['image_upload']['name']);
				$this->data[$this->alias]['image'] = '/files/'.$this->data[$this->alias]['image_upload']['name'];
			}
			if (!empty($this->data[$this->alias]['attachment_upload']['name']) && $this->data[$this->alias]['attachment_upload']['error'] == 0 && is_uploaded_file($this->data[$this->alias]['attachment_upload']['tmp_name'])){
				move_uploaded_file($this->data[$this->alias]['attachment_upload']['tmp_name'], WWW_ROOT.'files' . DS . $this->data[$this->alias]['attachment_upload']['name']);
				$this->data[$this->alias]['attachment'] = '/files/'.$this->data[$this->alias]['attachment_upload']['name'];
			}
		}

		return true;
	}

/*
* Generates a unique filename
*
* name: uniqueFilename
* @return string: unique filename
*/
	private function uniqueFilename(){
		$ipbits = explode('.', $_SERVER['REMOTE_ADDR']);
		list($usec, $sec) = explode(' ', microtime());
		$usec = (integer) ($usec * 65536);
		$sec = ((integer) $sec) & 0xFFFF;
		$uid = sprintf('%08x-%04x-%04x', ($ipbits[0] << 24) | ($ipbits[1] << 16) | ($ipbits[2] << 8) | $ipbits[3], $sec, $usec);
		return ($uid);
	}

}
