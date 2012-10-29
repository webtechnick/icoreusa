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
	public $actsAs = array(
		'WebTechNick.Rangeable'
	);

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
		'street' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your street address',
			),
		),
		'city' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your city',
			),
		),
		'state' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please select your state',
			),
		),
		'zip' => array(
			'notempty' => array(
				'rule' => array('postal', null, 'us'),
				'message' => 'Please enter your zip',
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
	
	/**
	* Geoloc a contractor on the first save
	*/
	public function afterSave($created){
		if($created){
			$this->geoLoc();
		}
	}
	
	public function saveAll($data, $options = array()){
		return parent::saveAll($data, $options);
	}
	
	/**
	* Geolocate by id.
	* @param int id
	*/
	function geoLoc($id = null){
		if($id) $this->id = $id;
		if($this->id){
			$Contractor = $this->find('first', array(
				'conditions' => array('Contractor.id' => $this->id),
				'fields' => array(
					'Contractor.street',
					'Contractor.street_2',
					'Contractor.city',
					'Contractor.state',
					'Contractor.zip',
				),
				'contain' => array()
			));
			if(!empty($Contractor)){
				$address = "{$Contractor['Contractor']['street']} {$Contractor['Contractor']['street_2']}, {$Contractor['Contractor']['city']}, {$Contractor['Contractor']['state']} {$Contractor['Contractor']['zip']}";
				if($geoloc = $this->geoLocAddress($address)){
					$this->saveField('lat', $geoloc['results'][0]['lat']);
					$this->saveField('lon', $geoloc['results'][0]['lon']);
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	* Geoloc an address for me.
	* @param string address fragment
	* @return mixed result of geocode lookup
	*/
	function geoLocAddress($address){
		$this->loadGeoLoc();
		return $this->GeoLoc->byAddress($address);
	}
	
	/**
	* Loads the GeoLoc datasource into GeoLoc
	*/
	function loadGeoLoc(){
		if(!$this->GeoLoc){
			App::import('Core','ConnectionManager');
			$this->GeoLoc = ConnectionManager::getDataSource('geoloc');
		}
	}
	
	/**
	* Get Conditions By Search
	* @param string input
	* @return array conditions
	*/
	public function getConditionsBySearch($input){
		$retval = array();
		if($this->isValidZip($input)){
			$zip = ClassRegistry::init('Zip')->findByZip($input);
			if(!empty($zip)){
				$query = $this->getRangeQuery(array(), 20, $zip['Zip']['lat'], $zip['Zip']['lon']);
				$retval = $query['conditions'];
			}
		} else {
			$retval = $this->generateFilterConditions($input);
		}
		return $retval;
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
