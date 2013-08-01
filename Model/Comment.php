<?php
App::uses('AppModel', 'Model');
/**
 * Comment Model
 *
 * @property User $User
 * @property Snippet $Snippet
 * @property Comment $ChildComment
 */
class Comment extends AppModel {

	public $actsAs = array(
		'Containable'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'body' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			)
		)
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
		),
		'Snippet' => array(
			'className' => 'Snippet',
			'foreignKey' => 'snippet_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildComment' => array(
			'className' => 'Comment',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}
