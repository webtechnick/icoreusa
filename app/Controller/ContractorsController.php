<?php
App::uses('AppController', 'Controller');
/**
 * Contractors Controller
 *
 * @property Contractor $Contractor
 */
class ContractorsController extends AppController {
	
	public $helpers = array('Icing.FileUpload');
	
	public $paginate = array(
		'Contractor' => array(
			'limit' => 10
		)
	);
	
	public function index($filter = null){
		if(!empty($this->request->data)){
			$filter = $this->request->data['Contractor']['filter'];
		}
		$conditions = $this->Contractor->generateFilterConditions($filter);
		$this->set('contractors',$this->paginate('Contractor',$conditions));
		$this->set('filter', $filter);
	}
	
	public function view($id = null){
		$this->Contractor->id = $id;
		if (!$this->Contractor->exists()) {
			$this->badFlash('Contractor Not Found');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('contractor', $this->Contractor->read(null, $id));
	}
	
	public function edit(){
  	if($this->request->is('put')){
  		if($this->Contractor->saveAll($this->request->data)){
  			$this->goodFlash('Succesfully Updated');
  		} else {
  			$this->badFlash('Unable to Update');
  		}
  	}
  	$this->request->data = $this->Contractor->find('first', array(
  		'conditions' => array(
  			'Contractor.user_id' => $this->Auth->user('id') 
  		),
  		'contain' => array('Image','Upload')
  	));
  }

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Contractor->recursive = 0;
		$this->set('contractors', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Contractor->id = $id;
		if (!$this->Contractor->exists()) {
			throw new NotFoundException(__('Invalid contractor'));
		}
		$this->set('contractor', $this->Contractor->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Contractor->create();
			if ($this->Contractor->save($this->request->data)) {
				$this->Session->setFlash(__('The contractor has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contractor could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Contractor->id = $id;
		if (!$this->Contractor->exists()) {
			throw new NotFoundException(__('Invalid contractor'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Contractor->save($this->request->data)) {
				$this->Session->setFlash(__('The contractor has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contractor could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Contractor->read(null, $id);
		}
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
		$this->Contractor->id = $id;
		if (!$this->Contractor->exists()) {
			throw new NotFoundException(__('Invalid contractor'));
		}
		if ($this->Contractor->delete()) {
			$this->Session->setFlash(__('Contractor deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Contractor was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
