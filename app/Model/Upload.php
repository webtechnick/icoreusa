<?php
App::uses('AppModel', 'Model');
/**
 * Upload Model
 *
 * @property Contractor $Contractor
 */
class Upload extends AppModel {
	
	public $actsAs = array('Icing.FileUpload');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'size' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'contractor_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'Contractor' => array(
			'className' => 'Contractor',
			'foreignKey' => 'contractor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	/**
	* Only delete the upload if we're the original uploader
	*/
	public function restrictedDelete($id = null, $user_id = null){
		if($id && $user_id){
			$this->id = $id;
			if($this->exists()){
				$contractor_id = $this->Contractor->field('id', array('Contractor.user_id' => $user_id));
				if(!empty($contractor_id)){
					return $this->delete();
				}
			}
		}
		return false;
	}
}
