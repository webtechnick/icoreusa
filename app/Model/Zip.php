<?php
class Zip extends AppModel {
	var $name = 'Zip';
	var $primaryKey = 'zip';
	var $validate = array(
		'zip' => "notempty",
	);
	var $searchFields = array('Zip.zip','Zip.city','Zip.state');
	
	/**
	* Add to the zipcode table, but first do a geoloc on the zipcode
	*/
	function add($zip = null){	
		if($zip){
			if($this->hasAny(array('Zip.zip' => $zip))){
				$this->validationErrors['zip'] = 'Zipcode already exists.';
				return false;
			}
			
			$this->GeoLoc = ConnectionManager::getDataSource('geoloc');
			$result = $this->GeoLoc->byAddress($zip);
			if(!empty($result['results'])){
				$data = array(
					'zip' => $zip,
					'lat' => $result['results'][0]['lat'],
					'lon' => $result['results'][0]['lon'],
					'city' => $result['results'][0]['city'],
					'state' => $result['results'][0]['state'],
					'country' => $result['results'][0]['country'],
					'is_primary' => true,
				);
				$this->create();
				return $this->save($data);
			}
		}
		return false;
	}
	
	/**
	*
	*/
	function findCityByZip($zip = null){
		$city = $this->find('first', array(
			'conditions' => array(
				'Zip.zip' => $zip,
			),
			'contain' => array(),
			'fields' => array('Zip.city')
		));
		return empty($city) ? null : strtolower($city['Zip']['city']);
	}
}