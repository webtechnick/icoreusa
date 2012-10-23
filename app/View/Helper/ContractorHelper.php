<?php
App::uses('AppHelper','View/Helper');
class ContractorHelper extends AppHelper{
  var $Contractor = null;
  var $helpers = array('Html','Form','Js');
  
  /**
  * Wrapper for setContractor
  * To be consistent with the content helper
  */
  function set($Contractor){
  	$this->setContractor($Contractor);
  }
  
  /**
  * Set the Contractor to base all functions off of
  * @param Contractor
  * @return void
  */
  function setContractor($Contractor){
  	$this->Contractor = $Contractor;
  }
  
  /**
  * Take in a time and convert to 24 hours
  * look for PM in the text and if PM exists
  * parse it out, look for : in the text, if it
  * exists parse it out as minutes and hours then 
  * add 12 to hours and add back on minutes
  * then return
  * @param string time as (4:00 PM)
  */
  function convert24hours($time){
  	$retval = $time;
  	if(is_array($retval)){
  		return $retval;
  	}
  	//Only proceed if we have a time stamp, sometimes it's text
  	if(strpos($time, ":")){
			if(strpos($time, "PM") || strpos($time, "pm")){
				$retval = str_replace(array("PM",'pm'), "", $time);
				$retval = trim($retval);
				list($hours, $minutes) = explode(":", $retval);
				$retval = $hours + 12 . ":" . $minutes;
			}
			elseif(strpos($time, "AM") || strpos($time, "am")) {
				$retval = str_replace(array("AM",'am'), "", $time);
			}
  	}
  	return trim($retval);
  }
  
  /**
  * Return the key of the current Contractor
  */
  function get($key = null, $truncatesize = null){
  	if(isset($this->Contractor['Contractor'][$key]) && !empty($this->Contractor['Contractor'][$key])){
  		if($truncatesize){
  			return $this->truncate($this->Contractor['Contractor'][$key], $truncatesize);
  		}
  		return $this->Contractor['Contractor'][$key];
  	}
  	return null;
  }
  
  /**
  * Truncate text
  */
  function truncate($string, $limit, $break=".", $pad="..."){
  	if(strlen($string) <= $limit) return $string;

  	// is $break present between $limit and the end of the string?
		if(false !== ($breakpoint = strpos($string, $break, $limit))) {
			if($breakpoint < strlen($string) - 1) {
				$string = substr($string, 0, $breakpoint) . $pad;
			}
		}
			
		return $string;
  }
  
  /**
  * Get the higest distance in miles
  * @param Contractor
  * @return float miles
  */
  function highestDistance($Contractors = null){
  	end($Contractors);
  	return round(key($Contractors),1);
  }
  
  /**
  * Round the Contractor's distance in miles
  * @param Contractor
  * @return float miles
  */
  function distance($distance){
  	return round($distance, 1) . " miles";
  }
  
  /**
  * Return the address of a Contractor
  * @param Contractor (optional)
  */
  function address($Contractor = null, $break = false){
  	if($Contractor) $this->setContractor($Contractor);
  	
  	$retval = "{$this->Contractor['Contractor']['street']}";
  	if(!empty($this->Contractor['Contractor']['street_2'])){
  		$retval .= " {$this->Contractor['Contractor']['street_2']}";
  	}
  	if($break){
  		$retval .= "<br />";
  	}
  	else {
  		$retval .= " ";
  	}
  	$retval .= "{$this->Contractor['Contractor']['city']}, {$this->Contractor['Contractor']['state']} {$this->Contractor['Contractor']['zip']}";
  	return str_replace("\n", "", $retval);
  }
  
  /**
  * Return the phone number of a clinic, try using hte callsource number first, fallback to normal phone number
  * @param Contractor (optional)
  * @param array of options
  * - link 'tel' | 'skype' | false (default false)
  * @return string phone number
  */
  function phone($Contractor = null, $options = array()){
  	if($Contractor) $this->setContractor($Contractor);
  	
  	$options = array_merge(array(
  		'link' => false
  	),$options);
  	
  	$retval = $this->get('phone');
  	return $this->formatNumber($retval);
  }
  /**
  * Display the google map
  *
  * @link http://code.google.com/apis/maps/documentation/staticmaps/
  * @param Contractor (optional)
  * @param array of options to pass to map
  * @param boolean return url only
  * @return map image
  */
  function map($Contractor = null, $options = array(), $urlonly = false){
  	if($Contractor) $this->setContractor($Contractor);
  	
  	$mapUrl = "http://maps.google.com/maps/api/staticmap?";
  	
  	$options = array_merge(
  		array(
  			'center' => "{$this->Contractor['Contractor']['lat']},{$this->Contractor['Contractor']['lon']}",
  			'maptype' => 'roadmap', //roadmap, satellite, hybrid
  			'size' => '230x110',
  			'zoom' => 13,
  			'format' => 'png',
  			'markers' => "{$this->Contractor['Contractor']['lat']},{$this->Contractor['Contractor']['lon']}",
  			'sensor' => 'false',
  			'mobilelink' => false
  		),
  		$options
  	);
  	
  	$fullMapUrl = $mapUrl . $this->encodeArray($options);
  	if($urlonly){
  		return $fullMapUrl;
  	}
  	$image = $this->Html->image($fullMapUrl, array('escape' => false, 'border' => '0', 'alt' => 'Map of ' . $this->get('company_name')));
  	if($options['mobilelink']){
  		return $this->Html->link($image, 'http://maps.google.com/maps?f=d&source=s_d&daddr=' . $this->address(), array('escape' => false));
  	}
  	return $image;
  }
  
  /**
  * Nick Baker -> Nick B.
  * Jessica Krouse -> Jessica K.
  * Nick -> Nick
  */
  function formatSubmitter($submitter = null){
  	if(strpos($submitter, " ") !== false){
  		$submitter_parts = explode(" ", $submitter);
  		$submitter = humanize($submitter_parts[0]) . ' ' . strtoupper(substr($submitter_parts[1], 0, 1)) . '.';
  	}
  	return $submitter;
  }
}