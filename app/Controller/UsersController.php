<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
	
	public $components = array('Cookie');
	
	public function beforeFilter(){
		$this->Auth->allow('register');
		parent::beforeFilter();
	}

	public function login() {
		$this->loginLogic();
  }
  
  public function contractor_login(){
  	$this->setAction('login');
  }
  
  public function admin_login(){
  	$this->setAction('login');
  }
  
  public function logout() {
    $this->infoFlash('You\'ve been sucessfully logged out.');
    @$this->Cookie->delete('Auth.User');
    $this->redirect($this->Auth->logout());
  }
  
  public function account(){
  	if($this->request->is('put')){
  		if($this->User->saveAll($this->request->data)){
  			$this->goodFlash('Succesfully Updated');
  		} else {
  			$this->badFlash('Unable to Update');
  		}
  	}
  	$this->request->data = $this->User->findById($this->Auth->user('id'));
  }
  
  public function register(){
  	if($this->Auth->user()){
  		$this->redirect(array('action' => 'account'));
  	}
  	if(!empty($this->request->data)){
  		if($this->User->register($this->request->data)){
  			$this->goodFlash('Succesful registration please login now');
  			$this->redirect(array('action' => 'login'));
  		} else {
  			$this->badFlash('Errors, please fix below');
  		}
  	}
  }

	public function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$contractors = $this->User->Contractor->find('list');
		$this->set(compact('contractors'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$contractors = $this->User->Contractor->find('list');
		$this->set(compact('contractors'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	private function loginLogic($do_redirect = true, $cookie_length = '+4 weeks'){
		//-- code inside this function will execute only when autoRedirect was set to false (i.e. in a beforeFilter).
		if ($this->request->is('post')) {
			if (!$this->Auth->login()) {
				$this->badFlash('Username or password is incorrect');
			}
    }
		
		if($this->Auth->user()) {
			if(!empty($this->request->data)) {
				$cookie = array();
        $cookie['email'] = $this->request->data['User']['email'];
        $cookie['password'] = Security::hash($this->request->data['User']['password'], null, true);
        $this->Cookie->write('Auth.User', $cookie, false, $cookie_length);
			}
			if($do_redirect){
				$this->redirect($this->Auth->redirect());
			}
		}
		if(empty($this->request->data)) {
			$cookie = $this->Cookie->read('Auth.User');
			if($cookie && $user = $this->User->findByEmailAndPassword($cookie['email'], $cookie['password'])) {
				if($this->Auth->login($user['User'])) {
					//  Clear auth message, just in case we use it.
					$this->Session->delete('Message.auth');
					if($do_redirect){
						$this->redirect($this->Auth->redirect());
					}
				}
			}
		}
	}
}
