<?php
App::uses('AppModel', 'Model');
/**
 * Tag Model
 *
 * @property Snippet $Snippet
 */
class Tag extends AppModel {

	public $actsAs = array(
		'Containable'
	);

	public $order = array('name' => 'ASC');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
			'unique' => array(
				'rule' => array('isUnique')
			)
		)

	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Snippet' => array(
			'className' => 'Snippet',
			'joinTable' => 'snippets_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'snippet_id',
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
}

