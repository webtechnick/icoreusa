<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {
	/**
  * Take a set of locations and split them evenly as we can
  * @param array to split
  * @return array of the resulting sets
  */
  function splitEvenly($array){
  	$count = count($array);
  	$by = ($count % 2) ? (int)($count/2) + 1 : (int)($count/2);

  	if($by == $count){
  		return array(
  			$array,
  			array()
  		);
  	}
  	
		return array_chunk($array, $by, true);
  }
  
  /**
  * Format the phone number
  */
  function formatNumber($sPhone){
  	$extention = strpos($sPhone, "x");
  	$sPhone = ereg_replace("[^0-9]",'',$sPhone);
  	
  	$sArea = substr($sPhone,0,3); 
  	$sPrefix = substr($sPhone,3,3); 
  	$sNumber = substr($sPhone,6,4);
  	$retval = "($sArea) $sPrefix-$sNumber";
  	if($extention){
  		$ext = substr($sPhone,10,strlen($sPhone));
  		$retval.= " x$ext";
  	}
  	
  	return $retval; 
  }
}
