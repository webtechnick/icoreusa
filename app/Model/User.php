<?php
App::uses('AppModel', 'Model');
App::uses('Security', 'Utility');
/**
 * User Model
 *
 * @property Contractor $Contractor
 */
class User extends AppModel {
	
	public $displayField = 'email';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please use a valid email address'
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'Email already taken'
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'is_admin' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
		'is_contractor' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
		'contractor_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'Contractor' => array(
			'className' => 'Contractor',
			'foreignKey' => 'contractor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	/**
	* If the user hasn't filled out their first name, assume they're not filling out the
	* contractor part of the user integration, and ignore it with validations
	*/
	public function saveAll($data, $options = array()){
		if(isset($data['Contractor']['first_name']) && empty($data['Contractor']['first_name'])){
			unset($data['Contractor']);
		} else {
			$data['User']['is_contractor'] = true;
		}
		return parent::saveAll($data, $options);
	}
	
	public function register($data){
		if($data['User']['password'] != $data['User']['confirm_password']){
			$this->invalidate('password', 'Password and Confirmation Password don\'t match.');
			return false;
		}
		$data['User']['password'] = $this->hashPassword($data['User']['password']);
		return $this->save($data);
	}
	
	/**
	* Find the user by email or username
	* @param username_or_email
	* @param password
	* @return user found, or null
	*/
	function findByEmailAndPassword($email, $password){
		return $this->find('first', array(
			'conditions' => array(
				'email' => $email,
				'password' => $password
			),
			'recursive' => -1
		));
	}
	
	/**
	* Hash the password.
	* @param string to hash
	* @return string hashed password.
	*/
	function hashPassword($password){
		return Security::hash($password, null, true);
	}
}
