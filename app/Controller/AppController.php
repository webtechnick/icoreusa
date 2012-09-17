<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	public $components = array(
		'Session',
		'Auth' => array(
      'authorize' => array('Controller'),
      'loginAction' => array('controller' => 'users', 'action' => 'login'),
      'allowedActions' => array('search','view','index','get','display'),
      'logoutRedirect' => array('controller' => 'pages', 'action' => 'home'),
      'authError' => 'Please Login',
      'autoRedirect' => false,
      'authenticate' => array(
      	'Form' => array(
      		'fields' => array('username' => 'email')
      	)
      )
    ),
		'DebugKit.Toolbar',
	);
	
	public function beforeFilter(){
		if(isset($this->request->query['fullsite']) && $this->request->query['fullsite']){
			$this->Session->write('fullsite', true);
		}
		$this->set('user', $this->Auth->user());
		$this->set('isadmin', $this->isAdmin());
		$this->set('iscontractor', $this->isContractor());
		return parent::beforeFilter();
	}
	
	public function beforeRender(){
		$this->newDetector();
		$is_mobile = $this->request->is('phone');
		if($is_mobile && !$this->Session->read('fullsite')){
			$this->theme = 'Mobile';
			if($this->layout != 'ajax'){
				$this->layout = 'mobile';
			}
		}
		$this->set('is_mobile', $is_mobile);
		return parent::beforeRender();
	}
	
	/**
	* Auth authorization function
	*/
	public function isAuthorized($user, $request = null) {
		if (strpos($this->request->action,"admin") !== false){
			return $this->isAdmin();
		}
		
		if (strpos($this->request->action,"contractor") !== false){
			return $this->isContractor();
		}
		
		return true;
	}
	
	function isAdmin(){
    return ($this->Auth->user('is_admin')); 
  }
  
  function isContractor(){
    return $this->isAdmin() || ($this->Auth->user('is_contractor')); 
  }
  
  function goodFlash($message){
    $this->Session->setFlash($message,'goodFlash');
  }
  
  function badFlash($message){
    $this->Session->setFlash($message,'badFlash');
  }
  
  function infoFlash($message){
    $this->Session->setFlash($message,'infoFlash');
  }
  
  /**
  * Create new detector to exclude ipad
  */
  function newDetector(){
  	$this->request->addDetector('phone', array(
			'env' => 'HTTP_USER_AGENT', 
			'options' => array(
				'Android', 'AvantGo', 'BlackBerry', 'DoCoMo', 'Fennec', 'iPod', 'iPhone', 
				'J2ME', 'MIDP', 'NetFront', 'Nokia', 'Opera Mini', 'Opera Mobi', 'PalmOS', 'PalmSource',
				'portalmmm', 'Plucker', 'ReqwirelessWeb', 'SonyEricsson', 'Symbian', 'UP\\.Browser',
				'webOS', 'Windows CE', 'Windows Phone OS', 'Xiino'
			)
		));
		$this->request->addDetector('ipad', array(
			'env' => 'HTTP_USER_AGENT', 
			'options' => array(
				'iPad'
			)
		));
  }
}
