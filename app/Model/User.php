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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $hasOne = array(
		'Contractor'
	);
	
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
