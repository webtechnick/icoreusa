<?php
App::uses('AppModel', 'Model');
/**
 * Contractor Model
 *
 * @property Upload $Upload
 * @property User $User
 */
class Contractor extends AppModel {
	
	public $displayField = 'email';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'first_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your first name',
			),
		),
		'last_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your last name',
			),
		),
		'phone_number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter a phone number, will be shown to clients.'
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Must be a valid email, will be shown to clients',
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please fill out a short bio about yourself',
			),
		),
		'is_full' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Upload' => array(
			'className' => 'Upload',
			'foreignKey' => 'contractor_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
	
	public $belongsTo = array(
		'User',
		'Image' => array(
			'className' => 'Upload',
			'foreignKey' => 'image_id'
		),
	);
	
	public $searchFields = array('first_name','last_name','email','phone_number','description');
	
	public function saveAll($data, $options = array()){
		return parent::saveAll($data, $options);
	}
	/**
	* Upgrade a contractor account
	* @param int id
	*/
	public function upgrade($id = null){
		if($id) $this->id = $id;
		if($this->exists()){
			return $this->saveField('is_full', true);
		}
		return false;
	}
	
	/**
	* Downgrade a contractor account
	* @param int id of contractor
	*/
	public function downgrade($id = null){
		if($id) $this->id = $id;
		if($this->exists()){
			return $this->saveField('is_full', false);
		}
		return false;
	}

}
